<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function __construct(){

        $this->middleware('auth')->except(['index', 'show']);
    }

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

    public function onlike(Request $request){

        $id = $request->id;
        $page = $request->page;
        $post = Posts::find($id);
        $posts = Posts::orderByDesc('updated_at')->paginate(5);
        
        if(Auth::user()!=null && !$post->likers->contains(Auth::user())){
            // attach 메소드는 모델에 관계를 추가할 때 중간 테이블에 삽입될 추가 데이터를 전달. 배열을 전달할 수도 있습니다:
            $post->likers()->attach(Auth::user()->id);

            $originalCount=DB::table('posts')->where('id',$id)->value('like');
            $value=$originalCount+1;
            
            DB::table('posts')->where('id',$id)->update(['like'=>$value]);
        };
        return view('posts.index', ['posts'=> $posts, 'page'=>$page]);
    }

    public function myindex(Request $request){

        $page = $request->page;
        $posts = auth()->user()->posts()->orderBy('updated_at', 'desc')->paginate(5);
        return view('posts.index',['posts'=>$posts]);
    }

    public function show(Request $request, $id){

        $page = $request->page;
        $post = Posts::find($id);
        
        if(Auth::user()!=null && !$post->viewers->contains(Auth::user())){
            // attach 메소드는 모델에 관계를 추가할 때 중간 테이블에 삽입될 추가 데이터를 전달. 배열을 전달할 수도 있습니다:
            $post->viewers()->attach(Auth::user()->id);

            $originalCount=DB::table('posts')->where('id',$id)->value('count');
            $value=$originalCount+1;
            
            DB::table('posts')->where('id',$id)->update(['count'=>$value]);
        };

        return view('posts.show', ['page'=> $page, 'post'=>$post]);
    }

    public function edit(Request $request, Posts $post){

        return view('posts.edit', ['post'=>$post, 'page'=>$request->page]);
    }

    public function update(Request $request, $id){

        $page = $request->page;

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:3',
            'image' => 'image|max:2000'
        ]);
        $post = Posts::find($id);

        $post->title = $request->title;
        $post->content = $request->content;
        if($request->file('image')){
            $imagePath = 'public/images/'.$post->image;
            Storage::delete('imagePath');
            $post->image =  $this->uploadPostImage($request);
        };
        $post->save();
        // back 메소드를 사용하여 '뒤로' 이동할 수 있다.

        return view('posts.show', ['page'=> $page, 'post'=>$post]);
    }

    public function delete(){

    }
    
}
