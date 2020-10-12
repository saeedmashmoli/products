<?php

namespace App\Http\Controllers\Admin;

use App\Chat;
use App\Events\GetMessageEvent;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chats(){
        $chats = Chat::all();
        $chats = $chats->sortByDesc(function ($chat) {
            return $chat['last_message_id'];
        });
        return $chats->values()->all();
    }
    public function getChat(Request $request){
        $userId = auth()->user()->id;
        $messages = Message::whereChatId($request->chatId)
            ->where('user_id','!=',$userId)->whereDoesntHave('users' , function ($query) use ($userId){
                $query->whereUserId($userId);
            })->get();
        foreach ($messages as $message){
            $message->users()->sync(auth()->user()->id);
        }
        $messages = Message::whereChatId($request->chatId)->get();
        return $messages;
    }
    public function sendMessage(Request $request){
        $user = auth()->user();
        $chat = Chat::whereId($request->chatId)->first();
        if ($request->file('file')){
            $result = $this->saveFile($request,$chat->id,'chats','file');
            $url = $result['path'];
        }else{
            $url = null;
        }
        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id ,
            'text' => $request->text ,
            'url' => $url
        ]);
        event(new GetMessageEvent($chat->user));
        return $message;
    }
    public function index(){
        return view('Admin.chats.index');
    }
    public function store(Request $request)
    {
        //
    }

    public function show(Chat $chat)
    {
        //
    }

    public function edit(Chat $chat)
    {
        //
    }

    public function update(Request $request, Chat $chat)
    {
        //
    }

    public function destroy(Chat $chat)
    {

    }
}
