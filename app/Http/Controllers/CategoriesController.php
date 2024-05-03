<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class CategoriesController extends Controller
{
      public function index()
      {
            $categories = Category::latest()->get();
            return Inertia::render('Admin/Categories/Index', compact('categories'));
      }
      public function create()
      {
            return Inertia::render('Admin/Categories/Create');
      }
      public function store(Request $request)
      {
            $validator = Validator::make($request->all(), [
                  'category_image' => 'required|image',
                  'category_heading' => 'required',
                  'thumbnail' => 'required|image',
            ]);
            if ($validator->fails()) {
                  return redirect()->back()->withErrors($validator)->withInput();
            }
            $category = new Category();
            $category->category_heading = $request->category_heading;
            if ($request->hasFile('category_image')) {
                  $image = $request->file('category_image');
                  $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                  Storage::disk('public')->put('categories/' . $name, file_get_contents($image));
                  $category->category_image ='/storage/categories/'. $name;
            }
            if ($request->hasFile('thumbnail')) {
                  $image = $request->file('thumbnail');
                  $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                  Storage::disk('public')->put('categories/thumbnail/' . $name, file_get_contents($image));
                  $category->thumbnail = '/storage/categories/thumbnail/'. $name;
            }
            $category->status = ($request->status == "true") ? 1 : 0;
            $category->save();
            return to_route('category.index', ['status' => true, 'message' => 'Data Added successfully!']);

      }
      public function edit($id)
      {
            $category = Category::where('id', $id)->first();
            return Inertia::render('Admin/Categories/Edit', compact("category"));
      }
      public function update(Request $request, $id)
      {
            $validator = Validator::make($request->all(), [
                  'category_image' => 'required',
                  'category_heading' => 'required',
                  'thumbnail' => 'required',
            ]);
            if ($validator->fails()) {
                  return redirect()->back()->withErrors($validator)->withInput();
            }
            $category = Category::findOrFail($id);
            if ($request->thumbnail != $category->thumbnail) {
                  if (public_path($category->thumbnail)) {
                        $imagePath = substr($category->thumbnail, strlen('/storage'));
                        Storage::disk('public')->delete($imagePath);
                     }
                  $image = $request->file('thumbnail');
                  $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                  Storage::disk('public')->put('categories/thumbnail/' . $name, file_get_contents($image));
                  $category->thumbnail = '/storage/categories/thumbnail/'.$name;
            }
            if ($request->category_image != $category->category_image) {
                  if (public_path($category->category_image)) {
                        $imagePath = substr($category->category_image, strlen('/storage'));
                        Storage::disk('public')->delete($imagePath);
                     }
                  $image = $request->file('category_image');
                  $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                  Storage::disk('public')->put('categories/' . $name, file_get_contents($image));
                  $category->category_image = '/storage/categories/'.$name;
            }
            $category->category_heading = $request->category_heading;
            $category->status = ($request->status == "1") ? 1 : 0;
            $category->save();
            return to_route('category.index', ['status' => true, 'message' => 'Data Updated successfully!']);

      }
      public function destroy($id)
      {

            $category = Category::findOrFail($id);
            $category->forceDelete();
            return to_route('category.index');
      }
}
