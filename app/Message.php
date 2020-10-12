<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [ 'user_id' , 'text' , 'url' , 'chat_id'];
    protected $appends = ['user','seen_users'];
    public function getUserAttribute()
    {
        return $this->user()->select('username')->first();
    }
    public function getSeenUsersAttribute()
    {
        return $this->users();
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function chat(){
        return $this->belongsTo(Chat::class);
    }
}
