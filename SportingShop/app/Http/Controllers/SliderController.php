<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;
use Auth;
class SliderController extends Controller
{
    public function authLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function manage_slider(){
        $all_slider = Slider::orderby('slider_id', 'DESC')->get();
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }
    public function add_slider(){

        return view('admin.slider.add_slider');

    }
    public function insert_slider(Request $request){
        $data = $request->all();
        $this->authLogin();

        $get_image = $request->file('slider_img');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/slider', $new_image);
            
            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_img = $new_image;
            $slider->slider_des = $data['slider_des'];
            $slider->slider_status = $data['slider_status'];
            $slider->save();

            Session::put('message', 'Thêm sliderthành công');
            return Redirect::to('add-slider');
        }else{
            Session::put('message', 'Hãy thêm hình ảnh cho slider');
            return Redirect::to('add-slider');
        }  

    }
    public function active_slider($slider_id){
        $this->authLogin();
        DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status'=>1]);
        Session::put('message', 'Kích hoạt slider thành công');
        return Redirect::to('manage-slider');
    }
    public function unactive_slider($slider_id){
        $this->authLogin();
        DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status'=>0]);
        Session::put('message', 'Tắt slider thành công');
        return Redirect::to('manage-slider');
    }
    public function delete_slider($slider_id){
        $this->authLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->delete();
        Session::put('message', 'Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('manage-slider'); 
     }  
}
