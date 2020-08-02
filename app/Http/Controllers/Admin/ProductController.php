<?php

namespace App\Http\Controllers\Admin;

use App\Gallery;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        else
            $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $products = Product::filter()->skip($row)->paginate($count);
        return view('Admin.products.index',compact('products','row'));
    }

    public function create()
    {
        return view('Admin.products.create');
    }

    public function store(ProductRequest $request)
    {

        $product = Product::create($request->all());
        $product->categories()->sync($request->input('category_id'));
        if ($request->file('file')) {
            $poster = $this->saveFile($request,$product->id,'products','image');
            $product->poster = $poster['name'];
            $product->url = $poster['path'];
            $product->save();
        }
        if ($request->file('files')) {
            $fileUrls = $this->saveFiles($request,$product->id,'products','image');
            foreach ($fileUrls as $fileUrl){
                Gallery::create([
                    'product_id' => $product->id,
                    'url' => $fileUrl['path']
                ]);
            }
        }

        return redirect(route('products.index'));
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {

        return view('Admin.products.edit',compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->title != $request->title)
            $request->validate(['title' => 'unique:products']);
        $product->update($request->all());
        $product->categories()->sync($request->input('category_id'));
        if($request->file('file')) {
            if ($product->poster != null){
                $path = public_path($product->url);
                $isExists = file_exists($path);
                if ($isExists)
                    unlink($path);
            }
            $poster = $this->saveFile($request,$product->id,'products','image');
            $product->poster = $poster['name'];
            $product->url = $poster['path'];
            $product->save();
        }
        if ($request->file('files')) {
            $fileUrls = $this->saveFiles($request,$product->id,'products','image');
            foreach ($fileUrls as $fileUrl){
                Gallery::create([
                    'product_id' => $product->id,
                    'url' => $fileUrl['path']
                ]);
            }
        }
        return redirect(route('products.index'));
    }

    public function destroy(Product $product)
    {
        if ($product->status == 0){
            $product->status = 1;
        }else {
            $product->status = 0;
        }
        $product->save();
        return back();
    }
    public function deleteFile(Request $request){
        $productImage = Gallery::find($request->id);
        $path1 = public_path('files/products/'.$productImage->product_id.'/32p/'.$productImage->url);
        $path2 = public_path('files/products/'.$productImage->product_id.'/300p/'.$productImage->url);
        $path3 = public_path('files/products/'.$productImage->product_id.'/640p/'.$productImage->url);
        $isExists = file_exists($path1);
        if ($isExists)
            unlink($path1);
        $isExists = file_exists($path2);
        if ($isExists)
            unlink($path2);
        $isExists = file_exists($path3);
        if ($isExists)
            unlink($path3);
        $productImage->delete();
        return "success";
    }
}
