<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => true
        ]);
        $token = Token::create([
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(32)),
        ]);
        return response()->json(['token' => $token->token, 'user' => $user]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = Token::create([
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(32)),
        ]);
        return response()->json(['token' => $token->token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $bearer = $request->bearerToken();
        if ($bearer) { Token::where('token', $bearer)->delete(); }
        return response()->noContent();
    }
}
