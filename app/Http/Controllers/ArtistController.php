<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
Use App\Models\artist;
Use App\Models\album;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $artists = DB::table('artists')
        ->leftJoin('albums','artists.id','=','albums.artist_id')
        //kasi nasa left?
        ->select('artists.id','albums.album_name','artists.artist_name', 'artists.img_path')
        //kaya nagseselect para di malito si laravel sa id(specify mo), kasi ambigous na yun
        //sa artists id kukunin yung id hindi sa fk
        ->get();

        return View::make('artist.index',compact('artists'));
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

        if($file = $request->hasFile('image')) {
            
            $file = $request->file('image') ;
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            // $fileName = $file->getClientOriginalName();
            // dd($fileName);
            $request->image->storeAs('images', $fileName, 'public');
            //

            $input['img_path'] = 'images/'.$fileName;
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
        $artists = Artist::all();
        return View::make('artist.index',compact('artists'));
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
        
	    return View::make('artist.edit',compact('artist'));
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
     return Redirect::to('/artist')->with('success','Artist updated!');
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

        Album::where('artist_id',$id)->delete();
        //dedelete nya muna yung children
        //where kasi 
        Artist::destroy($id);
        return Redirect::to('/artist')->with('success','Artist deleted!');
        //di pwede idelete yung parent kasi may children(sa album table)
    }
}
