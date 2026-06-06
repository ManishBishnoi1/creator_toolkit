<?php

namespace App\Core\Exceptions;

use Exception;

class ToolExecutionException extends Exception
{
    /**
     * Build an instance with dynamic tool metadata.
     */
    public static function failedToScrape(string $url, string $reason): self
    {
        return new self("Instagram scraping failed for URL [{$url}]. Reason: {$reason}", 422);
    }

    public static function aiGenerationFailed(string $reason): self
    {
        return new self("AI response generation failed. OpenAI error: {$reason}", 503);
    }
}
