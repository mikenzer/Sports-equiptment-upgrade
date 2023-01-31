@extends('layout')
@section('content')
<section id="form">
   <!--form-->
   <div class="container">
      <div class="row">
         <h2 align="center">Đăng nhập hoặc đăng ký để thanh toán và xem lịch sử mua hàng.</h2>
         <div class="col-sm-5 col-sm-offset-1">
            <div class="login-form">
               <!--login form-->

               <h2>Đăng nhập tài khoản</h2>
               <form action="{{URL::to('/login-customer')}}" method="post">
                  {{csrf_field()}}
                  <p>Email: <input type="text" name="email_account" placeholder="Email" required /></p><br>
                  <p>Mật khẩu: <input type="password" name="password_account" placeholder="Mật khẩu" required /></p>
                  <span>
                  
                  </span>
                  <button type="submit" class="btn btn-default">Đăng nhập</button>
               </form>
            </div>
            <!--/login form-->
         </div>
         <div class="col-sm-1">
            <h2 class="or">HOẶC</h2>
         </div>
         <div class="col-sm-4">
            <div class="signup-form">
               <!--sign up form-->
               <h2>Đăng ký</h2>
               <form action="{{URL::to('/add-customer')}}" method="post">
                  {{csrf_field()}}
                  
                  <p>Họ tên: <input type="text" name="customer_name" placeholder="Họ và tên" required /></p><br>
                  <p>Email: <input type="email" name="customer_email" placeholder="Địa chỉ Email" required /></p><br>
                  <p>Mật khẩu: <input type="password" name="customer_pass" placeholder="Mật khẩu" required /></p><br>
                  <p>Số điện thoại: <input type="text" name="customer_phone" placeholder="Số điện thoại" required /></p><br>
                  <!-- <form action="{{URL::to('/add-address')}}" method="post"> -->
                  <p>Địa chỉ: <input type="text" name="customer_address" placeholder="Địa chỉ" required /></p>
                  <!-- </form> -->
                  
                  <button type="submit" class="btn btn-default">Đăng ký</button>
               </form>
            </div>
            <!--/sign up form-->
         </div>
      </div>
   </div>
</section>
<!--/form-->
@endsection