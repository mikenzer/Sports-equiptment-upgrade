 <!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!----Seo--->
      <meta name="description" content="{{$meta_des}}">
      <meta name="keywords" content="{{$meta_keywords}}">
      <meta name="robots" content="INDEX/FOLLOW">
      <link rel="canonical" href="{{$url_canonical}}">
      <meta name="author" content="">
      <link rel="canonical" tyoe="img/x-icon" href="">
      <meta property="og:site_name" content="http://localhost/SportingShop" />
      <meta property="og:description" content="{{$meta_des}}" />
      <meta property="og:title" content="{{$meta_title}}" />
      <meta property="og:url" content="{{$url_canonical}}" />
      <meta property="og:type" content="website" />
      <!----EndSeo--->
      <title>{{$meta_title}}</title>
      <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
      <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
      <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->       
      <link rel="shortcut icon" href="{{('public/frontend/images/ico/favicon.ico')}}">
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
   </head>
   <!--/head-->
   <body>
      <header id="header">
         <!--header-->
         <!-- <div class="header_top"> -->
         <!--header_top-->
         <!-- div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            </div> -->
         <!--/header_top-->
         <div class="header-middle">
            <!--header-middle-->
            <div class="container">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="">
                        <a ><img src="{{asset('public/frontend/images/home/TTN-Sport.png')}}" alt="" height="100" width="100" /></a>
                     </div>
                     <!-- <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            USA
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            DOLLAR
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                        </div> -->
                  </div>
                  <div class="col-sm-8">
                     <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                           <li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
                           <?php
                              $customer_id = Session::get('customer_id');
                              if($customer_id != NULL){
                              ?>
                           <li><a href="{{URL::to('/history')}}"><i class="fa fa-truck"></i> Lịch sử mua hàng</a></li>
                           <?php
                              }
                              ?>
                           
                           <?php
                              $customer_id = Session::get('address');
                              if($customer_id != NULL){
                              ?>
                           <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                           <?php
                              }else{
                              ?>
                           <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                           <?php
                              }
                              ?>
                           <li><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                           <?php
                              $customer_id = Session::get('customer_id');
                              if($customer_id != NULL){
                               // $name = Session::get('customer_name');
                              ?>
                              <li class="dropdown">
                              <a href="#">
                                Xin chào 
                                <?php
                                $name = Session::get('customer_name');
                                if($name){
                                  echo  $name;
                               
                                }
                               
                                ?>
                                <i class="fa fa-angle-down"></i>
                            </a>
                              <ul role="menu" class="sub-menu">
                                    <li ><a href="{{URL::to('/profile-user/'.$customer_id)}}"><i class="fa fa-lock"></i> Hồ sơ</a></li><br>
                                    <li ><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
                                    
                              </ul>
                            </li>
                           <!-- <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li> -->
                           <?php
                              }else{
                              ?>
                           <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                           <?php
                              }
                              ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--/header-middle-->
         <div class="header-bottom">
            <!--header-bottom-->
            <div class="container">
               <div class="row">
                  <div class="col-sm-8">
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                     </div>
                     <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                           <li><a href="{{URL::to('/trang-chu')}}" class="active">Trang Chủ</a></li>
                           <li class="dropdown">
                              <a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                              <ul role="menu" class="sub-menu">
                                    @foreach($category as $key => $danhmuc)
                                    <li><a href="{{URL::to('/danh-muc-san-pham/'.$danhmuc->category_id)}}">{{$danhmuc->category_name}}</a></li>
                                    @endforeach
                              </ul>
                           </li>
                           <li class="dropdown">
                              <a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                           </li>
                           <!-- <li><a href="{{URL::to('/show-cart')}}">Giỏ hàng</a></li> -->
                           <!-- <li><a href="contact-us.html">Liên hệ</a></li> -->
                        </ul>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <form action="{{URL::to('/tim-kiem')}}" method="post">
                        {{csrf_field()}}
                        <div class="search_box pull-right">
                           <input type="text" name="keyword_search" placeholder="Tìm kiếm sản phẩm"/>
                           <input type="submit" style="margin-top: 0px; color: black" name="search_item" class="btn btn-primary btn-sm" value="Tìm kiếm"/>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!--/header-bottom-->
      </header>
      <!--/header-->
      
      @yield('content')

      <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
      <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
      <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
      <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
      <script src="{{asset('public/frontend/js/main.js')}}"></script>
      <div id="fb-root"></div>
      <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v13.0" nonce="5NoWSueg"></script>
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>      
      <script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
      <!-- Thêm giỏ hàng -->
      <script type="text/javascript">
         $(document).ready(function(){
             $('.add-to-cart').click(function(){
                 //swal("Good job!", "You clicked the button!", "success");
                 var id = $(this).data('id_product');
                 var cart_product_id = $('.cart_product_id_' + id).val();
                 var cart_product_name = $('.cart_product_name_' + id).val();
                 var cart_product_img = $('.cart_product_img_' + id).val();
                 var cart_product_price = $('.cart_product_price_' + id).val();
                 var cart_product_quanty = $('.cart_product_quanty_' + id).val();
                 var cart_product_qty = $('.cart_product_qty_' + id).val();
                 var _token = $('input[name="_token"]').val();

                 if(parseInt(cart_product_qty) > parseInt(cart_product_quanty)){
                    alert('Kho chỉ còn '+cart_product_quanty+' sản phẩm');
                 }else{

                 
                 $.ajax({
                     url: '{{url('/add-cart-ajax')}}',
                     method: 'POST',
                     data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_img:cart_product_img,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quanty:cart_product_quanty},
                     success:function(data){
                         //alert('cart_product_id');
         
                         swal({
                                 title: "Đã thêm sản phẩm vào giỏ hàng",
                                 text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                 showCancelButton: true,
                                 cancelButtonText: "Xem tiếp",
                                 confirmButtonClass: "btn-success",
                                 confirmButtonText: "Đi đến giỏ hàng",
                                 closeOnConfirm: false
                             },
                             function() {
                                 window.location.href = "{{url('/gio-hang')}}";
                             });
         
                     }
         
                 });
                }
             });
         });
      </script>
      <!-- //Chọn thành phố -->
      <script type="text/javascript">
         $(document).ready(function(){
             $('.choose').on('change',function(){
                 var action = $(this).attr('id');
                 var ma_id = $(this).val();
                 var _token = $('input[name="_token"]').val();
                 var result = '';
                 // alert(action);
                 // alert(matp);
                 // alert(_token);
                 if(action=='city'){
                     result = 'province';
                 }else{
                     result = 'wards';
                 }
                 $.ajax({
                     url: '{{url('/select-delivery-home')}}',
                     method: 'POST',
                     data:{action:action,ma_id:ma_id,_token:_token},
                     success:function(data){
                         $('#'+result).html(data);
                     }
                 });
             });
         });
      </script>
      <!--Button tính phí vận chuyển  -->
      <script type="text/javascript">
         $(document).ready(function(){
             $('.calculate_delivery').click(function(){
                 // var action = $(this).attr('id');
                 var city = $('.city').val();
                 var province = $('.province').val();
                 var wards = $('.wards').val();
                 var _token = $('input[name="_token"]').val();
                 // var result = '';
                 // if(action=='city'){
                 //     result = 'province';
                 // }else{
                 //     result = 'wards';
                 // }
                 if(city == '' || province == '' || wards == ''){
                     alert('Làm ơn chọn đủ thông tin');
                 }else{
                     $.ajax({
                     url: '{{url('/calculate-fee')}}',
                     method: 'POST',
                     data:{city:city,province:province,wards:wards,_token:_token},
                     success:function(){
                         location.reload();
                     }
                     });
                 }
                 
             });
         });   
      </script>
      <!-- Thanh toán -->
      <script type="text/javascript">
         $(document).ready(function(){
             $('.send_order').click(function(){
                 swal({
                   title: "Xác nhận đơn hàng",
                   text: "Bạn chắc chắn đặt hàng chứ?",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonClass: "btn-success",
                   confirmButtonText: "Xác nhận",
                   cancelButtonText: "Quay lại",
                   closeOnConfirm: false,
                   closeOnCancel: false
                 },
                 function(isConFirm){
                     if(isConFirm){
                         // var shipping_email = $('.shipping_email').val();
                         // var shipping_name = $('.shipping_name').val();
                         //var shipping_address = $('.shipping_address').val();
                         // var shipping_phone = $('.shipping_phone').val();
                         var shipping_note = $('.shipping_note').val();
                         var shipping_method = $('.payment_select').val();
                         var order_fee = $('.order_fee').val();
                         var order_coupon = $('.order_coupon').val();
                         var _token = $('input[name="_token"]').val();
                         $.ajax({
                             url: '{{url('/confirm-order')}}',
                             method: 'POST',
                             data:{shipping_note:shipping_note,order_fee:order_fee,order_coupon:order_coupon,_token:_token,shipping_method:shipping_method},
                             success:function(){
                                 swal(" ", "Đơn hàng của bạn đã được gửi thành công.", "success");
         
                             }
         
                         });
                         window.setTimeout(function(){
                             location.reload();
                         } ,3000);
                         
                     }else{
                         swal(" ", "Đơn hàng của bạn chưa được gửi.", "error");
                     }
                   
                 });
                 
             });
         });
      </script>
   </body>
</html>