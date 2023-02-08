<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon compte</title>
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
        Bonjour {{ $user->name }}
    </div>

    <form action="{{ route('post.user') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="name" id="name" value="{{old('name', $user->name)}}">
            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{old('email', $user->email)}}">
            @error('email')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" class="form-control" name="avatar" id="avatar">
            @error('file')
            <div>{{ $message }}</div>
            @enderror
        </div>

        @if(!empty($user->avatar->filename))
            <a href="{{ $user->avatar->url }}">
                <img src="{{ $user->avatar->thumb_url }}" width="200" height="200">
            </a>
        @endif
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <p><a href="">Modifier mon mot de passe</a></p>
</div>
