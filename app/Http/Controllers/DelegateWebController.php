<?php
namespace App\Http\Controllers;

use App\Models\Delegate;
use App\Models\TravelRoute;
use Illuminate\Http\Request;

class DelegateWebController extends Controller
{
    public function index() { $delegates = Delegate::with('route')->orderBy('name')->paginate(20); return view('delegates.index', compact('delegates')); }
    public function create() { $routes = TravelRoute::orderBy('name')->get(); return view('delegates.create', compact('routes')); }
    public function store(Request $request) { $data = $request->validate(['name' => 'required|string','phone' => 'nullable|string','email' => 'nullable|email','route_id' => 'nullable|exists:travel_routes,id']); Delegate::create($data); return redirect()->route('delegates.index'); }
    public function show(Delegate $delegate) { return view('delegates.show', compact('delegate')); }
    public function edit(Delegate $delegate) { $routes = TravelRoute::orderBy('name')->get(); return view('delegates.edit', compact('delegate','routes')); }
    public function update(Request $request, Delegate $delegate) { $data = $request->validate(['name' => 'sometimes|string','phone' => 'nullable|string','email' => 'nullable|email','route_id' => 'nullable|exists:travel_routes,id']); $delegate->update($data); return redirect()->route('delegates.show',$delegate); }
    public function destroy(Delegate $delegate) { $delegate->delete(); return redirect()->route('delegates.index'); }
}
