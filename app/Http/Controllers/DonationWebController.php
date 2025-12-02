<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\Project;
use App\Models\Campaign;
use App\Models\Warehouse;
use App\Models\Delegate;
use App\Models\Beneficiary;
use App\Models\TravelRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DonationWebController extends Controller
{
    public function index()
    {
        $cashDonations = Donation::with(['donor','project','campaign','warehouse'])
            ->where('type','cash')
            ->orderByDesc('received_at')->orderByDesc('id')->paginate(12, ['*'], 'cash_page');

        $inKindDonations = Donation::with(['donor','project','campaign','warehouse'])
            ->where('type','in_kind')
            ->orderByDesc('received_at')->orderByDesc('id')->paginate(12, ['*'], 'inkind_page');

        $dailyCashSummary = Donation::select(DB::raw("DATE(received_at) as day"), DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->where('type','cash')
            ->groupBy(DB::raw("DATE(received_at)"))
            ->orderByDesc(DB::raw("DATE(received_at)"))
            ->limit(14)
            ->get()
            ->map(function($r){ return ['day' => (string) $r->day, 'count' => (int) $r->count, 'total' => (float) $r->total]; });

        $today = now()->toDateString();
        $byChannelRaw = Donation::select('cash_channel', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->where('type','cash')
            ->whereDate('received_at', $today)
            ->groupBy('cash_channel')
            ->get();
        $todayByChannel = [
            'cash' => ['count' => 0, 'total' => 0.0],
            'instapay' => ['count' => 0, 'total' => 0.0],
            'vodafone_cash' => ['count' => 0, 'total' => 0.0],
        ];
        foreach ($byChannelRaw as $r) {
            $key = $r->cash_channel ?: 'cash';
            if (!isset($todayByChannel[$key])) { $todayByChannel[$key] = ['count' => 0, 'total' => 0.0]; }
            $todayByChannel[$key]['count'] = (int) $r->count;
            $todayByChannel[$key]['total'] = (float) $r->total;
        }

        return view('donations.index', compact('cashDonations','inKindDonations','dailyCashSummary','todayByChannel'));
    }

    public function create()
    {
        $donors = Donor::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $delegates = Delegate::orderBy('name')->get();
        $routes = TravelRoute::orderBy('name')->get();
        $beneficiaries = Beneficiary::select('id','full_name')->orderBy('full_name')->get();
        return view('donations.create', compact('donors','projects','campaigns','warehouses','delegates','routes','beneficiaries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'type' => 'required|in:cash,in_kind',
            'cash_channel' => 'required_if:type,cash|in:cash,instapay,vodafone_cash',
            'amount' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:64',
            'estimated_value' => 'nullable|numeric',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'delegate_id' => 'nullable|exists:delegates,id',
            'route_id' => 'nullable|exists:travel_routes,id',
            'allocation_note' => 'nullable|string',
            'received_at' => 'nullable|date'
        ]);
        if ($data['type'] === 'cash') {
            if (!isset($data['amount'])) { return back()->withErrors(['amount' => 'مطلوب مبلغ للتبرع النقدي']); }
            if (!isset($data['receipt_number']) || trim((string)$data['receipt_number'])==='') { return back()->withErrors(['receipt_number' => 'رقم الإيصال مطلوب للتبرع النقدي']); }
        } else {
            if (!isset($data['warehouse_id'])) { return back()->withErrors(['warehouse_id' => 'مطلوب تحديد المخزن للتبرع العيني']); }
            if (!isset($data['estimated_value'])) { return back()->withErrors(['estimated_value' => 'مطلوب قيمة تقديرية للتبرع العيني']); }
        }
        $donation = Donation::create($data);
        \App\Services\DonationService::postCreate($donation);
        return redirect()->route('donations.index');
    }

    public function show(Donation $donation)
    {
        $donation->load(['donor','project','campaign','warehouse','delegate','route']);
        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $donors = Donor::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $delegates = Delegate::orderBy('name')->get();
        $routes = TravelRoute::orderBy('name')->get();
        return view('donations.edit', compact('donation','donors','projects','campaigns','warehouses','delegates','routes'));
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:cash,in_kind',
            'cash_channel' => 'nullable|in:cash,instapay,vodafone_cash',
            'amount' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:64',
            'estimated_value' => 'nullable|numeric',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'delegate_id' => 'nullable|exists:delegates,id',
            'route_id' => 'nullable|exists:travel_routes,id',
            'allocation_note' => 'nullable|string',
            'received_at' => 'nullable|date'
        ]);
        $donation->update($data);
        return redirect()->route('donations.show', $donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index');
    }
}
