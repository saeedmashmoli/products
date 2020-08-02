<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['title' , 'label'];

    //Role Relations
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function path(){
        return "/roles/$this->id";
    }
}
