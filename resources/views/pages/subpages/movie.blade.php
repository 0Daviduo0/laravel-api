@extends('layouts.main-layout')

@section('content')

    <h1>Lista Film</h1>

    @foreach ($movies as $movie)

        <h3> Titolo: {{ $movie-> name }} | {{ $movie-> year }}</h3> 

        <p>

            {{ $movie -> genre -> name }}
            <br>
            @foreach ($movie -> tags as $tag)
                Tag: {{ $tag -> name }} | 
            @endforeach
                            
        </p>

        <br><br>

    @endforeach

@endsection