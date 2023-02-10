@extends('components.layout')
@section('page-title')
    <title>Rokkit Blogs | Blogs</title>
@endsection
<x-navigation-bar/>
@section('content')
    <section class="body-section">
        <div class="container">
            <div class="heading">
                <h1>The Rokkit Blogs</h1>
            </div>
            <p class="col-lg-10 m-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            <section class="blogs-list">
                <div class="filter-container">
                    <div class="row m-0">
                        <div class="col-lg-4 input-container">
                            <select name="category" id="category" class="form-control">
                                <option value="all">Category</option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name_slug }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4 input-container">
                            <select name="sort" id="sort" class="form-control">
                                <option value="all">Sort</option>
                                <option value="oldest-latest">Oldest - latest</option>
                                <option value="latest-oldest">latest - Oldest</option>
                            </select>
                        </div>
                        <div class="col-lg-4 input-container">
                            <input type="text" name="" id="" class="form-control" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="row m-0 mb-3 blog-list-container">
                    {{-- @if (isset($blogs))
                        @foreach ($blogs as $blog)
                        <div class="col-lg-4">
                            <div class="each-blog-container">
                                <div class="img-container" style="background-image:url('{{ url($blog->thumbnail) }}'); background-position: center; background-size: cover;" >
                                    
                                </div>
                                <div class="blog-info-container">
                                    <h2>{{ $blog->title }}</h2>
                                    <div class="publish-info">
                                        <div class="each-info">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                              {{ $blog->created_at->diffForHumans() }}
                                        </div>
                                        |
                                        <div class="each-info">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                              {{ $blog->user->name }}
                                        </div>
                                    </div>
                                    <div class="category-container">
                                        <a href="">{{ $blog->category->name }}</a>
                                    </div>
                                    <p>{{ $blog->excerpt }}</p>
                                    <a href="/blog/{{ $blog->id.'/'.$blog->slug }}" class="theme-btn d-flex ml-auto">Read More</a>
                                </div>
                                
                            </div>
                        </div>
                        @endforeach
                    @endif --}}
                    
                </div>
                <div class="read-more-container mt-2 mb-3 d-flex justify-content-center">
                    <button class="theme-btn read-more-btn">Load More Blogs</button>
                </div>
            </section>
        </div>
    </section>
@endsection
<x-footer/>
@section('script')
    <script>
        $('nav .nav-wrap .link-container ul li').eq(0).addClass('active');
        var limit = 2;
        var currentLimit = limit;
        checkActiveFilter(limit);
        $(function () {
            var token = $('meta[name="csrf-token"]').attr('content');
            $('.read-more-btn').on('click', function(){
                currentLimit += limit;
                checkActiveFilter(currentLimit);
            });
            $('.filter-container .input-container select').on('change', function(){
                category = $('.filter-container .input-container select#category').val();
                sort = $('.filter-container .input-container select#sort').val();
                filter(category, sort, currentLimit);
            });
            $('.filter-container .input-container input').on('keyup', function(){
                var search = $(this).val();
                if(search.length>0){
                    setSearchedBlogs(search);
                }else{
                    var protocolHost = location.protocol+'//'+document.location.host;
                    window.history.replaceState({}, '', `${protocolHost}`);
                    checkActiveFilter(currentLimit);
                }
                
            });

        });
    </script>
@endsection