<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Customer;
use App\City;
use App\Province;
use App\Wards;
use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetail;
class CheckoutController extends Controller
{
    public function authLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function confirm_order(Request $request){
        $data = $request->all();
        $shipping = new Shipping();
        // $shipping->shipping_name = $data['shipping_name'];
        // $shipping->shipping_phone = $data['shipping_phone'];
        //$shipping->shipping_address = $data['shipping_address'];
        // $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();

        $shipping_id = $shipping->shipping_id;
        
        //random code
        $checkout_code = substr(md5(microtime()), rand(0,26), 5);

        $order = new Order();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        $order->order_created_at = now();
        $order->save();

        
        if(Session::get('cart') == true){
            foreach(Session::get('cart') as $key => $cart){
                $order_detail = new OrderDetail;
                $order_detail ->order_code = $checkout_code;
                $order_detail->product_id = $cart['product_id'];
                $order_detail->product_name = $cart['product_name'];
                $order_detail->product_price = $cart['product_price'];
                $order_detail->product_quantity = $cart['product_qty'];
                $order_detail->product_coupon = $data['order_coupon'];
                $order_detail->product_feeship = $data['order_fee'];
                $order_detail->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['city']){
            $feeship = Feeship::where('fee_matp',$data['city'])->where('fee_maqh',$data['province'])->where('fee_maxa',$data['wards'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship >0){
                    foreach($feeship as $key => $fee){
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                }else{
                    Session::put('fee', 40000);
                    Session::save();
            
                }
            }
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action'] == "city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderBy('maqh', 'ASC')->get();
                $output.='<option>-----Chọn quận huyện-----</option>';
                foreach($select_province as $key => $province){
                $output.='<option value="'.$province->maqh.'">'.$province->tenqh.'</option>';
                }
            }else{
                $select_wards = Wards::where('maqh',$data['ma_id'])->orderBy('maxa', 'ASC')->get();
                $output.='<option>-----Chọn xã phường-----</option>';
                foreach($select_wards as $key => $wards){
                $output.='<option value="'.$wards->maxa.'">'.$wards->tenxa.'</option>';
                }
            }
        }
        echo $output;
    }
    public function login_checkout(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        //seo
        $meta_des = "Đăng nhập, đăng ký";
        $meta_keywords = "dang nhap, dang ky";
        $meta_title = "Tài khoản";
        $url_canonical = $request->url();
        //endSeo
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_pass'] = md5($request->customer_pass);
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_address'] = $request->customer_address;

        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        $customer_name = $request->customer_name;
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$customer_name);
        
         return Redirect::to('/checkout/$customer_id');
    }
   
   public function profile_user(Request $request, $customer_id){
        $profile = Customer::where('customer_id',Session::get('customer_id'))->get();
        //seo
        $meta_des = "Đăng nhập, đăng ký";
        $meta_keywords = "dang nhap, dang ky";
        $meta_title = "Thông tin khách hàng";
        $url_canonical = $request->url();
        //endSeo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
         return view('pages.checkout.profile')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('profile',$profile);
   }
   public function edit_profile(Request $request, $customer_id){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_address'] = $request->customer_address;
        Customer::where('customer_id',Session::get('customer_id'))->update($data);
        Session::put('message', 'Cập nhật thành công');
        return Redirect::to('update-profile/$customer_id');
   }
   public function update_profile(Request $request, $customer_id){
       
        $update_profile = Customer::where('customer_id',Session::get('customer_id'))->get();
        //seo
        $meta_des = "Đăng nhập, đăng ký";
        $meta_keywords = "dang nhap, dang ky";
        $meta_title = "Thông tin khách hàng";
        $url_canonical = $request->url();
        //endSeo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
         return view('pages.checkout.update_profile')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('update_profile',$update_profile);
   }
   //  public function profile_payment(Request $request, $customer_id){
   //      $profile = Customer::where('customer_id',Session::get('customer_id'))->get();
   //      //seo
   //      $meta_des = "Đăng nhập, đăng ký";
   //      $meta_keywords = "dang nhap, dang ky";
   //      $meta_title = "Thông tin khách hàng";
   //      $url_canonical = $request->url();
   //      //endSeo
   //      $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
   //      $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
   //       return view('pages.checkout.profile')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('profile',$profile);
   // }
    public function checkout(Request $request, $customer_id){
        $profile_payment = Customer::where('customer_id',Session::get('customer_id'))->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        // $all_customer = Customer::orderBy('customer_id','desc')->get();
        // $customer_id = $all_customer->customer_id;

        // $address = DB::table('tbl_address')->where('customer_id',$customer_id)->get();
        // //seo
        $meta_des = "Thông tin giao hàng";
        $meta_keywords = "thong tin, giao hang";
        $meta_title = "Thông tin giao hàng";
        $url_canonical = $request->url();
        //endSeo
        $city = City::orderby('matp', 'ASC')->get();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('city',$city)->with('profile_payment',$profile_payment);
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }
    public function payment(Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        //seo
        $meta_des = "Thanh toán";
        $meta_keywords = "thanh toan, pay";
        $meta_title = "Thanh toán";
        $url_canonical = $request->url();
        //endSeo
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_pass',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout/$customer_id');
        }else{
            return Redirect::to('/login-checkout');
        }        
    }
    public function order_place(Request $request){
        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_options;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total(0,',','.').' VND';
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order details
        $content = Cart::content();
        $order_data = array();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){
            echo 'Thanh toán chuyển khoản';
        }else{
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
            //seo
            $meta_des = "HÌnh thức thanh toán";
            $meta_keywords = "thanh toan, hinh thuc thanh toan";
            $meta_title = "Hình thức thanh toán";
            $url_canonical = $request->url();
            //endSeo
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_des',$meta_des)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
        }    
    }

    //Admin manage order
    public function manage_order(){
        $this->authLogin();
        $all_order = DB::table('tbl_order')->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')->select('tbl_order.*','tbl_customer.customer_name')->orderBy('tbl_order.customer_id','desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
    public function view_order($orderID){
        $order_by_id = DB::table('tbl_order')->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
}
