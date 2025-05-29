@extends('layouts.app')

@section('content')
<main class="main">
    <!-- Course Details Section -->
    <section id="courses-course-details" class="courses-course-details section">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8">
                    <div class="course-image-container mb-4">
                        @if($course->image)
                            <img src="{{ asset($course->image) }}" class="img-fluid course-image" alt="{{ $course->title }}">
                        @else
                            <img src="{{ asset('home/assets/img/course-details.jpg') }}" class="img-fluid course-image" alt="Default Course Image">
                        @endif
                    </div>
                    
                    <div class="course-description-card mb-4">
                        <h3 class="mb-3">{{ $course->title }}</h3>
                        <div class="description-content">
                            <p>{{ $course->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Course Content Section -->
                    <div class="course-content-card mb-4">
                        <h5 class="mb-4">Course Content</h5>
                        <div class="accordion" id="courseAccordion">
                            @if($chapters->count() > 0)
                                @foreach($chapters as $index => $chapter)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                                {{ $chapter->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                            aria-labelledby="heading{{ $index }}" data-bs-parent="#courseAccordion">
                                            <div class="accordion-body">
                                                <ul class="list-group">
                                                    @php
                                                        $chapterLessons = $lessons->where('chapter_id', $chapter->id)->sortBy('order');
                                                    @endphp
                                                    
                                                    @if($chapterLessons->count() > 0)
                                                        @foreach($chapterLessons as $lesson)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <i class="bi bi-play-circle me-2"></i>
                                                                    {{ $lesson->title }}
                                                                </span>
                                                                @if($lesson->start_time)
                                                                    <span class="badge bg-primary rounded-pill">{{ $lesson->start_time }}</span>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="list-group-item text-muted">No lessons available for this chapter</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    No chapters available for this course yet.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="course-info-card">
                        <div class="course-info-section mb-4">
                            <h4 class="mb-3">Course Details</h4>
                            <div class="course-info d-flex justify-content-between align-items-center mb-3">
                                <span><i class="bi bi-person"></i> Trainer</span>
                                <span><a href="#">{{ $course->name_cotcher }}</a></span>
                            </div>
                            <div class="course-info d-flex justify-content-between align-items-center mb-3">
                                <span><i class="bi bi-book"></i> Category</span>
                                <span class="category">
                                    {{ $course->category ? $categories->find($course->category)->name : 'Uncategorized' }}
                                </span>
                            </div>
                            <div class="course-info d-flex justify-content-between align-items-center mb-3">
                                <span><i class="bi bi-currency-dollar"></i> Price</span>
                                <span>${{ number_format($course->price, 2) }}</span>
                            </div>
                            <div class="course-info d-flex justify-content-between align-items-center mb-3">
                                <span><i class="bi bi-clock"></i> Duration</span>
                                <span>{{ $course->duration }} hours</span>
                            </div>
                        </div>
                        
                        <div class="course-features mb-4">
                            <h5 class="mb-3">This course includes:</h5>
                            <ul class="course-features-list">
                                <li><i class="bi bi-camera-video"></i> 
                                    @php
                                        $lessonCount = 0;
                                        foreach($chapters as $chapter) {
                                            $lessonCount += $lessons->where('chapter_id', $chapter->id)->count();
                                        }
                                    @endphp
                                    {{ $lessonCount }} Video lessons
                                </li>
                                <li><i class="bi bi-collection"></i> {{ $chapters->count() }} Chapters</li>
                                <li><i class="bi bi-clock"></i> {{ $course->duration }} hours of content</li>
                                <li><i class="bi bi-award"></i> Certificate of completion</li>
                            </ul>
                        </div>
                        @php

                            $isPurchased = false;
                            $user = Auth::user();
                            if ($user && $user->purchasedCourses->contains($course->id)) {
                                $isPurchased = true;
                            }
                        @endphp
                        
                        @if ($isPurchased)
                            <div class="course-actions">
                                <a href="{{ route('course.details', $course->id) }}" class="btn btn-primary w-100 mb-2">Start Course</a>
                                <button class="btn btn-outline-secondary w-100">Add to Wishlist</button>
                            </div>
                        @else
                            @auth
                            <div class="course-actions">
                                <a href="{{ route('checkout', $course->id) }}" class="btn btn-primary w-100 mb-2">Buy Now</a>
                                <button class="btn btn-outline-secondary w-100">Add to Wishlist</button>
                            </div>
                            @endauth
                        @endif
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Scroll to Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    /* Main Layout Styles */
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }
    
    /* Course Image Container */
    .course-image-container {
        position: relative;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .course-image {
        width: 100%;
        height: auto;
        display: block;
    }
    
    /* Course Description Card */
    .course-description-card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }
    
    .course-description-card h3 {
        color: #2d4059;
        font-weight: 600;
    }
    
    .description-content {
        line-height: 1.8;
        color: #555;
    }
    
    /* Accordion Styles */
    .accordion-button {
        font-weight: 500;
        background-color: #f8f9fa;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #f1f3f5;
        color: #2d4059;
    }
    
    .accordion-body {
        padding: 1.5rem;
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
        padding: 0.75rem 1.25rem;
    }
    
    /* Course Info Card (Right Sidebar) - Fixed Position */
    .course-info-card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        position: sticky;
        top: 20px;
        height: fit-content;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
    
    .course-info-section h4 {
        color: #2d4059;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .course-info {
        font-size: 15px;
    }
    
    .course-info i {
        margin-right: 8px;
        color: #6c757d;
    }
    
    /* Course Features List */
    .course-features-list {
        list-style: none;
        padding-left: 0;
    }
    
    .course-features-list li {
        padding: 8px 0;
        color: #555;
    }
    
    .course-features-list i {
        margin-right: 10px;
        color: #2d4059;
    }
    
    /* Course Content Card */
    .course-content-card {
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }
    
    .course-content-card h5 {
        color: #2d4059;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    /* Buttons */
    .btn-primary {
        background-color:rgb(227, 144, 19);
        border: none;
        padding: 10px 20px;
    }
    
    .btn-primary:hover {
        background-color:rgb(4, 193, 218);
    }
    
    .btn-outline-secondary {
        border-color:rgb(246, 133, 28);
        color:rgb(237, 134, 32);
    }
    
    .btn-outline-secondary:hover {
        background-color:rgb(4, 193, 218);
        color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .course-info-card {
            position: static;
            margin-top: 30px;
            max-height: none;
        }
    }
</style>
@endsection