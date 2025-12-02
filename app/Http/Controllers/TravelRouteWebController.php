<?php
namespace App\Http\Controllers;

use App\Models\TravelRoute;
use Illuminate\Http\Request;

class TravelRouteWebController extends Controller
{
    public function index() {
        $q = trim((string) request()->input('q'));
        $routes = TravelRoute::when($q !== '', function($qb) use ($q){ $qb->where('name','like',"%$q%"); })
            ->orderBy('name')->get();
        return view('routes.index', compact('routes','q'));
    }
    public function create() { return view('routes.create'); }
    public function store(Request $request) { $data = $request->validate(['name' => 'required|string','description' => 'nullable|string']); TravelRoute::create($data); return redirect()->route('travel-routes.index'); }
    public function show(TravelRoute $travel_route) { return view('routes.show', ['route' => $travel_route]); }
    public function edit(TravelRoute $travel_route) { return view('routes.edit', ['route' => $travel_route]); }
    public function update(Request $request, TravelRoute $travel_route) { $data = $request->validate(['name' => 'sometimes|string','description' => 'nullable|string']); $travel_route->update($data); return redirect()->route('travel-routes.show',$travel_route); }
    public function destroy(TravelRoute $travel_route) { $travel_route->delete(); return redirect()->route('travel-routes.index'); }
}
