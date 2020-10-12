<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chats(){
        return Chat::orderBy('created_at','desc')->get();
    }
    public function index(){
        return view('Admin.chats.index');
    }
}
