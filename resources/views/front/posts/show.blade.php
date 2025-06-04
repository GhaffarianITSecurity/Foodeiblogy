<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $post->title }} - Foodei Blog</title>
    <meta name="description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
    <meta name="keywords" content="{{ $post->category->name }}, food blog, {{ $post->tags }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="single-page">

    <header id="header" class="header position-relative">
        <div class="container-fluid container-xl position-relative">
            <div class="top-row d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <span class="fw-bold">فودی بلاگی</span>
                </a>
    
                <div class="d-flex align-items-center">
                   
    
                    <form action="{{ route('search') }}" method="GET" class="search-form ms-4">
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
                        <li><a href="{{ route('home') }}">صفحه اصلی</a></li>
                        @auth
                            <li>
                                <form method='POST' action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-link active text-decoration-none fw-bold">خروج</button>
                                </form>
                            </li>
                            @if(auth()->user()->is_admin)
                                <li><a href="{{ route('admin.dashboard') }}" class="active">داشبورد</a></li>
                            @endif
                            <li><a href="{{ route('profile.edit') }}" class="active">پروفایل</a></li>
                        @endauth
                        @guest
                            <li><a href="{{ route('login') }}" class="active">ورود</a></li>
                        @endguest
                        <li><a href="about.html">درباره ما</a></li>
                        <li><a href="author-profile.html">نویسنده و برنامه نویس وبلاگ</a></li>
                        <li><a href="contact.html">ارتباط با ما</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list mt-4"></i>
                </nav>
            </div>
        </div>
    </header>

    <main class="main">
        <section class="single-post">
            <div class="container">
                <article class="blog-post">
                    <div class="post-img" style="background-color: #f8f9fa; height: 500px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="post-meta">
                        <span><i class="bi bi-clock"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        <span><i class="bi bi-chat-dots"></i> {{ $post->comments->count() }} نظر</span>
                        <span><i class="bi bi-folder"></i> {{ $post->category->name ?? 'بدون دسته‌بندی' }}</span>
                    </div>

                    <h1 class="post-title">{{ $post->title }}</h1>

                    <div class="post-content mb-5">
                        {!! $post->content !!}
                    </div>

                    @if($post->ingredients->isNotEmpty())
                        <div class="ingredients-section mb-5">
                            <h3 class="mb-4">مواد اولیه</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>نام ماده</th>
                                            <th>مقدار</th>
                                            <th>واحد</th>
                                            <th>توضیحات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($post->ingredients as $ingredient)
                                            <tr>
                                                <td>{{ $ingredient->name }}</td>
                                                <td>{{ $ingredient->amount }}</td>
                                                <td>{{ $ingredient->unit }}</td>
                                                <td>{{ $ingredient->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Rating Section -->
                    <div class="rating-section mt-5 mb-5 p-4 border rounded">
                        <h4 class="mb-4">امتیاز</h4>
                        <div class="d-flex align-items-center mb-3">
                            <div class="average-rating me-3">
                                <span class="h3">{{ number_format($post->average_rating, 1) }}</span>
                                <span class="text-muted">/ 5</span>
                            </div>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($post->average_rating) ? '-fill' : '' }} text-warning"></i>
                                @endfor
                                <span class="text-muted ms-2">({{ $post->ratings->count() }} امتیاز)</span>
                            </div>
                        </div>

                        @auth
                            @if($post->user_rating)
                                <div class="user-rating mb-3">
                                    <h5>امتیاز شما</h5>
                                    <form action="{{ route('ratings.update', [$post, $post->user_rating]) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="star-rating me-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $post->user_rating->rating ? '-fill' : '' }} text-warning star" 
                                                   data-rating="{{ $i }}" 
                                                   style="cursor: pointer; font-size: 1.5rem;"></i>
                                            @endfor
                                            <input type="hidden" name="rating" value="{{ $post->user_rating->rating }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">بروزرسانی امتیاز</button>
                                    </form>
                                    <form action="{{ route('ratings.destroy', [$post, $post->user_rating]) }}" method="POST" class="d-inline mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف امتیاز</button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('ratings.store', $post) }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="d-flex align-items-center">
                                        <div class="star-rating me-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star text-warning star" 
                                                   data-rating="{{ $i }}" 
                                                   style="cursor: pointer; font-size: 1.5rem;"></i>
                                            @endfor
                                            <input type="hidden" name="rating" value="0">
                                        </div>
                                        <button type="submit" class="btn btn-primary" disabled>امتیاز دهید</button>
                                    </div>
                                </form>
                            @endif
                        @endauth

                        @guest
                            <p class="text-muted">لطفا برای امتیازدهی <a href="{{ route('login') }}">وارد شوید</a>.</p>
                        @endguest
                    </div>

                    @if($post->tags)
                        <div class="post-tags mt-5 mb-5">
                            <h4>برچسب‌ها:</h4>
                            @foreach(explode(',', $post->tags) as $tag)
                                <a href="#">{{ trim($tag) }}</a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="comments-section mt-5 mb-5 p-4 border rounded">
                        <h3 class="mb-4">نظرات ({{ $post->comments->count() }})</h3>

                        @auth
                            <div class="comment-form mb-4">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control" rows="5" required placeholder="نظر خود را اینجا بنویسید..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">ارسال نظر</button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <p class="text-muted mb-4">لطفا برای ثبت نظر <a href="{{ route('login') }}">وارد شوید</a>.</p>
                        @endguest

                        @if($post->comments->isNotEmpty())
                            <div class="comments-list">
                                @foreach($post->comments->where('parent_id', null) as $comment)
                                    @if($comment->status->value === \App\Enum\CommentStatusEnum::Approved->value)
                                        <div class="comment mb-4">
                                            <!-- Parent comment markup -->
                                            <div class="d-flex align-items-start">
                                                <div class="comment-img me-4">
                                                    @if($comment->user && $comment->user->avatar)
                                                        <img src="{{ Storage::url($comment->user->avatar) }}" alt="{{ $comment->user->full_name }}" class="rounded-circle" width="60">
                                                    @else
                                                        <img src="{{ asset('assets/images/user-avatar.png') }}" alt="Default Profile Image" class="rounded-circle" width="60">
                                                    @endif
                                                </div>
                                                <div class="comment-content pt-2">
                                                    <h5 class="mb-1">{{ $comment->full_name }}</h5>
                                                    <p class="text-muted small mb-2">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                                                    <p class="mb-0">{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                            <!-- Render replies -->
                                            @foreach($post->comments->where('parent_id', $comment->id) as $reply)
                                                @if($reply->status->value === \App\Enum\CommentStatusEnum::Approved->value)
                                                    <div class="comment-reply  mb-20 comment-reply ms-10">
                                                        <div class="d-flex align-items-start">
                                                            <div class="comment-img me-4">
                                                                @if($reply->user && $reply->user->avatar)
                                                                    <img src="{{ Storage::url($reply->user->avatar) }}" alt="{{ $reply->user->full_name }}" class="rounded-circle" width="60">
                                                                @else
                                                                    <img src="{{ asset('assets/images/user-avatar.png') }}" alt="Default Profile Image" class="rounded-circle" width="60">
                                                                @endif
                                                            </div>
                                                            <div class="comment-content pt-2">
                                                                <h5 class="mb-3">{{ $reply->full_name }}</h5>
                                                                <p class="text-muted small mb-2">{{ $reply->created_at->format('M d, Y H:i') }}</p>
                                                                <p class="mb-0">{{ $reply->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">هنوز نظری ثبت نشده است. اولین نظر را شما ثبت کنید!</p>
                        @endif
                    </div>

                    <!-- Related Posts Section -->
                    <div class="related-posts mt-5 mb-5">
                        <h3 class="mb-4">پست‌های مرتبط</h3>
                        <div class="row">
                            @foreach($relatedPosts as $relatedPost)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                            <img src="{{ asset('storage/' . $relatedPost->image) }}" 
                                                 alt="{{ $relatedPost->title }}" 
                                                 class="w-100 h-100"
                                                 style="object-fit: cover;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('posts.show', $relatedPost->id) }}" 
                                                   class="text-decoration-none text-dark">
                                                    {{ $relatedPost->title }}
                                                </a>
                                            </h5>
                                            <p class="card-text text-muted">
                                                <small>
                                                    <i class="bi bi-clock"></i> 
                                                    {{ $relatedPost->created_at->format('M d, Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Foodei Blog</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starContainers = document.querySelectorAll('.star-rating');
            
            starContainers.forEach(container => {
                const stars = container.querySelectorAll('.star');
                const ratingInput = container.querySelector('input[name="rating"]');
                const submitButton = container.closest('form').querySelector('button[type="submit"]');
                
                stars.forEach(star => {
                    star.addEventListener('mouseover', function() {
                        const rating = this.dataset.rating;
                        stars.forEach(s => {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        });
                        for(let i = 0; i < rating; i++) {
                            stars[i].classList.remove('bi-star');
                            stars[i].classList.add('bi-star-fill');
                        }
                    });

                    star.addEventListener('mouseout', function() {
                        const currentRating = ratingInput.value;
                        stars.forEach(s => {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        });
                        for(let i = 0; i < currentRating; i++) {
                            stars[i].classList.remove('bi-star');
                            stars[i].classList.add('bi-star-fill');
                        }
                    });

                    star.addEventListener('click', function() {
                        const rating = this.dataset.rating;
                        ratingInput.value = rating;
                        stars.forEach(s => {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        });
                        for(let i = 0; i < rating; i++) {
                            stars[i].classList.remove('bi-star');
                            stars[i].classList.add('bi-star-fill');
                        }
                        if(submitButton) {
                            submitButton.disabled = false;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>

</body>

</html>