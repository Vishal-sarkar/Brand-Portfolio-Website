<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Carbon;
use Image;

class BlogController extends Controller
{
    public function AllBlog(){
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));
    }

    public function AddBlog(){
        return view('admin.blogs.add_blogs');
    }

    public function StoreBlog(Request $request){
        $request->validate([
            'blog_category_id' => 'required',
            'blog_title' => 'required',
            'blog_description' => 'required',
        ],[
            'blog_category_id' => 'Select Blog Category name',
            'blog_title' => 'Blog Title is required',
        ]);
        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(430,327)->save('upload/blog_image/'.$name_gen);
            $save_url = 'upload/blog_image/'.$name_gen;
            Blog::insert([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Blog Inserted Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        } else {
            Blog::insert([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Blog inserted without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }

    public function EditBlog($id){
        $blog = Blog::find($id);
        return view('admin.blogs.edit_blog', compact('blog'));
    }

    public function UpdateBlog(Request $request, $id){
        if ($request->file('blog_image')) {      
        $blog_img = $request->oldImage;
        unlink($blog_img);
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(430,327)->save('upload/blog_image/'.$name_gen);
            $save_url = 'upload/blog_image/'.$name_gen;
            Blog::findOrFail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog')->with($notification);
        } else {
            Blog::findOrFail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.blog')->with($notification);
        }
    }

    public function DeleteBlog($id){
        $blog = blog::find($id);
        $img = $blog->blog_image;
        unlink($img);
        $blog->delete();
        $notification = array(
            'message' => 'Blog deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notification);
    }
}
