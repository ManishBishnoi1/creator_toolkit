<?php

namespace App\Modules\AITools\Actions;

use App\Core\Exceptions\ToolExecutionException;
use Illuminate\Support\Facades\Log;

class GenerateHashtagsAction
{
    /**
     * Execute the action to generate AI hashtags.
     *
     * @param string $niche
     * @param int $count
     * @return array
     * @throws ToolExecutionException
     */
    public function execute(string $niche, int $count = 15): array
    {
        Log::info("Generating {$count} hashtags for niche: {$niche}");

        try {
            // Mocking the generation based on common niches
            $nicheClean = strtolower(trim($niche));
            
            $hashtags = match (true) {
                str_contains($nicheClean, 'tech') || str_contains($nicheClean, 'code') => [
                    '#programming', '#coding', '#developer', '#tech', '#softwareengineer',
                    '#javascript', '#php', '#laravel', '#webdev', '#css', '#ai', '#python',
                    '#indiehackers', '#saas', '#github'
                ],
                str_contains($nicheClean, 'fitness') || str_contains($nicheClean, 'gym') => [
                    '#fitness', '#gym', '#workout', '#motivation', '#fit', '#bodybuilding',
                    '#training', '#health', '#lifestyle', '#healthy', '#gymlife', '#fitfam',
                    '#cardio', '#strength', '#gains'
                ],
                default => [
                    '#creators', '#contentcreation', '#socialmedia', '#branding', '#growth',
                    '#marketing', '#seo', '#instagram', '#tiktok', '#youtube', '#digitalmarketing',
                    '#design', '#photography', '#videography', '#creative'
                ]
            };

            // Slice to matching requested count
            return array_slice($hashtags, 0, $count);

        } catch (\Exception $e) {
            throw ToolExecutionException::aiGenerationFailed($e->getMessage());
        }
    }
}
