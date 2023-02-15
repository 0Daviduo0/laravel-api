@extends('layouts.main-layout')

@section('content')

    <h1>Films</h1>

    @foreach ($genres as $genre)
        <h2> Genere: {{ $genre-> name }}</h2>
        <p> Descrizione genere: {{ $genre-> description }}</p>
        <ul>
            @foreach ($genre -> movies as $movie)
                <li>

                    Film: {{ $movie -> name }} | Anno: {{ $movie -> year }} <br>
                    Genere: {{ $movie -> genre -> name }} <br>

                </li> <br> <br>
            @endforeach
        </ul>
    @endforeach

@endsection