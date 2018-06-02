<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserCheckIn;
use DateTime;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkins(){
        return $this->hasMany('App\UserCheckIn');
    }

    public function last(){
        return UserCheckIn::where('user_id', $this->id)->orderBy('created_at', 'desc')->first();
    }

    public function checkin(){
        $check = new UserCheckIn;
        $check->user_id = $this->id;
        $check->time_in = new DateTime();
        $check->time_out = new DateTime();
        $check->status = 1;
        $check->save();
    }

    public function checkout(){
        $last = $this->last();
        $last->status = 2;
        $last->time_out = new DateTime();
        $last->save();
    }
}
