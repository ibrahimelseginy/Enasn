<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginWebController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $data = $request->validate(['email' => 'required|email','password' => 'required|string']);
        $user = User::where('email',$data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
        }
        $request->session()->put('user_id', $user->id);
        return redirect()->intended('/');
    }
    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        return redirect()->route('login');
    }
}
