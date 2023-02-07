<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Accueil</title>
</head>
<body>

<div class="menu">
    <a href="{{ url("/") }}">Accueil</a>
    <a href="{{ route("login") }}">Connexion</a>
    <a href="{{ route("register") }}">Inscription</a>
</div>

@yield("content")

</body>
</html>
