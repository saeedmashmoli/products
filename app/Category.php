<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 'title' , 'parent_id' , 'status'];
    public function category(){
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function childCategory(){
        return $this->hasMany(Category::class,'parent_id');
    }
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function scopeFilter($query){
        $title = request('title');
        if (isset($title) && trim($title) != '' && $title != 'all')
            $query->where('title','LIKE','%'.$title.'%');
        $status = request('status');
        if (isset($status))
            $query->whereStatus($status);
    }
}
