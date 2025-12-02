<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class WebAuth
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->session()->get('user_id');
        if (!$id) {
            return redirect()->route('login');
        }
        $user = User::find($id);
        $request->setUserResolver(function () use ($user) { return $user; });
        return $next($request);
    }
}
