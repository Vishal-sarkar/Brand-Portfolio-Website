<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Carbon;
use Image;

class PortfolioController extends Controller
{
    public function AllPortfolio(){
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));
    }

    public function AddPortfolio(){
        return view('admin.portfolio.add_portfolio');
    }

    public function StorePortfolio(Request $request){
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_description' => 'required',
        ],[
            'portfolio_name' => 'Portfolio Name is required',
            'portfolio_title' => 'Portfolio Title is required',
        ]);
        if ($request->file('portfolio_image')) {
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1020,517)->save('upload/portfolio_image/'.$name_gen);
            $save_url = 'upload/portfolio_image/'.$name_gen;
            Portfolio::insert([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Portfolio Inserted Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        } else {
            Portfolio::insert([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);
            $notification = array(
                'message' => 'Portfolio inserted without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }

    public function EditPortfolio($id){
        $portfolio = Portfolio::find($id);
        return view('admin.portfolio.edit_portfolio', compact('portfolio'));
    }

    public function UpdatePortfolio(Request $request){
        $portfolio_id = $request->id;
        if ($request->file('portfolio_image')) {
            
        $portfolio_img = $request->oldImage;
        unlink($portfolio_img);
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1020,517)->save('upload/portfolio_image/'.$name_gen);
            $save_url = 'upload/portfolio_image/'.$name_gen;
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Portfolio Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.portfolio')->with($notification);
        } else {
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.portfolio')->with($notification);
        }
    }

    public function DeletePortfolio($id){
        $portfolio = Portfolio::find($id);
        $img = $portfolio->portfolio_image;
        unlink($img);
        $portfolio->delete();
        $notification = array(
            'message' => 'Portfolio deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);
    }

    public function PortfolioDetails($id){
        $portfolio = Portfolio::find($id);
        return view('frontend.portfolio_page', compact('portfolio'));
    }

}