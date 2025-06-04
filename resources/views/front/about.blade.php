<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>درباره ما - فودی بلاگی</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
</head>

<body class="about-page">

  <!-- ======= Header ======= -->
  <header id="header" class="header position-relative">
    <div class="container-fluid container-xl position-relative">
      <div class="top-row d-flex align-items-center justify-content-center">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="fw-bold">فودی بلاگی</span>
        </a>

        <div class="d-flex align-items-center">
        
        </div>
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
            <li><a href="{{ route('author') }}">درباره نویسنده و برنامه نویس</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list mt-4"></i>
        </nav>
      </div>
    </div>
  </header>

  <main id="main">
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
        <div class="row position-relative justify-content-center">
          <div class="col-lg-7 about-img" style="background-image: url({{asset('assets/img/about/about.jpg')}}); background-size: cover; background-position: center; min-height: 550px; width: 100%; padding-bottom: 40px; margin-bottom: 30px;"></div>
          <div class="col-lg-7 d-flex flex-column align-items-center">
            <h2 style="text-align: center;">درباره من</h2>
            <div class="our-story" style="text-align: center;">
              <h4>دانشجوی مهندسی نرم‌افزار و عاشق غذا</h4>
              <p>سلام! من یک دانشجوی مهندسی نرم‌افزار هستم که عشق زیادی به دنیای غذا و آشپزی دارم. از کودکی، آشپزخانه برای من مکانی جادویی بود که در آن می‌توانستم خلاقیت خود را به نمایش بگذارم.</p>
              <p>در طول تحصیل در رشته مهندسی نرم‌افزار، متوجه شدم که برنامه‌نویسی و آشپزی شباهت‌های زیادی با هم دارند. هر دو نیاز به خلاقیت، دقت، و صبر دارند. همانطور که در برنامه‌نویسی باید الگوریتم‌ها را به درستی پیاده‌سازی کنیم، در آشپزی نیز باید دستور پخت را با دقت دنبال کنیم.</p>
              <p>این وبلاگ محلی است برای به اشتراک گذاشتن تجربیات من در هر دو زمینه. اینجا می‌توانید دستور پخت‌های مورد علاقه من، نکات آشپزی، و گاهی اوقات ارتباط جالب بین دنیای تکنولوژی و آشپزی را پیدا کنید.</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section id="why-us" class="why-us">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>چرا فودی بلاگی؟</h2>
        </div>
        <div class="row g-0" data-aos="fade-up" data-aos-delay="200">
          <div class="col-xl-4 img-bg" style="background-image: url({{asset('assets/img/about/why-us-bg.jpg')}}); background-size: cover; background-position: center; min-height: 450px; padding-bottom: 40px; margin-bottom: 20px;"></div>
          <div class="col-xl-8 slides position-relative">
            <div class="slides-1 swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">ترکیب تکنولوژی و آشپزی</h3>
                    <p>در این وبلاگ، ما تلاش می‌کنیم تا دنیای تکنولوژی و آشپزی را به هم پیوند دهیم. با استفاده از تکنیک‌های مدرن و ابزارهای دیجیتال، تجربه آشپزی را به سطح جدیدی می‌بریم.</p>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">دستور پخت‌های اختصاصی</h3>
                    <p>تمام دستور پخت‌های ما با دقت آزمایش شده‌اند و با جزئیات کامل در اختیار شما قرار می‌گیرند. ما باور داریم که آشپزی خوب نیاز به دستورالعمل‌های دقیق و قابل اعتماد دارد.</p>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">جامعه غذایی</h3>
                    <p>فودی بلاگی تنها یک وبلاگ نیست، بلکه جامعه‌ای از علاقه‌مندان به غذا و تکنولوژی است. ما از تجربیات و نظرات شما استقبال می‌کنیم.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <span class="sitename">فودی بلاگی</span>
          </a>
          <div class="footer-contact pt-3">
            <p>  مشهد خیابان دلاروران</p>
            <p>کد پستی: ۱۴۳۴۵۶۷۸۹۰</p>
            <p class="mt-3"><strong>تلفن:</strong> <span>۰۲۱-۱۲۳۴۵۶۷۸</span></p>
            <p><strong>ایمیل:</strong> <span>info@foodybloggy.ir</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>لینک‌های مفید</h4>
          <ul>
            <li><a href="{{ route('home') }}">صفحه اصلی</a></li>
            <li><a href="{{ route('about') }}">درباره ما</a></li>
            <li><a href="#">خدمات</a></li>
            <li><a href="#">شرایط استفاده</a></li>
            <li><a href="#">حریم خصوصی</a></li>
            <li><a href="{{ route('author') }}">درباره نویسنده و برنامه نویس</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>کپی‌رایت</span> <strong class="px-1 sitename">فودی بلاگی</strong> <span>تمامی حقوق محفوظ است</span></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>