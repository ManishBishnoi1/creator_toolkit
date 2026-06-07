<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\AITools\Actions\GenerateCaptionAction;
use App\Modules\AITools\DTOs\CaptionRequestDTO;
use App\Modules\Downloader\Actions\FetchInstagramReel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Handle Instagram Reel download scraping requests.
     */
    public function downloadReel(Request $request, FetchInstagramReel $action): JsonResponse
    {
        $request->validate([
            'url' => 'required|url|string',
        ]);

        try {
            $result = $action->execute($request->input('url'));
            
            // Map direct Instagram CDN URLs to local proxy/stream routes to bypass hotlinking blocks
            if (!empty($result['thumbnail_url'])) {
                $result['thumbnail_url'] = route('tools.proxy-image', ['url' => $result['thumbnail_url']]);
            }
            if (!empty($result['video_url'])) {
                $result['video_url'] = route('tools.stream-video', ['url' => $result['video_url']]);
            }

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Proxy Instagram thumbnail images to avoid 403 Forbidden hotlink blocks.
     */
    public function proxyImage(Request $request)
    {
        $url = $request->query('url');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL provided.');
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->get($url);

            if (!$response->successful()) {
                abort(404, 'Image could not be retrieved.');
            }

            return response($response->body(), 200, [
                'Content-Type' => $response->header('Content-Type') ?: 'image/jpeg',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        } catch (\Exception $e) {
            abort(500, 'Image proxy failed.');
        }
    }

    /**
     * Stream Instagram Reel MP4 video files chunk-by-chunk to the client.
     */
    public function streamVideo(Request $request)
    {
        $url = $request->query('url');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL provided.');
        }

        return response()->stream(function () use ($url) {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, [
                'stream' => true,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                ],
            ]);

            $body = $response->getBody();

            while (!$body->eof()) {
                echo $body->read(1024 * 8); // 8KB chunks
                flush();
            }
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Disposition' => 'attachment; filename="instagram_reel.mp4"',
        ]);
    }

    /**
     * Handle AI Caption generation requests.
     */
    public function generateCaption(Request $request, GenerateCaptionAction $action): JsonResponse
    {
        $request->validate([
            'topic' => 'required|string|max:500',
            'tone' => 'nullable|string',
            'length' => 'nullable|integer|min:10|max:1000',
            'keywords' => 'nullable|array',
        ]);

        try {
            $dto = CaptionRequestDTO::fromRequest($request);
            $caption = $action->execute($dto);

            return response()->json([
                'success' => true,
                'caption' => $caption,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
