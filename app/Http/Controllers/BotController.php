<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    protected $telegramToken;
    protected $telegramApiUrl;

    public function __construct()
    {
        $this->telegramToken = '7668888525:AAEsfMkRfkDGYxELwwCeu5KTl_fIeMzi12E';
        $this->telegramApiUrl = "https://api.telegram.org/bot{$this->telegramToken}";
    }

    public function handleWebhook(Request $request)
    {
        // Log the raw request
        Log::info('Raw webhook request', [
            'content' => $request->getContent(),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->fullUrl()
        ]);

        try {
            // Try to get the update data
            $update = $request->all();
            
            if (empty($update)) {
                Log::warning('Empty update received');
                return response()->json(['status' => 'error', 'message' => 'Empty update'], 400);
            }

            // Log the parsed update
            Log::info('Parsed update', ['update' => $update]);
            
            if (isset($update['message'])) {
                $message = $update['message'];
                $chatId = $message['chat']['id'];
                $text = $message['text'] ?? '';

                Log::info('Processing message', [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'message' => $message
                ]);

                if (strpos($text, '/start') === 0) {
                    $this->sendWelcomeMessage($chatId);
                } else {
                    $this->processIngredients($chatId, $text);
                }
            } else {
                Log::warning('No message in update', ['update' => $update]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    protected function sendWelcomeMessage($chatId)
    {
        try {
            $message = "Welcome to the Recipe Bot! 🍳\n\n" .
                      "Please list the ingredients you have, separated by commas.\n" .
                      "For example: eggs, milk, flour, sugar\n\n" .
                      "I'll help you find recipes you can make with these ingredients!";

            Log::info('Sending welcome message', ['chat_id' => $chatId]);
            $this->sendTelegramMessage($chatId, $message);
        } catch (\Exception $e) {
            Log::error('Error sending welcome message', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId
            ]);
        }
    }

    protected function processIngredients($chatId, $text)
    {
        try {
            $ingredients = array_map('trim', explode(',', $text));
            
            $message = "I see you have these ingredients:\n" .
                      implode("\n", $ingredients) . "\n\n" .
                      "I'm looking for recipes that match these ingredients...\n" .
                      "This feature is coming soon!";

            Log::info('Processing ingredients', [
                'chat_id' => $chatId,
                'ingredients' => $ingredients
            ]);

            $this->sendTelegramMessage($chatId, $message);
        } catch (\Exception $e) {
            Log::error('Error processing ingredients', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId,
                'text' => $text
            ]);
        }
    }

    protected function sendTelegramMessage($chatId, $text)
    {
        try {
            Log::info('Sending Telegram message', [
                'chat_id' => $chatId,
                'text' => $text
            ]);

            $response = Http::post("{$this->telegramApiUrl}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ]);

            Log::info('Telegram API response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error('Failed to send Telegram message:', [
                    'chat_id' => $chatId,
                    'response' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending Telegram message', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId
            ]);
        }
    }
}
