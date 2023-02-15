@extends('layouts.main-layout')

@section('content')

    <h1>Film</h1>
    <h5>Per creare, modificare e eliminare film <a href="{{ route('home.movie') }}">Clicca qui</a></h5>

    @foreach ($genres as $genre)
        <h2> Genere: {{ $genre-> name }}</h2>
        <p> Descrizione genere: {{ $genre-> description }}</p>
        <ul>
            @foreach ($genre -> movies as $movie)
                <li>

                    Film: {{ $movie -> name }} | Anno: {{ $movie -> year }} <br>
                    Incassi: {{ $movie -> cashOut }}$ <br>

                    @foreach ($movie -> tags as $tag)
                        Tag: {{ $tag -> name }} | 
                    @endforeach

                </li> <br> <br>
            @endforeach
        </ul>
    @endforeach

@endsection