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

    public function movie() {
        $movies = Movie :: all();
    return view('pages.subpages.movie', compact('movies'));
    }
}
