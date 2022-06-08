<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listener extends Model
{
    use HasFactory;
    protected $fillable = ['listener_name'];

    public function albums()
	{
 		return $this->belongsToMany(Album::class);
 	}
     
    // public function listeners()
	//  {
	//  	return $this->belongsToMany('App\Models\Listener');
	//  }
}
