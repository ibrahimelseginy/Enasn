<?php
namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DonorWebController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q'));
        $type = $request->input('type');
        $classification = $request->input('classification');
        $active = $request->input('active');

        $donors = Donor::query()
            ->when($q !== '', function($q2) use ($q){
                $q2->where(function($w) use ($q){
                    $w->where('name','like',"%$q%")
                      ->orWhere('phone','like',"%$q%")
                      ->orWhere('email','like',"%$q%");
                });
            })
            ->when($type, function($q2,$t){ $q2->where('type',$t); })
            ->when($classification, function($q2,$c){ $q2->where('classification',$c); })
            ->when(!is_null($active) && $active !== '', function($q2,$a){ $q2->where('active', (bool) $a); })
            ->orderByDesc('id')->paginate(12)->withQueryString();

        $donStats = Donation::select('donor_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(COALESCE(amount, estimated_value, 0)) as total'))
            ->groupBy('donor_id')->get()->keyBy('donor_id');

        $totals = [
            'all' => Donor::count(),
            'active' => Donor::where('active',true)->count(),
            'recurring' => Donor::where('classification','recurring')->count(),
            'one_time' => Donor::where('classification','one_time')->count(),
        ];

        $allDonors = Donor::orderBy('name')->get();
        $selectedDonorId = $request->input('selected_donor_id');
        $selectedDonor = null;
        $donationsHistory = collect();
        if ($selectedDonorId) {
            $selectedDonor = Donor::find($selectedDonorId);
            if ($selectedDonor) {
                $donationsHistory = Donation::with(['project','campaign'])
                    ->where('donor_id', $selectedDonor->id)
                    ->orderByDesc('received_at')->orderByDesc('id')
                    ->limit(10)->get();
            }
        }

        return view('donors.index', compact('donors','donStats','totals','q','type','classification','active','allDonors','selectedDonor','donationsHistory','selectedDonorId'));
    }
    public function create()
    {
        $beneficiaries = \App\Models\Beneficiary::orderBy('full_name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();
        return view('donors.create', compact('beneficiaries','projects'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:individual,organization',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'classification' => 'required|in:one_time,recurring',
            'recurring_cycle' => 'nullable|in:monthly,yearly',
            'active' => 'boolean',
            'sponsorship_type' => 'nullable|in:none,monthly_sponsor,sadaqa_jariya',
            'sponsored_beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'sponsorship_project_id' => 'nullable|exists:projects,id',
            'sponsorship_monthly_amount' => 'nullable|numeric'
        ]);
        $email = isset($data['email']) ? trim((string)$data['email']) : null;
        $phone = isset($data['phone']) ? trim((string)$data['phone']) : null;
        $existing = null;
        if ($email || $phone) {
            $existing = Donor::query()
                ->when($email, fn($q) => $q->where('email', $email))
                ->when($phone, fn($q) => $q->orWhere('phone', $phone))
                ->first();
        }
        if ($existing) {
            $updateData = array_filter($data, fn($v) => !is_null($v));
            $existing->update($updateData);
            if ($request->input('return_to') === 'donations.create') {
                return redirect()->route('donations.create', ['donor_id' => $existing->id]);
            }
            return redirect()->route('donors.show', $existing);
        }
        if (($data['sponsorship_type'] ?? 'none') !== 'none' && empty($data['sponsorship_project_id'])) {
            $defaultProjId = \App\Models\Project::where('name','بعثاء الامل')->value('id');
            if ($defaultProjId) { $data['sponsorship_project_id'] = $defaultProjId; }
        }
        $donor = Donor::create($data);
        if ($request->input('return_to') === 'donations.create') {
            return redirect()->route('donations.create', ['donor_id' => $donor->id]);
        }
        return redirect()->route('donors.show', $donor);
    }
    public function show(Donor $donor)
    {
        $stats = Donation::select(DB::raw('COUNT(*) as count'), DB::raw('SUM(COALESCE(amount, estimated_value, 0)) as total'))
            ->where('donor_id',$donor->id)->first();
        $paidThisMonth = Donation::where('donor_id',$donor->id)
            ->where('type','cash')
            ->when($donor->sponsorship_project_id, function($q) use ($donor){ $q->where('project_id', $donor->sponsorship_project_id); })
            ->whereBetween('received_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');
        $history = Donation::with(['project','campaign','warehouse'])
            ->where('donor_id',$donor->id)
            ->orderByDesc('received_at')->orderByDesc('id')
            ->get();
        return view('donors.show', compact('donor','stats','paidThisMonth','history'));
    }
    public function edit(Donor $donor)
    {
        $beneficiaries = \App\Models\Beneficiary::orderBy('full_name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();
        return view('donors.edit', compact('donor','beneficiaries','projects'));
    }
    public function update(Request $request, Donor $donor)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'type' => 'sometimes|in:individual,organization',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'classification' => 'sometimes|in:one_time,recurring',
            'recurring_cycle' => 'nullable|in:monthly,yearly',
            'active' => 'boolean',
            'sponsorship_type' => 'nullable|in:none,monthly_sponsor,sadaqa_jariya',
            'sponsored_beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'sponsorship_project_id' => 'nullable|exists:projects,id',
            'sponsorship_monthly_amount' => 'nullable|numeric'
        ]);
        if (($data['sponsorship_type'] ?? $donor->sponsorship_type ?? 'none') !== 'none' && empty($data['sponsorship_project_id'])) {
            $defaultProjId = \App\Models\Project::where('name','بعثاء الامل')->value('id');
            if ($defaultProjId) { $data['sponsorship_project_id'] = $defaultProjId; }
        }
        $donor->update($data);
        return redirect()->route('donors.show', $donor);
    }
    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('donors.index');
    }
}
