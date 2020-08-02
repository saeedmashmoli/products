<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videolike extends Model
{
    protected $fillable = [ 'ip' , 'video_id' , 'like'];

    public function video(){
        return $this->belongsTo(Video::class);
    }

}
