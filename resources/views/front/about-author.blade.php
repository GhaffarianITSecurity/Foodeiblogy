<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>درباره نویسنده و برنامه نویس - فودی بلاگی</title>
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
</head>
<body class="about-page">
  <header id="header" class="header position-relative">
    <div class="container-fluid container-xl position-relative">
      <div class="top-row d-flex align-items-center justify-content-center">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="fw-bold">فودی بلاگی</span>
        </a>
      </div>
    </div>
    <div class="nav-wrap">
      <div class="container d-flex justify-content-center position-relative">
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('home') }}">صفحه اصلی</a></li>
            @auth
              <li>
                <form method='POST' action={{ route('logout') }}>
                  @csrf
                  <button class="btn btn-link text-decoration-none fw-bold">خروج</button>
                </form>
              </li>
              @if(auth()->user()->is_admin)
                <li><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
              @endif
              <li><a href="{{ route('profile.edit') }}">پروفایل</a></li>
            @endauth
            @guest
              <li><a href="{{ route('login') }}">ورود</a></li>
            @endguest
            <li><a href="{{ route('about') }}">درباره ما</a></li>
            <li><a href="{{ route('author') }}" class="active">درباره نویسنده و برنامه نویس</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list mt-4"></i>
        </nav>
      </div>
    </div>
  </header>
  <main id="main">
    <section id="about-author" class="about">
      <div class="container" data-aos="fade-up">
        <div class="row position-relative justify-content-center">
          <div class="col-lg-7 about-img" style="background-image: url('{{asset('assets/img/about/author-fake.jpg')}}'); background-size: cover; background-position: center; min-height: 400px; width: 100%; padding-bottom: 40px; margin-bottom: 30px;"></div>
          <div class="col-lg-7 d-flex flex-column align-items-center">
            <h2 class="fw-bold mb-4">درباره نویسنده و برنامه نویس</h2>
            <p class="mb-3" style="font-size: 1.2rem;">
              سلام! من یک دانشجوی نرم‌افزار اهل مشهد هستم که عاشق برنامه‌نویسی و آشپزی ایرانی‌ام. از کودکی به غذاهای سنتی ایران علاقه داشتم و همیشه دوست داشتم دستورپخت‌ها را با دیگران به اشتراک بگذارم. این وبلاگ ترکیبی از علاقه من به تکنولوژی و هنر آشپزی است. هدفم این است که با استفاده از دانش برنامه‌نویسی، تجربه‌ای متفاوت و لذت‌بخش برای علاقه‌مندان به غذاهای ایرانی فراهم کنم.
            </p>
            <p class="mb-3" style="font-size: 1.1rem;">
              در کنار تحصیل و توسعه این پروژه، سعی می‌کنم همیشه چیزهای جدید یاد بگیرم و مهارت‌هایم را در هر دو زمینه آشپزی و برنامه‌نویسی ارتقا دهم. اگر شما هم به این حوزه علاقه‌مند هستید، خوشحال می‌شوم تجربیات و نظراتتان را با من به اشتراک بگذارید.
            </p>
            <div class="d-flex flex-column align-items-center mt-4">
              <a href="http://github.com/GhaffarianITSecurity/" target="_blank" class="btn btn-dark mb-2" style="font-size:1rem; direction:ltr;">
                <i class="bi bi-github"></i> پروفایل گیت‌هاب من
              </a>
              <a href="https://github.com/GhaffarianITSecurity/Foodeiblogy/" target="_blank" class="btn btn-outline-primary" style="font-size:1rem; direction:ltr;">
                <i class="bi bi-github"></i> سورس پروژه Foodeiblogy
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; حق نشر <strong><span>فودی بلاگی</span></strong> | تمامی حقوق محفوظ است.
      </div>
    </div>
  </footer>
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>