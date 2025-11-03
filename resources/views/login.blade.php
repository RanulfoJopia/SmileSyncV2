
@if(session('error'))
<div class="alert alert-danger py-2">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger py-2">{{ $errors->first() }}</div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SmileSync</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url('https://www.bostondentalgroup.com/wp-content/uploads/2015/09/Most-Important-Reasons-to-Visit-the-Dentist.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(8px);
      background-color: rgba(255, 255, 255, 0.4);
      z-index: 0;
    }
  </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-lg border-0" style="max-width: 900px; width: 100%;">
    <div class="row g-0">

      <!-- Left side -->
      <div class="col-md-6 p-5">
        <h2 class="fw-bold" style="color: #1c6ea4;">Sign in to SmileSync</h2>
        <p class="text-muted mb-4">Enter your details below</p>

        <form method="POST" action="{{ url('/login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-50 py-1">Login</button>
        </form>

        <p class="text-center mt-3 mb-0">
          Don’t have an account? 
          <a href="{{ url('/register') }}" class="fw-bold text-decoration-none" style="color: #1c6ea4;">Create account</a>
        </p>
      </div>

      <!-- Right image -->
      <div class="col-md-6 d-none d-md-block">
        <img src="{{ asset('assets/Smile.png') }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
      </div>

    </div>
  </div>
</div>
</body>
</html>
