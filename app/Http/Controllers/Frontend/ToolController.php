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
            'authorization' => 'accepted',
        ]);

        try {
            $result = $action->execute($request->input('url'));
            
            // If the thumbnail is a remote URL, we proxy it to avoid blocks, otherwise we keep the local asset URL.
            // Bypasses proxying for Cloudinary URLs since they allow direct hotlinking.
            if (!empty($result['thumbnail_url']) && str_starts_with($result['thumbnail_url'], 'http') && !str_contains($result['thumbnail_url'], request()->getHost()) && !str_contains($result['thumbnail_url'], 'res.cloudinary.com')) {
                $result['thumbnail_url'] = route('tools.proxy-image', ['url' => $result['thumbnail_url']]);
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
            $response = \Illuminate\Support\Facades\Http::withOptions([
                'verify' => false, // Bypass SSL verification for local cert bundle issues
            ])->withHeaders([
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
     * Download the locally stored high-quality MP4 file.
     */
    public function downloadVideo(string $id)
    {
        // Sanitize the ID to prevent path traversal
        $id = basename($id);
        
        $filePath = storage_path("app/public/reels/{$id}.mp4");
        
        if (!file_exists($filePath)) {
            abort(404, 'Video file not found.');
        }

        // Retrieve title metadata from the .info.json if available to give it a nice name
        $fileName = "instagram_reel_{$id}.mp4";
        $jsonPath = storage_path("app/public/reels/{$id}.info.json");
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            if (!empty($jsonData['title'])) {
                // Sanitize filename to prevent special characters breaking headers
                $cleanTitle = preg_replace('/[^A-Za-z0-9_-]/', '_', $jsonData['title']);
                $cleanTitle = substr($cleanTitle, 0, 50); // limit length
                $fileName = "{$cleanTitle}_{$id}.mp4";
            }
        }

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'video/mp4',
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
