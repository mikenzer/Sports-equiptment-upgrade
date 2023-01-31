 @extends('admin_layout')
 @section('admin_content')
 <div class="container-fuid" >
    <style type="text/css">
        p.title_thongke{
            text-align: center;
            font-size:  20px;
            font-weight: bold;
            color: white;
        }
        p{
            color: white;
        }
    </style>
<div class="row">
<p class="title_thongke">Thống kê doanh số</p>
<form autocomplete="off">
    @csrf
    <div class="col-md-2">
    <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
    <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
    </div>
    <div class="col-md-2">
    <p>đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
    
    </div>
    <!-- <div class="col-md-2">
        <p>
            Lọc theo:
            <select class="dashboard-filter form-control">
                <option>--Chọn--</option>
                <option value="7ngay">7 ngày qua</option>
                <option value="7ngay">Tháng trước</option>
                <option value="7ngay">Tháng này</option>
                <option value="7ngay">365 ngày qua</option>
            </select>
        </p>
    </div> -->
    </form>
    <div class="col-md-12">
        <div id="mfirstchart" style="height:250px;"></div>
    </div>
<div class="row">
    
</div>
<div class="row">
    
</div>
</div>
 @endsection