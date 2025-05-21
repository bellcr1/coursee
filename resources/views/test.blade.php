<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Transcription</title>
</head>
<body>
    <h1>Transcription Test</h1>

    @if (isset($error))
        <p style="color:red;">Error: {{ $error }}</p>
    @endif

    @if (isset($text))
        <h3>Transcribed Text:</h3>
        <pre>{{ $text }}</pre>

        @if (isset($metrics))
            <h4>Metrics:</h4>
            <ul>
                <li>Duration: {{ $metrics['audio_duration'] ?? '?' }} sec</li>
                <li>Total time: {{ $metrics['total_time'] ?? '?' }} sec</li>
            </ul>
        @endif
    @endif

    <form action="{{ route('transcribe') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="video">Upload video/audio:</label>
        <input type="file" name="video" accept=".mp3,.mp4,.wav,.m4a" required>
        <button type="submit">Transcribe</button>


    </form>
</body>
</html>
