<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Genre;
use App\Models\Tag;
use App\Models\Movie;

class MainController extends Controller
{
    //------pagina principale------
    public function homepage() {
        $genres = Genre :: all();
    return view('pages.homepage', compact('genres'));
    }
}
