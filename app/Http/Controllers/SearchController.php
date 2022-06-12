<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\artist;
use App\Models\Album;
use App\Models\listener;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // dd($request);
        $searchResults = (new Search())
            ->registerModel(artist::class, 'artist_name')
            ->registerModel(Album::class, 'album_name', 'genre')
            ->registerModel(Listener::class, 'listener_name')
            ->search($request->get('search'));
        // dd($searchResults);
        // return view('item.search',compact('searchResults'));
        return view('search', compact('searchResults'));
    }
}
