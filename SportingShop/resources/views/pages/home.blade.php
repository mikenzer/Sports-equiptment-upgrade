 @extends('layout')
@section('content')
<section id="slider">
   <!--slider-->
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
              
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
               <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a>
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
                  <h2>Thương hiệu</h2>
                  <div class="brands-name">
                     <ul class="nav nav-pills nav-stacked">
                        @foreach($brand as $key => $brand)
                        <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> <span class="pull-right"></span>{{$brand->brand_name}}</a></li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               <!--/brands_products-->
               
            </div>
         </div>
         <div class="col-sm-9 padding-right">
            <div class="features_items">
               <!--features_items-->
               <h2 class="title text-center">Sản phẩm mới nhất</h2>
               @foreach($all_product as $key => $product)
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
                                 <h2>{{number_format($product->product_price).' '.'VNĐ'}}</h2>
                                 <p>{{$product->product_name}}</p>
                              </a>
                              <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
                           </form>
                        </div>
                     </div>
                     <!-- <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                           <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                           <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                        </ul>
                     </div> -->
                  </div>
               </div>
               @endforeach
            </div>
            
         </div>
      </div>
   </div>
</section>
<footer id="footer">
   <!--Footer-->
   <!--  <div class="footer-top">
      <div class="container">
          <div class="row">
              <div class="col-sm-2">
                  <div class="companyinfo">
                      <h2><span>e</span>-shopper</h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                  </div>
              </div>
              <div class="col-sm-7">
                  <div class="col-sm-3">
                      <div class="video-gallery text-center">
                          <a href="#">
                              <div class="iframe-img">
                                  <img src="{{('public/frontend/images/home/iframe1.png')}}" alt="" />
                              </div>
                              <div class="overlay-icon">
                                  <i class="fa fa-play-circle-o"></i>
                              </div>
                          </a>
                          <p>Circle of Hands</p>
                          <h2>24 DEC 2014</h2>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="video-gallery text-center">
                          <a href="#">
                              <div class="iframe-img">
                                  <img src="{{('public/frontend/images/home/iframe2.png')}}" alt="" />
                              </div>
                              <div class="overlay-icon">
                                  <i class="fa fa-play-circle-o"></i>
                              </div>
                          </a>
                          <p>Circle of Hands</p>
                          <h2>24 DEC 2014</h2>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="video-gallery text-center">
                          <a href="#">
                              <div class="iframe-img">
                                  <img src="{{('public/frontend/images/home/iframe3.png')}}" alt="" />
                              </div>
                              <div class="overlay-icon">
                                  <i class="fa fa-play-circle-o"></i>
                              </div>
                          </a>
                          <p>Circle of Hands</p>
                          <h2>24 DEC 2014</h2>
                      </div>
                  </div>
                  <div class="col-sm-3">
                      <div class="video-gallery text-center">
                          <a href="#">
                              <div class="iframe-img">
                                  <img src="{{('public/frontend/images/home/iframe4.png')}}" alt="" />
                              </div>
                              <div class="overlay-icon">
                                  <i class="fa fa-play-circle-o"></i>
                              </div>
                          </a>
                          <p>Circle of Hands</p>
                          <h2>24 DEC 2014</h2>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="address">
                      <img src="{{('public/frontend/images/home/map.png')}}" alt="" />
                      <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                  </div>
              </div>
          </div>
      </div>
      </div> -->
      <div class="footer-widget">
      <div class="container">
          <div class="row">
              <div class="col-sm-7">
                  <div class="single-widget">
                      <h2>Giới Thiệu</h2>
                      <p>Chuyên cung cấp các sản phẩm, thiết bị thể thao chính hãng, chất lượng</p>
                      <p>Công ty Cổ phần TN STORE với số đăng ký kinh doanh: 0105777650 </p>
                      <p>Địa chỉ đăng ký: 132/7 đường 3/2, phường Hưng Lợi, quận Ninh Kiều, thành phố Cần Thơ</p>
                      <p>Số điện thoại: 0379530595</p>
                      <p>Email: <a href="mailto:nhanb1809382@student.ctu.edu.vn">nhanb1809382@student.ctu.edu.vn</a></p>
                  </div>
              </div>
              <div class="col-sm-5">
                  <div class="single-widget">
                      <h2>Đối tác</h2>
                      
                           <img src="{{asset('public/frontend/images/logobrand/kingsport.png')}}" width="100px" />
                          <img src="{{asset('public/frontend/images/logobrand/nike.png')}}" width="100px" />
                          <img src="{{asset('public/frontend/images/logobrand/fornix.png')}}" width="100px" />
                          <img src="{{asset('public/frontend/images/logobrand/giant.png')}}" width="100px" />
                         
                      
                  </div>
              </div>
              
              
          </div>
      </div>
      </div>
      <div class="footer-bottom">
      <div class="container">
          <div class="row">
              <p class="pull-left">Copyright © 2022 TN STORE Inc. All rights reserved.</p>
          </div>
      </div>
      </div>

</footer>
<!--/Footer-->
@endsection