<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [ 'user_id'];
    protected $appends = ['messages','user','unread_messages_count' , 'last_message_id'];
    public function getLastMessageIdAttribute(){
        return $this->messages()->orderBy('id','desc')->first()->id;
    }
    public function getUnreadMessagesCountAttribute(){
        $userId = auth()->user()->id;
        return $this->messages()->where('user_id','!=',$userId)->whereDoesntHave('users' , function ($query) use ($userId){
            $query->whereUserId($userId);
        })->count();
    }
    public function getUserAttribute(){
        return $this->user()->first();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getMessagesAttribute()
    {
        return $this->messages()->get();
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}
