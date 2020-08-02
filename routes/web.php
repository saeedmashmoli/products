<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/migrate',function(){
    \Illuminate\Support\Facades\Artisan::call('config:clear');
});

Route::get('/', function () {
    return view('home');
})->name('/');
Route::post('checkLogin','LoginController@checkLogin')->name('checkLogin');
Route::get('login','LoginController@login')->name('login');
Route::post('loginUser','LoginController@loginUser');
Route::post('submitRegister','LoginController@submitRegister')->name('submitRegister');
Route::get('register','LoginController@register')->name('register');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::post('getProducts', 'HomeController@products');
Route::post('getProduct', 'HomeController@getProduct');
Route::post('likeProduct', 'HomeController@likeProduct');
Route::post('getAllProducts','HomeController@allProducts');
Route::post('getAllArticles', 'HomeController@allArticles');
Route::post('getArticle', 'HomeController@getArticle');
Route::post('likeArticle', 'HomeController@likeArticle');
Route::post('getAllVideos', 'HomeController@allVideos');
Route::post('getVideo', 'HomeController@getVideo');
Route::post('likeVideo', 'HomeController@likeVideo');
Route::get('aboutMeData', 'HomeController@aboutMeData');
Route::post('searchResult' , 'HomeController@searchResult');
Route::post('getComments' , 'HomeController@comments');

Route::group(['middleware'=>['auth:web']],function (){
    Route::post('sendComment','HomeController@sendComment')->name('sendComment');
    Route::get('panel', 'PanelController@index')->name('panel');
    Route::get('profile','PanelController@profile')->name('profile.show');
    Route::post('profile','PanelController@update')->name('profile.update');
});
Route::group(['namespace' => 'Admin' ,'middleware'=>['auth:web'], 'prefix' => 'admin'],function (){
    //Admin Permissions & Roles --Begin
    Route::group([ 'middleware' => ['can:show-roles']], function () {
        Route::resource('roles', 'RoleController');
        Route::resource('permissions', 'PermissionController');
        Route::get('aboutMe','PermissionController@about')->name('about.index');
        Route::post('changeAboutMe','PermissionController@changeAboutMe')->name('changeAboutMe');
    });

    Route::group([ 'middleware' => ['can:show-users']], function () {
        Route::resource('users', 'UserController');
    });
    Route::group([ 'middleware' => ['can:show-categories']], function () {
        Route::resource('categories', 'CategoryController');
    });
    Route::group([ 'middleware' => ['can:show-products']], function () {
        Route::resource('products', 'ProductController');
        Route::get('deleteProductFile', 'ProductController@deleteFile')->name('products.files.delete');
    });
    Route::group([ 'middleware' => ['can:show-articles']], function () {
        Route::resource('articles', 'ArticleController');
        Route::get('deleteArticleFile', 'ArticleController@deleteFile')->name('articles.files.delete');
    });
    Route::post('uploadImageForText','ArticleController@uploadImageForText')->name('uploadImageForText');
    Route::group([ 'middleware' => ['can:show-videos']], function () {
        Route::resource('videos', 'VideoController');
        Route::get('deleteVideoFile', 'VideoController@deleteFile')->name('videos.files.delete');
    });
    Route::group([ 'middleware' => ['can:show-comments']], function () {
        Route::resource('comments', 'CommentController');
        Route::post('submitCommentStatus' , 'CommentController@commentStatus')->name('comment.status');
    });
});
