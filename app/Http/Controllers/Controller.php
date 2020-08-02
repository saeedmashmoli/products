<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\ImageManagerStatic as Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function uploadedFile(Request $request){
        if ($request->hasFile('upload')){
            $image = $request->file('upload');
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $dest = public_path('files/uploads/');
            if (!file_exists($dest)) {
                mkdir($dest,0777,true);
            }
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 200);
            $image_resize->save($dest.$imageName,100);

            $path = '/files/uploads/'.$imageName;
            return ["uploaded" => 1,
                    "fileName" => $imageName,
                    "url" => $path];
        }
    }
    public function saveFile(Request $request,$id,$dir,$type){

        if ($request->hasFile('file')){
            $poster = $request->file('file');
            $extension = $poster->getClientOriginalExtension();
            $posterName = time().'.'.$extension;
            $destination = public_path('files/'.$dir.'/'.$id.'/');
            if($type=='image'){
                if (!file_exists($destination)) {
                    mkdir($destination,0777,true);
                }
                $image_resize = Image::make($poster->getRealPath());
                $image_resize->resize(640, 640);
                $image_resize->save($destination.$posterName,100);
            }else{
                $poster->move($destination,$posterName);
            }
            $posterPath = 'files/'.$dir.'/'.$id.'/'.$posterName;
            return ['path' => $posterPath,'name' => $posterName];
        }
    }
    public function saveFiles(Request $request,$id,$dir,$type){
        $uploadedFiles = [];
        if ($request->hasFile('files')){
            $files = $request->file('files');
            foreach ($files as $file){
                $uploadedFiles[] = $this->uploadFile($file,$id,$dir,$type);
            }
        }
        return $uploadedFiles;
    }
    public function uploadFile($file,$id,$dir,$type){
        $originalFileName = $file->getClientOriginalName();
        $fileName = time(). "-" .$originalFileName;
        $destination = public_path('files/'.$dir.'/'.$id.'/');

        if($type=='image'){
            $image_resize = Image::make($file->getRealPath());
            $des640 = $destination.'640p/';
            $image640 = $image_resize->resize(640, 640);
            if (!file_exists($des640)) {
                mkdir($des640,0777,true);
            }
            $image640->save($des640.$fileName,100);
            $image300 = $image_resize->resize(300, 300);
            $des300 = $destination.'300p/';
            if (!file_exists($des300)) {
                mkdir($des300,0777,true);
            }
            $image300->save($des300.$fileName,100);
            $image32 = $image_resize->resize(32, 32);
            $des32 = $destination.'32p/';
            if (!file_exists($des32)) {
                mkdir($des32,0777,true);
            }
            $image32->save($des32.$fileName,100);
            $filePath = $fileName;
        }else{
            $file->move($destination,$fileName);
            $filePath = 'files/'.$dir.'/'.$id.'/'.$fileName;
        }

        return ['path'=> $filePath,'name' => $fileName];
    }
}
