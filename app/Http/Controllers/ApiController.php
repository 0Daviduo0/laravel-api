<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Tag;

class ApiController extends Controller
{


    //Function to pass all movies, genres and tags
    public function getAll() {

        $movies = Movie::with('tags')->get();
        $genres = Genre::all();
        $tags = Tag::all();

        //return in json form
        return response()->json ([
            'success'=>'true',
            'response'=>[
                'movies'=>$movies,
                'genres'=>$genres,
                'tags'=>$tags
            ],
        ]);
    }

    //Function to validate data given to store movies
    public function Store(Request $request) {

        $data = $request->validate([
            'name'=>'required|string|min:3',
            'year'=>'required|integer|min:0',
            'cashOut'=>'required|integer|min:0',
            'genre_id'=>'required|integer|min:1',
            'tags_id'=>'required|array'
        ]);

        //find and associte genre
        $genre = Genre::find($data['genre_id']);
        $movie = Movie::make($data);
        $movie -> genre()->associate($genre);
        $movie -> save();

        //find tags and associate tags
        $tags = Tag::find($data['tags_id']);
        $movie->tags()->sync($tags);

        //send json with the movie
        return response()->json([
            'success'=>true,
            'response'=>$movie
        ]);
    }

    //Function to validate and update a movie
    public function Update(Request $request, Movie $movie) {

        $data = $request->validate([
            'name'=>'required|string|min:3',
            'year'=>'required|integer|min:0',
            'cashOut'=>'required|integer|min:0',
            'genre_id'=>'required|integer|min:1',
            'tags_id'=>'required|array'
        ]);

        //find and associte genre
        $genre = Genre::find($data['genre_id']);
        $movie->update($data);
        $movie->genre()->associate($genre);
        $movie->save();

        //find tags and associate tags
        $tags = Tag::find($data['tags_id']);
        $movie->tags()->sync($tags);

        //send json with the movie
        return response()->json([
            'success'=>true,
            'response'=>$movie
        ]);
    }

    //function to delete a movie
    public function Delete(Movie $movie) {

        //removing tags associated with the movie
        $movie->tags()->sync([]);
        //and delete the movie
        $movie->delete();

        //return the success of the operation
        return response()->json([
            'success'=>true
        ]);
    }






}
