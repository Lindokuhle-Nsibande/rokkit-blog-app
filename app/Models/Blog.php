<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(USer::class);
    }

    public function store($user_id, $category_id, $slug, $thumbnail, $title, $excerpt, $body){
        $this->user_id = $user_id; 
        $this->category_id = $category_id; 
        $this->slug = $slug; 
        $this->thumbnail = $thumbnail;
        $this->title = $title; 
        $this->excerpt = $excerpt; 
        $this->body = $body;
        cache()->forget('blogs');
        return $this->save();
    }
    public function getAllBlogs(){
        return cache()->remember('blogs', now()->years(), function(){
            return Blog::with(['category','user'])->orderBy('created_at', 'DESC')->get();
        });
    }
    public function updateBlog($blog_id, $category_id, $slug, $thumbnail = null, $title, $excerpt, $body){
        $blog = $this::find($blog_id);
        if($blog){
            $blog->category_id = $category_id; 
            $blog->slug = $slug; 
            if($thumbnail != null){
                $blog->thumbnail = $thumbnail;
            }
            $blog->title = $title; 
            $blog->excerpt = $excerpt; 
            $blog->body = $body;
            cache()->forget('blogs');
            return $blog->update();
        }else{
            return false;
        }
        
    }
    public function deleteBlog($blog_id, $user_id){
        $result = DB::table('blogs')->where([
            'id' => $blog_id,
            'user_id' => $user_id
        ])->delete();

        cache()->forget('blogs');
        return $result;
    }
}
