<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\artist;
use App\Models\album;
use App\Models\listener;

class ListenerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->get('search'))) {
            $listeners = Listener::with('albums')->get();
        } else {
            // $listeners = Listener::with(['albums' => function ($q) use ($request) {
            //     $q->where("album_name", "LIKE", "%" . $request->get('search') . "%")
            //         ->orWhere("genre", "LIKE", "%" . $request->get('search') . "%");
            // }])->orWhere('listener_name', "LIKE", "%" . $request->get('search') . "%")
            //     ->get();

            // ? Difference of has and with has don't use eager loading but can check relationships

            $listeners = Listener::whereHas('albums', function ($q) use ($request) {
                $q->where("album_name", "LIKE", "%" . $request->get('search') . "%")
                    ->orWhere("genre", "LIKE", "%" . $request->get('search') . "%");
            })->orWhere('listener_name', "LIKE", "%" . $request->get('search') . "%")
                ->get();
        }

        $url = 'listener';

        return View::make('listener.index', compact('listeners', 'url'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // checkbox gagamitin kasi maraming pagpipilian kaya PLUCK

        // $albums = Album::pluck('album_name','id');
        // // dd($albums);
        // return View::make('listener.create',compact('albums'));

        $albums = Album::with('artist')->get();
        // dd($album);
        // foreach($albums as $album ) {
        //     dump($album->artist->artist_name);
        // }
        return View::make('listener.create', compact('albums'));
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
        // *$listener = new Listener;
        // *$listener->listener_name = $request->listener_name;
        //kapag magkaiba, new ^^

        //option:
        // $listener->listener_name = $request->lname; //kung hindi listener_name yung nasa view
        //$input['listener_name']=$request->lname;

        // *$listener->save();

        // $listener = Listener::create($request->all());
        // //create kung same name ^^

        // // dd($request->album_id); 

        // // if(empty($request->album_id))
        // if($request->album_id) {
        //     //array yung album_id, 
        //     foreach ($request->album_id as $album_id) {
        //         DB::table('album_listener')->insert(
        //             ['album_id' => $album_id, 
        //              'listener_id' => $listener->id
        //             ]
        //             );
        //         }
        // }

        //new

        //
        // $input = $request->all();
        // // dd($request->album_id);
        // $listener = Listener::create($input);
        // if (!(empty($request->album_id))){
        //     foreach ($request->album_id as $album_id) {
        //         // DB::table('album_listener')->insert(
        //         //     ['album_id' => $album_id, 
        //         //      'listener_id' => $listener->id]
        //         //     );
        //         // dd($listener->albums());
        //         $listener->albums()->attach($album_id);
        //     }
        // }
        // return Redirect::to('listener')->with('success','New listener added!');

        $input = $request->all();
        // dd($request->album_id);
        $listener = Listener::create($input);
        if (!(empty($request->album_id))) {
            foreach ($request->album_id as $album_id) {
                // DB::table('album_listener')->insert(
                //     ['album_id' => $album_id, 
                //      'listener_id' => $listener->id]
                //     );
                // dd($listener->albums());
                $listener->albums()->attach($album_id);
            }  //end foreach

        }
        return Redirect::to('listener')->with('success', 'New listener added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        // $listener = Listener::find($id);

        // $album_listener = DB::table('album_listener')
        //                     ->where('listener_id',$id)
        //                     // listener_id = $id
        //                     ->pluck('album_id')
        //                     //instead of get ^^ pluck ginamit para regular array yung mafetch(fetch method)
        //                     //pluck = collection of arrays

        //                     ->toArray();
        //                     //converts collection to plain array

        //             //kung existing sa array ^^ kung hindi didisplay nya lang             
        // // dd($album_listener);

        // $albums = Album::pluck('album_name','id');
        //kung existing sa array ^^

        //new
        //kapag get object na nasa array, first- model

        // $listener = Listener::find($id);

        // $album_listener = DB::table('album_listener')
        //                     ->where('listener_id',$id)
        //                     ->pluck('album_id')
        //                     ->toArray();
        // dd($album_listener);
        // $albums = Album::pluck('album_name','id');
        // dd($albums, $album_listener);

        //JUNE 2 ===========

        $listener_albums = array();
        $listener = Listener::with('albums')->where('id', $id)->first();
        // $listener = Listener::with('albums')->get();

        // $albums = Album::with('artist')->where('id',$id)->take(1)->get();
        // dd($albums);

        // dump($listener);
        // dump($listener->listener_name);
        // dump($listener->albums);
        // foreach ($listener->albums as $album) {
        //      dump($album->album_name);
        //     }
        //$artist

        if (!(empty($listener->albums))) {
            foreach ($listener->albums as $listener_album) {
                $listener_albums[$listener_album->id] = $listener_album->album_name;
            }
        }

        $albums = Album::pluck('album_name', 'id')->toArray();
        // dd($albums, $listener_albums);

        // else {
        //     // $listener_albums[] = null;
        // }
        // $albums = Album::pluck('album_name','id')->toArray();
        // dd($albums,$listener_albums);
        // dd($albums,$listener->albums->toArray());
        // foreach ($listener->albums as $listener_album) {
        //     if(in_array($listener_album->album_name, $albums)){
        //         dump($albums);

        //     }
        //     else
        //         dump($albums);

        return View::make('listener.edit', compact('albums', 'listener', 'listener_albums'));
        //model yung listener, array yung album_listener

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
        //         $listener = Listener::find($id);
        //         // dd($request->input('album_id'));
        //         $album_ids = $request->album_id;
        //         //pwede request, pwede rin input

        //         // dd($album_ids);
        //         if(empty($album_ids)){
        //             //kapag walang sinubmit, idedelete nya

        //             // DB::table('album_listener')
        //             // //walang model yung pivot table

        //             //     ->where('listener_id',$id)
        //             //     ->delete();

        //         } 

        // //dedelete nya kapag inuncheck mo
        //         else {    
        //             DB::table('album_listener')
        //                 ->where('listener_id',$id)
        //                 ->delete();
        //     foreach($album_ids as $album_id) {
        //             DB::table('album_listener')
        //                 ->insert(['album_id' => $album_id,
        //                           'listener_id' => $id
        //                         ]); 
        //         }
        //     }

        //     $listener->update($request->all());

        //new
        $listener = Listener::find($id);
        $album_ids = $request->input('album_id');
        $listener->albums()->sync($album_ids);
        // dd($album_ids);
        // if(empty($album_ids)){
        //     $listener->albums()->detach();
        // }
        // else {
        //     // foreach($album_ids as $album_id) {
        //     $listener->albums()->detach();

        //     $listener->albums()->attach($album_ids);


        //     // }
        // }
        $listener->update($request->all());

        return Redirect::route('listener.index')->with('success', 'listener updated!');
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
        $listener = Listener::find($id);
        $listener->albums()->detach();
        // DB::table('album_listener')->where('listener_id',$id)->delete();

        $listener->delete();
        //   return Redirect::route('listener')->with('success','listener deleted!');
        return Redirect::to('listener.index')->with('success', 'New listener deleted!');
    }
}
