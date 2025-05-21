<?php

namespace App\Jobs;

use App\Models\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Jobs\GeneratePdfJob;


class TranscribeChapterVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chapter;

    public function __construct(Chapter $chapter)
    {
        $this->chapter = $chapter;
    }

    public function handle()
    {
        $videoPath = public_path($this->chapter->video);
        if (!file_exists($videoPath)) {
               \Log::error("TranscribeChapterVideo: Video file does not exist: $videoPath");
            return;
        }

        $file = fopen($videoPath, 'r');
        \Log::info("TranscribeChapterVideo: Sending file to Flask server...");

        $response = Http::attach(
            'audio',
            $file,
            basename($videoPath)
        )
        ->timeout(2000)
        ->post('http://127.0.0.1:5000/transcribe');

        if ($response->successful()) {
            $data = $response->json();
            $this->chapter->script = $data['text'] ?? null;
            \Log::info("TranscribeChapterVideo: Received transcript, dispatching PDF job.");

            GeneratePdfJob::dispatch($data['text']);
            $this->chapter->save();
        } else {
            \Log::error("TranscribeChapterVideo: Flask server error: " . $response->body());
        }
    }
}
