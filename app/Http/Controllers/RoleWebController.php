<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleWebController extends Controller
{
    public function index() { $roles = Role::orderBy('name')->paginate(20); return view('roles.index', compact('roles')); }
    public function create() { return view('roles.create'); }
    public function store(Request $request) { $data = $request->validate(['name' => 'required|string','key' => 'required|string|unique:roles,key']); Role::create($data); return redirect()->route('roles.index'); }
    public function show(Role $role) { return view('roles.show', compact('role')); }
    public function edit(Role $role) { return view('roles.edit', compact('role')); }
    public function update(Request $request, Role $role) { $data = $request->validate(['name' => 'sometimes|string','key' => 'sometimes|string|unique:roles,key,'.$role->id]); $role->update($data); return redirect()->route('roles.show',$role); }
    public function destroy(Role $role) { $role->delete(); return redirect()->route('roles.index'); }
}
