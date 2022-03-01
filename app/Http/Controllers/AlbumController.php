<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Album;
use \App\Models\artist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class AlbumController extends Controller
{
    public function index() {
      
        // $albums = Album::all();
        //dd($albums); // die and dump
        //dd(compact('albums'));

    $albums = DB::table('artists')->join('albums','artists.id','albums.artist_id')->get();
    // dd($albums); 

    //1 artist, many album
    // $albums = DB::table('artists')->join('albums','artists.id','albums.artist_id')-> join ('multiple join')->get();
    return View::make('album.index',compact('albums'));
    
    }

    public function create() {
        // return view::make('album.create');

        $artists = Artist::pluck('artist_name','id');
        //lahat ng artist kukunin ^^ 

        return View::make('album.create',compact('artists'));
        //kukunin yung artist

    }

    public function store(Request $request) {
     //dd($request);
    //option1
     //dd($request->title);

    //====================================
    //option2

     // $title = $request->title;
     // $artist = $request->artist;
     // $genre = $request->genre;
     // $year = $request->year;

     // $album = New Album;
     // $album->title = $title;
     // $album->artist = $artist;
     // $album->genre = $genre;
     // $album->year = $year;
     // $album->save();
     // return Redirect::to('/album');  
    //====================================
    //option3
        //dd($request->all());
        $input = $request->all(); //returning value is array
        Album::create($input);
        return Redirect::to('/album')->with('success','New Album Added');
    }

    public function edit($id) {
        // $album = Album::find($id);
        // //dd($album);
        // return View::make('album.edit',compact('album'));

        $album = Album::find($id);
	    $artists = Artist::pluck('artist_name','id');
        //artist pluck kasi array yung id. isa isa kaya hindi select all gamit
        
	    return View::make('album.edit',compact('album', 'artists'));
    }

    public function update(Request $request, $id){
     //dd($request);
     //$album = Album::find($request->id);
     $album = Album::find($id);
     //dd($album,$request->all());
     //dd($album,$request);
     //dd($album);
     $album->update($request->all());
     return Redirect::to('/album')->with('success','Album updated!');
    }

    public function destroy($id) {
         //$album = Album::find($id);
         //$album->delete();
         Album::destroy($id);
         return Redirect::to('/album')->with('success','Album deleted!');
    }
}
