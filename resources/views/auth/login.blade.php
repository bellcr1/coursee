<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>

  <!-- Fonts -->
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

    .login-box {
      background: #fff;
      padding: 50px 40px;
      border-radius: 18px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px; /* Increased width */
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

    .form-check-label {
      font-size: 0.9rem;
      color: #555;
    }

    .forgot-pass {
      font-size: 0.9rem;
      color: #007bff;
      text-decoration: none;
    }

    .forgot-pass:hover {
      text-decoration: underline;
    }

    .btn-login {
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

    .btn-login:hover {
      background-color: #e66a00;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 123, 0, 0.3);
    }

    .signup-link {
      display: block;
      margin-top: 25px;
      font-size: 0.95rem;
      color: #666;
    }

    .signup-link:hover {
      color: #333;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <div class="logo">
      <img src="{{ asset('home/assets/img/logo11.png') }}" alt="Logo">
    </div>

    <h3>Login</h3>
    <p class="subtitle">Welcome back! Please enter your credentials</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group text-start">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
               id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
        <span class="invalid-feedback d-block text-danger"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="form-group text-start">
        <label for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               id="password" name="password" required>
        @error('password')
        <span class="invalid-feedback d-block text-danger"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember"
                 {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
        @endif
      </div>

      <button type="submit" class="btn btn-login">Login</button>

      <a href="{{ route('register') }}" class="signup-link">— Don't have an account? Sign up —</a>
    </form>
  </div>

  <script src="{{ asset('log/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('log/js/popper.min.js') }}"></script>
  <script src="{{ asset('log/js/bootstrap.min.js') }}"></script>
</body>
</html>
