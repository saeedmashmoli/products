<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $comments = Comment::filter()->orderBy('id' , 'desc')->skip($row)->paginate($count);;
        return view('Admin.comments.index',compact('comments' , 'row'));
    }
    public function commentStatus(Request $request){
        $comment = Comment::find($request->commentId);
        if ($comment->status == 0){
            $comment->status = 1;
        }else {
            $comment->status = 0;
        }
        $comment->save();
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Comment $comment)
    {
        //
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {

    }
}
