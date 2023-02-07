@extends('layouts.main')

@section('content')

    <p> test</p>

    <h2>{!! "<script>alert('ok')</script> <p style='color:red;'>Laravel c'est trop cool</p>"!!}</h2>

@stop
