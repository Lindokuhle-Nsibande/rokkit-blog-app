<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $categories = new Category();
    $blogs = new Blog();
    return view('home',[
        'categories' => $categories->getAllCategory(),
        'blogs' => $blogs->getAllBlogs()
    ]);
});
Route::get('/login', function(){
    return view('login');
})->name('login');
Route::get('/register', function(){
    return view('register');
});
Route::post('/user/add', [
    UserController::class, 'registerUser'
]);
Route::post('/user/login', [
    UserController::class, 'userLogin'
]);


// ===========blogs Route===============//
Route::get('/blog/{id}/{slug}', function($id, $slug){
    $blogs = new Blog();
    $categories = new Category();
    return view('blog-view',[
        'blog' => $blogs->getAllBlogs()->where('id', '==', $id)->where('slug', '==', $slug)->first(),
        'categories' => $categories->getAllCategory()
    ]);
});
Route::get('/blogs/get/{category_slug}/{sort_slug}/{limit}', function($category_slug, $sort_slug, $limit){
    return BlogController::getAllBlogsByFilterWithLimit($category_slug, $sort_slug, $limit);
});
Route::get('/blogs/get/{category_slug}/{sort_slug}', function($category_slug, $sort_slug){
    return BlogController::getAllBlogsByFilter($category_slug, $sort_slug);
});
Route::get('/blogs/search/{query}', function($query){
    return BlogController::search($query);
});
Route::get('/blogs/{category_slug}/{sort_slug}', function($category_slug, $sort_slug){
    $categories = new Category();
    $blogs = new Blog();
    return view('home', [
        'categories' => $categories->getAllCategory(),
        'blogs' => BlogController::getAllBlogsByFilter($category_slug, $sort_slug)
    ]);
});
Route::post('/blogs/get/limit', function(){
    return BlogController::getBlogLimitPerPage();
});
Route::get('/blogs/get/all', function(){
    dd('hellow');
});



// ===========Routes of an authorised user ================//
Route::middleware(['auth'])->group(function () {
    Route::get('/logout',[
        UserController::class, 'userLogout'
    ]);
    Route::get('/my-blogs/{category_slug}/{sort_slug}', function(){
        $categories = new Category();
        return view('my-blogs', [
            'categories' => $categories->getAllCategory(),
            'blogs' => BlogController::getblogsByUserId(auth()->user()->id)
        ]);
    });
    Route::get('/my-blogs/get/{category_slug}/{sort_slug}', function($category_slug, $sort_slug){
        return BlogController::getAllUserBlogsByFilter($category_slug, $sort_slug, auth()->user()->id);
    });
    Route::get('/my-blogs/get/{category_slug}/{sort_slug}/{limit}', function($category_slug, $sort_slug, $limit){
        return BlogController::getAllUserBlogsByFilterWithLimit($category_slug, $sort_slug, auth()->user()->id, $limit);
    });
    Route::post('/add/blog',[
        BlogController::class, 'addNewBlog'
    ]);
    Route::post('/update/blog', [
        BlogController::class, 'editBlog'
    ]);
    Route::post('/delete/blog', [
        BlogController::class, 'deleteBlog'
    ]);
    Route::get('/user/blogs/search/{searchq}', function($searchq){
        $user_id = auth()->user()->id;
        return BlogController::search($searchq)->where('user_id', '==', $user_id);
    });
});
