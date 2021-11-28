<x-app-layout>
    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>create</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container" >
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('글쓰기') }}
                </h2>
            </x-slot>
            {{-- 
                form태그의 속성인 method, action, enctype 등은 입력받은 데이터를 어떻게 처리할 것인지 세부적으로 설정하는 데 사용. 
                method는 전송 방식,
                action은 전송 목적지,
                enctype은 전송되는 데이터 형식을 설정한다.
                enctype 속성은 multipart/form-data은 파일이나 이미지를 서버로 전송할 경우 이 방식을 사용한다.
                enctype을 사용하지 않으면 웹 서버로 데이터를 넘길때 파일의 경로명만 전송되고 파일 내용이 전송되지 않기 때문이다.
            --}}
            <form action="/posts/store" method="post" enctype="multipart/form-data" >
                {{-- get 외의 접근에서는 꼭 이 토큰을 함께 전송해야만 접근이 가능. --}}
                {{-- 로그인을 할 때 id와 pw를 넣고 로그인을 하면 서버가 그것을 확인해서 id와 pw가 맞으면 이 사용자가 유효한 사용자라는 토큰을 발행 해줍니다. --}}
                @csrf
                <div class="form-group">
                    <div class="mt-4 mb-4">
                        {{-- label태그의 for속성은 결합하고자 하는 요소의 id 속성값과 같아야 한다. --}}
                        <label for="title" class="form-label">Title</label>
                        {{-- name은 <form> submit 전송시 사용 --}}
                        {{-- old('title')는 이전의 값을 그대로 가져오는 것이다. --}}
                        <input type="text" class="form-control"  name = 'title' id="title" placeholder="title" >
                        @error('title')
                        <div>{{ $message }} </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3"  placeholder="content"></textarea>
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
                      <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        
    </body>
</html>
</x-app-layout>
