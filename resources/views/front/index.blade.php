<!DOCTYPE html>
<html lang="fa">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Foodei- Blogy B</title>
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
        <a href="index.html" class="logo d-flex align-items-end">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.webp" alt=""> -->
          <h1 class="sitename">FoodeiBlogy</h1><span>.</span>
        </a>

        <div class="d-flex align-items-center">
          <div class="social-links">
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          </div>

          <form class="search-form ms-4">
            <input type="text" placeholder="Search..." class="form-control">
            <button type="submit" class="btn"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </div>

    </div>

    <div class="nav-wrap">
      <div class="container d-flex justify-content-center position-relative">
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="index.html" class="active">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="author-profile.html">Author Profile</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
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
          <article class="blog-item featured" data-aos="fade-up">
            <img src="assets/img/blog/blog-post-3.webp" alt="Blog Image" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">Apr. 14th, 2025</span>
                <span class="category">Technology</span>
              </div>
              <h2 class="post-title">
                <a href="blog-details.html" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a>
              </h2>
            </div>
          </article><!-- End Featured Post -->

          <!-- Regular Posts -->
          <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Blog Image" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">Apr. 14th, 2025</span>
                <span class="category">Security</span>
              </div>
              <h3 class="post-title">
                <a href="blog-details.html" title="Sed do eiusmod tempor incididunt ut labore">Sed do eiusmod tempor incididunt ut labore</a>
              </h3>
            </div>
          </article><!-- End Blog Item -->

          <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/blog/blog-post-9.webp" alt="Blog Image" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">Apr. 14th, 2025</span>
                <span class="category">Career</span>
              </div>
              <h3 class="post-title">
                <a href="blog-details.html" title="Ut enim ad minim veniam, quis nostrud exercitation">Ut enim ad minim veniam, quis nostrud exercitation</a>
              </h3>
            </div>
          </article><!-- End Blog Item -->

          <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
            <img src="assets/img/blog/blog-post-7.webp" alt="Blog Image" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">Apr. 14th, 2025</span>
                <span class="category">Cloud</span>
              </div>
              <h3 class="post-title">
                <a href="blog-details.html" title="Adipiscing elit, sed do eiusmod tempor incididunt">Adipiscing elit, sed do eiusmod tempor incididunt</a>
              </h3>
            </div>
          </article><!-- End Blog Item -->

          <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
            <img src="assets/img/blog/blog-post-6.webp" alt="Blog Image" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">Apr. 14th, 2025</span>
                <span class="category">Programming</span>
              </div>
              <h3 class="post-title">
                <a href="blog-details.html" title="Excepteur sint occaecat cupidatat non proident">Excepteur sint occaecat cupidatat non proident</a>
              </h3>
            </div>
          </article><!-- End Blog Item -->

        </div>

      </div>

    </section><!-- /Blog Hero Section -->

    <!-- Featured Posts Section -->
    <section id="featured-posts" class="featured-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Posts</h2>
        <div><span>Check Our</span> <span class="description-title">Featured Posts</span></div>
      </div><!-- End Section Title -->

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
            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Blog Image">
                <div class="blog-post-content">
                  <div class="post-meta">
                    <span><i class="bi bi-person"></i> Julia Parker</span>
                    <span><i class="bi bi-clock"></i> Jan 15, 2025</span>
                    <span><i class="bi bi-chat-dots"></i> 6 Comments</span>
                  </div>
                  <h2><a href="#">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet</a></h2>
                  <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce porttitor metus eget lectus consequat, sit amet feugiat magna vulputate.</p>
                  <a href="#" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div><!-- End slide item -->

            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="assets/img/blog/blog-post-portrait-2.webp" alt="Blog Image">
                <div class="blog-post-content">
                  <div class="post-meta">
                    <span><i class="bi bi-person"></i> Mark Wilson</span>
                    <span><i class="bi bi-clock"></i> Jan 18, 2025</span>
                    <span><i class="bi bi-chat-dots"></i> 6 Comments</span>
                  </div>
                  <h2><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem</a></h2>
                  <p>Maecenas tempus tellus eget condimentum rhoncus sem quam semper libero sit amet adipiscing sem neque sed ipsum.</p>
                  <a href="#" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div><!-- End slide item -->

            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="assets/img/blog/blog-post-portrait-3.webp" alt="Blog Image">
                <div class="blog-post-content">
                  <div class="post-meta">
                    <span><i class="bi bi-person"></i> Sarah Johnson</span>
                    <span><i class="bi bi-clock"></i> Jan 21, 2025</span>
                    <span><i class="bi bi-chat-dots"></i> 15 Comments</span>
                  </div>
                  <h2><a href="#">At vero eos et accusamus et iusto odio dignissimos ducimus</a></h2>
                  <p>Nullam dictum felis eu pede mollis pretium integer tincidunt cras dapibus vivamus elementum semper nisi.</p>
                  <a href="#" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div><!-- End slide item -->

            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="assets/img/blog/blog-post-portrait-4.webp" alt="Blog Image">
                <div class="blog-post-content">
                  <div class="post-meta">
                    <span><i class="bi bi-person"></i> David Brown</span>
                    <span><i class="bi bi-clock"></i> Jan 24, 2025</span>
                    <span><i class="bi bi-chat-dots"></i> 10 Comments</span>
                  </div>
                  <h2><a href="#">Et harum quidem rerum facilis est et expedita distinctio</a></h2>
                  <p>Donec quam felis ultricies nec pellentesque eu pretium quis sem nulla consequat massa quis enim.</p>
                  <a href="#" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div><!-- End slide item -->

            <div class="swiper-slide">
              <div class="blog-post-item">
                <img src="assets/img/blog/blog-post-portrait-5.webp" alt="Blog Image">
                <div class="blog-post-content">
                  <div class="post-meta">
                    <span><i class="bi bi-person"></i> Emma Davis</span>
                    <span><i class="bi bi-clock"></i> Jan 27, 2025</span>
                    <span><i class="bi bi-chat-dots"></i> 6 Comments</span>
                  </div>
                  <h2><a href="#">Nam libero tempore, cum soluta nobis est eligendi optio</a></h2>
                  <p>Aenean leo ligula porttitor eu consequat vitae eleifend ac enim aliquam lorem ante dapibus in viverra.</p>
                  <a href="#" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div><!-- End slide item -->
          </div>

        </div>

      </div>

    </section><!-- /Featured Posts Section -->

    <!-- Category Section Section -->
   

  
    <!-- Latest Posts Section -->
    <section id="latest-posts" class="latest-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Latest Posts</h2>
        <div><span>Check Our</span> <span class="description-title">Latest Posts</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Politics</p>

              <h2 class="title">
                <a href="blog-details.html">Dolorum optio tempore voluptas dignissimos</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-12.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Maria Doe</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jan 1, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-2.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Sports</p>

              <h2 class="title">
                <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-13.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Allisa Mayer</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 5, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-3.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Entertainment</p>

              <h2 class="title">
                <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et soluta</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-10.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mark Dower</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 22, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-4.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Sports</p>

              <h2 class="title">
                <a href="blog-details.html">Non rem rerum nam cum quo minus olor distincti</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-14.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Lisa Neymar</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 30, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-5.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Politics</p>

              <h2 class="title">
                <a href="blog-details.html">Accusamus quaerat aliquam qui debitis facilis consequatur</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-11.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Denis Peterson</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jan 30, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-6.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Entertainment</p>

              <h2 class="title">
                <a href="blog-details.html">Distinctio provident quibusdam numquam aperiam aut</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-15.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mika Lendon</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Feb 14, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

        </div>
      </div>

    </section><!-- /Latest Posts Section -->

 

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Blogy</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

      

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Blogy</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
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