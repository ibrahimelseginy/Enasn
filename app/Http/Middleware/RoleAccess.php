<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !$user->active) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $name = $request->route() ? $request->route()->getName() : null;
        $method = $request->method();
        $resource = $name ? explode('.', $name)[0] : '';
        $action = $name ? explode('.', $name)[1] ?? '' : '';

        $roleKeys = $user->roles()->pluck('key')->all();
        $has = function(array $need) use ($roleKeys) { return count(array_intersect($need, $roleKeys)) > 0; };

        $writeMethods = ['POST','PUT','PATCH','DELETE'];
        $isWrite = in_array($method, $writeMethods, true) || in_array($action, ['store','update','destroy'], true);

        if (!$isWrite) {
            return $next($request);
        }

        if (in_array($resource, ['accounts','journal-entries','expenses'], true)) {
            if (!$has(['admin','finance'])) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return $next($request);
        }

        if (in_array($resource, ['roles','users'], true)) {
            if (!$has(['admin'])) { return response()->json(['message' => 'Forbidden'], 403); }
            return $next($request);
        }

        if (!$has(['admin','manager'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
