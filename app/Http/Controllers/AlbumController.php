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
    public function index(Request $request)
    {
        if (empty($request->get('search'))) {
            $albums = Album::with('artist', 'listeners')->get();
        } else { // TODO: Don't use with kasi di babasahin yung walang listener or walang laman especially sa mga relationship na pwede null like sa many to many for exp.
            $albums = Album::whereHas(
                'artist',
                function ($q) use ($request) {
                    $q->where("artist_name", "LIKE", "%" . $request->get('search') . "%");
                    // ! nakabase sa table taz yung data ng table pag sesearchan
                } // ? For example naglagay ka o if meron o dito lalabas pero pag wala
            )->orWhereHas(
                'listeners',
                function ($q) use ($request) {
                    $q->where("listener_name", "LIKE", "%" . $request->get('search') . "%");
                    // ! ito susunod na pwede masearch sa table taz yung data ng table pag sesearchan
                } // ? Ito sunod na chcheck if may o pag wala dederetso na sa pinaka else
            )->orWhere('album_name', "LIKE", "%" . $request->get('search') . "%")
                ->orWhere('genre', "LIKE", "%" . $request->get('search') . "%")

                // ? else kaya deretso where na and you can loop more orwhere

                ->get();
        }

        $url = 'album'; // ! ito sa search para globally.
        return View::make('album.index', compact('albums', 'url'));
    }

    public function create()
    {
        // return view::make('album.create');

        $artists = Artist::pluck('artist_name', 'id');
        //lahat ng artist kukunin ^^ 

        return View::make('album.create', compact('artists'));
        //kukunin yung artist

    }

    public function store(Request $request)
    {
        $artist = Artist::find($request->artist_id);
        // dd($artist);
        $album = new Album();
        $album->album_name = $request->album_name;
        $album->genre = $request->genre;
        // $album->artist_id = $request->artist_id;
        $album->artist()->associate($artist);
        $album->save();
    }

    public function show($id)
    {
        $albums = album::all();
        return View::make('album.index', compact('albums'));
    }

    public function edit($id)
    {
        // $album = Album::find($id);
        // //dd($album);
        // return View::make('album.edit',compact('album'));

        $album = Album::find($id);
        //$album = Album::wwith ('artist')->where('id',$id)->first();
        $artists = Artist::pluck('artist_name', 'id');
        //artist pluck kasi array yung id. isa isa kaya hindi select all gamit

        ///=====june 2
        $album = Album::with('artist')->where('id', $id)->first();
        // $album = Album::with('artist')->find($id)->first();
        // $albums = Album::with('artist')->where('id',$id)->take(1)->get();
        // dd($album,$albums);
        //$artist = Artist::where('id',$album->artist_id)->pluck('name','id');
        // dd($album);
        $artists = Artist::pluck('artist_name', 'id');

        return View::make('album.edit', compact('album', 'artists'));
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        //$album = Album::find($request->id);
        //  $album = Album::find($id);
        //  //dd($album,$request->all());
        //  //dd($album,$request);
        //  //dd($album);
        //  $album->update($request->all());

        //===new
        $artist = Artist::find($request->artist_id);
        // dd($artist);
        $album = Album::find($id);
        $album->album_name = $request->album_name;
        $album->artist()->associate($artist);
        $album->save();
        return Redirect::to('/album')->with('success', 'Album updated!');
    }

    public function destroy($id)
    {
        //$album = Album::find($id);
        //$album->delete();

        // $artist = Artist::find($id);
        // // Album::where('artist_id',$artist->id)->delete();
        // $artist->albums()->delete();

        // $artist->delete();
        // $artists = Artist::with('albums')->get();

        //new
        $album = Album::find($id);
        $album->listeners()->detach();
        $album->delete();

        return Redirect::route('album.index')->with('success', 'Album deleted!');

        //  Album::destroy($id);
        // return view::make('artist.index',compact('artists'));
        //  return Redirect::to('/album')->with('success','Album deleted!');
    }
}
