@extends('layout')
@section('content')
<section id="cart_items">
   <div class="container">
      <div class="breadcrumbs">
         <ol class="breadcrumb">
            <li><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
            <li class="active">Thanh toán giỏ hàng</li>
         </ol>
      </div>
      <div class="col-sm-12 clearfix">
         <div class="table-responsive cart_info">
            @if(session()->has('message'))
            <div class="alert alert-success">
               {{session()->get('message')}}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
               {{session()->get('error')}}
            </div>
            @endif
            <table class="table table-condensed">
               <form action="{{url('/update-cart')}}" method="POST">
                  @csrf
                  <thead>
                     <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Giá sản phẩm</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                     </tr>
                  </thead>
                  <tbody>
                     @if(Session::get('cart')==true)	
                     @php
                     $total = 0;
                     @endphp
                     @foreach(Session::get('cart') as $key => $cart)
                     @php
                     $subtotal = $cart['product_price']*$cart['product_qty'];
                     $total+=$subtotal;
                     @endphp
                     <tr>
                        <td class="cart_product">
                           <img src="{{asset('public/upload/product/'.$cart['product_img'])}}" width="90" alt="{{$cart['product_name']}}" />
                        </td>
                        <td class="cart_description">
                           <h4><a href=""></a></h4>
                           <p>{{$cart['product_name']}}</p>
                        </td>
                        <td class="cart_price">
                           <p>{{number_format($cart['product_price'],0,',','.')}} VND</p>
                        </td>
                        <td class="cart_quantity">
                           <div class="cart_quantity_button">
                              <input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                           </div>
                        </td>
                        <td class="cart_total">
                           <p class="cart_total_price">
                              {{number_format($subtotal,0,',','.')}} VND
                           </p>
                        </td>
                        <td class="cart_delete">
                           <a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                        </td>
                     </tr>
                     @endforeach
                     <tr>
                        <td><input type="submit" value="Cập nhật" name="update_qty" class="check_out btn btn-default btn-sm"></td>
                        <td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
                        <td>
                           @if(Session::get('coupon'))
                           <a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã giảm giá</a>
                           @endif
                        </td>
                        <td colspan="5">
                           <li>Tổng cộng: <span>{{number_format($total,0,',','.')}} VND</span></li>
                           @if(Session::get('coupon'))
                           <li> 
                              @foreach(Session::get('coupon') as $key => $cou)
                              @if($cou['coupon_condition'] == 1)
                              Mã khuyến mãi: -{{$cou['coupon_number']}} %
                              @php
                              $total_coupon = ($total*$cou['coupon_number'])/100;
                              @endphp
                              @php 
                              $total_after_coupon = $total-$total_coupon ;
                              @endphp
                           <li>Giảm: -{{number_format($total_coupon,0,',','.')}} VND</li>
                           @else
                           Mã khuyến mãi: -{{number_format($cou['coupon_number'],0,',','.')}} VND
                           @php
                           $total_coupon = $total-$cou['coupon_number'];
                           @endphp
                           @php 
                           $total_after_coupon = $total-$total_coupon; 
                           @endphp
                           @endif
                           @endforeach
                           </li>
                           @endif
                           <!-- <li>Thuế: <span></span></li> -->
                           @if(Session::get('fee'))
                           <li>
                              <a class="cart_quantity_delete" href="{{url('/del-fee/')}}"><i class="fa fa-times"></i></a>
                              Phí vận chuyển: <span>+{{number_format(Session::get('fee'),0,',','.')}} VND</span>
                              <?php
                                 $total_after_fee = $total + Session::get('fee');
                                 ?>
                           </li>
                           @endif
                           <li>Thành tiền: 
                              @php
                              if(Session::get('fee') && !Session::get('coupon')){
                              $total_after = $total_after_fee;
                              echo number_format($total_after,0,',','.').' VND';
                              }elseif(!Session::get('fee') && Session::get('coupon')){
                              $total_after = $total_after_coupon;
                              echo number_format($total_after,0,',','.').' VND';
                              }elseif(Session::get('fee') && Session::get('coupon')){
                              $total_after = $total_after_coupon;
                              $total_after = $total_after + Session::get('fee');
                              echo number_format($total_after,0,',','.').' VND';
                              }elseif(!Session::get('fee') && !Session::get('coupon')){
                              $total_after = $total;
                              echo number_format($total_after,0,',','.').' VND';
                              }
                              @endphp
                           </li>
                        </td>
                     </tr>
                     @else
                     <tr >
                        <td colspan="5">
                           <center>
                              <?php
                                 echo 'Hãy thêm sản phẩm vào giỏ hàng!';
                                 ?>	
                           </center>
                        </td>
                     </tr>
                     @endif
                  </tbody>
               </form>
               @if(Session::get('cart'))
               <tr>
                  <td>
                     <form method="post" action="{{url('/check-coupon')}}" >
                        @csrf
                        <input type="text" class="form-control" name="coupon" placeholder="Mã giảm giá">
                        <input type="submit" class="btn btn-default check_out" name="check_coupon" value="Tính mã giảm giá">
                     </form>
                  </td>
               </tr>
               @endif
            </table>
         </div>
      </div>
      <div class="shopper-informations">
         <div class="row">
            <div class="col-sm-12 clearfix">
               <div class="bill-to">
                  
                  @if(Session::get('cart'))
                  <div class="form-one">
                     <p>Tính phí vận chuyển</p>
                     <form >
                        @csrf           
                        <div class="form-group">
                           <label for="exampleInputPassword1">Chọn thành phố</label>
                           <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                              <option value="">-----Chọn tỉnh, thành phố-----</option>
                              @foreach($city as $key => $ci)
                              <option value="{{$ci->matp}}">{{$ci->tentp}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="exampleInputPassword1">Chọn quận huyện</label>
                           <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                              <option value="">-----Chọn quận huyện-----</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="exampleInputPassword1">Chọn xã phường</label>
                           <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                              <option value="">-----Chọn xã phường-----</option>
                           </select>
                        </div>
                        <input type="button" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery">
                     </form>
                     @if(Session::get('fee'))
                     <p>Thông tin giao hàng</p>
                     
                     <form>
                        <table class="table table-condensed">
                           <thead>
                              <tr>
                                 <td>Tên</td>
                                 <td>Email</td>
                                 <td>Số điện thoại</td>
                                 <td>Địa chỉ</td>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                @foreach($profile_payment as $key => $pf) 
                                  <td>{{ $pf->customer_name}}</td>
                                   <td>{{ $pf->customer_email}}</td>
                                   <td > {{ $pf->customer_phone}}</td>
                                   <td>{{ $pf->customer_address}}</td>
                                 @endforeach

                              </tr>
                              
                                  
                              
                           </tbody>
                        </table>
                        <?php
                        $customer_id = Session::get('customer_id');
                        ?>
                           <a class="btn btn-default update_info" href="{{URL::to('/update-profile/'.$customer_id)}}">Thay đổi thông tin</a><br>

                     </form>
                     <form method="post">
                        @csrf
                        <!-- <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*">		 -->							
                        <!-- <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên*">	 -->
                        <!-- <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ*"> -->
                        <!-- <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại*"> -->
                        <br><p>Ghi chú đơn hàng</p>
                        <textarea name="shipping_note" class="shipping_note" placeholder="Ghi chú đơn hàng của bạn" rows="5" required></textarea>
                        @if(Session::get('fee'))
                        <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                        @else
                        <input type="hidden" name="order_fee" class="order_fee" value="40000">
                        @endif
                        @if(Session::get('coupon'))
                        @foreach(Session::get('coupon') as $key => $cou)
                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                        @endforeach
                        @else
                        <input type="hidden" name="order_coupon" class="order_coupon" value="Không có mã giảm giá">
                        @endif
                        <input type="hidden" name="order_fee" class="order_fee" >
                        <div class="">
                           <div class="form-group">
                              <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                              <select name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                 <option value="0">Chuyển khoản</option>
                                 <option value="1">Thanh toán sau khi nhận hàng</option>
                              </select>
                           </div>
                        </div>
                        <input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                     </form>
                     
                     @endif
                  </div>
                  @else
                  <h2>Hãy thêm sản phẩm để thanh toán.</h2>
                  @endif					
               </div>
            </div>
         </div>
      </div>
      <!-- <div class="review-payment">
         <h2>Xem lại giỏ hàng</h2>
         </div>	 -->		
   </div>
</section>
<!--/#cart_items-->
@endsection