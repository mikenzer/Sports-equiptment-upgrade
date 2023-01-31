@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="review-payment">
				<h2>Đơn hàng của bạn đã được gửi đi. Cảm ơn bạn đã đặt hàng!</h2>
			</div>
			<a href="{{URL::to('/trang-chu')}}" class="active"><input type="submit" class="btn btn-primary btn-sm" value="Tiếp tục mua hàng"/></a>
		</div>
	</section> <!--/#cart_items-->
@endsection