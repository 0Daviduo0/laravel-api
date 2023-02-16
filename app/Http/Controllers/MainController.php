<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Genre;
use App\Models\Tag;
use App\Models\Movie;

class MainController extends Controller
{
    //------pagina principale------
    public function home() {
        $genres = Genre :: all();
    return view('pages.home', compact('genres'));
    }
    //lista Film
    public function movie() {
        $movies = Movie :: all();
    return view('pages.subpages.movie', compact('movies'));
    }


    //------Funzione per creare nuovi film------
    public function create() {
        $tags = Genre :: all();
        $genres = Tag :: all();
    return view('pages.subpages.create', compact('tags', 'genres'));
    }
    //Funzione per salvare i film all'interno del DB
    public function store(Request $request) {

        // dd($request -> all());

        $data = $request -> validate([
            'name' => 'required|string|max:64',
            'year' => 'required|integer',
            'cashOut' => 'required|integer',
            'genre_id' => 'required|integer',
            'tags' => 'required|array'
        ]);

        $movie = Movie :: make($data);
        $genre = Genre :: find($data['genre_id']);
        $movie -> genre() -> associate($genre);
        $movie -> save();

        $tags = Tag :: find($data['tags']);
        $movie -> tags() -> attach($tags);

        return redirect() -> route('home');
    }

    //------Funzione per modificare i prodotti------
    public function edit(Movie $movie) {

            $genres = Genre :: all();
            $tags = Tag :: all();

        return view('pages.subpages.edit', compact(
                        'movie',
                        'genres',
                        'tags'
                    ));
    }
    //Funzione per aggiornare i film modificati
    public function update(Request $request, Movie $movie) {

        $data = $request -> validate([
            'name' => 'required|string|max:64',
            'year' => 'required|integer',
            'cashOut' => 'required|integer',
            'genre_id' => 'required|integer',
            'tags' => 'required|array'
        ]);

            $movie -> update($data);
            $genre = Genre :: find($data['genre_id']);

            $movie -> genre() -> associate($genre);
            $movie -> save();
            
            $tags = Tag :: find($data['tags']);
            $movie -> tags() -> sync($tags);

        return redirect() -> route('home');
    }

    //------Funzione per eliminare i film dal DB------
    public function delete(Movie $movie) {

            $movie -> tags() -> sync([]);
            $movie -> delete();

        return redirect() -> route('home');
    }
}
