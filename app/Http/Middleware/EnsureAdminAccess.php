<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $allowedEmails = collect(config('posyandu.admin_emails', []))
            ->filter()
            ->map(fn ($email) => strtolower($email))
            ->values()
            ->all();

        $isAdminFlag = $user && (bool) ($user->getAttribute('is_admin') ?? false);

        $isAllowed = $user && (
            $isAdminFlag ||
            (!empty($allowedEmails) && in_array(strtolower($user->email), $allowedEmails, true))
        );

        if (! $isAllowed) {
            abort(403, 'Anda tidak memiliki akses ke area ini.');
        }

        return $next($request);
    }
}
