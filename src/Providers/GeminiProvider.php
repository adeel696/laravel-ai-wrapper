<?php

namespace Adeel696\AiWrapper\Providers;

use Adeel696\AiWrapper\Contracts\AiProviderInterface;
use Illuminate\Support\Facades\Http;

class GeminiProvider implements AiProviderInterface
{
    protected string $model;

    public function __construct()
    {
        $this->model = config('ai.models.gemini.default', 'gemini-pro');
    }

    public function chat(string $prompt, array $options = []): string
    {
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key=" . config('ai.providers.google.api_key'), [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            ...$options
        ]);

        return $response->json('candidates.0.content.parts.0.text');
    }

    public function complete(string $prompt, array $options = []): string
    {
        return $this->chat($prompt, $options);
    }

    public function summarize(string $text): string
    {
        return $this->chat("Summarize this:\n\n$text");
    }

    public function translate(string $text, string $language): string
    {
        return $this->chat("Translate this to $language:\n\n$text");
    }

    public function embed(string $text): array
    {
        return [];
    }

    public function moderate(string $text): array
    {
        return [];
    }

    public function generateImage(string $prompt): string
    {
        return 'Not supported';
    }

    public function transcribeAudio($file): string
    {
        return 'Not supported';
    }

    public function analyzeFile($file): string
    {
        return 'Not supported';
    }

    public function functionCall(string $prompt, array $functions): array
    {
        return ['message' => 'Gemini does not support function calling (yet)'];
    }

    public function stream(string $prompt, callable $onUpdate): void
    {
        // Streaming not implemented
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }
}
