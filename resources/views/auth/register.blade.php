<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register</title>

  <!-- Fonts and Bootstrap -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('log/css/bootstrap.min.css') }}">

  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(145deg, #fff 50%, #fffbe6 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .register-box {
      background: #fff;
      padding: 50px 40px;
      border-radius: 18px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      text-align: center;
    }

    .logo img {
      width: 90px;
      margin-bottom: 20px;
    }

    h3 {
      font-weight: 600;
      font-size: 1.8rem;
      margin-bottom: 10px;
      color: #333;
    }

    .subtitle {
      font-size: 1rem;
      color: #777;
      margin-bottom: 25px;
    }

    .form-group label {
      font-weight: 500;
      color: #444;
      text-align: left;
      display: block;
      margin-bottom: 6px;
    }

    .form-control {
      height: 48px;
      border-radius: 10px;
      border: 1px solid #ddd;
      padding: 10px 15px;
      font-size: 0.95rem;
      transition: all 0.2s;
    }

    .form-control:focus {
      border-color: #FF7B00;
      box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.1);
    }

    .btn-register {
      background-color: #FF7B00;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      padding: 12px;
      border: none;
      border-radius: 10px;
      width: 100%;
      margin-top: 15px;
      transition: all 0.3s ease;
    }

    .btn-register:hover {
      background-color: #e66a00;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 123, 0, 0.3);
    }

    .login-link {
      display: block;
      margin-top: 25px;
      font-size: 0.95rem;
      color: #666;
    }

    .login-link:hover {
      color: #333;
      text-decoration: underline;
    }

    .invalid-feedback {
      display: block;
      font-size: 0.85rem;
      color: red;
      margin-top: 5px;
    }
  </style>
</head>
<body>

  <div class="register-box">
    <div class="logo">
      <img src="{{ asset('home/assets/img/logo11.png') }}" alt="Logo">
    </div>

    <h3>Create Account</h3>
    <p class="subtitle">Get started by creating your account</p>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group text-start">
        <label for="name">First Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="form-group text-start">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
               id="lastname" name="lastname" value="{{ old('lastname') }}" required>
        @error('lastname')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="form-group text-start">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="form-group text-start">
        <label for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" required>
        @error('password')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="form-group text-start">
        <label for="password-confirm">Confirm Password</label>
        <input type="password" class="form-control" 
               id="password-confirm" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn btn-register">Sign Up</button>

      <a href="{{ route('login') }}" class="login-link">— Already have an account? Sign in —</a>
    </form>
  </div>

  <script src="{{ asset('log/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('log/js/popper.min.js') }}"></script>
  <script src="{{ asset('log/js/bootstrap.min.js') }}"></script>
</body>
</html>
