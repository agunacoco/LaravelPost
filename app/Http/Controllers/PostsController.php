<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function create(){

        return view('posts.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:3',
            'imageFile' => 'image|max:2000'
        ]);
        
        //dd($request->all());
        $post = new Posts;
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        if($request->file('image')){
            $posts->image =  $this->uploadPostImage($request);
        };
        $post->save();
        return redirect('/posts/index');
    }

    protected function uploadPostImage($request){
        $name = $request->file('image')->getClientOriginalName();
        $extension = $request->file('image')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
        $filename=$nameWithoutExtension.'_'.time().'.'.$extension;
        $request->file(image)->storeAs('public/images', $filename);
        return $filename;
    }
    
}
