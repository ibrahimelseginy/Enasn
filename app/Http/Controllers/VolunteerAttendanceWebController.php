<?php
namespace App\Http\Controllers;

use App\Models\VolunteerAttendance;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerAttendanceWebController extends Controller
{
    public function index() { $records = VolunteerAttendance::with('user')->orderByDesc('date')->paginate(50); return view('attendance.index', compact('records')); }
    public function create() { $users = User::where('is_volunteer',true)->orderBy('name')->get(); return view('attendance.create', compact('users')); }
    public function store(Request $request) { $data = $request->validate(['user_id' => 'required|exists:users,id','date' => 'required|date','check_in_at' => 'nullable','check_out_at' => 'nullable','notes' => 'nullable|string']); VolunteerAttendance::create($data); return redirect()->route('volunteer-attendance.index'); }
    public function show(VolunteerAttendance $volunteer_attendance) { return view('attendance.show', ['rec' => $volunteer_attendance->load('user')]); }
    public function edit(VolunteerAttendance $volunteer_attendance) { $users = User::where('is_volunteer',true)->orderBy('name')->get(); return view('attendance.edit', ['rec' => $volunteer_attendance, 'users' => $users]); }
    public function update(Request $request, VolunteerAttendance $volunteer_attendance) { $data = $request->validate(['date' => 'nullable|date','check_in_at' => 'nullable','check_out_at' => 'nullable','notes' => 'nullable|string']); $volunteer_attendance->update($data); return redirect()->route('volunteer-attendance.show',$volunteer_attendance); }
    public function destroy(VolunteerAttendance $volunteer_attendance) { $volunteer_attendance->delete(); return redirect()->route('volunteer-attendance.index'); }
}

