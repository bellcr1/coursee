<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateQuizContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $scriptText;
    protected int $id;


    public function __construct(string $scriptText ,int $id)
    {
        $this->scriptText = $scriptText;
        $this->id = $id;
    }

    public function handle(): void
    {
        $apiKey = env('OPENROUTER_API_KEY');
        $client = new Client();

        try {
            $response = $client->post("https://openrouter.ai/api/v1/chat/completions", [
                'verify' => storage_path('certs/cacert.pem'),
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'mistralai/mixtral-8x7b-instruct',
                    'messages' => [[
                        'role' => 'user',
                        'content' => "You are a quiz generator. Based **only** on the following text, generate a short multiple-choice quiz (max 3 questions):\n\n{$this->scriptText}\n\nYou must not use any outside knowledge. 
                        Return result as JSON with this structure: { questions: [ {question, options, correctAnswer} ] }"
                    ]],
                    'temperature' => 0.2,
                    'max_tokens' => 600
                ],
            ]);

            $aiResponse = json_decode($response->getBody(), true);
            $quizContent = json_decode($aiResponse['choices'][0]['message']['content'], true);
            \Illuminate\Support\Facades\Log::info("Réponse id:", ['response' => $response->getBody()]);

            if (isset($quizContent['questions']) && is_array($quizContent['questions'])) {
                Cache::put('quiz', $quizContent['questions'], now()->addMinutes(10));
                Cache::put('quizId', $this->id, now()->addMinutes(10));

            } else {
                \Log::error("Quiz JSON malformé ou vide : " . json_encode($quizContent));
            }
        } catch (\Exception $e) {
            \Log::error("Erreur génération quiz : " . $e->getMessage());
        }
    }
}

