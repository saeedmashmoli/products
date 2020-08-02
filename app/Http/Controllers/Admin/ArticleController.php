<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $articles = Article::filter()->skip($row)->paginate($count);
        return view('Admin.articles.index',compact('articles','row'));
    }
    public function create()
    {
        return view('Admin.articles.create');
    }
    public function store(ArticleRequest $request)
    {
        $request->validate(['title' => 'unique:articles']);
        $request->merge(['user_id' => auth()->user()->id]);
        $article = Article::create($request->all());
        if ($request->isPublish == 1)
            $article->update(['publish_date' => Carbon::now()]);
        $article->products()->sync($request->input('product_id'));
        if ($request->file('file')) {
            $poster = $this->saveFile($request,$article->id,'articles','image');
            $article->poster = $poster['name'];
            $article->url = $poster['path'];
            $article->save();
        }
        return redirect(route('articles.index'));
    }

    public function show(Article $article)
    {
        return 'ok';
    }

    public function edit(Article $article)
    {
        return view('Admin.articles.edit',compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->title != $request->title)
            $request->validate(['title' => 'unique:articles']);
        if ($request->isPublish == $article->isPublish )
            $article->update(['publish_date' => Carbon::now()]);
        $request->merge(['user_id' => auth()->user()->id]);
        $article->update($request->all());
        $article->products()->sync($request->input('product_id'));
        if ($request->file('file')) {
            if ($article->poster != null){
                $path = public_path($article->url);
                $isExists = file_exists($path);
                if ($isExists)
                    unlink($path);
            }
            $poster = $this->saveFile($request,$article->id,'articles','image');
            $article->poster = $poster['name'];
            $article->url = $poster['path'];
            $article->save();
        }
        return redirect(route('articles.index'));
    }

    public function destroy(Article $article)
    {

        if ($article->isPublish == 0){
            $article->isPublish = 1;
            $article->publish_date = Carbon::now();
        }else {
            $article->isPublish = 0;
        }
        $article->save();
        return back();
    }
    public function uploadImageForText(Request $request){
       return json_encode($this->uploadedFile($request));
    }
}
