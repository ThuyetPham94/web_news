@extends('frontend.index')
@section('content')
<!-- wide-news-heading
    ================================================== -->
<div class="wide-news-heading">

    <div class="item main-news">

        <div class="flexslider">
            <ul class="slides">
                @foreach ($sidebar_articles->take(3)->all() as $item)
                <li>
                    <div class="news-post large-image-post">
                        <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}">
                        <div class="hover-box">
                            @if ($item->subCategory)
                            <a href="#" class="category" style="background: {{ $item->subCategory->color }}">{{ $item->subCategory->name }}</a>
                            @else
                            <a href="#" class="category" style="background: {{ $item->category->color }}">{{ $item->category->name }}</a>
                            @endif
                            <h2><a href="single-post.html">{{ $item->name }} ...</a></h2>
                            <ul class="post-tags">
                                <li><i class="lnr lnr-user"></i>Tác giả: <a href="#">{{ $item->user->name }}</a></li>
                                {{-- <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @foreach ($sidebar_articles->take(-6)->all() as $item)
    <div class="item">
        <div class="news-post image-post">
            <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}">
            <div class="hover-box">
                @if ($item->subCategory)
                <a href="#" class="category" style="background: {{ $item->subCategory->color }}">{{ $item->subCategory->name }}</a>
                @else
                <a href="#" class="category" style="background: {{ $item->category->color }}">{{ $item->category->name }}</a>
                @endif
                <h2><a href="single-post.html">{{ $item->name }} ...</a></h2>
                <ul class="post-tags">
                    <li><i class="lnr lnr-user"></i>Tác giả: <a href="#">{{ $item->user->name }}</a></li>
                    {{-- <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li> --}}
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- End wide-news-heading -->

<!-- content-section
    ================================================== -->
<section id="content-section">
    <div class="container">

        <div class="row">
            <div class="col-lg-8">

                <!-- Posts-block -->
                <div class="posts-block standard-box">
                    <div class="title-section">
                        <h1>Latest News <i class="lnr lnr-bookmark"></i></h1>
                    </div>
                    <?php
                    $latest_news = $latest_articles->take(7);
                    $more_news = $latest_articles->take(-8);
                    ?>
                    @foreach ($latest_news->chunk(2) as $key=>$item)
                    <div class="row">
                        @foreach ($item as $v)
                        <div class="col-sm-6">
                            <div class="news-post standart-post">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="{{ asset($v->photo) }}" alt="{{ $v->name }}">
                                    </a>
                                    @if ($v->subCategory)
                                    <a href="#" class="category" style="background: {{ $v->subCategory->color }}">{{ $v->subCategory->name }}</a>
                                    @else
                                    <a href="#" class="category" style="background: {{ $v->category->color }}">{{ $v->category->name }}</a>
                                    @endif
                                </div>
                                <h2><a href="single-post.html">{{ $v->name }}</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>Tác giả: <a href="#">{{ $v->user->name }}</a></li>
                                    {{-- <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li> --}}
                                    <li><i class="lnr lnr-eye"></i>{{ $v->views }} Views</li>
                                </ul>
                                <p>{{ $v->sort_content }}</p>
                            </div>
                        </div>
                        @if ($key == 3)
                        <div class="col-sm-6">
                            <h2>Xem thêm ...</h2>
                            <ul class="list-news">
                                @foreach ($more_news as $item)
                                <li>
                                    <h2><a href="single-post.html">{{ $item->name }}</a></h2>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <!-- End Posts-block -->

                <!-- Posts-block -->
                <div class="posts-block featured-box">
                    <div class="title-section">
                        <h1>Featured</h1>
                    </div>

                    <div class="owl-wrapper">
                        <div class="owl-carousel" data-num="3">

                            <div class="item">
                                <div class="news-post standart-post">
                                    <div class="post-image">
                                        <a href="single-post-2.html">
                                            <img src="upload/blog/s24.jpg" alt="">
                                        </a>
                                        <a href="#" class="category category-fashion">fashion</a>
                                    </div>
                                    <h2><a href="single-post.html">Autumn wear ...</a></h2>
                                    <ul class="post-tags">
                                        <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                        <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="news-post standart-post">
                                    <div class="post-image">
                                        <a href="single-post-2.html">
                                            <img src="upload/blog/s25.jpg" alt="">
                                        </a>
                                        <a href="#" class="category category-world">world</a>
                                    </div>
                                    <h2><a href="single-post.html">Travelling is part of our life</a></h2>
                                    <ul class="post-tags">
                                        <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                        <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="news-post standart-post">
                                    <div class="post-image">
                                        <a href="single-post-2.html">
                                            <img src="upload/blog/s26.jpg" alt="">
                                        </a>
                                        <a href="#" class="category category-food">food</a>
                                    </div>
                                    <h2><a href="single-post.html">Traditional food</a></h2>
                                    <ul class="post-tags">
                                        <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                        <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="news-post standart-post">
                                    <div class="post-image">
                                        <a href="single-post-2.html">
                                            <img src="upload/blog/s27.jpg" alt="">
                                        </a>
                                        <a href="#" class="category">Politics</a>
                                    </div>
                                    <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                    <ul class="post-tags">
                                        <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                        <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="item">
                                <div class="news-post standart-post">
                                    <div class="post-image">
                                        <a href="single-post-2.html">
                                            <img src="upload/blog/s28.jpg" alt="">
                                        </a>
                                        <a href="#" class="category category-travel">Travel</a>
                                    </div>
                                    <h2><a href="single-post.html">Visiting antic countries is John Doe hobby.</a></h2>
                                    <ul class="post-tags">
                                        <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                        <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- End Posts-block -->

                <!-- Advertisement -->
                <div class="advertisement">
                    <a href="#"><img src="upload/addsense/620x80grey.jpg" alt=""></a>
                </div>
                <!-- End Advertisement -->

                <!-- Posts-block -->
                <div class="posts-block combined-box">
                    <div class="title-section">
                        <h1>Lifestyle</h1>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="news-post standart-post">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s13.jpg" alt="">
                                    </a>
                                    <a href="#" class="category category-fashion">Lifestyle</a>
                                </div>
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="news-post thumb-post">
                                        <div class="post-image">
                                            <a href="single-post-2.html">
                                                <img src="upload/blog/s18.jpg" alt="">
                                            </a>
                                        </div>
                                        <h2><a href="single-post.html">Duis aute irure dolor in reprehenderit in voluptate</a></h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="news-post thumb-post">
                                        <div class="post-image">
                                            <a href="single-post-2.html">
                                                <img src="upload/blog/s20.jpg" alt="">
                                            </a>
                                        </div>
                                        <h2><a href="single-post.html">Excepteur sint occaecat cupidatat non proident</a></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="news-post thumb-post">
                                        <div class="post-image">
                                            <a href="single-post-2.html">
                                                <img src="upload/blog/s24.jpg" alt="">
                                            </a>
                                        </div>
                                        <h2><a href="single-post.html">Consectetur adipisicing elit, sed do eiusmod</a></h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="news-post thumb-post">
                                        <div class="post-image">
                                            <a href="single-post-2.html">
                                                <img src="upload/blog/s15.jpg" alt="">
                                            </a>
                                        </div>
                                        <h2><a href="single-post.html">Culpa qui officia deserunt mollit anim id est</a></h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Posts-block -->

                <!-- Posts-block -->
                <div class="posts-block articles-box">
                    <div class="title-section">
                        <h1>World News</h1>
                    </div>

                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s3.jpg" alt="">
                                    </a>
                                    <a class="category category-travel" href="#">Travel</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s4.jpg" alt="">
                                    </a>
                                    <a class="category category-food" href="#">Food</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s5.jpg" alt="">
                                    </a>
                                    <a class="category category-world" href="#">World</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s6.jpg" alt="">
                                    </a>
                                    <a class="category category-travel" href="#">Travel</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s7.jpg" alt="">
                                    </a>
                                    <a class="category category-tech" href="#">Tech</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="news-post article-post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="post-image">
                                    <a href="single-post-2.html">
                                        <img src="upload/blog/s8.jpg" alt="">
                                    </a>
                                    <a class="category category-fashion" href="#">Fashion</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h2><a href="single-post.html">New alternatives are more productive</a></h2>
                                <ul class="post-tags">
                                    <li><i class="lnr lnr-user"></i>by <a href="#">John Doe</a></li>
                                    <li><a href="#"><i class="lnr lnr-book"></i><span>23 comments</span></a></li>
                                    <li><i class="lnr lnr-eye"></i>872 Views</li>
                                </ul>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <ul class="pagination-list">
                        <li><a href="#">Prev</a></li>
                        <li><a href="#" class="active">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>

                </div>
                <!-- End Posts-block -->

            </div>

            @include('frontend.function.component.sidebar')
        </div>

        <!-- Advertisement -->
        <div class="advertisement">
            <a href="#"><img src="upload/addsense/620x80grey.jpg" alt=""></a>
        </div>
        <!-- End Advertisement -->

        @include('frontend.function.week_news')
    </div>
</section>
<!-- End content section -->
@stop
