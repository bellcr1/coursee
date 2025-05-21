<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranscriptionController extends Controller
{
    public function showForm()
    {
        return view('test');
    }

    public function transcribe(Request $request)
    {

        ini_set('max_execution_time', 0); // بلا حد
        set_time_limit(0); // بلا حد

        $request->validate([
            'video' => 'required|file|mimes:mp3,mp4,wav,m4a|max:100000'
        ]);

        $video = $request->file('video');
        $videoPath = $video->getRealPath();  // الحصول على المسار الفعلي للملف
        $filename = $video->getClientOriginalName();  // الحصول على اسم الملف الأصلي

        // استخدم fopen لفتح الملف بطريقة stream
        $file = fopen($videoPath, 'r');  // فتح الملف لقراءته

        // إرسال الملف إلى Flask
        $response = Http::attach(
            'audio',  // اسم الحقل الذي يرسله Flask
            $file,    // البيانات المرفوعة من الملف
            $filename // اسم الملف
        )
        ->timeout(2000)  // تحديد وقت أقصى للطلب في حالة وجود وقت طويل للتحويل
        ->post('http://127.0.0.1:5000/transcribe');  // رابط API الخاص بـ Flask

        // التحقق من الاستجابة
        if ($response->successful()) {
            $data = $response->json();  // استرجاع البيانات من Flask
            return view('test', [
                'text' => $data['text'],
                'metrics' => $data['metrics'] ?? null
            ]);
        } else {
            return view('test', [
                'error' => $response->json()['error'] ?? 'Flask server error'
            ]);
        }
    }
}

