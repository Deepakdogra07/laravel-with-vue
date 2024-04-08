<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allNews = News::all();
        return Inertia::render('News/index',['allNews'=>$allNews]);
    }

    public function press_index()
    {
        $allNews = News::paginate(9);

        return Inertia::render('Frontend/Press/index',['news'=>$allNews]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('News/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
            'content' => 'required',
            'image' => 'required|image|max:2048',
        ],[
            'title.required' => 'Title is must.',
            'link.required' => 'Link is must.',
            'content.required' => 'Content is must.',
            'image.required' => 'Image is must.',
        ]);

            if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }

            $uploadedFile = $request->file('image');
            $originalName = $uploadedFile->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $path = $uploadedFile->storeAs('public/news', $uniqueName);

            News::create([
                'title'=>$request->title,
                'link'=>$request->link,
                'content'=>$request->content,
                'image'=>$uniqueName,
            ]);

            return to_route('news.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editNews = News::where('id',$id)->first();
        return Inertia::render('News/edit',['editNews'=>$editNews]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
            'content' => 'required',
            'image' => 'max:2048',
        ],[
            'title.required' => 'Title is must.',
            'link.required' => 'Link is must.',
            'content.required' => 'Content is must.',
        ]);

            if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }

            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
                $originalName = $uploadedFile->getClientOriginalName();
                $uniqueName = time() . '_' . $originalName;
                $path = $uploadedFile->storeAs('public/news', $uniqueName);
            }

            $newsUpdate = News::find($id);

            if ($newsUpdate) {
                $newsUpdate->title = $request->title;
                $newsUpdate->link = $request->link;
                $newsUpdate->content = $request->content;

                if ($request->hasFile('image')) {
                    $newsUpdate->image = $uniqueName;
                }

                $newsUpdate->update();
                return to_route('news.index');
            }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        News::where('id',$id)->delete();
        return to_route('news.index');
    }
}
