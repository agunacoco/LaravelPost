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
            'image' => 'image|max:2000'
        ]);
        
        //dd($request->all());
        $post = new Posts;
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        if($request->file('image')){
            $post->image =  $this->uploadPostImage($request);
        };
        $post->save();
        return redirect('/posts/index');
    }

    protected function uploadPostImage($request){
        $name = $request->file('image')->getClientOriginalName();
        $extension = $request->file('image')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
        $filename=$nameWithoutExtension.'_'.time().'.'.$extension;
        $request->file('image')->storeAs('public/images', $filename);
        return $filename;
    }

    public function index(){
        // paginate() 메서드를 사용할 때는 ::서브쿼리를 사용해야한다.
        // orderBy()사용하는데 :: 쿼리빌더를 사용해야한다.
        $posts = Posts::orderByDesc('updated_at')->paginate(5);
        return view('posts.index', ['posts'=> $posts] );
    }

    public function __construct(){
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function myindex(){
        $posts = auth()->user()->posts()->orderBy('updated_at', 'desc')->paginate(5);
        return view('posts.index',['posts'=>$posts]);
    }

    public function show(Request $request, $id){
        $page = $request->page;
        $post = Posts::find($id);
        return view('posts.show', ['page'=> $page, 'post'=>$post]);
    }
    
}
