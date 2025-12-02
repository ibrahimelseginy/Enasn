<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\VolunteerHour;
use App\Models\Task;
use App\Models\Campaign;

class VolunteerWebController extends Controller
{
    public function index() { $volunteers = User::where('is_volunteer',true)->orderBy('name')->paginate(20); return view('volunteers.index', compact('volunteers')); }
    public function create() { return view('volunteers.create'); }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string','email' => 'required|email|unique:users,email','password' => 'required|string|min:6','phone' => 'nullable|string','active' => 'boolean']);
        $data['password'] = Hash::make($data['password']);
        $data['is_volunteer'] = true;
        $data['is_employee'] = false;
        $user = User::create($data);
        return redirect()->route('volunteers.show',$user);
    }
    public function show(User $volunteer) { return view('volunteers.show', compact('volunteer')); }
    public function edit(User $volunteer) { return view('volunteers.edit', compact('volunteer')); }
    public function update(Request $request, User $volunteer)
    {
        $data = $request->validate(['name' => 'sometimes|string','email' => 'sometimes|email|unique:users,email,'.$volunteer->id,'password' => 'nullable|string|min:6','phone' => 'nullable|string','active' => 'boolean']);
        if (!empty($data['password'])) { $data['password'] = Hash::make($data['password']); }
        $volunteer->update($data);
        return redirect()->route('volunteers.show',$volunteer);
    }
    public function destroy(User $volunteer) { $volunteer->delete(); return redirect()->route('volunteers.index'); }
    public function reports(Request $request)
    {
        $volunteers = User::where('is_volunteer',true)->orderBy('name')->get();
        $userId = (int) $request->get('user_id', 0);
        $selected = $userId ? User::where('is_volunteer',true)->find($userId) : null;
        $assignments = collect();
        $summary = ['projects' => 0, 'hours' => 0, 'tasks_done' => 0];
        $campaignMap = collect();
        if ($selected) {
            $assignments = $selected->projects()->with(['manager','deputy'])->orderBy('name')->get();
            $summary['projects'] = $assignments->count();
            $summary['hours'] = (float) VolunteerHour::where('user_id',$selected->id)->sum('hours');
            $summary['tasks_done'] = (int) Task::where('assigned_to',$selected->id)->where('status','done')->count();
            $campaignIds = $assignments->pluck('pivot.campaign_id')->filter()->unique()->values();
            if ($campaignIds->count() > 0) {
                $campaignMap = Campaign::whereIn('id',$campaignIds)->get()->keyBy('id');
            }
        }
        return view('volunteers.reports', compact('volunteers','selected','assignments','summary','campaignMap','userId'));
    }
}
