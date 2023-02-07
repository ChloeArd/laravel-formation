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

@foreach($articles as $article)
    <div class="containerArticle">
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
        <span class="author"> Par <a href="{{ route('user.profile', ['user' => $article->user->id]) }}"></a> Inscrit le {{ $article->user->created_at->format('d/m/Y') }}</span> <br>
        <span>Posté {{ $article->created_at->diffForHumans }}</span> {{-- Carbon --}}
    </div>
@endforeach

</body>
</html>
