@extends('layouts.admin')

@section('content')

        <div class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card user-form-card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-user-edit mr-2"></i> Edit User Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Personal Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-user-circle"></i> Personal Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">First Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                        name="name" id="name" value="{{ old('name', $user->name) }}" readonly>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                                        name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" readonly>
                                                    @error('lastname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                name="email" id="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                            <label for="category">Expertise Category</label>
                                            <select class="form-control @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category', $user->category) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    
                                    <!-- Social Media Section -->
                                    
                                    
                                    <!-- Professional Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-briefcase"></i> Professional Information</h5>
                                      

                                        @if(Auth::user()->role == 'Admin')
                                        <div class="form-group">
                                            <label for="role">User Role</label>
                                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                                <option value="User" {{ old('role', $user->role) == 'User' ? 'selected' : '' }}>User</option>
                                                <option value="Coach" {{ old('role', $user->role) == 'Coach' ? 'selected' : '' }}>Coach</option>
                                                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                            @enderror
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Password Section (only shown when editing own profile) -->
                                    @if (Auth::user()->id == $user->id)
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-lock"></i> Change Password</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                        name="password" id="password" placeholder="Leave blank to keep current">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm New Password</label>
                                                    <input type="password" class="form-control" 
                                                        name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted">Note: Password must be at least 8 characters long</small>
                                    </div>
                                    @endif

                                    <!-- Form Actions -->
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    
    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    
    <script>
      $(document).ready(function() {
        // Update file input label
        $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        
        // Show password requirements on focus
        $('#password').on('focus', function() {
            $(this).next('.password-requirements').removeClass('d-none');
        });
      });
    </script>
</body>
</html>
@endsection