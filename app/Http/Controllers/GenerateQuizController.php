<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class GenerateQuizController extends Controller
{
    public function generate(Request $request)
    {          

        $scriptText = $request->input('script');
        Log::info("scriptText AI:", ['response' => $scriptText]);

        $id = $request->input('id');
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
                        'content' => "You are a quiz generator. Based **only** on the following text, generate a short multiple-choice quiz (max 3 questions):\n\n{$scriptText}\n\nYou must not use any outside knowledge. 
                        Return result as JSON with this structure: { questions: [ {question, options, correctAnswer} ] }"
                    ]],
                    'temperature' => 0.2,
                    'max_tokens' => 600
                ],
            ]);

            $aiResponse = json_decode($response->getBody(), true);
            $content = trim($aiResponse['choices'][0]['message']['content']);
            Log::info("AI Raw Content", ['content' => $content]);
            $quizContent = json_decode($content, true);

            Log::info("Réponse AI:", ['response' => $aiResponse]);

            if (isset($quizContent['questions']) && is_array($quizContent['questions'])) {
                Cache::put('quiz', $quizContent['questions'], now()->addMinutes(10));
                Cache::put('quizId', $id, now()->addMinutes(10));

                return back()->with('success', 'Quiz généré avec succès');
            } else {
                Log::error("Quiz JSON malformé ou vide : " . json_encode($quizContent));
                return back()->with('error', 'Erreur: quiz vide ou mal formé.');
            }

        } catch (\Exception $e) {
            Log::error("Erreur génération quiz : " . $e->getMessage());
            return back()->with('error', 'Erreur lors de la génération du quiz.');
        }
    }
}

