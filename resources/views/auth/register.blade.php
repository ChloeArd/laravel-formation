<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
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
        Inscription
    </div>

    <form action="{{ route('post.register') }}" method="post">

        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>
       <div class="form-group">
           <label for="email">Email</label>
           <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
           @error('email')
           <div>{{ $message }}</div>
           @enderror
       </div>
        <div class="form-group">
           <label for="password">Mot de passe</label>
           <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}">
            @error('password')
            <div>{{ $message }}</div>
            @enderror
       </div>
        <button type="submit" class="btn btn-primary">Inscription</button>
    </form>
</div>
