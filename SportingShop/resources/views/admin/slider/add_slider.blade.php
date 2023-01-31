@extends('admin_layout')
@section('admin_content')
<div class="row">
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Thêm slider
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
                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}              
                    <div class="form-group">
                        <label for="exampleInputEmail1" required="">Tên slider</label>
                        <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1" placeholder="Tên slider" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hình ảnh</label>
                        <input type="file" name="slider_img" class="form-control" id="exampleInputEmail1" enctype="multipart/form-data" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả</label>
                        <textarea style="resize: none" row="5" class="form-control" name="slider_des" id="exampleInputPassword1" placeholder="Mô tả slider" required></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Trạng thái</label>
                        <select name="slider_status" class="form-control input-sm m-bot15">
                            <option value="0">Ẩn</option>
                            <option value="1">Hiển thị</option>
                        </select>
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-info">Thêm slider</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection