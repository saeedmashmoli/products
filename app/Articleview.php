<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articleview extends Model
{
    protected $fillable = [ 'ip' , 'article_id'];

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
