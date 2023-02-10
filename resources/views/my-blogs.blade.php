@extends('components.layout')
@section('page-title')
    <title>Rokkit Blogs | My Blogs</title>
@endsection
<x-navigation-bar/>
@section('content')
    <section class="body-section">
        <div class="container">
            <div class="heading">
                <h1>My Blogs</h1>
            </div>
            <div class="action-button-container d-flex justify-content-center mt-3 mb-3">
                <button class="theme-btn" type="button" data-toggle="modal" data-target="#addNewBlog">Add New Blog</button>
            </div>
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
                                <div class="img-container" style="background-image:url('{{ url($blog->thumbnail) }}'); background-position: center; background-size: cover;">
                                    
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
        {{-- Add new blog modal --}}
        <div class="modal fade" id="addNewBlog" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewBlogTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- <h5 class="modal-title" id="addNewBlogTitle">Modal title</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="" name="addNewBlogForm" id="addNewBlogForm">
                        <h4 class="text-center">Add New Blog</h3>
                        <div class="thumbnail-container">
                            <div class="input-container">
                                <input type="file" class="file" id="file" name="file" accept="image/*" required>
                                <div class="img-preview-container">
                                    <img src="" class="img-fluid" alt="Thumbnail Preview">
                                </div>
                            </div>
                        </div>
                        <div class="input-container">
                            <input type="text" name="title" id="title" placeholder="Blog Title" required>
                        </div>
                        <div class="input-container">
                            <select name="category" id="category" required>
                                <option value="">Select Category</option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="input-container">
                            <textarea name="excerpt" id="excerpt" rows="2" placeholder="Blog Excerpt"></textarea>
                        </div>
                        <div class="input-container">
                            <textarea name="body" id="body" rows="5" placeholder="Blog Body"></textarea>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button class="theme-btn w-100">Publish Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
<x-footer/>
@section('script')
    <script>
        var limit = 2;
        var currentLimit = limit;
        checkActiveUserFilter(currentLimit);
        $(function () {
            var token = $('meta[name="csrf-token"]').attr('content');
            var category_slug = 'all';
            var sort_slug = 'all';

            $('.read-more-btn').on('click', function(){
                currentLimit += limit;
                checkActiveUserFilter(currentLimit);
            });
            $('.filter-container .input-container select').on('change', function(){
                category = $('.filter-container .input-container select#category').val();
                sort = $('.filter-container .input-container select#sort').val();
                myBlogsFilter(category, sort, currentLimit);
            });
            $('.filter-container .input-container input').on('keyup', function(){
                var search = $(this).val();
                var search = $(this).val();
                if(search.length>0){
                    setSearchUserBlog(search);
                }else{
                    var protocolHost = location.protocol+'//'+document.location.host;
                    window.history.replaceState({}, '', `${protocolHost}`);
                    checkActiveUserFilter(currentLimit);
                }
            });
            $('#addNewBlogForm').on('submit', function(e){
                    e.preventDefault();
                    var form = document.forms.addNewBlogForm;
                    addNewBlog(token, form, currentLimit);
                });
            $(".file").change(function () {
                const file = this.files[0];
                var parent = $(this).parent();
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        parent.find(".img-preview-container img")
                            .attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection