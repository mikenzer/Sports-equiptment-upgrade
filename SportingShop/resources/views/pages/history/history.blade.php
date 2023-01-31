 @extends('layout')
@section('content')
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê đơn hàng
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
                    
                    <th>Thứ tự</th>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tình trạng đơn hàng</th> 
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 0;

                @endphp
                @foreach($order as $key => $od) 
                    @php
                    $i++
                    @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{ $od->order_code}}</td>
                    <td>{{ $od->order_created_at}}</td>
                    <td >
                        @if($od->order_status == 1)
                           <mark style="background-color:#fa8429;">Chờ xác nhận</mark>
                        @else
                           <mark>Đã xử lý</mark>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{URL::to('/view-history/'.$od->order_code)}}" class="active styling_edit" ui-toggle-class="">
                            Chi tiết
                        </a>
                        <!-- <a onclick="return confirm('Bạn chắc chắn muốn xóa không?')" href="{{URL::to('/delete-order/'.$od->order_code)}}" class="active styling_edit" ui-toggle-class="">
                            <i class="fa fa-times text-danger text"></i>
                        </a> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection