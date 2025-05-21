@extends('layouts.app')

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold mb-3">Edit Profile</h1>
                        <p class="text-muted mb-0">Update your coach profile information.</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('trainers') }}">Trainers</a></li>
                    <li><a href="{{ route('coach.profile', auth()->id()) }}">My Profile</a></li>
                    <li class="current">Edit Profile</li>
                </ol>
            </div>
        </nav>
    </div>

    <section class="section profile-edit">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg rounded-4">
                        <div class="card-body p-4">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('coach.update', $user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" 
                                               value="{{ old('lastname', $user->lastname) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3" >
                                    <label for="role" class="form-label fw-bold">role</label>

                                    <select name="role" id="role">
                                        <option value="{{ $user->role }}">{{ $user->role }}</option>
                                        @if ($user->role == 'Admin')
                                        <option value="User">User</option>
                                        <option value="Coach">Coach   </option>
                                        @elseif ($user->role == 'Coach')
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                        @else
                                        <option value="Coach">Coach   </option>
                                        <option value="Admin">Admin</option>
                                        @endif

                                      </select>
                                    
                                   
                                </div>
                               

                                <div class="mb-4">
                                    <label for="description" class="form-label">Biography</label>
                                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $user->description) }}</textarea>
                                </div>

                                <!-- Expertise Section -->
                                <div class="mb-4">
                                    <label class="form-label">Expertise</label>
                                    
                                    <div class="row g-2 mb-3">
                                        @php
                                            $currentExpertises = $user->expertise ? explode(',', $user->expertise) : [];
                                            $commonExpertises = [
                                                'Course Design',
                                                'Interactive Learning', 
                                                'Student Engagement',
                                                'Digital Assessment',
                                                'Curriculum Development',
                                                'E-Learning'
                                            ];
                                        @endphp
                                        
                                        @foreach($commonExpertises as $expertise)
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="expertises[]" 
                                                           id="expertise-{{ Str::slug($expertise) }}"
                                                           value="{{ $expertise }}"
                                                           {{ in_array($expertise, $currentExpertises) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="expertise-{{ Str::slug($expertise) }}">
                                                        {{ $expertise }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="custom_expertise" class="form-label">Add Custom Expertise</label>
                                        <input type="text" class="form-control" id="custom_expertise" name="custom_expertise" 
                                               placeholder="Enter additional expertise (comma separated)"
                                               value="{{ old('custom_expertise') }}">
                                        <small class="text-muted">Example: "Online Teaching, Educational Technology"</small>
                                    </div>
                                    
                                    @if(!empty($currentExpertises))
                                        <div class="selected-expertises mt-3">
                                            <h6>Current Expertises:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($currentExpertises as $expertise)
                                                    <span class="badge bg-primary">{{ $expertise }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @if($user->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($user->image) }}" 
                                                 alt="Current Profile Image" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 150px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                        <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                               value="{{ old('linkedin_url', $user->linkedin_url) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="twitter_url" class="form-label">Twitter URL</label>
                                        <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                               value="{{ old('twitter_url', $user->twitter_url) }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('coach.profile', auth()->id()) }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Page Structure */
.main {
    padding-top: 2rem;
    padding-bottom: 4rem;
}

.page-title {
    margin-bottom: 3rem;
}

.heading h1 {
    font-size: 2.5rem;
    color: #2c3e50;
}

.breadcrumbs {
    background: #f8f9fa;
    padding: 1rem 0;
}

.breadcrumbs ol {
    margin-bottom: 0;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-body {
    padding: 2rem;
}

/* Form Elements */
.form-control {
    border-radius: 10px;
    padding: 12px 15px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #87ddf9;
    box-shadow: 0 0 0 0.25rem rgba(135, 221, 249, 0.25);
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

/* Expertise Section */
.form-check-input:checked {
    background-color: #87ddf9;
    border-color: #87ddf9;
}

.badge.bg-primary {
    background-color: #87ddf9 !important;
    color: white;
    font-weight: 500;
    padding: 0.5em 0.8em;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
}

.selected-expertises h6 {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

/* Buttons */
.btn {
    border-radius: 10px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #87ddf9;
    border: none;
}

.btn-primary:hover {
    background-color: #222121;
}

.btn-outline-secondary {
    border-color: #ddd;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .heading h1 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endsection