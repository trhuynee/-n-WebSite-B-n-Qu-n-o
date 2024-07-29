@extends('layout.master_ad')

@section('title', 'Chỉnh sửa nhãn hiệu | Quản trị viên')

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
            <li class="breadcrumb-item"><a href="{{ url('/danh-sach-chung') }}">Danh sách {{ $type }}</a></li>
            <li class="breadcrumb-item">Chỉnh sửa {{ $type }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa {{ $type }}</h3>
                <div class="tile-body">
                    <form class="row" action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-3">
                            <label class="control-label">Tên {{ $type }}</label>
                            <input type="text" name="{{ $nameField }}" class="form-control"
                                   value="{{ $item->$nameField }}" placeholder="Tên {{ $type }}">
                            <div class="error-message">{{ $errors->first($nameField) }}</div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="exampleSelect1" class="control-label">Tình trạng</label>
                            <select id="inputState" name="trangthai" class="form-control">
                                <option>-- Chọn tình trạng --</option>
                                <option value="0" @if ($item->trangthai == 0) selected @endif>Còn hàng</option>
                                <option value="1" @if ($item->trangthai == 1) selected @endif>Hết hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button class="btn btn-save" type="submit">Cập nhật</button>
                            <a class="btn btn-cancel" href="{{ url('/quan-li-san-pham') }}">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
