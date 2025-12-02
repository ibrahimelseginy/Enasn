<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectWebController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $status = (string) $request->get('status', '');
        $fixed = $request->has('fixed') ? $request->boolean('fixed') : null;
        $projects = Project::query()
            ->when($q !== '', function($qr) use($q){ $qr->where('name','like','%'.$q.'%'); })
            ->when($status !== '', function($qr) use($status){ $qr->where('status',$status); })
            ->when(!is_null($fixed), function($qr) use($fixed){ $qr->where('fixed',$fixed); })
            ->orderBy('name')
            ->paginate(20)
            ->appends(['q'=>$q,'status'=>$status] + (!is_null($fixed) ? ['fixed'=>$fixed] : []));
        return view('projects.index', compact('projects','q','status','fixed'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'fixed' => 'nullable|boolean',
            'status' => 'required|in:active,archived',
            'description' => 'nullable|string',
        ]);
        $data['fixed'] = $data['fixed'] ?? true;
        $project = Project::create($data);
        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $donationsCount = \App\Models\Donation::where('project_id',$project->id)->count();
        $cashSum = (float) \App\Models\Donation::where('project_id',$project->id)->where('type','cash')->sum('amount');
        $inKindSum = (float) \App\Models\Donation::where('project_id',$project->id)->where('type','in_kind')->sum('estimated_value');
        $beneficiariesCount = \App\Models\Beneficiary::where('project_id',$project->id)->count();
        $expensesCount = \App\Models\Expense::where('project_id',$project->id)->count();
        $latestDonations = \App\Models\Donation::where('project_id',$project->id)->orderByDesc('id')->limit(5)->get();
        $latestExpenses = \App\Models\Expense::where('project_id',$project->id)->orderByDesc('id')->limit(5)->get();
        $latestBeneficiaries = \App\Models\Beneficiary::where('project_id',$project->id)->orderByDesc('id')->limit(5)->get();
        $volunteers = \App\Models\User::where('is_volunteer',true)->orderBy('name')->get();
        $projectVolunteers = $project->volunteers()->orderBy('name')->get();
        $campaigns = \App\Models\Campaign::orderByDesc('season_year')->orderBy('name')->get();
        $donationsTotal = $cashSum + $inKindSum;
        $cashPct = $donationsTotal > 0 ? round(($cashSum/$donationsTotal)*100) : 0;
        return view('projects.show', compact('project','donationsCount','cashSum','inKindSum','beneficiariesCount','expensesCount','latestDonations','latestExpenses','latestBeneficiaries','projectVolunteers','volunteers','cashPct','donationsTotal','campaigns'));
    }

    public function attachVolunteer(Request $request, Project $project)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string',
            'started_at' => 'nullable|date',
            'campaign_id' => 'nullable|exists:campaigns,id'
        ]);
        $project->volunteers()->syncWithoutDetaching([
            $data['user_id'] => [
                'role' => $data['role'] ?? null,
                'started_at' => $data['started_at'] ?? null,
                'campaign_id' => $data['campaign_id'] ?? null,
            ]
        ]);
        return redirect()->route('projects.show', $project);
    }

    public function detachVolunteer(Project $project, \App\Models\User $user)
    {
        $project->volunteers()->detach($user->id);
        return redirect()->route('projects.show', $project);
    }

    public function setManager(Project $project, Request $request)
    {
        $data = $request->validate(['manager_user_id' => 'nullable|exists:users,id','manager_photo_url' => 'nullable|string']);
        $project->update($data);
        return redirect()->route('projects.show', $project);
    }

    public function setDeputy(Project $project, Request $request)
    {
        $data = $request->validate(['deputy_user_id' => 'nullable|exists:users,id','deputy_photo_url' => 'nullable|string']);
        $project->update($data);
        return redirect()->route('projects.show', $project);
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'fixed' => 'nullable|boolean',
            'status' => 'sometimes|in:active,archived',
            'description' => 'nullable|string',
        ]);
        $project->update($data);
        return redirect()->route('projects.show', $project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
