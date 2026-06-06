<?php

namespace App\Modules\AITools\Actions;

use App\Core\Exceptions\ToolExecutionException;
use App\Modules\AITools\DTOs\CaptionRequestDTO;
use Illuminate\Support\Facades\Log;

class GenerateCaptionAction
{
    /**
     * Execute the action to generate AI Caption.
     *
     * @param CaptionRequestDTO $dto
     * @return string
     * @throws ToolExecutionException
     */
    public function execute(CaptionRequestDTO $dto): string
    {
        Log::info('Generating AI Caption with configurations', $dto->toArray());

        try {
            // In a real application, you would invoke the OpenAI client:
            // $client = OpenAI::client(config('services.openai.key'));
            // $response = $client->chat()->create([...]);
            // return $response->choices[0]->message->content;

            // Simulating AI Response generation
            $keywordsList = implode(', ', $dto->keywords);
            
            return "✨ Elevate your feed! ✨\n\n" .
                "Talking all about '{$dto->topic}' today. Let's get real: consistency is key. " .
                "Whether you're starting out or scaling up, keep pushing forward!\n\n" .
                (!empty($keywordsList) ? "Tags: {$keywordsList}\n\n" : "") .
                "What do you think? Let me know in the comments below! 👇";

        } catch (\Exception $e) {
            throw ToolExecutionException::aiGenerationFailed($e->getMessage());
        }
    }
}
