<?php
namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\Donation;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Http\Request;

class InventoryTransactionWebController extends Controller
{
    public function index()
    {
        $transactions = InventoryTransaction::with(['item','warehouse','beneficiary','project','campaign'])
            ->orderByDesc('id')->paginate(20);
        return view('inventory.index', compact('transactions'));
    }
    public function create()
    {
        $items = Item::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $donations = Donation::where('type','in_kind')->orderByDesc('id')->get();
        $beneficiaries = Beneficiary::orderBy('full_name')->get();
        $projects = Project::orderBy('name')->get();
        $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get();
        return view('inventory.create', compact('items','warehouses','donations','beneficiaries','projects','campaigns'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:in,transfer,out',
            'quantity' => 'required|numeric',
            'source_donation_id' => 'nullable|exists:donations,id',
            'beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'reference' => 'nullable|string'
        ]);
        InventoryTransaction::create($data);
        return redirect()->route('inventory-transactions.index');
    }
    public function show(InventoryTransaction $inventory_transaction)
    {
        $inventory_transaction->load(['item','warehouse','beneficiary','project','campaign','sourceDonation']);
        return view('inventory.show', ['t' => $inventory_transaction]);
    }
    public function edit(InventoryTransaction $inventory_transaction)
    {
        $items = Item::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $donations = Donation::where('type','in_kind')->orderByDesc('id')->get();
        $beneficiaries = Beneficiary::orderBy('full_name')->get();
        $projects = Project::orderBy('name')->get();
        $campaigns = Campaign::orderByDesc('season_year')->orderBy('name')->get();
        return view('inventory.edit', ['t' => $inventory_transaction, 'items' => $items, 'warehouses' => $warehouses, 'donations' => $donations, 'beneficiaries' => $beneficiaries, 'projects' => $projects, 'campaigns' => $campaigns]);
    }
    public function update(Request $request, InventoryTransaction $inventory_transaction)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:in,transfer,out',
            'quantity' => 'nullable|numeric',
            'beneficiary_id' => 'nullable|exists:beneficiaries,id',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'reference' => 'nullable|string'
        ]);
        $inventory_transaction->update($data);
        return redirect()->route('inventory-transactions.show', $inventory_transaction);
    }
    public function destroy(InventoryTransaction $inventory_transaction)
    {
        $inventory_transaction->delete();
        return redirect()->route('inventory-transactions.index');
    }
}
