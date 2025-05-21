<?php

namespace App\Console\Commands;

use FPDF;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class GenerateScrumPdf extends Command
{
    protected $signature = 'scrum:pdf';
    protected $description = 'Generate a PDF explaining Scrum methodology using AI';

    public function handle()
    {
        $api_key =env('OPENROUTER_API_KEY');
        $url = "https://openrouter.ai/api/v1/chat/completions";
        $model = "mistralai/mixtral-8x7b-instruct";

        // Texte long à analyser (remplacez par votre contenu)
        $long_text = " What is Scrum? It is the systematic, customer, resolution, unraveling meeting. That just doesn't really ."; // [Votre texte complet ici]

        $client = new Client();
        
        try {
            $this->info("Contacting AI API...");
            
            $response = $client->post($url, [
                'verify' => storage_path('certs/cacert.pem'), // Point to your certificate file
                
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "Explique-moi ce texte de manière claire et structurée, avec :

                                        1. Un titre clair et simple.
                                    2. Une explication étape par étape.
                                    3. La mise en évidence des termes importants en gras.
                                    4. Des exemples concrets de la vie réelle.
                                    5. Une conclusion courte qui commence par : En résumé, 
                                     (Please rewrite the explanation in a clearer and more visually appealing way, using simple and well-organized headings that stand out.)
                                   $long_text"
                        ]
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 800
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            $ai_response = $responseData['choices'][0]['message']['content'];

            $this->info("Generating PDF...");
            
            $pdf = new FPDF();
            $pdf->AddPage();
            
            // Header
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(30, 30, 30);
            $pdf->Cell(0, 10, 'AI-Generated Explanation (Scrum)', 0, 1, 'C');
            $pdf->Ln(5);
            $pdf->SetDrawColor(100, 100, 100);
            $pdf->SetLineWidth(0.3);
            $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
            $pdf->Ln(5);
            
            // Title
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetFillColor(230, 230, 250);
            $pdf->SetTextColor(50, 50, 150);
            $pdf->Cell(0, 10, 'Scrum Explanation:', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            // Content
            $pdf->SetFont('Arial', '', 11);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(0, 7, utf8_decode($ai_response));
            $pdf->Ln();
            
            // Footer
            $pdf->SetY(-15);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->SetTextColor(100, 100, 100);
            $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
            
            // Save to storage
            $filename = 'scrum_output_' . time() . '.pdf';
            $path = storage_path('app/public/' . $filename);
            $pdf->Output($path, 'F');
            
            $this->info("✅ PDF generated successfully!");
            $this->line("📄 Path: " . $path);
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
        }
    }
}