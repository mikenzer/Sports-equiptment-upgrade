@extends('admin_layout')
@section('admin_content')
<div class="row">
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Thêm sản phẩm
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
                <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên sản phẩm</label>
                        <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" class="form-control" name="product_name" id="exampleInputEmail1" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Số lượng</label>
                        <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số lượng" name="product_quanty" class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá sản phẩm</label>
                        <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số tiền" name="product_price" class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                        <input type="file" name="product_img" class="form-control" id="exampleInputEmail1" enctype="multipart/form-data">
                    </div>
                    <div class="form-group"  data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" >
                        <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                        <textarea style="resize: none" row="5" class="form-control" name="product_des" placeholder="Mô tả sản phẩm"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chi tiết sản phẩm</label>
                        <textarea style="resize: none" row="8" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" class="form-control" name="product_content"  placeholder="Nội dung sản phẩm"></textarea> 
                    </div>    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Từ Khóa</label>
                        <textarea style="resize: none" row="8" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" class="form-control" name="product_keywords"placeholder="Từ khóa sản phẩm"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                        <select name="product_cate" class="form-control input-sm m-bot15">
                            @foreach($cate_product as $key => $cate)
                            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Thương hiệu</label>
                        <select name="product_brand" class="form-control input-sm m-bot15">
                            @foreach($brand_product as $key => $cate)
                            <option value="{{$cate->brand_id}}">{{$cate->brand_name}}</option>
                            @endforeach
                        </select>
                    </div>             
                    <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                        <select name="product_status" class="form-control input-sm m-bot15">
                            <option value="0">Ẩn</option>
                            <option value="1">Hiển thị</option>
                        </select>
                    </div>
                     <input type="hidden" name="product_sold" value="0" >
                    <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection