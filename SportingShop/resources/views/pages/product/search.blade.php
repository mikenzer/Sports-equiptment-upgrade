@extends('layout')
@section('content')
<section id="slider">
   <!--slider-->
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#slider-carousel" data-slide-to="1"></li>
                  <!-- <li data-target="#slider-carousel" data-slide-to="2"></li> -->
               </ol>
               <div class="carousel-inner"  >
                 @php
                  $i = 0 ;
                @endphp
                @foreach($slider as $key => $sl)
                  @php
                    $i++;
                  @endphp
                  <div class="item {{$i == 1 ? 'active' : ''}}" >
                     <div class="col-sm-12">
                        <img src="{{asset('public/upload/slider/'.$sl->slider_img)}}" width="100%" alt="{{$sl->slider_des}}"/>
                     </div>
                  </div>
                  <!-- <div class="item">
                     <img src="{{('public/frontend/images/home/banner3.JPG')}}" width="100%" alt="" />
                  </div> -->
                  <!-- <div class="item">                                   
                     <img src="{{('public/frontend/images/home/banner4.jpg')}}" width="100%" alt="" />
                  </div> -->
                  @endforeach
               </div>
            <!--    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a> -->
            </div>
         </div>
      </div>
   </div>
</section>
<!--/slider-->
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
<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Kết quả tìm kiếm</h2>
    @foreach($search_product as $key => $product)
        <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                        <form>
                            @csrf
                           <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                           <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                           <input type="hidden" value="{{$product->product_img}}" class="cart_product_img_{{$product->product_id}}">
                           <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                           <input type="hidden" value="{{$product->product_quanty}}" class="cart_product_quanty_{{$product->product_id}}">
                           <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                           <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                              <img src="{{URL::to('public/upload/product/'.$product->product_img)}}" alt="" />
                              <h2>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h2>
                              <p>{{$product->product_name}}</p>

                                             
                           </a>
                           <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                  </form>

                        </div>
                    </div>
                   <!--  <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào so sánh</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </a>
    @endforeach
</div>
 </div>
      </div>
   </div>
</section>
@endsection