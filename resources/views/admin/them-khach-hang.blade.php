@extends('layout.master_ad')

@section('title', 'Thêm khách hàng | Quản trị viên')

@section('content')
    <style>
        .Choicefile {
            display: block;
            background: #14142B;
            border: 1px solid #fff;
            color: #fff;
            width: 150px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            padding: 5px 0px;
            border-radius: 5px;
            font-weight: 500;
            align-items: center;
            justify-content: center;
        }

        .Choicefile:hover {
            text-decoration: none;
            color: white;
        }

        #uploadfile,
        .removeimg {
            display: none;
        }

        #thumbbox {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .removeimg {
            height: 25px;
            position: absolute;
            background-repeat: no-repeat;
            top: 5px;
            left: 5px;
            background-size: 25px;
            width: 25px;
            border-radius: 50%;
        }

        .removeimg::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            content: '';
            border: 1px solid red;
            background: red;
            text-align: center;
            display: block;
            margin-top: 11px;
            transform: rotate(45deg);
        }

        .removeimg::after {
            content: '';
            background: red;
            border: 1px solid red;
            text-align: center;
            display: block;
            transform: rotate(-45deg);
            margin-top: -2px;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('quan-li-nhan-vien') }}">Danh sách khách hàng</a></li>
                <li class="breadcrumb-item"><a href="{{ route('them-khach-hang') }}">Thêm quản khách hàng</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới khách hàng</h3>
                    <div class="tile-body">
                        <form class="row" action="{{ route('xu-li-them-khach-hang') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-4">
                                <label class="control-label">Họ và tên</label>
                                <input class="form-control" name="hovaten" type="text" required placeholder="Họ và tên">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Email</label>
                                <input class="form-control" name="email" type="text" required placeholder="Email">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Mật khẩu</label>
                                <input class="form-control" name="password" type="password" required placeholder="Mật khẩu">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">Địa chỉ</label>
                                <input class="form-control" name="diachi" type="text" required placeholder="Địa chỉ">
                            </div>
                            <div class="form-group  col-md-3">
                                <label class="control-label">Số điện thoại</label>
                                <input class="form-control" name="sdt" type="number" required
                                    placeholder="Số điện thoại">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Giới tính</label>
                                <select class="form-control" name="gioitinh" required>
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Ngày sinh</label>
                                <input class="form-control" type="date" name="ngaysinh" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleSelect1" class="control-label">Chức vụ</label>
                                <select class="form-control" id="exampleSelect1" name="phanquyen">
                                    <option>-- Chọn chức vụ --</option>
                                    <option value="1">Quản trị viên</option> <!-- Sửa đổi giá trị thành 1 -->
                                    <option value="2">Khách hàng</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Lưu lại</button>
                                <a class="btn btn-cancel" href="#">Hủy bỏ</a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
    </main>


    <!--MODAL-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-md-12">
                            <span class="thong-tin-thanh-toan">
                                <h5>Tạo chức vụ mới</h5>
                            </span>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Nhập tên chức vụ mới</label>
                            <input class="form-control" type="text" required>
                        </div>
                    </div>
                    <BR>
                    <button class="btn btn-save" type="button">Lưu lại</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    <BR>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!--MODAL-->
@endsection
