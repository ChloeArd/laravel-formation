<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un article</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

</body>
</html>

<div class="row">

    <div class="col-lg-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    <div class="card-header">
        Modifier un article
    </div>

    <form action="{{ route('articles.update', ['article' => $article->slug]) }}" method="post">

        @method("PUT")
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" name="title" id="title" value="{{old('title', $article->title)}}">
            @error('title')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea name="content" id="content" placeholder="Contenu de l'article...">{{old('content', $article->content)}}</textarea>
            @error('content')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category">Catégorie</label>
            <select class="form-control" name="category">
                <option value=""></option>
                @foreach($categories as $acategory)
                    <option value="{{ $category->id }}"
                            @if(old('category', $article->category_id ?? "") == $category->id)
                                selected
                        @endif

                    >{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <p><a href="{{ route('login') }}">J'ai déjà un compte</a></p>
</div>
