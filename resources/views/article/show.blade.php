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

    <div class="containerArticle">
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
        <span class="author"> Par <a href="{{ route('user.profile', ['user' => $article->user->id]) }}"></a> Inscrit le {{ $article->user->created_at->format('d/m/Y') }}</span> <br>
        <span>Posté {{ $article->created_at->diffForHumans }}</span> {{-- Carbon --}}
    </div>

    <div class="containerComment">
        <h2>Commentaires</h2>

        <div class="comment">
            @forelse($comments as $comment)
                <p>{{ $comment->content }}</p>
            @empty
                <p>Pas de commentaire pour l'instant</p>
                <p><a href="{{ route('user.profile', ['user' => $comment->$user->id]) }}">{{ $comment->user->name }} le {{ $comment->created_at->isoFormat('LLL') }}</a> </p>
            @endforelse
        </div>
        {{-- Si l'utilisateur est connecté --}}
        @auth
            <form action="{{ route('post.comment', ['article' => $article->slug]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="content">Laisser un commentaire</label>
                    <textarea name="content" id="content" placeholder="Votre commentaire...">{{old('content')}}</textarea>
                    @error('content')
                    <div>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Commenter</button>
            </form>
        @endauth

        {{-- Si l'utilisateur est en invité/ non connecté --}}
        @guest
            <a href="{{ route('login') }}">Laisser un commentaire</a>
        @endguest
    </div>


</body>
</html>
