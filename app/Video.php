<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    protected $fillable = [ 'title' , 'text' , 'picUrl' , 'videoUrl' , 'isPublish' , 'user_id'];
    protected $appends = ['like_count','dis_like_count','view_count'];
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function getPublishDateAttribute($value)
    {
        return jdate($value)->format('%B %d، %Y');
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
        return $this->hasMany(Videolike::class);
    }
    public function getViewCountAttribute()
    {
        return $this->views()->count();
    }
    public function views(){
        return $this->hasMany(Videoview::class);
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
    protected $hidden = [
        'updated_at'
    ];
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
            $query->whereHas('products',function ($query) use ($categories){
                $query->whereHas('categories',function ($query) use ($categories){
                    $query->whereIn('id',$categories);
                });
            });
        }
    }
}
