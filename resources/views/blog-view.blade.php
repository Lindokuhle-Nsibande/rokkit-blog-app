@extends('components.layout')
@section('page-title')
    <title>Rokkit Blogs | {{ $blog->title }}</title>
@endsection
<x-navigation-bar/>
@section('content')
    <section class="body-section">
        <div class="container">
            <div class="back-btn-container">
                <a href="/"><span class="lnr lnr-arrow-left"></span> Back To All Blogs</a>
            </div>
            <div class="row m-0 mt-3">
                <div class="col-lg-5">
                    <div class="thumnail-blog-info-container">
                        <div class="thumnail-container">
                            <img src="{{ url($blog->thumbnail) }}" class="img-fluid" alt="">
                        </div>
                        <div class="publish-info mt-2 mb-3 d-flex">
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
                        @if ($blog->user_id == auth()->user()->id)
                            <div class="action-btn-container" data-id="{{ $blog->id }}">
                                <button class="theme-btn" type="button" data-toggle="modal" data-target="#editBlog">Edit Blog</button>
                                <button class="theme-btn delete-blog">Delete Blog</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="content-container">
                        <div class="upper-content-container">
                            <div class="category-container">
                                <a href="">{{ $blog->category->name }}</a>
                            </div>
                            <h1>{{ $blog->title }}</h1>
                        </div>
                        <div class="body-content-container">
                            {!!  $blog->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit blog modal --}}
        <div class="modal fade" id="editBlog" data-blog-id="{{ $blog->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBlogTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="" name="editBlogForm" id="editBlogForm">
                        <h4 class="text-center">Edit Blog</h3>
                        <div class="thumbnail-container">
                            <div class="input-container">
                                <input type="file" class="file" id="file" name="file" accept="image/*">
                                <div class="img-preview-container">
                                    <img src="{{ url($blog->thumbnail) }}" class="img-fluid" alt="Thumbnail Preview">
                                </div>
                            </div>
                        </div>
                        <div class="input-container">
                            <input type="text" name="title" id="title" placeholder="Blog Title" value="{{ $blog->title }}" required>
                        </div>
                        <div class="input-container">
                            <select name="category" id="category" required>
                                <option value="">Select Category</option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        {{-- <option value="{{ $category->id }}">{{ $category->name }}</option> --}}
                                        @if ($blog->category_id == $category->id)
                                            <option value="{{ $category->id }}" selected >{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                        
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="input-container">
                            <textarea name="excerpt" id="excerpt" rows="2" placeholder="Blog Excerpt" required>{{ $blog->excerpt }}</textarea>
                        </div>
                        <div class="input-container">
                            <textarea name="body" id="body" rows="5" placeholder="Blog Body" required>{{ $blog->body }}</textarea>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button class="theme-btn w-100">Update Blog</button>
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
        $(function () {
            var token = $('meta[name="csrf-token"]').attr('content');

            @if ($blog->user_id == auth()->user()->id)
                $('.delete-blog').on('click', function(){
                    var blog_id = $(this).parent().closest('.action-btn-container').attr('data-id');
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover the blog!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            console.log(blog_id);
                            deleteBlog(token, blog_id)
                        }
                    });
                });
                $('#editBlogForm').on('submit', function(e){
                    e.preventDefault();
                    var blog_id = $('#editBlog').attr('data-blog-id');
                    var form = document.forms.editBlogForm;
                    updateBlog(token, blog_id, form);
                });
            @endif
            $(".file").change(function () {
                const file = this.files[0];
                var parent = $(this).parent();
                $('#addNewBlogForm').on('submit', function(e){
                    e.preventDefault();
                    var form = document.forms.addNewBlogForm;
                    addNewBlog(token, form);
                });
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