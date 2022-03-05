<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
Use App\Models\artist;
Use App\Models\album;
Use App\Models\listener;

class ListenerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $listeners = DB::table('listeners')
                        ->leftJoin('album_listener','listeners.id','=','album_listener.listener_id')
                        ->leftJoin('albums','albums.id','=','album_listener.album_id')
                        ->select('listeners.id','listeners.listener_name','albums.album_name')
                        ->get();
        return View::make('listener.index',compact('listeners'));
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

        $albums = Album::pluck('album_name','id');
        // dd($albums);
        return View::make('listener.create',compact('albums'));

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

        $listener = Listener::create($request->all());
        //create kung same name ^^

        // dd($request->album_id); 
        
        // if(empty($request->album_id))
        if($request->album_id) {
            //array yung album_id, 
            foreach ($request->album_id as $album_id) {
                DB::table('album_listener')->insert(
                    ['album_id' => $album_id, 
                     'listener_id' => $listener->id
                    ]
                    );
                }
        }
        return Redirect::to('listener')->with('success','New listener added!');

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

        $listener = Listener::find($id);
        
        $album_listener = DB::table('album_listener')
                            ->where('listener_id',$id)
                            // listener_id = $id
                            ->pluck('album_id')
                            //instead of get ^^ pluck ginamit para regular array yung mafetch(fetch method)
                            //pluck = collection of arrays

                            ->toArray();
                            //converts collection to plain array

                    //kung existing sa array ^^ kung hindi didisplay nya lang             
        // dd($album_listener);

        $albums = Album::pluck('album_name','id');
        //kung existing sa array ^^

        // dd($albums, $album_listener);
        return View::make('listener.edit',compact('albums','listener','album_listener'));
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
        $listener = Listener::find($id);
        // dd($request->input('album_id'));
        $album_ids = $request->album_id;
        //pwede request, pwede rin input

        // dd($album_ids);
        if(empty($album_ids)){
            //kapag walang sinubmit, idedelete nya

            DB::table('album_listener')
            //walang model yung pivot table

                ->where('listener_id',$id)
                ->delete();
                
        } 

//dedelete nya kapag inuncheck mo
        else {    
            DB::table('album_listener')
                ->where('listener_id',$id)
                ->delete();
    foreach($album_ids as $album_id) {
            DB::table('album_listener')
                ->insert(['album_id' => $album_id,
                          'listener_id' => $id
                        ]); 
        }
    }
    $listener->update($request->all());
    return Redirect::route('listener.index')->with('success','listener updated!');

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
        
        DB::table('album_listener')->where('listener_id',$id)->delete();
        
        $listener->delete();
        return Redirect::route('listener.index')->with('success','listener deleted!');
    }
}
