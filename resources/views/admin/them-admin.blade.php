@extends('layout.master_ad')

@section('title', 'Thêm quản trị viên | Quản trị viên')

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
                <li class="breadcrumb-item"><a href="{{ route('quan-li-nhan-vien') }}">Danh sách quản trị viên</a></li>
                <li class="breadcrumb-item"><a href="{{ route('them-admin') }}">Thêm quản trị viên</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới quản trị viên</h3>
                    <div class="tile-body"> 
                        <form class="row" action="{{ route('xu-li-them-admin') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-6">
                                <label class="control-label">Họ và tên</label>
                                <input class="form-control" name="hovaten" type="text" required placeholder="Họ và tên"
                                    maxlength="50">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Email</label>
                                <input class="form-control" name="email" type="email" required placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Mật khẩu</label>
                                <input class="form-control" name="password" type="password" required placeholder="Mật khẩu"
                                    minlength="6">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Địa chỉ</label>
                                <input class="form-control" name="diachi" type="text" required placeholder="Địa chỉ">
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="control-label">Số điện thoại</label>
                                <input class="form-control" name="sdt" type="tel" required
                                    placeholder="Số điện thoại" pattern="[0-9]{10}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Giới tính</label>
                                <select class="form-control" name="gioitinh" required>
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Ngày sinh</label>
                                <input class="form-control" type="date" name="ngaysinh" required
                                    max="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleSelect1" class="control-label">Chức vụ</label>
                                <select class="form-control" id="exampleSelect1" name="phanquyen" required>
                                    <option value="">-- Chọn chức vụ --</option>
                                    <option value="1">Quản trị viên</option> <!-- Sửa đổi giá trị thành 1 -->
                                    <option value="2">Khách hàng</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Lưu lại</button>
                                <a class="btn btn-cancel" href="{{ route('quan-li-nhan-vien') }}">Hủy bỏ</a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
    </main>

@endsection
