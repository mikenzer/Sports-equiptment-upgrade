@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				@if(session()->has('message'))
					<div class="alert alert-success">
							{!! session()->get('message') !!}
					</div>
				@elseif(session()->has('error'))
					<div class="alert alert-danger">
							{!! session()->get('error') !!}
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
						<!-- 	<td class="cart_description">
								<h4><a href=""></a></h4>
								<p></p>
							</td> -->
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
                            	@endif</td>
							
							<td colspan="5">
								<li>Tổng cộng: <span>{{number_format($total,0,',','.')}} VND</span></li>
								@if(Session::get('coupon'))
								<li> 
									
										@foreach(Session::get('coupon') as $key => $cou)
											@if($cou['coupon_condition'] == 1)
												Mã giảm: -{{$cou['coupon_number']}} %
												
													@php
														$total_coupon = ($total*$cou['coupon_number'])/100;
														echo '<li>Giảm: -'.number_format($total_coupon,0,',','.').' VND</li>';
													@endphp
												
												<li>Tổng tiền sau khi giảm: {{number_format($total-$total_coupon,0,',','.')}} VND</li>
											@else
												Mã giảm: -{{number_format($cou['coupon_number'],0,',','.')}} VND
												
													
												<li>Tổng tiền sau khi giảm: {{number_format($total-$cou['coupon_number'],0,',','.')}} VND</li>
											@endif
										@endforeach
									
									

								</li>
								@endif
								<!-- <li>Thuế: <span></span></li>
								<li>Phí vận chuyển: <span>Free</span></li> -->
								
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
				@if(Session::get('cart'))
					<center>
                        @if(Session::get('customer_id'))
                        <?php
                        $customer_id = Session::get('customer_id');
                        ?>	
                            <a class="btn btn-default check_out" href="{{URL::to('/checkout/'.$customer_id)}}">Thanh toán</a>
                                    
                        @else           
                            <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                        @endif
                                    
                    </center>
                @endif			
			</div>

	</section> <!--/#cart_items-->
<!-- <section id="do_action">
		<div class="container">			
			<div class="row">
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							
						</ul>						
                                    <a class="btn btn-default check_out" href="">Thanh toán</a>
                                    <a class="btn btn-default check_out" href="">Mã giảm giá</a>
					</div>
				</div>
			</div>
		</div>
	</section> --><!--/#do_action-->
@endsection