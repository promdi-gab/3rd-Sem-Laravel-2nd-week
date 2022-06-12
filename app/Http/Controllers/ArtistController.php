<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\artist;
use App\Models\album;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use App\DataTables\ArtistsDataTable;
use Log;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (empty($request->get('search'))) {
            $artists = Artist::with('albums')->get();
            // $artists = Artist::has('albums')->get();
            //ifefetech yung may related album

            // dd($artists);
        } else
            $artists = Artist::with(['albums' => function ($q) use ($request) {
                $q->where("genre", "=", $request->get('search'))
                    // ! titignan muna kaya naka array if existing yung genre pag wala hindi na agad lalabas
                    ->orWhere("album_name", "LIKE", "%" . $request->get('search') . "%");
                // ? or kung anu man nilagay mo na may genre
            }])->where("artist_name", "LIKE", "%" . $request->get('search') . "%")
                ->get();

        $url = 'artist';
        return View::make('artist.index', compact('artists', 'url'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return View::make('artist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        // $input = $request->all();
        // Artist::create($input);
        // return Redirect::to('artist/index');

        // $input = $request->all();

        $input = $request->all();
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($file = $request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            // $fileName = $file->getClientOriginalName();
            // dd($fileName);
            $request->image->storeAs('images', $fileName, 'public');
            //

            $input['img_path'] = 'images/' . $fileName;
            $Artist = Artist::create($input);
            // $file->move($destinationPath,$fileName);
        }

        return Redirect::to('artist');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::find($id);
        // dd($artist);
        return view('artist.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $artist = Artist::find($id);

        return View::make('artist.edit', compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $artist = Artist::find($id);
        $artist->update($request->all());
        return Redirect::to('/artist')->with('success', 'Artist updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dedelete yung sa table ng album at artist

        // Album::where('artist_id',$id)->delete();
        // //dedelete nya muna yung children
        // //where kasi 
        // Artist::destroy($id);
        // return Redirect::to('/artist')->with('success','Artist deleted!');
        // //di pwede idelete yung parent kasi may children(sa album table)


        $artist = Artist::find($id);

        $artist->albums()->delete();

        $artist->delete();
        $artist = Artist::with('albums')->get();
    }

    public function getArtists(ArtistsDataTable $dataTable) {
        // dd($dataTable);
        return $dataTable->render('artist.artist');
    }
}
