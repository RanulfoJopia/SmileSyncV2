<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmileSync - Dental Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fc;
      margin: 0;
      padding: 0;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(90deg, #0077b6, #00b4d8);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .navbar .nav-link {
      color: white !important;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    .navbar .nav-link:hover {
      color: #ffd166 !important;
    }

    /* Hero Section */
    .hero-section {
      padding: 100px 0;
      background: linear-gradient(135deg, #e0f7fa, #ffffff);
    }
    .hero-left h1 {
      font-size: 3.5rem;
      color: #0077b6;
      font-weight: 700;
    }
    .hero-left p {
      font-size: 1.3rem;
      color: #495057;
      margin-bottom: 30px;
    }
    .btn-primary {
      background: #0077b6;
      border: none;
      padding: 15px 35px;
      font-size: 18px;
      border-radius: 50px;
      transition: all 0.3s ease;
      font-weight: 600;
    }
    .btn-primary:hover {
      background: #023e8a;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 119, 182, 0.4);
    }

    /* Section Titles */
    .section-title {
      text-align: center;
      margin-bottom: 60px;
      color: #023e8a;
      font-weight: 700;
    }

    /* Features */
    .card {
      border-radius: 15px;
      transition: 0.3s;
      border: 1px solid #e0f7fa;
      height: 100%; /* Ensures equal height for the grid */
      text-align: center; /* Center the image placeholder */
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    }
    .card img {
      height: 200px;
      width: 100%; /* Ensure width is full */
      object-fit: contain; /* FIX: Shows the whole image without cropping */
      padding: 20px; /* Add padding to prevent image from touching edges */
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      background-color: #f8f9fc; /* Light background for the image area */
    }
    .card-body {
        padding: 25px;
    }

    /* How it works */
    .step-box {
      text-align: center;
      padding: 30px;
      border-radius: 10px;
    }
    .step-box i {
      font-size: 50px;
      color: #0077b6;
      margin-bottom: 15px;
    }

    /* Call to Action (CTA) Section */
    .cta-section {
        background: #00b4d8; 
        padding: 60px 0;
        text-align: center;
        color: white;
    }
    .cta-section h2 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }
    .btn-cta {
        background: #ffd166;
        color: #023e8a;
        border: none;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 50px;
        transition: all 0.3s;
    }
    .btn-cta:hover {
        background: #ffc300;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* Testimonials */
    .testimonial {
      text-align: center;
      padding: 30px;
      border-radius: 15px;
      background: #ffffff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      height: 100%; /* Ensures equal height for the grid */
    }
    .testimonial p {
      font-style: italic;
      color: #6c757d;
    }
    .testimonial h6 {
      margin-top: 15px;
      font-weight: bold;
      color: #0077b6;
    }

    /* Footer */
    footer {
      background: #023e8a;
      color: white;
      padding: 40px 0 20px;
    }
    footer a {
      color: #ffd166;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
    .footer-icon-link {
      margin-right: 15px;
      font-size: 1.5rem;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark px-4 sticky-top">
    <a class="navbar-brand fw-bold" href="{{url("/home")}}">
      <img src="{{ asset('assets/logo.png') }}" alt="Dental Logo" width="40" height="40" class="me-2 rounded-circle">
      SmileSync
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link mx-3" href="{{url("/home")}}">Home</a></li>
        <li class="nav-item"><a class="nav-link mx-3" href="#features">Features</a></li>
        <li class="nav-item"><a class="nav-link mx-3" href="#how-it-works">How It Works</a></li>
        <li class="nav-item"><a class="nav-link mx-3" href="{{url("/register")}}">Register</a></li>
        <li class="nav-item"><a class="nav-link mx-3" href="{{url("/login")}}">Login</a></li>
      </ul>
    </div>
  </nav>

  <section class="hero-section">
    <div class="container-fluid px-5">
      <div class="row align-items-center">
        <div class="col-md-6 hero-left order-2 order-md-1">
          <h1>Sync Your Smile. Simplify Your Care.</h1>
          <p class="lead">Track your dental journey, monitor braces adjustments, and manage appointments all in one secure, intuitive platform.</p>
          <a href="{{url("/register")}}" class="btn btn-primary btn-lg">Start Now <i class="bi bi-chevron-right"></i></a>
        </div>
        
      </div>
    </div>
  </section>

  <section class="py-5 bg-light" id="features">
    <div class="container-fluid px-5">
      <h2 class="section-title"><i class="bi bi-lightbulb-fill text-warning me-2"></i> Designed for Modern Dental Care</h2>
      <p class="text-center text-muted mb-5 lead">We provide the tools you need to take control of your Dental Clinic.</p>
      <div class="row g-4 justify-content-center">
        
        <div class="col-md-4 d-flex"> 
          <div class="card shadow-sm w-100">
            <img src="{{ asset('assets/calendar.jpg') }}" alt="Appointments" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-calendar-check text-success me-2"></i> Smart Appointments</h5>
              <p>Book, view, and manage appointments easily</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 d-flex">
          <div class="card shadow-sm w-100">
            <img src="{{ asset('assets/chart.jpg') }}" alt="Progress" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-bar-chart-line text-warning me-2"></i> Visual Progress Tracker</h5>
              <p>Instantly visualize patient treatment journey with charts, timelines, before-and-after comparisons, and detailed records.</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 d-flex">
          <div class="card shadow-sm w-100">
            <img src="{{ asset('assets/secure.jpg') }}" alt="Records" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-shield-lock text-danger me-2"></i> HIPAA-Compliant Records</h5>
              <p>Keep sensitive patient records safe and easily accessible for authorized professionals.</p>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section>

  <section class="py-5" id="how-it-works">
    <div class="container-fluid px-5">
      <h2 class="section-title"><i class="bi bi-arrow-down-right-square-fill text-info me-2"></i> Getting Started is Simple</h2>
      <div class="row text-center">
        <div class="col-md-4 step-box">
          <i class="bi bi-person-plus-fill"></i>
          <h5>1. Create Account</h5>
          <p>Register quickly to set up your profile and link to your dental practice.</p>
        </div>
        <div class="col-md-4 step-box">
          <i class="bi bi-calendar-event-fill"></i>
          <h5>2. Book & Sync</h5>
          <p>Book new appointments or sync your existing schedule and treatment plan.</p>
        </div>
        <div class="col-md-4 step-box">
          <i class="bi bi-bar-chart-fill"></i>
          <h5>3. Enjoy Clarity</h5>
          <p>Begin tracking your progress and receive timely reminders and insights.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container-fluid px-5">
        <h2>Ready to Simplify Your Dental Journey?</h2>
        <p class="lead mb-4">Join hundreds of satisfied Dentist and practices using SmileSync today.</p>
        <a href="{{url("/register")}}" class="btn btn-cta btn-lg">Sign Up Now and Get Started!</a>
    </div>
  </section>

  <section class="py-5 bg-light">
    <div class="container-fluid px-5">
      <h2 class="section-title"><i class="bi bi-chat-square-quote-fill text-primary me-2"></i> What Our Users Are Saying</h2>
      <div class="row g-4">
        <div class="col-md-4 d-flex">
          <div class="testimonial w-100">
            <p>"SmileSync makes it so easy to manage my appointments. Love it! The reminders are a lifesaver."</p>
            <h6>- Jane D., Braces Patient</h6>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="testimonial w-100">
            <p>"I can track my braces journey and see how far I’ve come. The visual charts are very motivating."</p>
            <h6>- Mark J., Parent of a Patient</h6>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="testimonial w-100">
            <p>"My dentist loves how organized all my records are now. It streamlines my visits and check-ups."</p>
            <h6>- Emily R., General Dentistry User</h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container-fluid px-5">
      <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
          <h5>SmileSync</h5>
          <p>Your trusted partner in dental health tracking, dedicated to clarity and convenience.</p>
          <div>
            <a href="#" class="footer-icon-link"><i class="bi bi-facebook text-white"></i></a>
            <a href="#" class="footer-icon-link"><i class="bi bi-twitter text-white"></i></a>
            <a href="#" class="footer-icon-link"><i class="bi bi-linkedin text-white"></i></a>
          </div>
        </div>
        <div class="col-md-6 text-md-end">
          <p class="mb-1"><i class="bi bi-envelope"></i> support@smilesync.com</p>
          <p class="mb-3"><i class="bi bi-telephone"></i> +63 912 345 6789</p>
          <p>&copy; 2025 SmileSync. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>