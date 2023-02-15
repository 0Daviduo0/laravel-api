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
    public function productEdit(Product $product) {

            $typologies = Typology :: all();
            $categories = Category :: all();

        return view('pages.product.edit', compact(
                        'product',
                        'typologies',
                        'categories'
                    ));
    }
    //Funzione per aggiornare i prodotti modificati
    public function productUpdate(Request $request, Product $product) {

        $data = $request -> validate([
            'name' => 'required|string|max:64',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'typology_id' => 'required|integer',
            'categories' => 'required|array'
        ]);

            $product -> update($data);
            $typology = Typology :: find($data['typology_id']);

            $product -> typology() -> associate($typology);
            $product -> save();
            
            $categories = Category :: find($data['categories']);
            $product -> categories() -> sync($categories);

        return redirect() -> route('home');
    }

    //------Funzione per eliminare i prodotti dal DB------
    public function productDelete(Product $product) {

            $product -> categories() -> sync([]);
            $product -> delete();

        return redirect() -> route('home');
    }
}
