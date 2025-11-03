<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SmileSync</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .register-card {
      position: relative;
      z-index: 1;
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
    }
  </style>
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 w-100 register-card" style="max-width: 850px;">
      <div class="row g-0">

        <!-- Left side (Form) -->
        <div class="col-md-6 p-5">
          <h4 class="fw-bold text-primary">Create Your SmileSync Account</h4>
          <p class="text-muted mb-4">Fill in your details below</p>

          <!-- Validation Errors -->
          @if ($errors->any())
            <div class="alert alert-danger p-2">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Success Message -->
          @if(session('success'))
            <div class="alert alert-success p-2">{{ session('success') }}</div>
          @endif

          <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="row">
              <div class="col-md-6 mb-2">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control form-control-sm" required>
              </div>
              <div class="col-md-6 mb-2">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control form-control-sm" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-2">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="form-control form-control-sm" required>
              </div>
              <div class="col-md-6 mb-2">
                <label class="form-label">Suffix</label>
                <input type="text" name="suffix" value="{{ old('suffix') }}" class="form-control form-control-sm" placeholder="e.g. Jr, Sr, III">
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" required>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-sm" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control form-control-sm" required>
              </div>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary w-50 py-1">Register</button>
            </div>

            <p class="text-center mb-0">
              Already have an account?
              <a href="{{ url('/login') }}" class="fw-bold text-decoration-none text-primary">Login here</a>
            </p>
          </form>
        </div>

        <div class="col-md-6 d-none d-md-block">
          <img src="{{ asset('assets/Smile.png') }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
        </div>

      </div>
    </div>
  </div>

</body>
</html>
