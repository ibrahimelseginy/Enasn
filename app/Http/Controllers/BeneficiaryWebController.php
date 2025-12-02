<?php
namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Http\Request;

class BeneficiaryWebController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $status = (string) $request->get('status', '');
        $atype = (string) $request->get('assistance_type', '');
        $projectId = $request->get('project_id');
        $campaignId = $request->get('campaign_id');

        $beneficiaries = Beneficiary::query()
            ->with(['project','campaign'])
            ->when($q !== '', function($qr) use($q){
                $qr->where(function($w) use($q){
                    $w->where('full_name','like','%'.$q.'%')
                      ->orWhere('phone','like','%'.$q.'%')
                      ->orWhere('national_id','like','%'.$q.'%');
                });
            })
            ->when($status !== '', function($qr) use($status){ $qr->where('status',$status); })
            ->when($atype !== '', function($qr) use($atype){ $qr->where('assistance_type',$atype); })
            ->when(!empty($projectId), function($qr) use($projectId){ $qr->where('project_id',$projectId); })
            ->when(!empty($campaignId), function($qr) use($campaignId){ $qr->where('campaign_id',$campaignId); })
            ->orderByDesc('id')
            ->paginate(20)
            ->appends(['q'=>$q,'status'=>$status,'assistance_type'=>$atype,'project_id'=>$projectId,'campaign_id'=>$campaignId]);

        $projects = Project::orderBy('name')->get();
        $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get();

        $stats = [
            'total' => Beneficiary::count(),
            'new' => Beneficiary::where('status','new')->count(),
            'under_review' => Beneficiary::where('status','under_review')->count(),
            'accepted' => Beneficiary::where('status','accepted')->count(),
        ];

        return view('beneficiaries.index', compact('beneficiaries','projects','campaigns','q','status','atype','projectId','campaignId','stats'));
    }
    public function create() { $projects = Project::orderBy('name')->get(); $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get(); return view('beneficiaries.create', compact('projects','campaigns')); }
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string',
            'national_id' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'assistance_type' => 'required|in:financial,in_kind,service',
            'status' => 'in:new,under_review,accepted',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id'
        ]);
        $data['status'] = $data['status'] ?? 'new';
        $b = Beneficiary::create($data);
        return redirect()->route('beneficiaries.show',$b);
    }
    public function show(Beneficiary $beneficiary) { return view('beneficiaries.show', compact('beneficiary')); }
    public function edit(Beneficiary $beneficiary)
    { $projects = Project::orderBy('name')->get(); $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get(); return view('beneficiaries.edit', compact('beneficiary','projects','campaigns')); }
    public function update(Request $request, Beneficiary $beneficiary)
    {
        $data = $request->validate([
            'full_name' => 'sometimes|string',
            'national_id' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'assistance_type' => 'sometimes|in:financial,in_kind,service',
            'status' => 'in:new,under_review,accepted',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id'
        ]);
        if (isset($data['status'])) {
            $allowed = [ 'new' => ['under_review'], 'under_review' => ['accepted'], 'accepted' => [] ];
            $current = $beneficiary->status; $next = $data['status'];
            if ($current !== $next && !in_array($next, $allowed[$current] ?? [], true)) { return back()->withErrors(['status' => 'انتقال حالة غير مسموح']); }
        }
        $beneficiary->update($data);
        return redirect()->route('beneficiaries.show',$beneficiary);
    }
    public function destroy(Beneficiary $beneficiary) { $beneficiary->delete(); return redirect()->route('beneficiaries.index'); }
}
