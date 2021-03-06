<x-app-layout> 
    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>index</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container" >
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('게시글 리스트') }}
                </h2>
            </x-slot>
            <form action="{{ route('posts.mysearch') }}" method="post" role="search">
                @csrf
                <div class="float-end">
                    <label for="title" class="form-label">제목</label>
                    <input type="text" id="title" name="title" />
                    <button type="submit" class="btn btn-outline-primary" >검색</button>
                </div>
            </form>
            @auth
            <div class="mt-4 mb-4">
                <button onclick=location.href="/posts/create" class="btn btn-primary">게시글 작성</button>
            </div>
            @endauth

            <div class="mt-4 mb-4">
                <ul class="list-group h-50">
                    @foreach ( $posts as $post )
                    <li class="list-group-item">
                        <span>
                            <a href="{{ route('posts.show', ['id' => $post->id, 'page'=>$posts->currentPage()]) }}">
                                Title : {{ $post-> title }}
                            </a>
                        </span>
                        <div class="float-end">
                            <button type="button" class="btn btn-outline-danger" onclick=location.href="{{ route('posts.myonlike', ['id'=>$post->id, 'page'=>$posts->currentPage(), 'title' => $title ?? '' ]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>   
                            </button>
                            {{ $post->likers->count() }} {{ $post->likers->count() > 0 ? Str::plural('love', $post->likers->count()): 'love' }}
                        </div><br/><br/>
                        <span>
                            written on {{ $post->created_at->diffForHumans() }}
                            {{-- Str::plural 메소드는 문자열을 복수형태로 변환. 문자열의 단일 혹은 복수 형태를 조회하기 위해서는, 함수의 두번재 인자로 정수를 전달 가능. --}}
                            {{-- 두번째 인자의 값이 1이면 문자열이 단일로 그 외에는 문자열이 복수의 형태로 된다. --}}
                            {{ $post->viewers->count() }} {{ $post->viewers->count() > 0 ? Str::plural('view', $post->viewers->count()) : 'view' }}
                        </span>
                    </li><br/>
                    @endforeach
                </ul>
            </div>
            <div class="mb-4">          
                {{ $posts->links() }}                
            </div>
        </div>
    </body>
</html>
</x-app-layout>