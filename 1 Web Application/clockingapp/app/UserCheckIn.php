<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCheckIn extends Model
{
    //Table Name
    protected $table = 'user_check_ins';

    //Primary Key
    protected $primaryKey = 'id';

    //Desallow Timestamps
    public $timestamps = true;

    //Always order by created_at ascending
    public function __cunstruct(){
        $this->orderBy('created_at', 'asc');
    }

    //Add relationship user to Checkins
    public function user(){
        return $this->belongsTo('App\User');
    }
}
