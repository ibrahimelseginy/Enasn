<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Support\Facades\Schema;

class AuditLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $write = in_array($request->method(), ['POST','PUT','PATCH','DELETE'], true);
        if ($write) {
            $data = [
                'user_id' => optional($request->user())->id,
                'method' => $request->method(),
                'path' => $request->path(),
                'payload' => $request->all(),
            ];
            if (Schema::hasColumn('audits','status_code')) { $data['status_code'] = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null; }
            if (Schema::hasColumn('audits','ip')) { $data['ip'] = $request->ip(); }
            if (Schema::hasColumn('audits','user_agent')) { $data['user_agent'] = $request->userAgent(); }
            Audit::create($data);
        }
        return $response;
    }
}
