<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Services\SEOService;

class SEOMiddleware
{
    public function __construct(
        protected SEOService $seoService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getPathInfo();

        // 1. Enforce Lowercase URLs for SEO consistency (except files, internal routes, etc.)
        if ($request->isMethod('get') && !str_starts_with($path, '/_') && preg_match('/[A-Z]/', $path)) {
            $lowercaseUrl = strtolower($request->getBaseUrl() . $path);
            $query = $request->getQueryString();
            if ($query) {
                $lowercaseUrl .= '?' . $query;
            }
            return redirect($lowercaseUrl, 301);
        }

        // 2. Strip Trailing Slashes (except root) to prevent duplicate content indexing issues
        if ($request->isMethod('get') && $path !== '/' && str_ends_with($path, '/')) {
            $trimmedUrl = rtrim($request->getBaseUrl() . $path, '/');
            $query = $request->getQueryString();
            if ($query) {
                $trimmedUrl .= '?' . $query;
            }
            return redirect($trimmedUrl, 301);
        }

        // Initialize canonical URL on the singleton service
        $this->seoService->setCanonical($request->url());

        $response = $next($request);

        // 3. Inject standard security and browser-crawling headers
        if ($response instanceof Response) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
    }
}
