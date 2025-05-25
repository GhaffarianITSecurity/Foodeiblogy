<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>جستجو - فودی بلاگی</title>
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

<body class="search-page">

  <!-- ======= Header ======= -->
  <header id="header" class="header position-relative">
    <div class="container-fluid container-xl position-relative">
      <div class="top-row d-flex align-items-center justify-content-center">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="fw-bold">فودی بلاگی</span>
        </a>

        <div class="d-flex flex-column align-items-center mt-4">
          <form action="{{ route('search') }}" method="GET" class="search-form mb-3">
            <input type="text" name="query" placeholder="جستجو..." class="form-control" value="{{ $query }}">
            <button type="submit" class="btn"><i class="bi bi-search"></i></button>
          </form>

          <div class="social-links">
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          </div>
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
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list mt-4"></i>
        </nav>
      </div>
    </div>
  </header>

  <main id="main">
    <section class="search-results section">
      <div class="container section-title" data-aos="fade-up">
        <h2>نتایج جستجو برای: {{ $query }}</h2>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
              <article class="post-card shadow-sm rounded overflow-hidden h-100">
                <div class="post-img position-relative">
                  <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                  <span class="post-date position-absolute bottom-0 end-0 bg-light text-dark m-2 px-2 py-1 rounded-pill small">
                    <i class="bi bi-calendar me-1"></i>
                    <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('M d, Y') }}</time>
                  </span>
                </div>

                <div class="post-content p-3">
                  <a href="{{ route('posts.category', $post->category->slug ?? 'uncategorized') }}" class="post-category d-inline-block mb-2 badge bg-primary text-decoration-none">{{ $post->category->name ?? 'دسته‌بندی نشده' }}</a>
                  
                  @if($post->tags)
                    <div class="post-tags mb-2">
                      @foreach(explode(',', $post->tags) as $tag)
                        <span class="badge bg-light text-dark me-1">{{ trim($tag) }}</span>
                      @endforeach
                    </div>
                  @endif

                  <h3 class="title fs-5 fw-bold">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                  </h3>
                  
                  @if($post->excerpt)
                    <p class="excerpt text-muted small mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                  @endif

                  <div class="d-flex align-items-center mt-auto pt-2 border-top">
                    
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary ms-auto">ادامه مطلب</a>
                  </div>
                </div>
              </article>
            </div>
            @endforeach
          @else
            <div class="col-12 text-center py-5">
              <i class="bi bi-search display-1 text-muted"></i>
              <p class="mt-3 fs-5">هیچ نتیجه‌ای برای «{{ $query }}» یافت نشد.</p>
              <a href="{{ route('home') }}" class="btn btn-primary mt-2">بازگشت به صفحه اصلی</a>
            </div>
          @endif
        </div>

        <div class="d-flex justify-content-center mt-5">
          {{ $posts->links() }}
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
            <p>مشهد خیابان دلاروران</p>
            <p>کد پستی: ۱۴۳۴۵۶۷۸۹۰</p>
            <p class="mt-3"><strong>تلفن:</strong> <span>۱۲۳۴۵۶۷۸</span></p>
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