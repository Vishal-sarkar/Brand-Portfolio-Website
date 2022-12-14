<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;
use Image;

class AboutController extends Controller
{
    public function AboutPage(){
        $aboutPage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }

    public function UpdateAbout(Request $request){
        $about_id = $request->id;
        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(523,605)->save('upload/home_about/'.$name_gen);
            $save_url = 'upload/home_about/'.$name_gen;
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'About Page Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        } else {
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);
            $notification = array(
                'message' => 'About Page Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
        
    }

    public function HomeAbout(){
        $aboutPage = About::find(1);
        return view('frontend.about_page', compact('aboutPage'));
    }

    public function AboutMultiImage(){
        $multImg = MultiImage::find(1);
        return view('admin.about_page.multimage', compact('multImg'));
    }

    public function StoreMultiImage(Request $request){
        $image = $request->file('multImg');
        foreach($image as $multi_image){
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();
            Image::make($multi_image)->resize(220,220)->save('upload/multi_image/'.$name_gen);
            $save_url = 'upload/multi_image/'.$name_gen;
            MultiImage::insert([
                'multImg' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }
        $notification = array(
            'message' => 'Multi Image Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AllMultiImage(){
        $multImg = MultiImage::all();
        return view('admin.about_page.All_multiimage', compact('multImg'));
    }

    public function EditMultiImage($id){
        $multImg = MultiImage::find($id);
        return view('admin.about_page.edit_multiimage', compact('multImg'));
    }

    public function UpdateMultiImage(Request $request, $id){
        $image = $request->file('multImg');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(220,220)->save('upload/multi_image/'.$name_gen);
        $save_url = 'upload/multi_image/'.$name_gen;
        MultiImage::findOrFail($id)->update([
            'multImg' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
        
    }

    public function DeleteMultiImage($id){
        $multImg = MultiImage::find($id);
        $img = $multImg->multImg;
        unlink($img);
        MultiImage::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
    }
}