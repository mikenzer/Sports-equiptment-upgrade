@extends('layout')
@section('content')
@foreach($product_detail as $key => $detail)
<section>
<div class="container">
<div class="row">
<div class="col-sm-3">
   <div class="left-sidebar">
      <h2>Danh mục sản phẩm</h2>
      <div class="panel-group category-products" id="accordian">
         <!--category-products-->
         @foreach($category as $key => $cate)
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title"><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
            </div>
         </div>
         @endforeach
      </div>
      <!--/category-products-->
      <div class="brands_products">
         <!--brands_products-->
         <h2>Thương hiệu sản phẩm</h2>
         <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
               @foreach($brand as $key => $brand)
               <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right"></span>{{$brand->brand_name}}</a></li>
               @endforeach
            </ul>
         </div>
      </div>
      <!--/brands_products-->
      <!-- <div class="price-range"> -->
      <!--price-range-->
      <!-- <h2>Price Range</h2>
         <div class="well text-center">
             <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
             <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
         </div>
         </div> -->
      <!--/price-range-->
      <!-- <div class="shipping text-center"> -->
      <!--shipping-->
      <!-- <img src="{{('public/frontend/images/home/shipping.jpg')}}" alt="" />
         </div> -->
      <!--/shipping-->
   </div>
</div>
<div class="col-sm-9 padding-right">
<div class="product-details">
   <!--product-details-->
   <div class="col-sm-5">
      <div class="view-product">
         <img src="{{URL::to('/public/upload/product/'.$detail->product_img)}}" alt=""/>
      </div>
   </div>
   <div class="col-sm-7">
      <div class="product-information">
        
         
             <!--/product-information-->
         <img src="{{URL::to('/public/frontend/images/product-details/new.jpg')}}" class="newarrival" alt="" />
         <h2>{{$detail->product_name}}</h2>
         <p><b>Mã ID:</b> {{$detail->product_id}} </p>
         <p><b>Số lượng còn trong kho:</b> {{$detail->product_quanty}} </p>
         <p><b>Điều kiện:</b> Mới</p>
         <p><b>Thương hiệu:</b> {{$detail->brand_name}}</p>
         <p><b>Danh mục:</b> {{$detail->category_name}}</p>
         <img src="{{URL::to('/public/frontend/mages/product-details/rating.png')}}" alt="" />
            <form action="{{URL::to('/save-cart')}}" method="POST">
                           @csrf
                           <input type="hidden" value="{{$detail->product_id}}" class="cart_product_id_{{$detail->product_id}}">
                           <input type="hidden" value="{{$detail->product_name}}" class="cart_product_name_{{$detail->product_id}}">
                           <input type="hidden" value="{{$detail->product_img}}" class="cart_product_img_{{$detail->product_id}}">
                           <input type="hidden" value="{{$detail->product_price}}" class="cart_product_price_{{$detail->product_id}}">
                           <input type="hidden" value="{{$detail->product_quanty}}" class="cart_product_quanty_{{$detail->product_id}}">            
                        <span>
                           <span>{{number_format($detail->product_price,0,',','.').'VNĐ'}}</span>
                        
                           <label>Số lượng:</label>
                           <input name="qty" type="number" min="1" class="cart_product_qty_{{$detail->product_id}}"  value="1" />
                           <input name="productid_hidden" type="hidden"  value="{{$detail->product_id}}" />
                        </span>
                        <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$detail->product_id}}" name="add-to-cart">
                        </form>            <!-- <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$detail->product_id}}" name="add-to-cart">Thêm giỏ hàng</button> -->
         
         <!-- <form action="{{URL::to('/save-cart')}}" method="post">
            <span>
            	{{csrf_field()}}
            	<span>{{number_format($detail->product_price).' '.'VND'}}</span>
            	<label>Số lượng:</label>
            	<input name="qty" type="number" min="1" value="1" />
            	<input name="productid_hidden" type="hidden" value="{{$detail->product_id}}" />
            	<button type="submit" class="btn btn-fefault cart">
            		<i class="fa fa-shopping-cart"></i>
            		Thêm vào giỏ hàng
            	</button>
            	<button type="submit" class="btn btn-fefault cart" data-id_product="{{$detail->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
            </span>
            </form> -->
         <!-- <a href=""><img src="{{URL::to('/public/frontend/images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a> -->
      </div>
      <!--/product-information-->
   </div>
</div>
<!--/product-details-->
<div class="category-tab shop-details-tab">
   <!--category-tab-->
   <div class="col-sm-12">
      <ul class="nav nav-tabs">
         <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
         <li><a href="#companyprofile" data-toggle="tab">Chi tiết</a></li>
         <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
      </ul>
   </div>
   <div class="tab-content">
      <div class="tab-pane fade active in" id="details" >
         <p>{!!$detail->product_des!!}</p>
      </div>
      <div class="tab-pane fade" id="companyprofile" >
         <p>{!!$detail->product_content!!}</p>
      </div>
      <div class="tab-pane fade" id="reviews" >
         <!-- <div class="col-sm-12">
            <ul>
            	<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
            	<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
            	<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <p><b>Write Your Review</b></p>
            
            <form action="#">
            	<span>
            		<input type="text" placeholder="Your Name"/>
            		<input type="email" placeholder="Email Address"/>
            	</span>
            	<textarea name="" ></textarea>
            	<b>Rating: </b> <img src="{{URL::to('/public/frontend/images/product-details/rating.png')}}" alt="" />
            	<button type="button" class="btn btn-default pull-right">
            		Submit
            	</button>
            </form>
            </div> -->
      </div>
   </div>
</div>
<!--/category-tab-->
@endforeach
<div class="recommended_items">
   <!--recommended_items-->
   <h2 class="title text-center">Sản phẩm liên quan</h2>
   <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
         <div class="item active">
            @foreach($relate as $key => $related)  
            <a href="{{URL::to('/chi-tiet-san-pham/'.$related->product_id)}}">
               <div class="col-sm-4">
                  <div class="product-image-wrapper">
                     <div class="single-products">
                        <div class="productinfo text-center">
                           <img src="{{URL::to('public/upload/product/'.$related->product_img)}}" alt="" width="50" height="260" />
                           <h2>{{number_format($related->product_price).' '.'VND'}}</h2>
                           <p>{{$related->product_name}}</p>
            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
            </div>
            </div>
            </div>
            </div>
            </a>
            @endforeach
         </div>
         
      </div>
      <!-- <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
      <i class="fa fa-angle-left"></i>
      </a>
      <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
      <i class="fa fa-angle-right"></i>
      </a> -->			
   </div>
</div>
<!--/recommended_items-->
</div>
</div>
</div>
</section>
@endsection