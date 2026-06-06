<?php

namespace App\Modules\AITools\DTOs;

use Illuminate\Http\Request;

readonly class CaptionRequestDTO
{
    public function __construct(
        public string $topic,
        public string $tone,
        public int $length,
        public array $keywords = []
    ) {}

    /**
     * Build the DTO from an HTTP request.
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            topic: $request->input('topic'),
            tone: $request->input('tone', 'casual'),
            length: (int) $request->input('length', 150),
            keywords: $request->input('keywords', [])
        );
    }

    /**
     * Convert the DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'topic' => $this->topic,
            'tone' => $this->tone,
            'length' => $this->length,
            'keywords' => $this->keywords,
        ];
    }
}
