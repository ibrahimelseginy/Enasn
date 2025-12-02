<?php
namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollWebController extends Controller
{
    public function index() { $payrolls = Payroll::with('user')->orderByDesc('id')->paginate(50); return view('payrolls.index', compact('payrolls')); }
    public function create() { $users = User::orderBy('name')->get(); return view('payrolls.create', compact('users')); }
    public function store(Request $request) { $data = $request->validate(['user_id' => 'required|exists:users,id','month' => 'required|string','amount' => 'required|numeric','currency' => 'nullable|string','paid_at' => 'nullable|date']); Payroll::create($data); return redirect()->route('payrolls.index'); }
    public function show(Payroll $payroll) { return view('payrolls.show', compact('payroll')); }
    public function edit(Payroll $payroll) { $users = User::orderBy('name')->get(); return view('payrolls.edit', compact('payroll','users')); }
    public function update(Request $request, Payroll $payroll) { $data = $request->validate(['month' => 'nullable|string','amount' => 'nullable|numeric','currency' => 'nullable|string','paid_at' => 'nullable|date']); $payroll->update($data); return redirect()->route('payrolls.show',$payroll); }
    public function destroy(Payroll $payroll) { $payroll->delete(); return redirect()->route('payrolls.index'); }
}
