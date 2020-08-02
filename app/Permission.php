<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'title','label'
    ];
    //Permission Relations --Begin
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function path(){
        return "/permissions/$this->id";
    }

}
