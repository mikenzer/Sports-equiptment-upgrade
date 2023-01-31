@extends('layout')
@section('content')
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 style="text-align:center;">Thông tin của bạn</h3>
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
                    
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th> 
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
               
                <tr>
                    @foreach($profile as $key => $pf) 
                   <td>{{ $pf->customer_name}}</td>
                    <td>{{ $pf->customer_email}}</td>
                    <td > {{ $pf->customer_phone}}</td>
                    <td>{{ $pf->customer_address}}</td>
                   @endforeach
                </tr>
                
            </tbody>
        </table>

    </div>

</div>
<a class="btn btn-default update_info" style="margin-left: 650px;"  href="{{URL::to('/update-profile/'.$pf->customer_id)}}">Thay đổi thông tin</a><br>
</div>

@endsection