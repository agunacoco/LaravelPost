<x-app-layout>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>edit</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        </head>
        <body>
            <div class="container" >
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('글쓰기') }}
                    </h2>
                </x-slot><br/>

                <form action="{{ route('posts.update', ['id'=> $post->id, 'page'=>$page]) }}" method="post" enctype="multipart/form-data" >
                    {{-- get 외의 접근에서는 꼭 이 토큰을 함께 전송해야만 접근이 가능. --}}
                    {{-- 로그인을 할 때 id와 pw를 넣고 로그인을 하면 서버가 그것을 확인 해서 id와 pw가 맞으면 이 사용자가 유효한 사용자라는 토큰을 발행 해줍니다. --}}
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <div class="mt-4 mb-4">
                            {{-- label태그의 for속성은 결합하고자 하는 요소의 id 속성값과 같아야 한다. --}}
                            <label for="title" class="form-label">Title</label>
                            {{-- name은 <form> submit 전송시 사용 --}}
                            {{-- old('title')는 이전의 값을 그대로 가져오는 것이다. --}}
                            <input type="text" class="form-control"  name = 'title' id="title" value="{{ $post->title }}" >
                            @error('title')
                            <div>{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="3" >{{ $post->content }}</textarea>
                            @error('content')
                            <div>{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" name="image" id="image" rows="3"></input>
                            @error('image')
                            <div>{{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <img class="img-thumbnail" width="30%" src="{{ $post->imagePath() }}">
                        </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </body>
    </html>
</x-app-layout>