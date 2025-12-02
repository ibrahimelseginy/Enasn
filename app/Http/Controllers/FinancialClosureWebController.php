<?php
namespace App\Http\Controllers;

use App\Models\FinancialClosure;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class FinancialClosureWebController extends Controller
{
    public function index() { $closures = FinancialClosure::orderByDesc('date')->paginate(20); return view('closures.index', compact('closures')); }
    public function create() { return view('closures.create'); }
    public function store(Request $request)
    {
        $data = $request->validate(['date' => 'required|date','branch' => 'nullable|string']);
        $closure = FinancialClosure::create($data);
        JournalEntry::whereDate('date','<=',$data['date'])->when($data['branch'] ?? null, function($q,$b){ $q->where('branch',$b); })->update(['locked' => true]);
        return redirect()->route('closures.index');
    }
    public function approve(FinancialClosure $closure)
    {
        $closure->update(['approved' => true]);
        return redirect()->route('closures.index');
    }
}
