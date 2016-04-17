<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Game extends Eloquent implements UserInterface, RemindableInterface {

    public $timestamps = true;

    protected $fillable = ['username', 'streak','score'];

    use UserTrait, RemindableTrait;

    protected $table = 'games';

    public $messages;

    //protected $hidden = array('password', 'remember_token');

    public static $rules = [
        'username'=>'required|min:3|max15'
    ];

    public function isValid()
    {
        $v = Validator::make($this->attributes, static::$rules);

        if($v->passes())
        {
            return true;
        }

        $this->messages = $v->messages();
        return false;
    }

}