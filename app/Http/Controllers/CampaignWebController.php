<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignWebController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $status = (string) $request->get('status', '');
        $year = $request->get('season_year');
        $campaigns = Campaign::query()
            ->when($q !== '', function($qr) use($q){ $qr->where('name','like','%'.$q.'%'); })
            ->when($status !== '', function($qr) use($status){ $qr->where('status',$status); })
            ->when(!empty($year), function($qr) use($year){ $qr->where('season_year',$year); })
            ->orderByDesc('season_year')->orderBy('name')
            ->paginate(20)
            ->appends(['q'=>$q,'status'=>$status,'season_year'=>$year]);
        return view('campaigns.index', compact('campaigns','q','status','year'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'season_year' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,archived',
        ]);
        $campaign = Campaign::create($data);
        return redirect()->route('campaigns.show', $campaign);
    }

    public function show(Campaign $campaign)
    {
        $donationsCount = \App\Models\Donation::where('campaign_id',$campaign->id)->count();
        $cashSum = (float) \App\Models\Donation::where('campaign_id',$campaign->id)->where('type','cash')->sum('amount');
        $inKindSum = (float) \App\Models\Donation::where('campaign_id',$campaign->id)->where('type','in_kind')->sum('estimated_value');
        $beneficiariesCount = \App\Models\Beneficiary::where('campaign_id',$campaign->id)->count();
        $expensesCount = \App\Models\Expense::where('campaign_id',$campaign->id)->count();
        $latestDonations = \App\Models\Donation::where('campaign_id',$campaign->id)->orderByDesc('id')->limit(5)->get();
        $latestExpenses = \App\Models\Expense::where('campaign_id',$campaign->id)->orderByDesc('id')->limit(5)->get();
        $latestBeneficiaries = \App\Models\Beneficiary::where('campaign_id',$campaign->id)->orderByDesc('id')->limit(5)->get();
        return view('campaigns.show', compact('campaign','donationsCount','cashSum','inKindSum','beneficiariesCount','expensesCount','latestDonations','latestExpenses','latestBeneficiaries'));
    }

    public function edit(Campaign $campaign)
    {
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'season_year' => 'sometimes|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'sometimes|in:active,archived',
        ]);
        $campaign->update($data);
        return redirect()->route('campaigns.show', $campaign);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('campaigns.index');
    }
}
