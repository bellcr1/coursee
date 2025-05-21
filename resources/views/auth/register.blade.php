<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('log/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('log/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('log/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('log/css/style.css') }}">

    <title>Register</title>
  </head>
  <body>
  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('log/images/undraw_remotely_2j6y.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>Sign Up</h3>
                <p class="mb-4">Create your account to get started.</p>
              </div>
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group first">
                  <label for="name">First Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="lastname">Last Name</label>
                  <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                         id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                  @error('lastname')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         id="email" name="email" value="{{ old('email') }}" required>
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" 
                         id="password" name="password" required>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group last mb-4">
                  <label for="password-confirm">Confirm Password</label>
                  <input type="password" class="form-control" 
                         id="password-confirm" name="password_confirmation" required>
                </div>

                <input type="submit" value="Register" class="btn btn-block btn-primary">

                <span class="d-block text-left my-4 text-muted">  <a href="{{ route('login') }}">&mdash; or Sign In here &mdash;</a></span>
                
                <div class="social-login">
                  <a href="#" class="facebook">
                    <span class="icon-facebook mr-3"></span> 
                  </a>
                  <a href="#" class="twitter">
                    <span class="icon-twitter mr-3"></span> 
                  </a>
                  <a href="#" class="google">
                    <span class="icon-google mr-3"></span> 
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('log/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('log/js/popper.min.js') }}"></script>
  <script src="{{ asset('log/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('log/js/main.js') }}"></script>
  </body>
</html>