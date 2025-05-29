<?php

namespace App\Jobs;

use FPDF;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $textToExplain;
    protected $id;


    /**
     * Create a new job instance.
     *
     * @param string $textToExplain
     */
    public function __construct($textToExplain,$id)
    {
        $this->textToExplain = $textToExplain;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api_key = env('OPENROUTER_API_KEY');
        if (empty($api_key)) {
            \Log::error("OPENROUTER_API_KEY is not set or empty.");
            return;
        }
        $url = "https://openrouter.ai/api/v1/chat/completions";
        $model = "mistralai/mixtral-8x7b-instruct";

        $client = new Client();

        try {
            \Log::info("Contacting AI API...");
            // الاتصال بالـ API
            $response = $client->post($url, [
                'verify' => storage_path('certs/cacert.pem'),
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "Please explain this text clearly and structurally, with:

1. A simple and clear title.
2. Step-by-step explanation.
3. Important terms highlighted in bold.
4. Real-life concrete examples.
5. A short conclusion starting with: \"In summary,\"

Also, rewrite the explanation with clearer and well-organized headings that stand out.

Here is the text to explain:

{$this->textToExplain}"
                        ]
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 800
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            $ai_response = $responseData['choices'][0]['message']['content'];

            // توليد PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Header
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetTextColor(0, 70, 140);
            $pdf->Cell(0, 12, utf8_decode('AI-Generated Explanation'), 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetDrawColor(0, 70, 140);
            $pdf->SetLineWidth(0.5);
            $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
            $pdf->Ln(7);

            // Title Section
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(40, 40, 40);
            $pdf->Cell(0, 10, utf8_decode('Detailed Explanation:'), 0, 1);
            $pdf->Ln(4);

            // Content
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(0, 7, utf8_decode($ai_response));
            $pdf->Ln();

            // Footer
            $pdf->SetY(-15);
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->SetTextColor(120, 120, 120);
            $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');

            // Save PDF
            $filename = 'chapter' . $this->id . '.pdf';
            $path = storage_path('app/public/' . $filename);
            $pdf->Output('F', $path);

            // هنا ممكن تعمل تسجيل أو إبلاغ عن نجاح العملية
            \Log::info("PDF generated successfully: " . $path);

        } catch (\Exception $e) {
            \Log::error("Error generating Scrum PDF: " . $e->getMessage());
        }
    }
}
