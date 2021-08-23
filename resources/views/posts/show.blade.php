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
                <button class="btn btn-primary" onclick=location.href="{{ route('posts.index',['page'=>$page]) }}">목록보기</button>
            @endauth

        </div>
    </body>
</html>
</x-app-layout>