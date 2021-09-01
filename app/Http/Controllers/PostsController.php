<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Comment;
use App\Models\PostLike;
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

    public function index(Request $request){

        $title = $request->title;
        if($title){
            $posts = Posts::where('title', 'like', '%'. $title. '%')->orderBy('updated_at', 'desc')->paginate(5);
        } else {
            $posts = Posts::orderByDesc('updated_at')->paginate(5);
        }
        // paginate() 메서드를 사용할 때는 ::서브쿼리를 사용해야한다.
        // orderBy()사용하는데 :: 쿼리빌더를 사용해야한다.
        
        return view('posts.index', ['posts'=> $posts, 'title'=>$title] );
    }

    public function onlike(Request $request){

        $title = $request->title;
        $id = $request->id;
        $page = $request->page;
        $post = Posts::find($id);
        $like = PostLike::all()->where('post_id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
        
        if(Auth::user()!=null && !$post->likers->contains(Auth::user())){
            // attach 메소드는 모델에 관계를 추가할 때 중간 테이블에 삽입될 추가 데이터를 전달. 배열을 전달할 수도 있습니다:
            $post->likers()->attach(Auth::user()->id);

            $originalCount=DB::table('posts')->where('id',$id)->value('like');
            $value=$originalCount+1;
            
            DB::table('posts')->where('id',$id)->update(['like'=>$value]);
        }else if(Auth::user()!=null && $post->likers->contains(Auth::user())){
            $like->delete();
        }

        return redirect()->route('posts.index', [ 'page'=>$page, 'title'=>$title]);
    }

    public function myonlike(Request $request){

        $title = $request->title;
        //dd($title);
        $id = $request->id;
        $page = $request->page;
        $post = Posts::find($id);
        $like = PostLike::all()->where('post_id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();
        
        if(Auth::user()!=null && !$post->likers->contains(Auth::user())){
            // attach 메소드는 모델에 관계를 추가할 때 중간 테이블에 삽입될 추가 데이터를 전달. 배열을 전달할 수도 있습니다:
            $post->likers()->attach(Auth::user()->id);

            $originalCount=DB::table('posts')->where('id',$id)->value('like');
            $value=$originalCount+1;
            
            DB::table('posts')->where('id',$id)->update(['like'=>$value]);
        }else if(Auth::user()!=null && $post->likers->contains(Auth::user())){
            $like->delete();
        }

        return redirect()->route('posts.myindex', [ 'page'=>$page, 'title'=>$title]);
    }

    public function search(Request $request){
        $title = $request->title;
        
        return redirect()->route('posts.index', ['title'=>$title]);
    }
    public function mysearch(Request $request){
        $title = $request->title;
        return redirect()->route('posts.myindex', ['title'=>$title]);
    }

    public function myindex(Request $request){

        $title = $request->title;
        if($title){
            $posts = Posts::where('title', 'like', '%'.$title.'%')->where('user_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(5);
        }else {
            $posts = auth()->user()->posts()->orderBy('updated_at', 'desc')->paginate(5);
        }
        return view('posts.myindex', ['posts'=>$posts, 'title'=>$title]);
    }

    public function show(Request $request, $id){
        
        $page = $request->page;
        $post = Posts::find($id);
        $comments = Comment::where('post_id', '=', $id)->orderBy('created_at', 'desc')->get();

        if(Auth::user()!=null && !$post->viewers->contains(Auth::user())){
            // attach 메소드는 모델에 관계를 추가할 때 중간 테이블에 삽입될 추가 데이터를 전달. 배열을 전달할 수도 있습니다:
            $post->viewers()->attach(Auth::user()->id);

            $originalCount=DB::table('posts')->where('id',$id)->value('count');
            $value=$originalCount+1;
            
            DB::table('posts')->where('id',$id)->update(['count'=>$value]);
        };

        return view('posts.show', ['page'=> $page, 'post'=>$post, 'comments'=>$comments]);
    }
    public function comment(Request $request){

        $request->validate([
            'content' => 'required|min:1'
        ]);

        $id = $request->id;
        $comment = new Comment;

        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->comment = $request->content;
        $comment->save();

        return redirect()->route('posts.show', ['id'=>$id]);
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

        if(auth()->user()->id != $post->user_id ){
            abort(403);
        }

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

    public function delete(Request $request){

        $page = $request->page;
        $id = $request->id;
        // 모델을 찾지 못했을 때는 예외를 던진다.
        $post = Posts::findOrFail($id);
                  
        if(auth()->user()->id != $post->user_id){
            abort(403);
        }

        if ($post->image) {
            $imagePath = 'public/images/' . $post->image;
            Storage::delete('imagePath');   //storage에 저장된 image를 삭제.
        }
        $post->delete();
        return redirect()->route('posts.index', ['page'=>$page]);
    }

    public function graph(){
        $posts = Posts::orderBy('count', 'desc')->paginate(5);
        return view('posts.graph', ['posts'=>$posts]);
    }
    
}
