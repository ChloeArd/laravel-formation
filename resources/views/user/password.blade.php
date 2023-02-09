<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier mon mot de passe</title>
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
        Modifier mon mot de passe
    </div>

    <form action="{{ route('update.password') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="current">Mot de passe actuel</label>
            <input type="password" class="form-control" name="current" id="current">
            @error('current')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" class="form-control" name="password" id="password">
            @error('password')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmez le mot de passe</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>

    <p><a href="{{ route("user.edit") }}">Revenir à mon compte</a></p>
</div>
