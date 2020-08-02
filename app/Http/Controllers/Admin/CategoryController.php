<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 0;
        $count = 6;
        if ($request->pageCount!=null)
            $count = $request->pageCount;
        else
            $row = ($page > 0 ) ? (($page-1)*$count+1) : 1;
        $categories = Category::filter()->with('category')->skip($row)->paginate($count);
        return view('Admin.categories.index',compact('categories','row'));
    }


    public function create()
    {
        return view('Admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        Category::create($request->all());
        return redirect(route('categories.index'));
    }

    public function show(Category $category)
    {
        //
    }
    public function edit(Category $category)
    {
        return view('Admin.categories.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['title' => 'required']);
        $category->update($request->all());
        return redirect(route('categories.index'));
    }

    public function destroy(Category $category)
    {
        if ($category->status == 0)
            $category->status = 1;
        else
            $category->status = 0;
        $category->save();
        return back();
    }
}
