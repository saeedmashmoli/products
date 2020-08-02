<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [ 'url' , 'article_id' ];
    public function article(){
        return $this->belongsTo(Article::class);
    }
    protected $hidden = [
        'updated_at','created_at'
    ];
}
