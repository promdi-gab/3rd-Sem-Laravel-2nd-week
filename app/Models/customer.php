<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //Dont forget this

class customer extends Model
{
    use HasFactory;
    use softDeletes; //para amgamit naten yung restore

    protected $dates = ["deleted_at"]; //para alam nung softdelete san pupunta

    protected $table = "customers"; //name of your table

    protected $primaryKey = "customer_id"; //the primary key of your table 

    protected $guarded = ["customer_id"]; //Ibig sabihen neto pwede di matawag sa controller kase error pag di tinawag e
    //diba hindi naman tinatawag toh gets?okok

    public static $rules = [  'title' =>'required|alpha_num|min:3', //LOCAL RULES AND MESSAGE ONLY GOOD FOR CUSTOMER MODEL AND CONTROLLER
                    'lname'=>'required|alpha',
                    'fname'=>'required',
                    'address'=>'required',
                    'phone'=>'numeric',
                    'town'=>'required',
                    'zipcode'=>'required'];
                    
    public static $messages = [
            'required' => 'Ang :attribute field na ito ay kailangan',
            'min' => 'masyadong maigsi ang :attribute',
            'alpha' => "pawang letra lamang",
            'fname.required' => 'ilagay ang apelyido'
        ];
}