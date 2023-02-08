<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articles</title>
</head>
<body>

    <div class="col-lg-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    @foreach($articles as $article)
        <div class="containerArticle">
            <h2><a href="{{route('articles.show', ['article' => $article->slug])}}">{{ $article->title }}</a></h2>
            <p>{{ \Illuminate\Support\Str::words($article->content, 5) }}</p>
            <span class="author"> Par <a href="{{ route('user.profile', ['user' => $article->user->id]) }}"></a> Inscrit le {{ $article->user->created_at->format('d/m/Y') }}</span> <br>
            <span>Posté {{ $article->created_at->diffForHumans }}</span> {{-- Carbon --}}

            {{-- si l'utilisateur et connecté et que l'article lui appartient --}}
            @if(Auth::check() && Auth::user()->id = $article->user_id)
                <div class="author">
                    <a href="{{route('article.edit', ['article' => $article->slug])}}">Modifier</a>
                    <form action="{{route('article.destroy', ['article' => $article->slug])}}" method='post'>
                        @method("DELETE")
                        @csrf
                        <button type="submit">X</button>
                    </form>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Pagination --}}
<div class="Pagination"> {{ $articles->links() }}</div>

</body>
</html>
