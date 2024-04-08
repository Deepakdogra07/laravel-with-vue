<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pages;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function pages()
    {
        $pages = Pages::all();
        // dd($pages);
     return Inertia::render('AllPages/Pages',['pages' => $pages]);

    }
    public function details()
    {
     return Inertia::render('AllPages/AddDetails');
    }
    public function detailSave(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required'
        ]);
        $detail  = new Pages;
        $detail->title = $request->title;
        $detail->slug = $request->slug;
        $detail->content = $request->content;
        $detail->save();

    }
    public function viewPages(Request $request)
    {
        // dd("dfgdfgdf");
        $page = Pages::find($request->id);
        // dd($page);
        return Inertia::render('AllPages/ViewPages',['page' => $page]);

    }
    public function editPages(Request $request)
    {
        $page = Pages::find($request->id);
        // dd($page);
        return Inertia::render('AllPages/EditDetails',['page' => $page]);

    }
    public function updatePages(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required'
        ]);
        $page = Pages::where('id', $request->id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
        ]);
        return Inertia::render('AllPages/EditDetails',['page' => $page]);

    }
    public function deletePages(Request $request)
    {
        $page = Pages::find($request->id)->delete();
    }

}
