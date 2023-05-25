<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = [
            'superAdmin' => [1],
            'MR' => [2,6],
            'storeIn' => [3],
            'StockOut' => [4,3],
            'OnlyViewer' => [5],
             'SMR' =>[6],
             'knitting' =>[7],
             'viewExportCalender' =>[8],
        ];
        $roleIds = $roles[$role] ?? [];
        if (!in_array(auth()->user()->role_id, $roleIds)) {
            abort('403');
        }
        return $next($request);
    }
}
