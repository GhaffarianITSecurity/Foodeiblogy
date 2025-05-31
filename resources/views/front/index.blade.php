<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Foodei- Blogy </title>
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

  <!-- =======================================================
  * Template Name: Blogy
  * Template URL: https://bootstrapmade.com/blogy-bootstrap-blog-template/
  * Updated: Feb 22 2025 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header position-relative">
    <div class="container-fluid container-xl position-relative">

      <div class="top-row d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="fw-bold">فودی بلاگی</span>
        </a>

        <div class="d-flex align-items-center mt-20">
          <form action="{{ route('search') }}" method="GET" class="search-form me-4">
            <input type="text" name="query" placeholder="جستجو..." class="form-control">
            <button type="submit" class="btn"><i class="bi bi-search"></i></button>
          </form>


        </div>
      </div>

    </div>

    <div class="nav-wrap">
      <div class="container d-flex justify-content-center position-relative">
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('home') }}" class="active">صفحه اصلی</a></li>
            
              @auth
                <li><form method='POST' action={{ route('logout') }}>
                  @csrf
                  <button class="btn btn-link active text-decoration-none fw-bold">خروج</button></form>
                </li>
                @if(auth()->user()->is_admin)
                    <li><a href="{{ route('admin.dashboard') }}" >داشبورد</a></li>
                @endif
                <li><a href="{{ route('profile.edit') }}">پروفایل</a></li>
              @endauth
              @guest
                <li><a href="{{ route('login') }}" >ورود</a></li>
              @endguest
            <li><a href="{{ route('about') }}">درباره ما</a></li>
            <li><a href="{{ route('author') }}">نویسنده و برنامه نویس وبلاگ</a></li>
            <li><a href="contact.html">ارتباط با ما</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list mt-4"></i>
        </nav>
      </div>
    </div>

  </header>

  <main class="main">

    <!-- Blog Hero Section -->
    <section id="blog-hero" class="blog-hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="blog-grid">
          <!-- Featured Post (Large) -->
          @if(isset($featuredPost) && $featuredPost)
          <article class="blog-item featured" data-aos="fade-up">
            <img src="{{ asset('storage/' . $featuredPost->image) }}" alt="{{ $featuredPost->title }}" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">{{ $featuredPost->created_at->format('M d, Y') }}</span>
                <span class="category">{{ $featuredPost->category->name ?? 'Uncategorized' }}</span>
              </div>
              <h2 class="post-title">
                <a href="{{ route('posts.show', $featuredPost->id) }}" title="{{ $featuredPost->title }}">{{ $featuredPost->title }}</a>
              </h2>
            </div>
          </article>
          @endif

          <!-- Regular Posts -->
          @if(isset($latestPosts) && $latestPosts->isNotEmpty())
            @foreach($latestPosts as $post)
            <article class="blog-item" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
              <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">{{ $post->created_at->format('M d, Y') }}</span>
                  <span class="category">{{ $post->category->name ?? 'Uncategorized' }}</span>
                </div>
                <h3 class="post-title">
                  <a href="{{ route('posts.show', $post->id) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                </h3>
              </div>
            </article>
            @endforeach
          @else
            <div class="col-12 text-center">
              <p>پستی جدیدی پیدا نشد.</p>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- Featured Posts Section -->
    <section id="featured-posts" class="featured-posts section">
      <div class="container section-title" data-aos="fade-up">
        <h2>پست های برتر</h2>
        <div><span>پست های</span> <span class="description-title">برتر مارا ببینید</span></div>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="blog-posts-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 800,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 3,
              "spaceBetween": 30,
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 20
                },
                "768": {
                  "slidesPerView": 2,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 30
                }
              }
            }
          </script>

          <div class="swiper-wrapper">
            @if(isset($featuredPosts) && $featuredPosts->isNotEmpty())
              @foreach($featuredPosts as $post)
              <div class="swiper-slide">
                <div class="blog-post-item">
                  <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                  <div class="blog-post-content">
                    <div class="post-meta">
                      <span><i class="bi bi-clock"></i> {{ $post->created_at->format('M d, Y') }}</span>
                      <span><i class="bi bi-chat-dots"></i> {{ $post->comments_count ?? 0 }} Comments</span>
                    </div>
                    <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
                    <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <div class="col-12 text-center">
                <p>پستی پیدا نشد.</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- Category Section Section -->
   

  
    <!-- Latest Posts Section -->
    <section id="latest-posts" class="latest-posts section">
      <div class="container section-title" data-aos="fade-up">
        <h2>اخرین پست ها</h2>
        <div><span>اخرین</span> <span class="description-title">پست های مارو ببنید</span></div>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @if(isset($recentPosts) && $recentPosts->isNotEmpty())
            @foreach($recentPosts as $post)
            <div class="col-lg-4">
              <article>
                <div class="post-img">
                  <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
                </div>

                <p class="post-category">{{ $post->category->name ?? 'Uncategorized' }}</p>

                <h2 class="title">
                  <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                </h2>

                <div class="d-flex align-items-center">
                  <div class="post-meta">
                    <p class="post-date">
                      <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('M d, Y') }}</time>
                    </p>
                  </div>
                </div>
              </article>
            </div>
            @endforeach
          @else
            <div class="col-12 text-center">
              <p>پست های جدیدی پیدا نشد</p>
            </div>
          @endif
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
            <li><a href="{{ route('author') }}">نویسنده و برنامه نویس وبلاگ</a></li>
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
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>