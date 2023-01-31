<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Social; //sử dụng model Social
use Socialite; //sử dụng Socialite
use App\Login;
use App\Statistic;
use App\Rules\Captcha; 
use Validator;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    //Dashboard
    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();

        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $datta = json_encode($chart_data);
    }

    public function authLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        echo view('admin_login');
    }
    public function show_dashboard(){
        $this->authLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $this->validate($request,[
            'admin_email' => 'required|email|max:255', 
            'admin_password' => 'required|max:255'  
        ]);
        // $data = $request->all();
        if(Auth::attempt([ 'admin_email' => $request->admin_email, 'admin_password' => $request->admin_password])){
            return redirect('/dashboard');
        }else{
            return redirect('/admin')->with('message','Tài khoản hoặc mật khẩu không chính xác');
        }
        // $data = $request->all();

        //  $data = $request->validate([
        //     //validation laravel
        //     'admin_email' => 'required',
        //     'admin_password' => 'required',
            
        //    'g-recaptcha-response' => new Captcha(),         //dòng kiểm tra Captcha
        // ]);

        // $admin_email = $data['admin_email'];
        // $admin_password = md5($data['admin_password']);
        // $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        
        // if($login){
        //     $login_count = $login->count();
        //     if($login_count >= 0){
        //         Session::put('admin_name', $login->admin_name);
        //         Session::put('admin_id', $login->admin_id);
        //         return Redirect::to('/dashboard');
        //     }     
        // }else{
        //         Session::put('message', 'Sai mật khẩu hoặc tài khoản. Mời bạn nhập lại!');
        //         return Redirect::to('/admin');
        //     } 
        // $admin_email = $request->admin_email;
        // $admin_password = md5($request->admin_password);

        // $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        // if($result){
        //     Session::put('admin_name', $result->admin_name);
        //     Session::put('admin_id', $result->admin_id);
        //     return Redirect::to('/dashboard');
        // }else{
        //     Session::put('message', 'Sai mật khẩu hoặc tài khoản. Mời bạn nhập lại!');
        //     return Redirect::to('/admin');
        // }
    }
    public function logout(Request $request){
        $this->authLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('admin');
    }

    //Login FB
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                    'admin_status' => 1

                ]);
            }
            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('admin_id',$account->user)->first();

            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }
}
