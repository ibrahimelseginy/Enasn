<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Http\Request;

class ExpenseWebController extends Controller
{
    public function index() { $expenses = Expense::with(['beneficiary','project','campaign'])->orderByDesc('id')->paginate(20); return view('expenses.index', compact('expenses')); }
    public function create() { $beneficiaries = Beneficiary::orderBy('full_name')->get(); $projects = Project::orderBy('name')->get(); $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get(); return view('expenses.create', compact('beneficiaries','projects','campaigns')); }
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:operational,aid,logistics',
            'amount' => 'required|numeric',
            'currency' => 'nullable|string',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'paid_at' => 'nullable|date'
        ]);
        $exp = Expense::create($data);
        \App\Services\ExpenseService::postCreate($exp);
        return redirect()->route('expenses.show',$exp);
    }
    public function show(Expense $expense) { return view('expenses.show', compact('expense')); }
    public function edit(Expense $expense) { $beneficiaries = Beneficiary::orderBy('full_name')->get(); $projects = Project::orderBy('name')->get(); $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get(); return view('expenses.edit', compact('expense','beneficiaries','projects','campaigns')); }
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:operational,aid,logistics',
            'amount' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'paid_at' => 'nullable|date'
        ]);
        $expense->update($data);
        return redirect()->route('expenses.show',$expense);
    }
    public function destroy(Expense $expense) { $expense->delete(); return redirect()->route('expenses.index'); }
}
