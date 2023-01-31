<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use App\Slider;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){
        //slider
        $slider = Slider::orderby('slider_id', 'DESC')->where('slider_status','1')->take(4)->get();


        //seo
        $meta_des = "Chuyên cung cấp các dụng cụ, xe đạp thể thao và các thiết bị phòng gym.";
        $meta_keywords = "dung cu the thao, dụng cụ thể thao, xe dap the thao, xe đạp thể thao, thiet bi tap gym, thiết bị tập gym";
        $meta_title = "TTN Sport | Thiết bị thể thao, dụng cụ phòng gym";
        $url_canonical = $request->url();
        //endSeo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc')->get();
        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider', $slider);
    }
    public function search(Request $request){
        $keywords = $request->keyword_search;
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
        //slider
        $slider = Slider::orderby('slider_id', 'DESC')->where('slider_status','1')->take(4)->get();
        //seo
        $meta_des = "Tìm kiếm sản phẩm";
        $meta_keywords = "tim, kiem";
        $meta_title = "Kết quả tìm kiếm";
        $url_canonical = $request->url();
        //endSeo
        return view('pages.product.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider', $slider);
    }

    //SendMail
    public function send_mail(){
        //send mail
                $to_name = "shoplaravel";
                $to_email = "trongnhan18082k@gmail.com";//send to this email
        
                $data = array("name"=>"Mail từ tài khoản khách hàng","body"=>'Mail gửi về vấn đề hàng hóa'); //body of mail.blade.php
            
                Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
                    $message->to($to_email)->subject('test mail nhé');//send this mail with subject
                    $message->from($to_email,$to_name);//send from this mail
                });
                return Redirect('/')->with('message','');
                //--send mail

    }
}
