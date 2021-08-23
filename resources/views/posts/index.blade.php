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
            @auth
            <div class="mt-4 mb-4">
                <button onclick=location.href="/posts/create" class="btn btn-primary">게시글 작성</button>
            </div>
            @endauth

            <div class="mb-4">
                <ul class="list-group h-50">
                    @foreach ( $posts as $post )
                    <li class="list-group-item">
                        <span>
                            <a href="{{ route('posts.show', ['id' => $post->id, 'page'=>$posts->currentPage()]) }}">
                                Title : {{ $post-> title }}
                            </a>
                        </span><br/><br/>
                        <span>
                            written on {{ $post->created_at->diffForHumans() }}
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