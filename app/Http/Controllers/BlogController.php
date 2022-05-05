<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::all();
        return view('blog.index',compact('blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $blog = new Blog;
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->published = 1;
        if($request->hasFile('photo')){
            $blog->photo = $request->photo->store('uploads/blogs');
        }
            $blog->save();
            flash(__('Blog has been inserted successfully'))->success();
        return redirect()->route('blog.index');
    }

    public function updateStatus(Request $request)
    {
        
        $blog = Blog::find($request->id);
        $blog->published = $request->status;
        if($blog->save()){
            return '1';
        }
        else {
            return '0';
        }

        return '0';
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $blog->photo = $request->previous_photo;
        if($request->hasFile('photo')){
            $blog->photo = $request->photo->store('uploads/blogs');
        }
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->save();
        flash(__('Blog has been updated successfully'))->success();
        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if(Blog::destroy($id)){
          
            flash(__('Blog has been deleted successfully'))->success();
        }
        else{
            flash(__('Something went wrong'))->error();
        }
        return redirect()->route('blog.index');
    }
}
