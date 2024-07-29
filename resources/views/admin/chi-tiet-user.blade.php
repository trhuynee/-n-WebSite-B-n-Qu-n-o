@extends('layout.master_ad')

@section('title', 'Thông tin khách hàng | Quản trị viên')

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
                <li class="breadcrumb-item"><a href="{{ route('quan-li-khach-hang') }}">Danh sách khách hàng</a></li>
                <li class="breadcrumb-item"><a href="{{ route('chi-tiet-user', ['id' => $user->id]) }}">Thông tin khách
                        hàng</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form class="row" action="{{ route('chi-tiet-user', ['id' => $user->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-6">
                                <label class="control-label">Họ và tên</label>
                                <input class="form-control" name="hovaten" type="text" required
                                    value="{{ $user->hovaten }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Email</label>
                                <input class="form-control" name="email" type="text" required
                                    value="{{ $user->email }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Địa chỉ</label>
                                <input class="form-control" name="diachi" type="text" required
                                    value="{{ $user->diachi }}">
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="control-label">Số điện thoại</label>
                                <input class="form-control" name="sdt" type="number" required
                                    value="{{ $user->sdt }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Giới tính</label>
                                <select class="form-control" name="gioitinh" required>
                                    <option value="Nam" {{ $user->gioitinh == 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ $user->gioitinh == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Ngày sinh</label>
                                <input class="form-control" type="date" name="ngaysinh" required
                                    value="{{ $user->ngaysinh }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleSelect1" class="control-label">Chức vụ</label>
                                <select class="form-control" id="exampleSelect1" name="phanquyen">
                                    <option value="1" {{ $user->phanquyen == 1 ? 'selected' : '' }}>Quản trị viên
                                    </option>
                                    <option value="2" {{ $user->phanquyen == 2 ? 'selected' : '' }}>Khách hàng
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                {{-- <button class="btn btn-save" type="submit">Lưu lại</button> --}}
                                <a class="btn btn-cancel" href="{{ url('/quan-li-khach-hang') }}">Hủy bỏ</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
