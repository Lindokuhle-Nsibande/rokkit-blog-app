<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    // custom public path when deploying a project I will on change the url  pointing where the public path is located
    public static function customePublic_path($url){
        // return base_path('../_Directory where public folder col be_/'.$url.'');
        return public_path(''.$url.'');
    }
    public static function addNewBlog(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png',
            'category' => 'required',
            'excerpt' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'response'=>$validator->errors()
            ]);
        }else{
            $blog = new Blog();
            $user_id = auth()->user()->id;
            $category_id = $request->category;
            $title = $request->title;
            $slug = Str::slug($title);
            $excerpt = $request->excerpt;
            $body = $request->body;
            $time = time();
            $file = $request->file('file');
            $thumbnail = $slug.'_'.$time.'.'.$file->getClientOriginalExtension();

            $thumbnailPath = 'assets/img/thumbnails/'.$thumbnail;

            $result = $blog->store($user_id, $category_id, $slug, $thumbnailPath, $title, $excerpt, $body);
            if($result){
                $file->move(static::customePublic_path('assets/img/thumbnails'), $thumbnail);
                return response()->json([
                    'status'=>200,
                    'response'=>['massage' => 'Successfully added new blog']
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'response'=>['massage' => 'Sorry couldn\'t add new blog']
                ]);
            }
        }
    }
    public static function getblogsByUserId($user_id){
        $blog = new Blog();
        return $blog->getAllBlogs()
                    ->where('user_id', '==', $user_id);
    }
    public static function editBlog(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'nullable|mimes:jpeg,jpg,png',
            'category' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'blog_id' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'response'=>$validator->errors()
            ]);
        }else{
            $blog = new Blog();
            $blog_id = $request->blog_id;
            $user_id = auth()->user()->id;
            $category_id = $request->category;
            $title = $request->title;
            $slug = Str::slug($title);
            $excerpt = $request->excerpt;
            $body = $request->body;
            $time = time();
            $file = $request->file('file');
            $deleteImg = false;
            $thumbnailPath = "";
            if(isset($file) && $file != ""){
                if($file->isValid()){
                    $time = time();
                    $thumbnail = $slug.'_'.$time.'.'.$file->getClientOriginalExtension();
                    $thumbnailPath = 'assets/img/thumbnails/'.$thumbnail;
                    $deleteImg = true;
                }
            }

            $checkIfTheUserOwnsBlog = $blog->getAllBlogs()->where('user_id', '==', $user_id)
                                                            ->where('id', '==', $blog_id);
            $existingThumbnailPath = $checkIfTheUserOwnsBlog->value('thumbnail');
            if(isset($checkIfTheUserOwnsBlog)){
                $result = $blog->updateBlog($blog_id, $category_id, $slug, $thumbnailPath, $title, $excerpt, $body);
            
                if($result){
                    if($deleteImg){
                        $file->move(static::customePublic_path('assets/img/thumbnails'), $thumbnail);
                        File::delete(static::customePublic_path($existingThumbnailPath));
                    }
                    return response()->json([
                        'status'=>200,
                        'response'=>['massage' => 'Successfully updated the blog']
                    ]);
                }else{
                    return response()->json([
                        'status'=>500,
                        'response'=>['massage' => 'Sorry couldn\'t edit the blog']
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>401,
                    'response'=>['massage' => 'Sorry not authorised to edit the blog']
                ]);
            }
        }
    }
    public static function deleteBlog(Request $request){
        $validator = Validator::make($request->all(), [
            'blog_id'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'response'=>$validator->errors()
            ]);
        }else{
            $blog = new Blog();
            $user_id = auth()->user()->id;
            $blog_id = $request->input('blog_id');
            $checkIfTheUserOwnsBlog = $blog->getAllBlogs()->where('user_id', '==', $user_id)
                                                            ->where('id', '==', $blog_id);
            if($checkIfTheUserOwnsBlog){
                $result = $blog->deleteBlog($blog_id, $user_id);
                if($result>0){
                    return response()->json([
                        'status'=>200,
                        'response'=>['massage' => 'Successfully deleted the blog']
                    ]);
                }else{
                    return response()->json([
                        'status'=>500,
                        'response'=>['massage' => 'Sorry couldn\'t delete the blog']
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>401,
                    'response'=>['massage' => 'Sorry not authorised to delete the blog']
                ]);
            }
        }
    }
    public static function getAllBlogsByFilter($category_slug, $sort_slug){
        $blogObj = new Blog();
        $categoryObj = new Category();
        $blogController = new BlogController;

        $blogs = $blogObj->getAllBlogs();

        if($category_slug != 'all'){
            $category_id = $categoryObj->getAllCategory()
                                        ->where('name_slug', '==', $category_slug)
                                        ->value('id');
            $blogs = $blogObj->getAllBlogs()
                                ->where('category_id', '==', $category_id);
        }
        $blogs = $blogs->map(function($blog, $key){
            $blog->published = $blog->created_at->diffForHumans();
            return $blog;
        });
        if($sort_slug != 'all'){
            if($sort_slug == 'oldest-latest'){
                $blogs = $blogs->sortBy('created_at');
            }else
            if($sort_slug == 'latest-oldest'){
                $blogs = collect($blogs)->sortByDesc('created_at');
                // dd($blogs);
            }
        }
        return $blogs;
    }
    public static function getAllBlogsByFilterWithLimit($category_slug, $sort_slug, $limit){
        $blogObj = new Blog();
        $categoryObj = new Category();
        $blogController = new BlogController;

        $blogs = $blogObj->getAllBlogs();

        if($category_slug != 'all'){
            $category_id = $categoryObj->getAllCategory()
                                        ->where('name_slug', '==', $category_slug)
                                        ->value('id');
            $blogs = $blogObj->getAllBlogs()
                                ->where('category_id', '==', $category_id);
        }
        $blogs = $blogs->map(function($blog, $key){
            $blog->published = $blog->created_at->diffForHumans();
            return $blog;
        });
        if($sort_slug != 'all'){
            if($sort_slug == 'oldest-latest'){
                $blogs = $blogs->sortByDesc('created_at');
            }else
            if($sort_slug == 'latest-oldest'){
                $blogs = $blogs->sortBy('created_at');
            }
        }
        return $blogs->take($limit)->all();
    }
    public static function getAllUserBlogsByFilter($category_slug, $sort_slug, $user_id){
        return static::getAllBlogsByFilter($category_slug, $sort_slug)->where('user_id', '==', $user_id);
    }
    public static function getAllUserBlogsByFilterWithLimit($category_slug, $sort_slug, $user_id, $limit){
        $blogs = static::getAllUserBlogsByFilter($category_slug, $sort_slug, $user_id);
        $blogs = $blogs->take($limit);
        return $blogs;
    }
    public static function search($search){
        $blogsObj = new Blog();

        $blogs = $blogsObj->getAllBlogs();

        $blogs = $blogs->filter(function($blog) use($search){
            if(false !== stristr($blog->title, $search)){
                return false !== stristr($blog->title, $search);
            }else
            if(false !== stristr($blog->user->name, $search)){
                return false !== stristr($blog->user->name, $search);
            }else
            if(false !== stristr($blog->body, $search)){
                return false !== stristr($blog->body, $search);
            }else
            if(false !== stristr($blog->excerpt, $search)){
                return false !== stristr($blog->excerpt, $search);
            }
        });
        $blogs = $blogs->map(function($blog, $key){
            $blog->published = $blog->created_at->diffForHumans();
            return $blog;
        });
        return $blogs;
    }
    public static function whereNotCaseSensetive($array, $attribute, $value){
        $array = collect($array);
        $collection = $array->filter(function ($item) use ($attribute, $value) {
            return strtolower($item[$attribute]) == strtolower($value);
        });
        return $collection;
    }
    public static function getBlogLimitPerPage(){
        $blogsObj = new BlogController();
        return 6;
    }
}
