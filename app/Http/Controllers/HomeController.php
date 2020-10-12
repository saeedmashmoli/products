<?php

namespace App\Http\Controllers;

use App\About;
use App\Article;
use App\Articlelike;
use App\Articleview;
use App\Category;
use App\Chat;
use App\Comment;
use App\Events\SendMessage;
use App\Events\SendMessageEvent;
use App\Events\SentMessageEvent;
use App\Message;
use App\Product;
use App\Productlike;
use App\Productview;
use App\Video;
use App\Videolike;
use App\Videoview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function products(Request $request){
        $products = Product::whereStatus(1)->filter()->inRandomOrder()->get()->take(5);
        $categories = Category::whereStatus(1)->whereNull('parent_id')->with('childCategory')->get()->take(5);
        return ['products' => $products , 'categories' => $categories] ;
    }
    public function allArticles(Request $request){
        $page = $request->page ? $request->page : 0;
        $count = 8;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        return Article::where('isPublish',1)->filter()->orderBy('id','desc')->skip($row)->paginate($count);
    }
    public function allProducts(Request $request){
        $page = $request->page ? $request->page : 0;
        $count = 8;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        return Product::whereStatus(1)->filter()->orderBy('id','desc')->skip($row)->paginate($count);
    }
    public function allVideos(Request $request){
        $page = $request->page ? $request->page : 0;
        $count = 8;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        return Video::where('isPublish',1)->filter()->orderBy('id','desc')->skip($row)->paginate($count);
    }
    public function getArticle(Request $request){

        $page = $request->page ? $request->page : 0;
        $count = 3;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $articles = Article::where('isPublish',1)->orderBy('id','desc')->skip($row)->paginate($count);
        $article = Article::whereSlug($request->slug)->with('user')->with('products')->first();
        if (!$article)
            return 'false';
        $ip = $_SERVER['REMOTE_ADDR'];
        $viewCount = Articleview::whereIp($ip)->whereArticleId($article->id)->first();
        if (!$viewCount)
            Articleview::create(['ip' => $ip , 'article_id' => $article->id]);
        $likeStatus = Articlelike::whereArticleId($article->id)->whereIp($ip)->first();
        if ($likeStatus){
            $likeStatus = $likeStatus->like;
        }else{
            $likeStatus = false;
        }
        return ['articles' => $articles , 'article' => $article , 'likeStatus' => $likeStatus];
    }
    public function getProduct(Request $request){
        $page = $request->page ? $request->page : 0;
        $count = 3;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $products = Product::whereStatus(1)->orderBy('id','desc')->skip($row)->paginate($count);
        $product = Product::whereSlug($request->slug)->with('galleries')->first();
        if (!$product)
            return 'false';
        $ip = $_SERVER['REMOTE_ADDR'];
        $viewCount = Productview::whereIp($ip)->whereProductId($product->id)->first();
        if (!$viewCount)
            Productview::create(['ip' => $ip , 'product_id' => $product->id]);
        $likeStatus = Productlike::whereProductId($product->id)->whereIp($ip)->first();
        if ($likeStatus){
            $likeStatus = $likeStatus->like;
        }else{
            $likeStatus = false;
        }
        return ['products' => $products , 'product' => $product , 'likeStatus' => $likeStatus];
    }
    public function getVideo(Request $request){
        $page = $request->page ? $request->page : 0;
        $count = 3;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $videos = Video::where('isPublish',1)->orderBy('id','desc')->skip($row)->paginate($count);
        $video = Video::whereSlug($request->slug)->with('products')->first();
        if (!$video)
            return 'false';
        $ip = $_SERVER['REMOTE_ADDR'];
        $viewCount = Videoview::whereIp($ip)->whereVideoId($video->id)->first();
        if (!$viewCount)
            Videoview::create(['ip' => $ip , 'video_id' => $video->id]);
        $likeStatus = Videolike::whereVideoId($video->id)->whereIp($ip)->first();
        if ($likeStatus){
            $likeStatus = $likeStatus->like;
        }else{
            $likeStatus = false;
        }
        return ['videos' => $videos , 'video' => $video  , 'likeStatus' => $likeStatus];
    }
    public function aboutMeData(){
        return About::first();
    }
    public function searchResult(Request $request){
        $articles = Article::where('title' , 'LIKE' , '%'.$request->title.'%')
            ->orWhere('body' , 'LIKE' , '%'.$request->title.'%')
            ->orderBy('id' , 'desc')->get()->take(3);
        $products = Product::where('title' , 'LIKE' , '%'.$request->title.'%')
            ->orWhere('text' , 'LIKE' , '%'.$request->title.'%')
            ->orderBy('id' , 'desc')->get()->take(3);
        $videos = Video::where('title' , 'LIKE' , '%'.$request->title.'%')
            ->orWhere('text' , 'LIKE' , '%'.$request->title.'%')
            ->orderBy('id' , 'desc')->get()->take(3);
        $result = [
            'products' => $products,
            'articles' => $articles,
            'videos' => $videos
        ];
        return response()->json($result);
    }
    public function sendComment(Request $request){
        Comment::create($request->all());
    }
    public function likeArticle(Request $request){
        $ip = $_SERVER['REMOTE_ADDR'];
        $likeArticle = Articlelike::whereIp($ip)->whereArticleId($request->article_id)->first();
        if (!$likeArticle){
            Articlelike::create(['like'=> 1 , 'article_id' => $request->article_id , 'ip' => $ip]);
        }else {
            $likeArticle->update(['like' => !$likeArticle->like ]);
        }
        return Article::whereId($request->article_id)->with('products')->with('user')->first();
    }
    public function likeVideo(Request $request){
        $ip = $_SERVER['REMOTE_ADDR'];
        $videoLike = Videolike::whereIp($ip)->whereVideoId($request->video_id)->first();
        if (!$videoLike){
            Videolike::create(['like'=> 1 , 'video_id' => $request->video_id , 'ip' => $ip]);
        }else {
            $videoLike->update(['like' => !$videoLike->like ]);
        }
        return Video::whereId($request->video_id)->with('products')->first();
    }
    public function likeProduct(Request $request){
        $ip = $_SERVER['REMOTE_ADDR'];
        $productLike = Productlike::whereIp($ip)->whereProductId($request->product_id)->first();
        if (!$productLike){
            Productlike::create(['like'=> 1 , 'product_id' => $request->product_id , 'ip' => $ip]);
        }else {
            $productLike->update(['like' => !$productLike->like ]);
        }
        $product = Product::whereId($request->product_id)->with('galleries')->first();
        return $product;
    }
    public function getChat(){
        $user = auth()->user();
        $chat = Chat::whereUserId($user->id)->first();
        if ($chat){
            return $chat;
        }else {
            return null;
        }
    }
    public function sendMessage(Request $request){
        $user = auth()->user();
        if ($request->chatId > 0){
            $chat = Chat::whereId($request->chatId)->first();
        }else{
           $chat = Chat::create(['user_id' => $user->id]);
        }
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
        event(new SentMessageEvent());
        return $message;
    }
}
