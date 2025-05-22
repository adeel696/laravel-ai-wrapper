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

composer require adeel696/ai-wrapper

⚙️ Configuration & 🧪 Usage

php artisan vendor:publish --tag=config

Update config/ai.php as needed:

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

In your .env file, add the relevant API keys:

OPENAI_API_KEY=your-openai-api-key
ANTHROPIC_API_KEY=your-anthropic-api-key
GOOGLE_AI_API_KEY=your-google-api-key


## Imoprt and Initialize

use Adeel696\AiWrapper\AiManager;

$ai = new AiManager();


3. Usage Examples

🔁 Set Provider and Model (Optional)
$ai->setProvider('claude')->setModel('claude-3-opus-20240229');

💬 Chat (Default Provider)
$response = $ai->chat("Tell me about Laravel.");
echo $response;

📄 Summarize Text
$text = "Laravel is a PHP framework designed for web artisans...";
echo $ai->summarize($text);

🌐 Translate Text
echo $ai->translate("How are you?", "es");

🧠 Embed Text (for semantic search)
$vector = $ai->embed("What is AI?");
print_r($vector);

🎧 Transcribe Audio
$response = $ai->transcribeAudio(storage_path('audio/voice.mp3'));
echo $response;

🧩 Stream Output (if supported by provider)
$ai->stream("Tell me a joke.", function ($chunk) {
    echo $chunk;
});

🧰 Available Methods
Method	Description
chat()	            Chat completion from AI model
complete()	        Standard text completion
summarize()	        Summarize long text input
translate()	        Translate text to another language
embed()	            Get vector embedding of a prompt
moderate()	        Run moderation check on text
generateImage()	    Generate image from a text prompt
transcribeAudio()	Transcribe audio file to text
analyzeFile()	    Analyze content from uploaded file
functionCall()	    Perform structured function call (OpenAI)
stream()	        Stream AI response in real-time