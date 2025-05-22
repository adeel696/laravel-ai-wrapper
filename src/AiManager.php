<?php

namespace adeel696\AiWrapper;
 

use adeel696\AiWrapper\Contracts\AiProviderInterface;
use adeel696\AiWrapper\Providers\OpenAiProvider;
use adeel696\AiWrapper\Providers\ClaudeProvider;
use adeel696\AiWrapper\Providers\GeminiProvider;

class AiManager implements AiProviderInterface
{
    protected AiProviderInterface $provider;

    public function __construct()
    {
        $this->setProvider(config('ai.default_provider', 'openai'));
    }

    public function setProvider(string $name): self
    {
        switch ($name) {
            case 'openai':
                $this->provider = new OpenAiProvider();
                break;

            case 'claude':
                $this->provider = new ClaudeProvider();
                break;

            case 'gemini':
                $this->provider = new GeminiProvider();
                break;

            default:
                throw new \InvalidArgumentException("Unsupported provider [$name]");
        }

        return $this;
    }

    public function setModel(string $model): self
    {
        $this->provider->setModel($model);
        return $this;
    }

    // Delegate all methods to the active provider

    public function chat(string $prompt, array $options = []): string
    {
        return $this->provider->chat($prompt, $options);
    }

    public function complete(string $prompt, array $options = []): string
    {
        return $this->provider->complete($prompt, $options);
    }

    public function summarize(string $text): string
    {
        return $this->provider->summarize($text);
    }

    public function translate(string $text, string $language): string
    {
        return $this->provider->translate($text, $language);
    }

    public function embed(string $text): array
    {
        return $this->provider->embed($text);
    }

    public function moderate(string $text): array
    {
        return $this->provider->moderate($text);
    }

    public function generateImage(string $prompt): string
    {
        return $this->provider->generateImage($prompt);
    }

    public function transcribeAudio($file): string
    {
        return $this->provider->transcribeAudio($file);
    }

    public function analyzeFile($file): string
    {
        return $this->provider->analyzeFile($file);
    }

    public function functionCall(string $prompt, array $functions): array
    {
        return $this->provider->functionCall($prompt, $functions);
    }

    public function stream(string $prompt, callable $onUpdate): void
    {
        $this->provider->stream($prompt, $onUpdate);
    }
}
