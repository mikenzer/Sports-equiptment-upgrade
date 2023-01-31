<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use App\Coupon;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $quantity = $request->qty;

        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first(); 
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '12';
        $data['options']['image'] = $product_info->product_img;
        //Cart::destroy();
        Cart::add($data);
        Cart::setGlobalTax(0);
        return Redirect::to('/show-cart');

         

    }
    public function show_cart(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        
        //seo
        $meta_des = "Các sản phẩm đã thêm";
        $meta_keywords = "Gio, hang, gio hang";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        //endSeo
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function delete_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_qty(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->quantity_cart;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }

    //Cart Ajax
     public function add_cart_ajax(Request $request){
        $data = $request->all();
        //print_r($data);
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                     $cart[$key] = array(
                    'session_id' => $val['session_id'],
                    'product_name' => $val['product_name'],
                    'product_id' => $val['product_id'],
                    'product_img' => $val['product_img'],
                    'product_quanty' => $val['product_quanty'],
                    'product_qty' => $val['product_qty']+ $data['cart_product_qty'],
                    'product_price' => $val['product_price'],
                    );
                    Session::put('cart',$cart);
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_quanty' => $data['cart_product_quanty'],
                'product_img' => $data['cart_product_img'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                
                );
                Session::put('cart',$cart);
            }
        
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_quanty' => $data['cart_product_quanty'],
                'product_img' => $data['cart_product_img'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                
            );
            Session::put('cart',$cart);
        }
       
        Session::save();

  

    }
    public function gio_hang(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        
        //seo
        $meta_des = "Các sản phẩm đã thêm";
        $meta_keywords = "Gio, hang, gio hang";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        //endSeo
        return view('pages.cart.show_cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function del_product($session_id){
        $cart = Session::get('cart');
        if($cart == true){
            foreach($cart as $key => $val){
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Xóa xản phẩm thành công');
        }else{
            return redirect()->back()->with('error','Xóa xản phẩm thất bại');
        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true){
            $message ='';
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key && $qty <= $cart[$session]['product_quanty']){
                        $cart[$session]['product_qty'] = $qty;
                        $message.='<p style="color:green">Cập nhật số lượng '.$cart[$session]['product_name'].' thành công</p>';
                    }elseif($val['session_id']==$key && $qty > $cart[$session]['product_quanty']){
                        $message.='<p style="color:red">Cập nhật số lượng '.$cart[$session]['product_name'].' thất bại</p>';
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message',$message);
        }
        // }else{
        //     return redirect()->back()->with('message','');
        // }
    }
    public function del_all_product(){
        $cart = Session::get('cart');
        if($cart == true){
            //Session::destroy();
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa tất cả sản phẩm thành công');
        }
    }
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('message','Thêm mã giảm giá thành công');
            }
        }else{
            return redirect()->back()->with('error','Mã giảm giá không đúng');
        }
    }
    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true){
            
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa mã giảm giá thành công');
        }
    }
}
