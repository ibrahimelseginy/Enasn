<?php
namespace App\Http\Controllers;

use App\Models\VolunteerHour;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerHourWebController extends Controller
{
    public function index() { $hours = VolunteerHour::with('user')->orderByDesc('date')->paginate(50); return view('vhours.index', compact('hours')); }
    public function create() { $users = User::orderBy('name')->get(); return view('vhours.create', compact('users')); }
    public function store(Request $request) { $data = $request->validate(['user_id' => 'required|exists:users,id','date' => 'required|date','hours' => 'required|numeric','task' => 'nullable|string']); VolunteerHour::create($data); return redirect()->route('volunteer-hours.index'); }
    public function show(VolunteerHour $volunteer_hour) { return view('vhours.show', ['vh' => $volunteer_hour->load('user')]); }
    public function edit(VolunteerHour $volunteer_hour) { $users = User::orderBy('name')->get(); return view('vhours.edit', ['vh' => $volunteer_hour, 'users' => $users]); }
    public function update(Request $request, VolunteerHour $volunteer_hour) { $data = $request->validate(['date' => 'nullable|date','hours' => 'nullable|numeric','task' => 'nullable|string']); $volunteer_hour->update($data); return redirect()->route('volunteer-hours.show',$volunteer_hour); }
    public function destroy(VolunteerHour $volunteer_hour) { $volunteer_hour->delete(); return redirect()->route('volunteer-hours.index'); }
}
