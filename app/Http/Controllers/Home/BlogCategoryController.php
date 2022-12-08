<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Carbon;
use Image;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory(){
        $blogCategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogCategory'));
    }

    public function AddBlogCategory(){
        return view('admin.blog_category.blog_category_add');
    }

    public function StoreBlogCategory(Request $request){
        $request->validate([
            'blog_category' => 'required',
        ],[
            'blog_category' => 'Blog Category is required',
        ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function EditBlogCategory($id){
        $blogCategory = BlogCategory::find($id);
        return view('admin.blog_category.blog_category_edit', compact('blogCategory'));
    }

    public function UpdateBlogCategory(Request $request,$id){
        $request->validate([
            'blog_category' => 'required',
        ],[
            'blog_category' => 'Blog Category is required',
        ]);

        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function DeleteBlogCategory($id){
        $blogCategory = BlogCategory::find($id)->delete();
        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

}
