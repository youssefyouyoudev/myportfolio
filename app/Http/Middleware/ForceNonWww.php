<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceNonWww
{
    /**
     * Redirect www.youssefyouyou.com/* → youssefyouyou.com/* with HTTP 301.
     *
     * This runs on every web request. If the incoming host starts with "www.",
     * we strip it and redirect permanently so search engines consolidate link equity
     * on the canonical non-www version.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        if (str_starts_with($host, 'www.')) {
            $nonWwwHost = substr($host, 4); // strip "www."

            $url = $request->getScheme()
                . '://'
                . $nonWwwHost
                . $request->getRequestUri();

            return redirect()->away($url, 301);
        }

        return $next($request);
    }
}
