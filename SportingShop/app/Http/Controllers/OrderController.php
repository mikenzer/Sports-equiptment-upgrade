<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetail;
use App\Customer;
use App\Coupon;
use App\Product;
use App\Address;
use App\Slider;
use DB;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();

class OrderController extends Controller
{
    public function history(Request $request){
        if(!Session::get('customer_id')){
            return redirect('dang-nhap');
        }else{
            $order = Order::where('customer_id',Session::get('customer_id'))->orderby('order_created_at', 'DESC')->get();
            //slider
        $slider = Slider::orderby('slider_id', 'DESC')->where('slider_status','1')->take(4)->get();


        //seo
        $meta_des = "Chuyên cung cấp các dụng cụ, xe đạp thể thao và các thiết bị phòng gym.";
        $meta_keywords = "dung cu the thao, dụng cụ thể thao, xe dap the thao, xe đạp thể thao, thiet bi tap gym, thiết bị tập gym";
        $meta_title = "Lịch sử mua hàng";
        $url_canonical = $request->url();
        //endSeo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc')->get();


        return view('pages.history.history')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider', $slider)->with('order', $order);
        }
        
    }
    public function view_history(Request $request, $order_code){
        if(!Session::get('customer_id')){
            return redirect('dang-nhap');
        }else{
            $order = Order::where('customer_id',Session::get('customer_id'))->orderby('order_created_at', 'DESC')->get();
            //slider
        $slider = Slider::orderby('slider_id', 'DESC')->where('slider_status','1')->take(4)->get();


        //seo
        $meta_des = "Chuyên cung cấp các dụng cụ, xe đạp thể thao và các thiết bị phòng gym.";
        $meta_keywords = "dung cu the thao, dụng cụ thể thao, xe dap the thao, xe đạp thể thao, thiet bi tap gym, thiết bị tập gym";
        $meta_title = "Lịch sử mua hàng";
        $url_canonical = $request->url();
        //endSeo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc')->get();
        //Xem lich su don hang
        $order_detail = OrderDetail::where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();
        foreach($order as $key => $od){
            $customer_id = $od->customer_id;
            $shipping_id = $od->shipping_id;
            $order_status = $od->order_status;
        }
        $customer = Customer::where('customer_id', $customer_id)->first(); 
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        // $show_address = Address::where('customer_id', $customer_id)->get(); 
        $order_detail = OrderDetail::with('product')->where('order_code', $order_code)->get();

        foreach($order_detail as $key => $detail){
            $product_coupon = $detail->product_coupon;

        }
        if($product_coupon != 'Không có mã giảm giá'){
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        return view('pages.history.view_history')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider', $slider)->with('order_detail', $order_detail)->with('order', $order)->with('customer', $customer)->with('shipping', $shipping)->with('coupon_condition', $coupon_condition)->with('coupon_number', $coupon_number)->with('order_status', $order_status);
        }
        
    }
    public function print_order(){
        
    }
    public function update_qty(Request $request){
        $data = $request->all();
        $order_detail = OrderDetail::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
        $order_detail->product_quantity = $data['order_qty'];
        $order_detail->save();
    }
    public function update_order_qty(Request $request){
        //update order
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        if($order->order_status == 2){
            foreach($data['order_product_id'] as $key => $product_id){
                $product = Product::find($product_id);
                $product_qty = $product->product_quanty;
                $product_sold = $product->product_sold;
                foreach($data['quantity'] as $key2 => $qty){
                    if($key == $key2){
                        $product_remain = $product_qty - $qty;
                        $product->product_quanty = $product_remain;
                        $product->product_sold = $product_sold +$qty;
                        $product->save();
                    }
                } 
            }
        }elseif($order->order_status!=2){
            foreach($data['order_product_id'] as $key => $product_id){
                
                $product = Product::find($product_id);
                $product_qty = $product->product_quanty;
                $product_sold = $product->product_sold;
                foreach($data['quantity'] as $key2 => $qty){
                        if($key==$key2){
                                $product_remain = $product_qty + $qty;
                                $product->product_quanty = $product_remain;
                                $product->product_sold = $product_sold - $qty;
                                $product->save();
                        }
                }
            }
        }

    }
    public function view_order($order_code){
        $order_detail = OrderDetail::where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();
        foreach($order as $key => $od){
            $customer_id = $od->customer_id;
            $shipping_id = $od->shipping_id;
            $order_status = $od->order_status;
        }
        $customer = Customer::where('customer_id', $customer_id)->first(); 
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        // $show_address = Address::where('customer_id', $customer_id)->get(); 
        $order_detail = OrderDetail::with('product')->where('order_code', $order_code)->get();

        foreach($order_detail as $key => $detail){
            $product_coupon = $detail->product_coupon;

        }
        if($product_coupon != 'Không có mã giảm giá'){
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        // $coupon = Coupon::where('coupon_code', $product_coupon)->first();
        // if($coupon){
        //     $coupon_count = $coupon->count();
        //     if($coupon_count > 0){
        //         $coupon_condition = $coupon->coupon_condition;
        //         $coupon_number = $coupon->coupon_number;
        //     }else{
        //         $coupon_condition = 2;
        //         $coupon_number = 0;
        //     }
        
        // }
        return view('admin.view_order')->with(compact('order_detail', 'customer', 'shipping', 'coupon_condition', 'coupon_number', 'order', 'order_status'));
    }
    public function manage_order(){
        $order = Order::orderby('order_created_at', 'DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
}
