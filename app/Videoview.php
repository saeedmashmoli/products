<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videoview extends Model
{
    protected $fillable = [ 'ip' , 'video_id'];

    public function video(){
        return $this->belongsTo(Video::class);
    }
}
