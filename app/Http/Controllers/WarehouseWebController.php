<?php
namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseWebController extends Controller
{
    public function index() { $warehouses = Warehouse::orderBy('name')->paginate(20); return view('warehouses.index', compact('warehouses')); }
    public function create() { return view('warehouses.create'); }
    public function store(Request $request)
    { $data = $request->validate(['name' => 'required|string','location' => 'nullable|string']); Warehouse::create($data); return redirect()->route('warehouses.index'); }
    public function show(Warehouse $warehouse) { return view('warehouses.show', compact('warehouse')); }
    public function edit(Warehouse $warehouse) { return view('warehouses.edit', compact('warehouse')); }
    public function update(Request $request, Warehouse $warehouse)
    { $data = $request->validate(['name' => 'sometimes|string','location' => 'nullable|string']); $warehouse->update($data); return redirect()->route('warehouses.show',$warehouse); }
    public function destroy(Warehouse $warehouse) { $warehouse->delete(); return redirect()->route('warehouses.index'); }
}
