<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [ 'title' , 'price','status','text' , 'poster' , 'url' , 'slug'];
    protected $hidden = [
        'updated_at'
    ];
    protected $appends = ['like_count','dis_like_count','view_count' , 'comments'];
    public function getCommentsAttribute()
    {
        return $this->comments()->whereStatus(1)->whereParentId(0)->orderBy('id','desc')->get();
    }
    public function getLikeCountAttribute()
    {
        return $this->likes()->where('like',1)->count();
    }
    public function getDisLikeCountAttribute()
    {
        return $this->likes()->where('like',0)->count();
    }
    public function likes(){
        return $this->hasMany(Productlike::class);
    }
    public function getViewCountAttribute()
    {
        return $this->views()->count();
    }
    public function views(){
        return $this->hasMany(Productview::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return jdate($value)->format('%B %d، %Y');
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');;
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function articles(){
        return $this->belongsToMany(Article::class);
    }
    public function videos(){
        return $this->belongsToMany(Video::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function scopeFilter($query){
        $beginDate = request('beginDateTime');
        if ($beginDate)
            $query->where('created_at' , '>=' , createGDate($beginDate));
        $endDateTime = request('endDateTime');
        if ($endDateTime)
            $query->where('created_at' , '<=' , createGDate($endDateTime));
        $title = request('title');
        if (isset($title) && trim($title) != '' && $title != 'all')
            $query->where('title','LIKE','%'.$title.'%');
        $categories = request('categories');

        if ($categories){
            $query->whereHas('categories',function ($query) use ($categories){
                $query->whereIn('id',$categories);
            });
        }
    }
}
