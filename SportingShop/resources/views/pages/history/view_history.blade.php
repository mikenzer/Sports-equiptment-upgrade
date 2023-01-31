@extends('layout')
@section('content')
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">
        Thông tin khách hàng
    </div>
    
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert1">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại </th>
                    <th>Email</th>
                    
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                   
                    <td>{{$customer->customer_name}}</td>
                    <td>{{$customer->customer_phone}}</td>
                    <td>{{$customer->customer_email}}</td>
                </tr>
               
            </tbody>
        </table>
    </div>
    
</div>
</div>
<br>
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">
        Thông tin vận chuyển
    </div>
    
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert1">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    
                    <!-- <th>Tên người vận chuyển</th> -->
                    <th>Địa chỉ giao hàng</th>
                    <th>Ghi chú</th>
                    <th>Hình thức thanh toán</th>
                    
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                   
                  
                    <td>{{$customer->customer_address}}</td>
                    <td>{{$shipping->shipping_note}}</td>
                    <td>
                        @if($shipping->shipping_method == 0)
                            Chuyển khoản
                        @else
                            Thanh toán sau khi nhận hàng
                        @endif
                    </td>
                </tr>
               
            </tbody>
        </table>
    </div>
    
</div>
</div>
<br><br>
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">
        Chi tiết đơn hàng
    </div>
    
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert1">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
        <table class="table table-striped b-t b-light">
            <thead>
                <tr><!-- 
                    <th style="width:20px;">
                        <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                        </label>
                    </th> -->
                    <th>Thứ tự</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng trong kho</th>
                    <!-- <th>Mã giảm giá</th> -->
                    <th>Số lượng</th>
                    <th>Giá</th>
                    
                    <th>Tổng tiền</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 0;
                $total = 0;

                @endphp

                @foreach($order_detail as $key => $detail)
                    @php
                    $i++;
                    $subtotal = $detail->product_price*$detail->product_quantity;
                    $total += $subtotal;
                    @endphp
                <tr  class="color_qty_{{$detail->product_id}}">
                    
                    <td>{{$i}}</td>
                    <td>{{$detail->product_name}}</td>
                    <td>{{$detail->product->product_qty}}</td>                
                    <td colspan="1">
                        <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$detail->product_id}}" value="{{$detail->product_quantity}}" name="product_quantity">
                        <input type="hidden" name="order_product_id" class="order_product_id" value="{{$detail->product_id}}">
                        <input type="hidden" name="order_code" class="order_code" value="{{$detail->order_code}}">
                        <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$detail->product_id}}" value="{{$detail->product->product_qty}}">
                        <!-- @if($order_status != 2)
                        <button class="btn btn-default update_qty_order" data-product_id="{{$detail->product_id}}" name="update_qty_order">Cập nhật</button>
                        @endif -->
                    </td>
                    <td>{{number_format($detail->product_price,0,',','.')}} VND</td>

                    <td>{{number_format($detail->product_price*$detail->product_quantity,0,',','.')}} VND</td>
                </tr>
               @endforeach
               <tr>
                <td colspan="2">
                    Tổng:
                    {{number_format($total,0,',','.')}} VND <br>
                    Phí vận chuyển:
                    {{number_format($detail->product_feeship,0,',','.')}} VND <br>
                    @php
                    $total_coupon = 0;
                    $total_after_coupon = 0;
                    @endphp

                    Mã giảm giá: 
                    @if($detail->product_coupon != 'Không có mã giảm giá')
                        {{$detail->product_coupon}}<br>
                        @else
                        Không có!<br>
                    @endif

                    @if($coupon_condition == 1)
                        @php
                        $total_coupon = ($total*$coupon_number)/100;
                        $total_after_coupon = $total - $total_coupon;
                        @endphp
                        Giảm:
                        {{$coupon_number}} %<br>
                        Thanh toán: 
                        <b>{{number_format($total_after_coupon+$detail->product_feeship,0,',','.')}} VND</b>
                    @else($coupon_condition == 2)
                        @php
                        
                        $total_after_coupon = $total - $coupon_number;
                        @endphp
                        @if($coupon_number != 0)
                        Giảm:
                        {{number_format($coupon_number,0,',','.')}} VND<br>
                        Thanh toán: 
                        <b>{{number_format($total_after_coupon+$detail->product_feeship,0,',','.')}} VND</b>
                        @else
                        Thanh toán: 
                        <b>{{number_format($total+$detail->product_feeship,0,',','.')}} VND</b>
                        @endif
                    @endif
                      
                </td>
                <td>
                   <a  href="{{URL::to('/history')}}" ><button class="btn btn-primary btn-sm"> Trở lại</button> </a>
                </td>
            </tr>
          
            </tbody>
        </table>
        <!-- <a href="{{url('/print-order')}}">In đơn hàng</a> -->
    </div>
   
</div>
</div>
@endsection