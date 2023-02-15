@extends('layouts.main-layout')

@section('content')

    <h1>Lista Film</h1>
    <h5>Per tornare alla Home dei film <a href="{{ route('home') }}">Clicca qui</a></h5>
    <a href="{{ route('movie.create') }}">Aggiungi un nuovo film</a>


    @foreach ($movies as $movie)

        <h3> Titolo: {{ $movie-> name }} | {{ $movie-> year }}</h3>

        <p>

            Incassi: {{ $movie -> cashOut }}$ <br>
            Genere: {{ $movie -> genre -> name }}
            <br>
            @foreach ($movie -> tags as $tag)
                Tag: {{ $tag -> name }} | 
            @endforeach
                            
        </p>

        <br><br>

    @endforeach

@endsection