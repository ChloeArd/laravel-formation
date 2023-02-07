@if($number < 5)
    Inferieur à 5
@elseif($number == 5)
    Egale à 5
@else
    Supérieur à 5
@endif

@for($i = 0; $i < 5; $i++)
    Nombre égal à {{$i}}
    <br>
@endfor

@unless($number == 5)
    Nombre est différent de 5
@endunless

@foreach($fruits as $fruit)
    <p>{{$fruit}}</p>
@endforeach

@forelse($fruits as $fruit)
    <p>{{$fruit}}</p>
@empty
    Aucun fruit
@endforelse

@php
    echo rand(1, 15);
@endphp
<br><br>
@isset($fruits)
    {{ count($fruits) }}
@endif

<br>
<br>

@switch($number)
    @case(2)
        Nombre égal à 2
        @break
    @case(15)
        Nombre égal à 15
        @break
    @default
        Nombre ni égal à 2 et à 15
@endswitch
