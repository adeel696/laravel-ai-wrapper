<?php

namespace adeel696\AiWrapper\Providers;

use adeel696\AiWrapper\Contracts\AiProviderInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class OpenAiProvider implements AiProviderInterface
{
    protected string $model;

    public function __construct()
    {
        $this->model = config('ai.default_model', 'gpt-3.5-turbo');
    }

    public function chat(string $prompt, array $options = []): string
    {
        return 111;
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                ...$options
            ]);

            return $response->json('choices.0.message.content') ?? 'No response received.';
    }

    public function complete(string $prompt, array $options = []): string
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/completions', [
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                'max_tokens' => 100,
                ...$options
            ]);

        return $response->json('choices.0.text');
    }

    public function summarize(string $text): string
    {
        return $this->chat("Summarize the following:\n\n$text");
    }

    public function translate(string $text, string $language): string
    {
        return $this->chat("Translate the following to $language:\n\n$text");
    }

    public function embed(string $text): array
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/embeddings', [
                'model' => 'text-embedding-ada-002',
                'input' => $text,
            ]);

        return $response->json('data.0.embedding');
    }

    public function moderate(string $text): array
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/moderations', [
                'input' => $text,
            ]);

        return $response->json();
    }

    public function generateImage(string $prompt): string
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/images/generations', [
                'prompt' => $prompt,
                'n' => 1,
                'size' => '512x512',
            ]);

        return $response->json('data.0.url');
    }

    public function transcribeAudio(UploadedFile $file): string
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->attach('file', file_get_contents($file->getPathname()), $file->getClientOriginalName())
            ->post('https://api.openai.com/v1/audio/transcriptions', [
                'model' => 'whisper-1'
            ]);

        return $response->json('text');
    }

    public function analyzeFile(UploadedFile $file): string
    {
        // You can implement OpenAI Assistants or use custom logic
        return "Not implemented yet.";
    }

    public function functionCall(string $prompt, array $functions): array
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'functions' => $functions,
                'function_call' => 'auto'
            ]);

        return $response->json();
    }

    public function stream(string $prompt, callable $onUpdate): void
    {
        $response = Http::withToken(config('ai.providers.openai.api_key'))
            ->withHeaders([
                'Accept' => 'text/event-stream'
            ])
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'stream' => true
            ]);

        foreach (explode("\n\n", $response->body()) as $chunk) {
            if (str_starts_with($chunk, 'data: ')) {
                $json = json_decode(substr($chunk, 6), true);
                $onUpdate($json['choices'][0]['delta']['content'] ?? '');
            }
        }
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }
}