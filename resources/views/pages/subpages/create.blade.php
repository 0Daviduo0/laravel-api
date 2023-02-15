@extends('layouts.main-layout')

@section('content')
    
    <h1>Aggiungi un Film</h1>
    <form action="{{ route('movie.store') }}" method="POST">
        @csrf
            <label for="name">Nome film</label>
            <input type="text" name="name"> <br>

            <label for="year">Anno</label>
            <input type="year" name="year"> <br>

            <label for="cashOut">incassi</label>
            <input type="number" name="cashOut"> <br>

            <label for="genre">Tipologia</label>
            <select name="genre_id">

                @foreach ($genres as $genre)

                    <option value="{{ $genre -> id }}">{{ $genre -> name }}</option>  

                @endforeach

            </select> <br>

        <h3>Tags</h3>
        
        @foreach ($tags as $tag)

            <input type="checkbox" name="tags[]" value={{ $tag -> id }}>
            <label for="tags">{{ $tag -> name }}</label> <br>

        @endforeach

            <input type="submit" value="Aggiungi film">
    </form>

@endsection