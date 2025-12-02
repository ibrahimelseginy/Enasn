<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemWebController extends Controller
{
    public function index() { $items = Item::orderBy('name')->paginate(20); return view('items.index', compact('items')); }
    public function create() { return view('items.create'); }
    public function store(Request $request)
    { $data = $request->validate(['sku' => 'nullable|string','name' => 'required|string','unit' => 'nullable|string','estimated_value' => 'nullable|numeric']); Item::create($data); return redirect()->route('items.index'); }
    public function show(Item $item) { return view('items.show', compact('item')); }
    public function edit(Item $item) { return view('items.edit', compact('item')); }
    public function update(Request $request, Item $item)
    { $data = $request->validate(['sku' => 'nullable|string','name' => 'sometimes|string','unit' => 'nullable|string','estimated_value' => 'nullable|numeric']); $item->update($data); return redirect()->route('items.show',$item); }
    public function destroy(Item $item) { $item->delete(); return redirect()->route('items.index'); }
}
