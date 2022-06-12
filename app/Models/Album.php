<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Album extends Model implements Searchable
{
    use HasFactory;
    protected $fillable = ['album_name', 'artist_id', 'img_path'];
    public $searchableType = 'Album Searched';

    public function artist()
    {
        return $this->belongsTo('App\Models\Artist');
    }

    public function listeners()
    {
        return $this->belongsToMany('App\Models\Listener');
    }

    public function getSearchResult(): SearchResult
    {
        $url = url('show-album/' . $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->album_name,
            $this->genre,
            $url
        );
    }
}
