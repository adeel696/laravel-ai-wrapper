<?php

namespace Adeel696\AiWrapper\Providers;

use Adeel696\AiWrapper\Contracts\AiProviderInterface;
use Illuminate\Support\Facades\Http;

class ClaudeProvider implements AiProviderInterface
{
    protected string $model;

    public function __construct()
    {
        $this->model = config('ai.models.claude.default', 'claude-3-opus-20240229');
    }

    public function chat(string $prompt, array $options = []): string
    {
        $response = Http::withToken(config('ai.providers.anthropic.api_key'))
            ->withHeaders(['anthropic-version' => '2023-06-01'])
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => $this->model,
                'max_tokens' => 1024,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                ...$options
            ]);

        return $response->json('content.0.text');
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
        return ['message' => 'Claude does not support function calling'];
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
