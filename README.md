# Laravel AI Wrapper

**adeel696/ai-wrapper** is a Laravel package that provides a unified interface to interact with multiple AI providers such as **OpenAI (ChatGPT)**, **Anthropic Claude**, and **Google Gemini** — all from a simple, Laravel-friendly wrapper.

---

## 🚀 Features

- 🔌 Unified interface for multiple AI providers
- 🧠 Support for OpenAI, Claude (Anthropic), and Gemini (Google)
- 📦 Works out of the box with Laravel's config and service provider system
- 🔁 Runtime switching of providers and models (`setProvider()`, `setModel()`)
- 🧰 Wrapper methods like `chat`, `summarize`, `translate`, `embed`, and more
- 🧪 Easy to extend with additional providers

---

## 📦 Installation
```bash
composer require adeel696/ai-wrapper
```

## ⚙️ Configuration  & 🧪 Usage
```bash
php artisan vendor:publish --tag=config
```

Update config/ai.php as needed:

```bash
return [

    'default_provider' => 'openai',
    'default_model' => 'gpt-3.5-turbo',

    'providers' => [
        'openai' => ['api_key' => env('OPENAI_API_KEY')],
        'anthropic' => ['api_key' => env('ANTHROPIC_API_KEY')],
        'google' => ['api_key' => env('GOOGLE_AI_API_KEY')],
    ],

    'models' => [
        'openai' => ['default' => 'gpt-3.5-turbo'],
        'claude' => ['default' => 'claude-3-opus-20240229'],
        'gemini' => ['default' => 'gemini-pro'],
    ],
];
```

In your .env file, add the relevant API keys:
```bash
OPENAI_API_KEY=your-openai-api-key
ANTHROPIC_API_KEY=your-anthropic-api-key
GOOGLE_AI_API_KEY=your-google-api-key
```

## Imoprt and Initialize
```bash
use adeel696\AiWrapper\AiManager;

$ai = new AiManager();
```

Usage Examples

🔁 Set Provider and Model (Optional)
```bash
$ai->setProvider('claude')->setModel('claude-3-opus-20240229');
```

💬 Chat (Default Provider)
```bash
$response = $ai->chat("Tell me about Laravel.");
echo $response;
```

📄 Summarize Text
```bash
$text = "Laravel is a PHP framework designed for web artisans...";
echo $ai->summarize($text);
```

🌐 Translate Text
```bash
echo $ai->translate("How are you?", "es");
```

🧠 Embed Text (for semantic search)
```bash
$vector = $ai->embed("What is AI?");
print_r($vector);
```

🎧 Transcribe Audio
```bash
$response = $ai->transcribeAudio(storage_path('audio/voice.mp3'));
echo $response;
```

🧩 Stream Output (if supported by provider)
```bash
$ai->stream("Tell me a joke.", function ($chunk) {
    echo $chunk;
});
```
