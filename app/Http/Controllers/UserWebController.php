<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserWebController extends Controller
{
    public function index() { $users = User::with('roles')->orderBy('name')->paginate(20); return view('users.index', compact('users')); }
    public function create() { $roles = Role::orderBy('name')->get(); return view('users.create', compact('roles')); }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string','email' => 'required|email|unique:users,email','password' => 'required|string|min:6','phone' => 'nullable|string','is_employee' => 'boolean','is_volunteer' => 'boolean','active' => 'boolean','roles' => 'array']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        if (!empty($data['roles'])) { $user->roles()->sync($data['roles']); }
        return redirect()->route('users.show',$user);
    }
    public function show(User $user) { return view('users.show', compact('user')); }
    public function edit(User $user) { $roles = Role::orderBy('name')->get(); return view('users.edit', compact('user','roles')); }
    public function update(Request $request, User $user)
    {
        $data = $request->validate(['name' => 'sometimes|string','email' => 'sometimes|email|unique:users,email,'.$user->id,'password' => 'nullable|string|min:6','phone' => 'nullable|string','is_employee' => 'boolean','is_volunteer' => 'boolean','active' => 'boolean','roles' => 'array']);
        if (!empty($data['password'])) { $data['password'] = Hash::make($data['password']); }
        $user->update($data);
        if (isset($data['roles'])) { $user->roles()->sync($data['roles']); }
        return redirect()->route('users.show',$user);
    }
    public function destroy(User $user) { $user->delete(); return redirect()->route('users.index'); }
    public function attachRole(User $user, Role $role) { $user->roles()->syncWithoutDetaching([$role->id]); return back(); }
    public function detachRole(User $user, Role $role) { $user->roles()->detach($role->id); return back(); }
}
