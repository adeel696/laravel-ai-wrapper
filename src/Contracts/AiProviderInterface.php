<?php

namespace adeel696\AiWrapper\Contracts;

use Illuminate\Http\UploadedFile;

interface AiProviderInterface
{
    public function chat(string $prompt, array $options = []): string;

    public function complete(string $prompt, array $options = []): string;

    public function summarize(string $text): string;

    public function translate(string $text, string $language): string;

    public function embed(string $text): array;

    public function moderate(string $text): array;

    public function generateImage(string $prompt): string;

    public function transcribeAudio(UploadedFile $file): string;

    public function analyzeFile(UploadedFile $file): string;

    public function functionCall(string $prompt, array $functions): array;

    public function stream(string $prompt, callable $onUpdate): void;

    public function setModel(string $model): self;
}