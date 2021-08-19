<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostsController extends Controller
{
    public function create(){

        return view('posts.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:3',
            'imageFile' => 'image|max:2000'
        ]);
        
        //dd($request->all());
        $post = new Posts;
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->image = $request ->file;
        $post->save();

        if($request->file('file')){
            $posts->image = 
        }

    }
    
}
