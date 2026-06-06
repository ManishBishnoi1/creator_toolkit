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
