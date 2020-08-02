<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password','mobile','Admin','role_id'
    ];

    protected $hidden = [
        'password', 'remember_token','updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query){

    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->role->contains('title' , $role);
        }
        return !! $role->intersect([$this->role])->count();
    }

}
