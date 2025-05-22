<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    |
    | This value controls which AI provider to use by default.
    | Supported: "openai", "anthropic" (Claude), "google" (Gemini)
    |
    */

    'default_provider' => 'openai',

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | This value sets the fallback model to use when no model is specified.
    | You can override it per provider under the 'models' section.
    |
    */

    'default_model' => 'gpt-3.5-turbo',

    /*
    |--------------------------------------------------------------------------
    | API Keys for Each Provider
    |--------------------------------------------------------------------------
    |
    | Define your API keys for supported providers.
    | It's recommended to store these in your .env file for security.
    |
    */

    'providers' => [
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
        ],
        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
        ],
        'google' => [
            'api_key' => env('GOOGLE_AI_API_KEY'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Models per Provider
    |--------------------------------------------------------------------------
    |
    | This allows you to configure the default model for each provider.
    | You can override this dynamically in your code using setModel().
    |
    */

    'models' => [
        'openai' => [
            'default' => 'gpt-3.5-turbo',
        ],
        'claude' => [
            'default' => 'claude-3-opus-20240229',
        ],
        'gemini' => [
            'default' => 'gemini-pro',
        ],
    ],
];
