<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ env('APP_URL') }}">Home</a>
                </li>
                @foreach ($categories as $item)
                <?php
                $articles = Helper::getArticleByCategory('nav', $item->id);
                ?>
                <li class="nav-item">
                    <a class="nav-link world" href="#">{{ $item->name }} @if (count($articles))
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    @endif</a>
                    @if (count($articles))
                    <div class="mega-posts-menu">
                        <div class="posts-line">
                            @if (count($item->subCategories))
                            <ul class="filter-list">
                                <li><a href="#">All</a></li>
                                @foreach ($item->subCategories as $sub)
                                <li><a href="#">{{ $sub->name }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                            <div class="row">
                                @foreach ($articles as $article)
                                <div class="col-lg-3 col-md-6">
                                    <div class="news-post standart-post">
                                        <div class="post-image">
                                            <a href="single-post-2.html">
                                                <img src="{{ asset($article->photo) }}" alt="{{ $article->name }}">
                                            </a>
                                            <?php
                                            $sub_cate = $item->subCategories->firstWhere('id', $article->sub_category_id); ?>
                                            @if ($sub_cate)
                                                <a href="#" class="category category-world">{{ $sub_cate->name }}</a>
                                            @endif
                                        </div>
                                        <h2><a href="single-post.html">{{ $article->name }}</a></h2>
                                        <ul class="post-tags">
                                            <li><i class="lnr lnr-user"></i>by <a href="#">
                                            @if ($article->user)
                                            {{ $article->user->name }}
                                            @endif
                                            </a></li>
                                            {{-- <li><a href="#"><i class="lnr lnr-book"></i><span>{{ count($article->comments) }} comments</span></a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search for..." aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</nav>
