@extends('layouts.main-layout')

@section('content')

    <h1>Films</h1>

    @foreach ($tags as $tag)
        <h2> Nome Tag: {{ $tag-> name }}</h2>
        <p> Descrizione Tag: {{ $tag-> description }}</p>
        <ul>
            @foreach ($tag -> movies as $movie)
                <li>

                    Film: {{ $movie -> name }} | Anno: {{ $movie -> year }} <br>
                    Genere: {{ $movie -> genre -> name }} <br>

                </li> <br> <br>
            @endforeach
        </ul>
    @endforeach

@endsection