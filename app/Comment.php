<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'text' , 'product_id' , 'user_id' , 'parent_id' , 'status'];
    protected $appends = ['like_count','dis_like_count' , 'child_comments' ,'user'];
    public function getCreatedAtAttribute($value)
    {
        return jdate($value)->format('%B %d، %Y H:i:s');
    }
    public function getLikeCountAttribute()
    {
        return $this->likes()->where('like',1)->count();
    }
    public function getUserAttribute()
    {
        return $this->user()->first();
    }
    public function getDisLikeCountAttribute()
    {
        return $this->likes()->where('like',0)->count();
    }
    public function getChildCommentsAttribute(){
       return $this->childComments()->whereStatus(1)->orderBy('id','desc')->get();
    }
    public function likes(){
        return $this->hasMany(Commentlike::class);
    }

    public function getCreateAttribute($value)
    {
        return jdate($value)->format('%B %d، %Y');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function checkUser(){
        return $this->belongsTo(User::class,'check_user_id');
    }
    public function childComments(){
        return $this->hasMany(Comment::class,'parent_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $hidden = [
        'updated_at','created_at'
    ];
    public function scopeFilter($query)
    {
        $beginDate = request('beginDateTime');
        if ($beginDate)
            $query->where('created_at', '>=', createGDate($beginDate));
        $endDateTime = request('endDateTime');
        if ($endDateTime)
            $query->where('created_at', '<=', createGDate($endDateTime));
        $status = request('status');
        if ($status)
            $query->whereStatus($status);
        else
            $query->whereStatus(0);
    }
}
