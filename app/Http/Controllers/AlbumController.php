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
    public function index(Request $request) {
      
        // $albums = Album::with('artist')->get();
        // $albums = Album::with('artist','listeners')->get();
        // $albums = Album::with('artist')->orderBy('album_name', 'DESC')->get();
        // $albums = Album::all();
      //  dd($albums); // die and dump

        //dd(compact('albums'));

    // $albums = DB::table('artists')->join('albums','artists.id','albums.artist_id')->get();
    // dd($albums); 
        // foreach ($albums as $album){
        //    dump($album);

        // //ONE IS TO MANY
        //      dump($album->artist->artist_name); // this is lazy loaded
        //     //  //Model = ($album->artist | property= >artist_name

        //     // // dump($album->artist_name);
        //     // dump($album->album_name); //dynamic property

        //  }

    //1 artist, many album
    // $albums = DB::table('artists')->join('albums','artists.id','albums.artist_id')-> join ('multiple join')->get();
    // return View::make('album.index',compact('albums'));
    

    //JUNE 8 ======
    if (empty($request->get('search'))) {
        $albums = Album::with('artist','listeners')->get();
    }
    else {
        // $albums = Album::with(['artist' =>function($q) use($request){
        //   $q->where("artist_name","LIKE", "%".$request->get('search')."%");
        // }])->get();
        
// $albums = Album::whereHas('artist', function($q) use($request){
//           $q->where("artist_name","LIKE", "%".$request->get('search')."%");
//         })->get();

// $albums = Album::whereHas('artist', function($q) use($request) {
        //         $q->where("artist_name","LIKE", "%".$request->get('search')."%");
        //             })
//             ->orWhereHas('listeners', function($q) use($request){
        //               $q->where("listener_name","LIKE", "%".$request->get('search')."%");
        //             })->orWhere('album_name',"LIKE", "%".$request->get('search')."%")
        //             ->get();

$albums = Album::whereHas('artist', function($q) use($request) {
                $q->where("artist_name","LIKE", "%".$request->get('search')."%");
        })->orWhereHas('listeners', function($q) use($request){
          $q->where("listener_name","LIKE", "%".$request->get('search')."%");
        })->orWhere('album_name',"LIKE", "%".$request->get('search')."%")
        ->get();
     }

     $url = 'album';
     return View::make('album.index',compact('albums','url'));

    }

    public function create() {
        // return view::make('album.create');

        $artists = Artist::pluck('artist_name','id');
        //lahat ng artist kukunin ^^ 

        return View::make('album.create',compact('artists'));
        //kukunin yung artist

    }

    public function store(Request $request) {

        $artist = Artist::find($request->artist_id);
        // dd($artist);
        $album = new Album();
        $album->album_name = $request->album_name;
        // $album->artist_id = $request->artist_id;
        $album->artist()->associate($artist);
        $album->save();

        // $input = $request->all();
       
        // $request->validate([
        //     'image' => 'mimes:jpeg,png,jpg,gif,svg',
        // ]);

        // if($file = $request->hasFile('image')) {
        //     $file = $request->file('image') ;
        //     // $fileName = uniqid().'_'.$file->getClientOriginalName();
        //     $fileName = $file->getClientOriginalName();
        //     $destinationPath = public_path().'/images' ;
        //     // dd($fileName);
        // $input['img_path'] = 'images/'.$fileName;
        // // $album = Album::create($input);
        //     $file->move($destinationPath,$fileName);
        // }
        // $album = Album::create($input);
        // return Redirect::to('/album')->with('success','New Album added!');

        //====================================

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

        // $input = $request->all();
        // $request->validate([
        //     'image' => 'mimes:jpeg,png,jpg,gif,svg', 
            
        //     // 'image' => ['mimes:jpeg,png,jpg,gif,svg|
        //     // file|max:512' ] -to limit
        // ]);

        // // if($request->hasFile('image')) {
        // if($file = $request->hasFile('image')) {
        //     //para macheck kung may inupload ^^ 

        //     $file = $request->file('image') ;
        //     // $fileName = uniqid().'_'.$file->getClientOriginalName();
  
        //     $fileName = $file->getClientOriginalName();
        //          //kukuhain originalname ng photo ^^

        //     $destinationPath = public_path().'/images' ;
        //     // dd($fileName);
    
        //     $input['img_path'] = 'images/'.$fileName;
        // // }
        //     $album = Album::create($input);
        //     $file->move($destinationPath,$fileName);
        // }
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
        //$album = Album::wwith ('artist')->where('id',$id)->first();
	    $artists = Artist::pluck('artist_name','id');
        //artist pluck kasi array yung id. isa isa kaya hindi select all gamit
        
        ///=====june 2
        $album = Album::with('artist')->where('id',$id)->first();
        // $album = Album::with('artist')->find($id)->first();
        // $albums = Album::with('artist')->where('id',$id)->take(1)->get();
        // dd($album,$albums);
        //$artist = Artist::where('id',$album->artist_id)->pluck('name','id');
        // dd($album);
        $artists = Artist::pluck('artist_name','id');

	    return View::make('album.edit',compact('album', 'artists'));
    }

    public function update(Request $request, $id){
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
     return Redirect::to('/album')->with('success','Album updated!');
    }

    public function destroy($id) {
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
        
        return Redirect::route('album.index')->with('success','Album deleted!');

        //  Album::destroy($id);
        // return view::make('artist.index',compact('artists'));
        //  return Redirect::to('/album')->with('success','Album deleted!');
    }
}
