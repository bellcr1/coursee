@extends('layouts.app')

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Trainers</h1>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Trainers</li>
                </ol>
            </div>
        </nav>
    </div>

    <!-- Trainers Section -->
    <section id="trainers" class="section trainers">
        <div class="container">
            <div class="row gy-5">
                @foreach($coaches as $coach)
                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="600">
                    <a href="{{ route('coach.profile', $coach->id) }}" class="text-decoration-none">
                        <div class="member-img">
                            <img src="{{ asset($coach->image) }}" class="img-fluid"  alt="{{ $coach->name }}">
                            <div class="social">
                                @if($coach->twitter)
                                <a href="{{ $coach->twitter }}"><i class="bi bi-twitter-x"></i></a>
                                @endif
                                @if($coach->facebook)
                                <a href="{{ $coach->facebook }}"><i class="bi bi-facebook"></i></a>
                                @endif
                                @if($coach->instagram)
                                <a href="{{ $coach->instagram }}"><i class="bi bi-instagram"></i></a>
                                @endif
                                @if($coach->linkedin)
                                <a href="{{ $coach->linkedin }}"><i class="bi bi-linkedin"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>{{ $coach->name }}</h4>
                            <span>{{ $coach->specialty }}</span>
                            <p>{{ $coach->description }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>
@endsection