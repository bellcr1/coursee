@extends('layouts.app')

@section('content')
<main class="main">
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold mb-3">{{ $user->name }}'s Profile</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section profile">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="profile-card text-center p-4 rounded-4 shadow">
                        <div class="profile-image mb-4">
                            @if($user->image)
                                <img src="{{ asset($user->image) }}" class="img-fluid rounded-circle border-4 border-white shadow" width="300" height="200" alt="{{ $user->name }}">
                            @else
                                <img src="{{ asset('images/default-profile.jpg') }}" class="img-fluid rounded-circle border-4 border-white shadow" width="300" height="200" alt="Default profile">
                            @endif
                        </div>
                        <h3 class="fw-bold mb-2">{{ $user->name }} {{ $user->lastname }}</h3>

                        <div class="social-links mb-4">
                            @if($user->linkedin_url)
                                <a href="{{ $user->linkedin_url }}" target="_blank" class="btn btn-light btn-sm rounded-circle me-2">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                            @if($user->twitter_url)
                                <a href="{{ $user->twitter_url }}" target="_blank" class="btn btn-light btn-sm rounded-circle">
                                    <i class="bi bi-twitter-x"></i>
                                </a>
                            @endif
                        </div>
                        
                        @if(Auth::id() == $user->id)
                            <a href="{{ route('coach.edit', $user->id) }}" class="btn btn-sm btn-outline-primary mt-3">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="profile-content p-4 rounded-4 shadow">
                        <!-- Profile content here -->
                        <div class="profile-header mb-5">
                            <h2 class="fw-bold mb-3 animate-text-gradient">About {{$user->name}} {{$user->lastname}}</h2>
                            <p class="text-muted mb-0">Empowering students through innovative online learning experiences.</p>
                        </div>

                        <!-- Biography Section -->
                        <div class="profile-section mb-5">
                            <h3 class="section-title mb-3">Biography</h3>
                            <p class="text-muted lh-base">{{ $user->description }}.</p>
                        </div>

                        <!-- Expertise Section -->
                        <div class="profile-section mb-5">
                            <h3 class="section-title mb-3">Expertise</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="expertise-item d-flex align-items-center p-3 rounded-3 shadow-sm bg-white hover-scale">
                                        <i class="bi bi-check-circle-fill text-primary me-3"></i>
                                        <span class="fw-medium">Course Design</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="expertise-item d-flex align-items-center p-3 rounded-3 shadow-sm bg-white hover-scale">
                                        <i class="bi bi-check-circle-fill text-primary me-3"></i>
                                        <span class="fw-medium">Interactive Learning</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="expertise-item d-flex align-items-center p-3 rounded-3 shadow-sm bg-white hover-scale">
                                        <i class="bi bi-check-circle-fill text-primary me-3"></i>
                                        <span class="fw-medium">Student Engagement</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="expertise-item d-flex align-items-center p-3 rounded-3 shadow-sm bg-white hover-scale">
                                        <i class="bi bi-check-circle-fill text-primary me-3"></i>
                                        <span class="fw-medium">Digital Assessment</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection