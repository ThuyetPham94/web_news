<!-- more from news box -->
<div class="more-from-news">
    <h1>Tin Tức Nôi Bật Trong Tuần</h1>
    <div class="row">
        @foreach (Helper::getArticleByCategory('weekly') as $item)
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="news-post thumb-post">
                <div class="post-image">
                    <a href="single-post-2.html">
                        <img src="{{ asset($item->photo) }}" alt="">
                    </a>
                </div>
                <h2><a href="single-post.html">{{ $item->name }}</a></h2>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- end more from news box -->
