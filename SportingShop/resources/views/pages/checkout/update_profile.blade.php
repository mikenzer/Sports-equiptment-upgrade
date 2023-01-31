  @extends('layout')
  @section('content')
  <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h3 style="text-align:center;">Cập nhật thông tin của bạn</h3>
                        </header>
                        <div class="panel-body">
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo '<span class="text-success">'.$message.'</span>';
                                    Session::put('message',null);
                                }
                            ?>
                            @foreach($update_profile as $key => $edit_pf)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/edit-profile/'.$edit_pf->customer_id)}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ tên</label>
                                    <textarea style="resize: none" row="5" class="form-control" name="customer_name" id="exampleInputPassword1" >{{$edit_pf->customer_name}}</textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                     <textarea style="resize: none" row="5" class="form-control" name="customer_email" id="exampleInputPassword1" >{{$edit_pf->customer_email}}</textarea> 
                                </div> 
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số điện thoại</label>
                                    <textarea style="resize: none" row="5" class="form-control" name="customer_phone" id="exampleInputPassword1" >{{$edit_pf->customer_phone}}</textarea> 
                                </div>  
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Địa chỉ</label>
                                    <textarea style="resize: none" row="5" class="form-control" name="customer_address" id="exampleInputPassword1" >{{$edit_pf->customer_address}}</textarea> 
                                </div>                           
                                <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật</button>
                                <a class="btn btn-info" style="margin-left: 50px;" href="{{URL::to('/checkout/'.$edit_pf->customer_id)}}">Trờ lại</a>
                            </form>

                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
@endsection 