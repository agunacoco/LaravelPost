<x-app-layout>
    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>상세보기</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('목록보기') }}
                </h2>
            </x-slot>
            <div name="show">

                <div class="form-group mt-4 mb-4">
                    <label for="title">Title</label>
                    <input type="text" readonly name="title" class="form-control" id="title" value="{{ $post->title }}">
                </div>
                <div class="form-group mb-4">
                    <label for="content">Content</label>
                    <div type="text" name="content" id="content" readonly class="form-control" >
                        {{ $post->content }}
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="image">Image</label>
                    <div>
                        <img class="img-thumbnail" width="35%" src="{{ $post->imagePath() }}" id="image" name="image">
                    </div>
                </div> 
                <div class="form-group mb-4">
                    <label>Writer</label>
                    <input readonly type="text" value="{{ $post->user->name }}" class="form-control">
                </div> 
                <div class="form-group mb-4">
                    <label>Create Date</label>
                    <input readonly type="text" value="{{ $post->created_at }}" class="form-control">
                </div> 
                <div class="form-group mb-4">
                    <label>Update Date</label>
                    <input readonly type="text" value="{{ $post->updated_at }}" class="form-control">
                </div> 
                @auth
                    <div class="flex">
                        <button class="btn btn-warning" onclick=location.href="{{ route('posts.edit', ['post'=>$post, 'page'=>$page]) }}">수정</button>
                        <form action="{{ route('posts.delete', ['id'=>$post->id, 'page'=>$page]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">삭제</button>
                        </form>
                        <button class="btn btn-primary" onclick=location.href="{{ route('posts.index',['page'=>$page]) }}">목록보기</button>    
                    </div>
                @endauth
            </div>

            <hr class="form-group mt-5 mb-4">
            <div name="comment">
                <form action="{{ route('posts.comment', ['id'=>$post->id])}}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Comment</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control"  name="content" id="content" placeholder="comment" >
                            <button type="submit" class="btn btn-outline-secondary">댓글</button>
                        </div>
                        @error('content')
                            <div>{{ $message }}</div>
                        @enderror
                    </div> 
                </form>
                <div name="comment-list" class="mt-4">
                    <ul class="list-group list-group-flush">
                        @foreach ( $comments ?? '' as $comment)
                        <li class="list-group-item mt-2">
                            <span>{{ $comment->user->name }}: {{ $comment->comment }}</span>
                            <span class="float-end">{{ $comment->created_at }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <br/><br/>
        </div>
    </body>
</html>
</x-app-layout>