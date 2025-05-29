@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container">
    <main class="content">
        <div class="video-container" id="videoContainer">
            <div class="video-container mb-4">
                <video id="mainVideo" width="100%" controls class="rounded shadow">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div id="noVideoMessage" class="alert alert-info p-3" style="display: none;">No video available for this course.</div>
            </div>
        </div>
        

        <div class="video-info">
            <div class="mb-2">
                <span class="badge badge-primary">ADVANCED LEVEL</span>
            </div>
            <h1 class="course-title">{{$course->title}}</h1>
            <h2 class="video-title">Modern JavaScript Patterns</h2>
            <div class="instructor-info">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Instructor" class="instructor-avatar">
                <div class="instructor-details">
                    <div class="instructor-name">{{$course->name_cotcher}}</div>
                    <div class="instructor-title">Senior Web Architect</div>
                </div>
            </div>
            <div id="chapterScriptContent" >
            <p class="video-description">
                @php
                    $firstScript = null;
                    foreach($chapters as $chapter) {
                        if($chapter->script) {
                            $firstScript = $chapter->script;
                            break;
                        }
                    }
                @endphp
                
             {{ $firstScript ?? 'No script available for this chapter.' }}
            </p>
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary">
                    <i class="fas fa-thumbs-up"></i> Like
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-bookmark"></i> Save
                </button>
                <button class="btn btn-outline btn-icon">
                    <i class="fas fa-share"></i>
                </button>
                <button class="btn btn-outline btn-icon">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>

        <div class="resources">
            <h3 class="section-title">
                <span><i class="fas fa-paperclip"></i> Lesson Resources</span>
                <span>{{$chapters->count()}} files</span>
            </h3>
            @if($chapters->count() > 0)
            @foreach($chapters as $index => $chapter)
            <div class="resource-item">
                <div class="resource-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div class="resource-details">
                    <div class="resource-name">{{$chapter->title}}</div>
                    <div class="resource-meta">PDF</div>
                </div>
                <button class="download-btn" onclick="downloadPdf('{{ $chapter->id }}')">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="resource-item">
                <div class="resource-icon">
                    <i class="fas fa-file-code"></i>
                </div>
                <div class="resource-details">
                    <div class="resource-name">Example Code</div>
                    <div class="resource-meta">JS • 1.1 MB</div>
                </div>
                <button class="download-btn" onclick="downloadPdf('{{ $chapter->id }}')">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="resource-item">
                <div class="resource-icon">
                    <i class="fas fa-link"></i>
                </div>
                <div class="resource-details">
                    <div class="resource-name">Additional Reading</div>
                    <div class="resource-meta">External links</div>
                </div>
                <button class="download-btn"><i class="fas fa-external-link-alt"></i></button>
            </div>
            @endforeach
            @else
            <div class="alert alert-info">
                No chapters available for this course yet.
            </div>
        @endif
        </div>
    </main>

    <aside class="sidebar">
        <div class="chapters-container">
            @if($chapters->count() > 0)
                @foreach($chapters as $index => $chapter)
                    @php
                    $chapterLessons = $lessons->where('chapter_id', $chapter->id)->sortBy('order');
                    @endphp
                   



                   







                  















          
                
                















                    @if ($chapter->script!=NULL)
                        <div class="chapter active" video="{{ asset($chapter->video) }}" data-script="{!! htmlentities($chapter->script) !!}">
                            <div class="chapter-header" >
                                <div class="chapter-title">
                                    <i class="fas fa-folder-open chapter-icon"></i>
                                    <span>{{ $chapter->title }} </span>
                                </div>
                                <div class="chapter-meta">
                                    <span>{{ $chapterLessons->count() }}/{{ $chapterLessons->count() }}</span>
                                    <span>
                                        {{ $chapterLessons->sum('duration') ?? '0' }} min
                                    </span>
                                </div>
                            </div>
        
                            <div class="lessons">
                                @if($chapterLessons->count() > 0)
                                    @foreach($chapterLessons as $lesson)
                                        <div class="lesson completed" >
                                            <div class="lesson-icon-container">
                                                <i class="fas fa-play-circle lesson-icon"></i>
                                            </div>
                                            <div class="lesson-details">
                                                <div class="lesson-title">{{ $lesson->title }}</div>
                                                @if($lesson->start_time)
                                                    <div class="lesson-duration" data-start="{{ $lesson->start_time }}" >{{ $lesson->start_time }} </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-lessons text-muted">
                                        No lessons available for this chapter
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('quiz.launch') }}">
                                    @csrf
                                    <input type="hidden" name="script" value="{{ $chapter->script }}">
                                    <input type="hidden" name="id" value="{{ $chapter->id }}">
                                    <button
                                        class="btn w-100 {{ isset($quizStatus[$chapter->id]) && $quizStatus[$chapter->id] ? 'btn-success' : 'btn-primary' }}"
                                        type="submit"
                                        id="afficherQuizBtn{{ $chapter->id }}"
                                        {{ isset($quizStatus[$chapter->id]) && $quizStatus[$chapter->id] ? 'disabled' : '' }}
                                    >
                                        @if(isset($quizStatus[$chapter->id]) && $quizStatus[$chapter->id])
                                            Quiz déjà validé pour ce chapitre.
                                        @else
                                            🧠 Générer Quiz
                                        @endif
                                    </button>
                                </form>
                                
                                @php
                                    $quiz = \Illuminate\Support\Facades\Cache::get('quiz');
                             
                                $quizId = \Illuminate\Support\Facades\Cache::get('quizId');
                                @endphp
                                
                                
                                
                                <!-- Remove the old button completely -->
                                {{-- <button class="btn btn-primary" id="afficherQuizBtn" onclick="afficherTest()">🧠 Afficher le Quiz</button> --}}
                                
                                <!-- Modal toujours ici -->
                                <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:1000;">
                                    <div id="modalContent" style="background:white; padding:20px; border-radius:10px; width:80%; max-width:600px; z-index:1001;"></div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
                @if(!empty($quiz))
                                
                                    <script>
                                        alert("🧠 Afficher le Quiz");
                                        @php
                                        \Illuminate\Support\Facades\Log::info("Réponse:", ['response' => session('quiz_chapter_id') ]);
                                        @endphp
                                        setTimeout(() => {
                                            afficherTest({{ session('quiz_chapter_id') }}); // يتم عرض الاختبار تلقائيًا بعد الأليرت
                                            
                                        }, 100);
                                    </script>
                              
                
                                @endif
                @php
                
                Cache::forget('quiz');
            @endphp
            @else
                <div class="alert alert-info">
                    No chapters available for this course yet.
                </div>
            @endif
        </div>
    

        <div class="completion-progress">
            <div class="progress-text">
                <span class="progress-label">Course Progress</span>
                <span class="progress-percent">42% Complete</span>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill"></div>
            </div>
        </div>
    </aside>
</div>



      
                <!-- Ajouter un id pour le bouton -->
<!-- Ton modal HTML comme avant -->

<script>
    const questions = @json($quiz);
    const quizId = @json($quizId);;



    function downloadPdf(pdfId) {
        const link = document.createElement('a');
        link.href = `/download-pdf/${pdfId}`;
        link.setAttribute('download', '');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }


    function afficherTest() {
        if (!questions.length) {
            alert("⚠️ Quiz non généré. Attends 5 secondes puis recharge.");
            return;
        }

        

        document.getElementById("modalOverlay").style.display = "flex";
        const modal = document.getElementById("modalContent");


        
        modal.innerHTML = `
            <input type="hidden" id="chapterId" value="${quizId}">
            <h3 id="testStatus">QCM Test:</h3>
            <div id="score"></div>
            <form id="testForm">
                ${questions.map((q, i) => `

                    <div>
                        <h4>Question ${i+1}: ${q.question}</h4>
                        ${q.options.map(opt => `
                            <label><input type="radio" name="q${i}" value="${opt}"> ${opt}</label><br>
                        `).join('')}
                        <p id="result${i}"></p>
                    </div>
                `).join('')}
                <button type="button" id="verifyBtn" onclick="verifierReponses()">Vérifier</button>
            </form>
        `;
        
    }

    function verifierReponses() {
    let score = 0;

    questions.forEach((q, i) => {
        const selected = document.querySelector(`input[name="q${i}"]:checked`);
        const result = document.getElementById(`result${i}`);

        if (!selected) {
            result.textContent = "❌ Choisis une réponse.";
            result.style.color = "red";
        } else if (selected.value === q.correctAnswer) {
            result.textContent = "✅ Correct !";
            result.style.color = "green";
            score++;
        } else {
            result.textContent = "❌ Mauvaise réponse.";
            result.style.color = "red";
        }
    });

    const percent = ((score / questions.length) * 100).toFixed(2);
    document.getElementById("score").innerHTML = `<strong>Votre score: ${score}/${questions.length} (${percent}%)</strong>`;

    const btn = document.getElementById("afficherQuizBtn"+ quizId);

    if (percent >= 70) {
        document.getElementById("testStatus").innerHTML = "✅ Test validé !";
        setTimeout(() => {
            fermerModal();
        }, 1000);

        btn.classList.remove("btn-danger");
        btn.classList.add("btn-success");
        btn.disabled = true;
        btn.innerText = "✔️ Test validé";

        // ✅ Appel AJAX vers le controller Laravel
        fetch('/quiz/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                chapter_id: quizId,
                quiz_passed: true
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log("✔️ Backend confirmé:", data);
        })
        .catch(err => {
            console.error("❌ Erreur fetch:", err);
        });

    } else {
        document.getElementById("testStatus").innerHTML = "❌ Test échoué.";
        btn.classList.remove("btn-success");
        btn.classList.add("btn-danger");
        btn.disabled = false;
        btn.innerText = "❌ Recommencer Quiz";

        setTimeout(() => {
            fermerModal();
        }, 1000);

        fetch('/quiz/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                chapter_id: quizId,
                quiz_passed: false
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log("✔️ Backend confirmé:", data);
        })
        .catch(err => {
            console.error("❌ Erreur fetch:", err);
        });
    }
}

    function fermerModal() {
        document.getElementById("modalOverlay").style.display = "none";
    }

    









document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('mainVideo');
    const videoSource = document.getElementById('videoSource');
    const noVideoMessage = document.getElementById('noVideoMessage');

    let currentVideoUrl = '';
    let pendingSeekTime = null;

    // لما نكليكي على chapter
    document.querySelectorAll('.chapter').forEach(chapter => {
        chapter.addEventListener('click', function (e) {
            // ما تعمل والو إذا الكليكة صارت على lesson
            if (e.target.closest('.lesson')) return;


            const videoUrl = chapter.getAttribute('video');
            if (videoUrl && videoUrl !== currentVideoUrl) {
                currentVideoUrl = videoUrl;
                videoSource.src = videoUrl;
                video.load();
                noVideoMessage.style.display = 'none';
                video.style.display = 'block';
            } else if (!videoUrl) {
                video.style.display = 'none';
                noVideoMessage.style.display = 'block';
            }
            const script = chapter.getAttribute('data-script');
            document.getElementById('chapterScriptContent').textContent = script && script.trim() !== '' ? script : 'No script available for this chapter.';
        });
    });

    function timeToSeconds(timeString) {
        const parts = timeString.split(':').map(Number);
        while (parts.length < 3) parts.unshift(0);
        const [hours, minutes, seconds] = parts;
        return hours * 3600 + minutes * 60 + seconds;
    }

    // لما نكليكي على وقت الدرس
    document.querySelector('.chapters-container').addEventListener('click', function (e) {
        const lesson = e.target.closest('.lesson-duration');
        if (!lesson) return;
        
        // التأكد من أن timeString موجود
        const timeString = lesson.dataset.start;
        if (!timeString) return;

        const seconds = timeToSeconds(timeString);
        console.log("Lesson clicked, time =", seconds);

        // التأكد من تحميل الفيديو
        video.addEventListener('canplay', function handleCanPlay() {
            // نضبط الوقت ونبدأ التشغيل عندما يصبح الفيديو جاهزًا
            video.currentTime = seconds;
            video.play();

            video.removeEventListener('canplay', handleCanPlay); // إزالة الحدث بعد التنفيذ
        });

        // إذا الفيديو لا يزال في وضع التحميل
        if (video.readyState < 3) { // 3 يعني أنه بدأ التحميل جزئياً
            video.load();
            console.log("Lesson clicked, time =");


        } else {
            video.currentTime = seconds;
            video.play();
        }
    });
});


    // Enhanced interactivity with fullscreen functionality
    document.addEventListener('DOMContentLoaded', function() {
        const videoContainer = document.getElementById('videoContainer');
        const fullscreenToggle = document.getElementById('fullscreenToggle');
        
        // Fullscreen toggle functionality
        fullscreenToggle.addEventListener('click', toggleFullscreen);
        
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                videoContainer.classList.add('fullscreen');
                document.body.classList.add('fullscreen');
                
                if (videoContainer.requestFullscreen) {
                    videoContainer.requestFullscreen();
                } else if (videoContainer.webkitRequestFullscreen) {
                    videoContainer.webkitRequestFullscreen();
                } else if (videoContainer.msRequestFullscreen) {
                    videoContainer.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        }
        
        // Handle fullscreen change events
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('msfullscreenchange', handleFullscreenChange);
        
        function handleFullscreenChange() {
            if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                videoContainer.classList.remove('fullscreen');
                document.body.classList.remove('fullscreen');
            }
        }
        
        // Toggle chapter expansion
        document.querySelectorAll('.chapter-header').forEach(header => {
            header.addEventListener('click', () => {
                const chapter = header.parentElement;
                chapter.classList.toggle('active');
                
                // Close other chapters when opening a new one (optional)
                if (chapter.classList.contains('active')) {
                    document.querySelectorAll('.chapter').forEach(ch => {
                        if (ch !== chapter) ch.classList.remove('active');
                    });
                }
            });
        });

        // Simulate lesson selection
        document.querySelectorAll('.lesson').forEach(lesson => {
            lesson.addEventListener('click', (e) => {
                // Remove active class from all lessons
                document.querySelectorAll('.lesson').forEach(l => {
                    l.classList.remove('active');
                });
                
                // Add active class to clicked lesson
                lesson.classList.add('active');
                
                // Mark as completed if not already
                if (!lesson.classList.contains('completed')) {
                    lesson.classList.add('completed');
                    
                    // Update progress
                    updateCourseProgress();
                }
                
                // Update video content
                updateVideoContent(lesson);
            });
        });

        // Play button functionality
        const playBtn = document.querySelector('.play-btn');
        playBtn.addEventListener('click', function() {
            const videoPlayer = document.querySelector('.video-player');
            const placeholder = document.querySelector('.video-placeholder');
            
            if (placeholder) {
                videoPlayer.innerHTML = `
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #000;">
                        <div style="text-align: center; color: white; padding: 2rem; max-width: 500px;">
                            <i class="fas fa-play-circle" style="font-size: 3.5rem; margin-bottom: 1.5rem; color: var(--primary);"></i>
                            <h3 style="margin-bottom: 0.5rem; font-weight: 500;">Now Playing</h3>
                            <p style="color: rgba(255,255,255,0.8);">${document.querySelector('.lesson.active .lesson-title').textContent}</p>
                            <div style="margin-top: 1.5rem;">
                                <button style="background: var(--primary); color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 4px; font-weight: 500; cursor: pointer;">
                                    <i class="fas fa-sync-alt" style="margin-right: 0.5rem;"></i> Restart Lesson
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        // Helper function to update course progress
        function updateCourseProgress() {
            const totalLessons = document.querySelectorAll('.lesson').length;
            const completedLessons = document.querySelectorAll('.lesson.completed').length;
            const progressPercent = Math.round((completedLessons / totalLessons) * 100);
            
            const progressBar = document.querySelector('.progress-bar-fill');
            const progressText = document.querySelector('.progress-percent');
            
            progressBar.style.width = progressPercent + '%';
            progressText.textContent = progressPercent + '% Complete';
            
            // Update chapter completion counts
            document.querySelectorAll('.chapter').forEach(chapter => {
                const total = chapter.querySelectorAll('.lesson').length;
                const completed = chapter.querySelectorAll('.lesson.completed').length;
                const meta = chapter.querySelector('.chapter-meta span:first-child');
                
                meta.textContent = `${completed}/${total}`;
            });
        }

        // Helper function to update video content
        function updateVideoContent(lesson) {
            const videoPlaceholder = document.querySelector('.video-placeholder');
            if (videoPlaceholder) {
                videoPlaceholder.querySelector('h3').textContent = 'Ready to Watch';
                videoPlaceholder.querySelector('p').textContent = lesson.querySelector('.lesson-title').textContent;
            }
            
            // Update video info section
            const videoTitle = document.querySelector('.video-title');
            videoTitle.textContent = lesson.querySelector('.lesson-title').textContent;
            
            // Update time display with new lesson duration
            const duration = lesson.querySelector('.lesson-duration').textContent;
            document.querySelector('.time-display').textContent = `0:00 / ${duration}`;
        }
    });
</script>

@endsection
@section('styles')
<style>
    .w-100 {
    width: 100% !important;
}
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #dbeafe;
        --primary-extra-light: #eff6ff;
        --secondary: #059669;
        --dark: #1e293b;
        --dark-gray: #64748b;
        --medium-gray: #94a3b8;
        --light-gray: #e2e8f0;
        --light: #f8fafc;
        --white: #ffffff;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        --radius-sm: 6px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
        background-color: var(--light);
        color: var(--dark);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    /* Video Player Section */
    .video-container {
        background: #000;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .video-container.fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        margin: 0;
        border-radius: 0;
    }

    .video-player {
        width: 100%;
        height: 500px;
        background: linear-gradient(135deg, #1e3a8a, #000);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        position: relative;
    }

    .fullscreen .video-player {
        height: calc(100vh - 60px);
    }

    .video-placeholder {
        text-align: center;
        padding: 2rem;
        max-width: 400px;
    }

    .video-placeholder i {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        color: rgba(255, 255, 255, 0.9);
        transition: var(--transition);
    }

    .video-placeholder h3 {
        font-size: 1.25rem;
        font-weight: 500;
        color: var(--white);
        margin-bottom: 0.5rem;
    }

    .video-placeholder p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    .video-controls {
        background: rgba(0, 0, 0, 0.9);
        padding: 0.75rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fullscreen .video-controls {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1001;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .control-btn {
        background: none;
        border: none;
        color: var(--white);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .control-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
    }

    .control-btn.play-btn {
        background: var(--primary);
    }

    .control-btn.play-btn:hover {
        background: var(--primary-dark);
        transform: scale(1.05);
    }

    .progress-container {
        flex-grow: 1;
        height: 6px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 3px;
        margin: 0 1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .progress-container:hover {
        height: 8px;
    }

    .progress-bar {
        height: 100%;
        background: var(--primary);
        border-radius: 3px;
        width: 30%;
        position: relative;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        background: var(--white);
        border-radius: 50%;
        opacity: 0;
        transition: var(--transition);
    }

    .progress-container:hover .progress-bar::after {
        opacity: 1;
    }

    .time-display {
        color: var(--white);
        font-size: 0.85rem;
        min-width: 80px;
        text-align: center;
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
        opacity: 0.9;
    }

    /* Video Info Section */
    .video-info {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .video-info:hover {
        box-shadow: var(--shadow-md);
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 20px;
        background: var(--light-gray);
        color: var(--dark-gray);
        margin-bottom: 1rem;
    }

    .badge-primary {
        background: var(--primary-light);
        color: var(--primary);
    }

    .course-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--dark);
        line-height: 1.3;
    }

    .video-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--primary);
        position: relative;
        padding-left: 1.5rem;
    }

    .video-title:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .instructor-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--light-gray);
        transition: var(--transition);
    }

    .instructor-avatar:hover {
        transform: scale(1.05);
    }

    .instructor-details {
        display: flex;
        flex-direction: column;
    }

    .instructor-name {
        font-weight: 600;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .instructor-title {
        font-size: 0.85rem;
        color: var(--dark-gray);
    }

    .video-description {
        color: var(--dark-gray);
        margin-bottom: 1.5rem;
        line-height: 1.7;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn {
        padding: 0.65rem 1.25rem;
        border-radius: var(--radius-sm);
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--light-gray);
        color: var(--dark);
    }

    .btn-outline:hover {
        background: var(--light);
        border-color: var(--medium-gray);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        justify-content: center;
        border-radius: 50%;
    }

    /* Resources Section */
    .resources {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .resources:hover {
        box-shadow: var(--shadow-md);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: var(--primary);
    }

    .section-title span:last-child {
        font-size: 0.85rem;
        color: var(--medium-gray);
        font-weight: 500;
    }

    .resource-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--light-gray);
        transition: var(--transition);
    }

    .resource-item:last-child {
        border-bottom: none;
    }

    .resource-item:hover {
        transform: translateX(3px);
    }

    .resource-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .resource-details {
        flex-grow: 1;
    }

    .resource-name {
        font-weight: 500;
        color: var(--dark);
        font-size: 0.95rem;
        margin-bottom: 0.15rem;
    }

    .resource-meta {
        font-size: 0.75rem;
        color: var(--medium-gray);
    }

    .download-btn {
        color: var(--medium-gray);
        background: none;
        border: none;
        cursor: pointer;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .download-btn:hover {
        background: var(--light-gray);
        color: var(--primary);
    }

    /* Chapters Section */
    .chapters-container {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: var(--transition);
    }

    .chapters-container:hover {
        box-shadow: var(--shadow-md);
    }

    .chapter {
        border-bottom: 1px solid var(--light-gray);
    }

    .chapter:last-child {
        border-bottom: none;
    }

    .chapter-header {
        padding: 1.1rem 1.5rem;
        background: var(--white);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .chapter-header:hover {
        background: var(--light);
    }

    .chapter-title {
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
    }

    .chapter-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--medium-gray);
        font-size: 0.85rem;
    }

    .chapter-icon {
        transition: var(--transition);
        color: var(--medium-gray);
    }

    .chapter.active .chapter-header {
        background: var(--primary-light);
    }

    .chapter.active .chapter-icon {
        color: var(--primary);
    }

    .lessons {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .chapter.active .lessons {
        max-height: 1000px;
    }

    .lesson {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid var(--light-gray);
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .lesson:last-child {
        border-bottom: none;
    }

    .lesson:hover {
        background: var(--primary-extra-light);
    }

    .lesson.active {
        background: var(--primary-light);
        padding-left: 1.25rem;
    }

    .lesson.active:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary);
        border-radius: 0 2px 2px 0;
    }

    .lesson-icon-container {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--light-gray);
        transition: var(--transition);
    }

    .lesson.active .lesson-icon-container {
        background: var(--primary-light);
    }

    .lesson.completed .lesson-icon-container {
        background: rgba(16, 185, 129, 0.1);
    }

    .lesson-icon {
        color: var(--medium-gray);
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .lesson.active .lesson-icon {
        color: var(--primary);
    }

    .lesson.completed .lesson-icon {
        color: var(--success);
    }

    .lesson-details {
        flex-grow: 1;
        min-width: 0;
    }

    .lesson-title {
        font-size: 0.92rem;
        color: var(--dark-gray);
        margin-bottom: 0.15rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: var(--transition);
    }

    .lesson.active .lesson-title {
        color: var(--dark);
        font-weight: 500;
    }

    .lesson.completed .lesson-title {
        color: var(--dark);
    }

    .lesson-duration {
        font-size: 0.75rem;
        color: var(--medium-gray);
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
        transition: var(--transition);
    }

    .lesson.active .lesson-duration {
        color: var(--primary);
    }

    .lesson.completed .lesson-duration {
        color: var(--success);
    }

    /* Completion Progress */
    .completion-progress {
        padding: 1.75rem;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-top: 1.5rem;
        transition: var(--transition);
    }

    .completion-progress:hover {
        box-shadow: var(--shadow-md);
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .progress-label {
        font-weight: 500;
        color: var(--dark);
    }

    .progress-percent {
        font-weight: 600;
        color: var(--primary);
    }

    .progress-bar-container {
        height: 8px;
        background: var(--light-gray);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), #3b82f6);
        width: 42%;
        border-radius: 4px;
        transition: width 0.5s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-bar-fill:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            to right,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.3) 50%,
            rgba(255, 255, 255, 0) 100%
        );
        animation: shimmer 2s infinite;
    }

    /* Animations */
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    /* Utility Classes */
    .text-muted {
        color: var(--medium-gray);
    }

    .text-primary {
        color: var(--primary);
    }

    .mb-1 { margin-bottom: 0.5rem; }
    .mb-2 { margin-bottom: 1rem; }
    .mb-3 { margin-bottom: 1.5rem; }

    /* Fullscreen styles */
    body.fullscreen {
        overflow: hidden;
    }

    .fullscreen-toggle {
        display: flex;
    }

    .fullscreen .fullscreen-toggle i:before {
        content: '\f066'; /* compress icon */
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .container {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .video-player {
            height: 450px;
        }
        
        .sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .completion-progress {
            margin-top: 0;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 0 1rem;
        }
        
        .video-player {
            height: 350px;
        }
        
        .video-info {
            padding: 1.5rem;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
        
        .sidebar {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .video-player {
            height: 250px;
        }
        
        .video-controls {
            padding: 0.75rem 1rem;
        }
        
        .control-group {
            gap: 0.5rem;
        }
        
        .time-display {
            min-width: 60px;
            font-size: 0.8rem;
        }
        
        .chapter-header {
            padding: 1rem;
        }
        
        .lesson {
            padding: 0.75rem 1rem;
        }
    }
</style>
