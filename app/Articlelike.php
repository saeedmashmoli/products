<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articlelike extends Model
{
    protected $fillable = [ 'ip' , 'article_id' , 'like'];

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
