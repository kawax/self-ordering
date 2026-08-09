<?php

declare(strict_types=1);

namespace Revolution\Ordering\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HasTable
{
    /**
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->table)) {
            return redirect()->route('table');
        }

        return $next($request);
    }
}
