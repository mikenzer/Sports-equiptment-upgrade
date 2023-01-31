@extends('admin_layout')
@section('admin_content')
<div class="row">
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Thêm mã giảm giá
        </header>
        <div class="panel-body">
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert1">'.$message.'</span>';
                    Session::put('message',null);
                }
                ?>
            <div class="position-center">
                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên mã giảm giá</label>
                        <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mã giảm giá</label>
                        <textarea style="resize: none" row="5" class="form-control" name="coupon_code" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số lượng</label>
                        <textarea style="resize: none" row="5" class="form-control" name="coupon_time" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Tính năng</label>
                        <select name="coupon_condition" class="form-control input-sm m-bot15">
                            <option value="0">-----Chọn-----</option>
                            <option value="1">Giảm theo phần trăm</option>
                            <option value="2">Giảm theo tiền</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số phần trăm hoặc số tiền giảm</label>
                        <input type="text" name="coupon_number" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                    </div>                  
                    <button type="submit" name="add_category_product" class="btn btn-info">Thêm mã giảm giá</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection