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
        // $input = $request->all(); //returning value is array
        // Album::create($input);
        // return Redirect::to('/album')->with('success','New Album Added');

        $input = $request->all();
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg', 
            
            // 'image' => ['mimes:jpeg,png,jpg,gif,svg|
            // file|max:512' ] -to limit
        ]);

        // if($request->hasFile('image')) {
        if($file = $request->hasFile('image')) {
            //para macheck kung may inupload ^^ 

            $file = $request->file('image') ;
            // $fileName = uniqid().'_'.$file->getClientOriginalName();
  
            $fileName = $file->getClientOriginalName();
                 //kukuhain originalname ng photo ^^

            $destinationPath = public_path().'/images' ;
            // dd($fileName);
    
            $input['img_path'] = 'images/'.$fileName;
        // }
            $album = Album::create($input);
            $file->move($destinationPath,$fileName);
        }
// dd($input);
    }

    public function show($id)
    {
        $albums = album::all();
        return View::make('album.index',compact('albums'));
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
