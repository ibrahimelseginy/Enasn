<?php
namespace App\Http\Controllers;

use App\Models\GuestHouse;
use Illuminate\Http\Request;

class GuestHouseWebController extends Controller
{
    public function index()
    {
        $q = trim((string) request()->input('q'));
        $status = request()->input('status');
        $houses = GuestHouse::when($q !== '', function($qb) use ($q){ $qb->where('name','like',"%$q%")->orWhere('location','like',"%$q%"); })
            ->when($status, function($qb,$s){ $qb->where('status',$s); })
            ->orderBy('name')->paginate(24);
        return view('guest_houses.index', compact('houses','q','status'));
    }
    public function create()
    {
        return view('guest_houses.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'status' => 'in:active,archived',
            'description' => 'nullable|string'
        ]);
        $data['status'] = $data['status'] ?? 'active';
        GuestHouse::create($data);
        return redirect()->route('guest-houses.index');
    }
    public function show(GuestHouse $guest_house)
    {
        return view('guest_houses.show', compact('guest_house'));
    }
    public function edit(GuestHouse $guest_house)
    {
        return view('guest_houses.edit', compact('guest_house'));
    }
    public function update(Request $request, GuestHouse $guest_house)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'status' => 'in:active,archived',
            'description' => 'nullable|string'
        ]);
        $guest_house->update($data);
        return redirect()->route('guest-houses.show', $guest_house);
    }
    public function destroy(GuestHouse $guest_house)
    {
        $guest_house->delete();
        return redirect()->route('guest-houses.index');
    }
}
