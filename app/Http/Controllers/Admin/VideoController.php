<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $videos = Video::filter()->skip($row)->paginate($count);
        return view('Admin.videos.index',compact('videos','row'));
    }
    public function create()
    {
        return view('Admin.videos.create');
    }

    public function store(VideoRequest $request)
    {
        $request->validate(['title' => 'unique:videos']);
        $request->merge(['user_id' => auth()->user()->id]);
        $video = Video::create($request->all());
        if ($request->isPublish == 1)
            $video->update(['publish_date' => Carbon::now()]);
        $video->products()->sync($request->input('product_id'));
        if ($request->file('file')) {
            $poster = $this->saveFile($request,$video->id,'videos','image');
            $video->picUrl = $poster['path'];
            $video->save();
        }
//        if ($request->file('files')) {
//            $videoUrl = $this->saveFiles($request,$video->id,'videos','video');
//            $video->videoUrl = $videoUrl[0]['path'];
//            $video->save();
//        }
        return redirect(route('videos.index'));
    }

    public function show(Video $video)
    {
        //
    }

    public function edit(Video $video)
    {
        return view('Admin.videos.edit',compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        if ($video->title != $request->title)
            $request->validate(['title' => 'unique:videos']);
        if ($request->isPublish == $video->isPublish )
            $video->update(['publish_date' => Carbon::now()]);
        $request->merge(['user_id' => auth()->user()->id]);
        $video->update($request->all());
        $video->products()->sync($request->input('product_id'));
        if ($request->file('file')) {
            if ($video->picUrl != null){
                $path = public_path($video->picUrl);
                $isExists = file_exists($path);
                if ($isExists)
                    unlink($path);
            }
            $poster = $this->saveFile($request,$video->id,'videos','image');
            $video->picUrl = $poster['path'];
            $video->save();
        }
//        if ($request->file('files')) {
//            if ($video->videoUrl != null){
//                $path = public_path($video->videoUrl);
//                $isExists = file_exists($path);
//                if ($isExists)
//                    unlink($path);
//            }
//            $videoUrl = $this->saveFiles($request,$video->id,'videos','video');
//            $video->videoUrl = $videoUrl[0]['path'];
//            $video->save();
//        }
        return redirect(route('videos.index'));
    }

    public function destroy(Video $video)
    {
        if ($video->isPublish == 0){
            $video->isPublish = 1;
            $video->publish_date = Carbon::now();
        }else {
            $video->isPublish = 0;
        }
        $video->save();
        return back();
    }
}
