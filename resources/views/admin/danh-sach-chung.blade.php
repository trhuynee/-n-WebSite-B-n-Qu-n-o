@extends('layout.master_ad')

@section('title', 'Danh sách nhãn hiệu | Quản trị viên')

@section('content')
    <style>
        .text-align-center th,
        td {
            text-align: center;
        }

        .tfoot-left td {
            text-align: left;
            font-weight: bold;
        }
    </style>
    <main class="app-content">
        <div class="row element-button">
            <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter1" title="Thêm"><i
                        class="fas fa-plus"></i>
                    Thêm mới nhãn hiệu</a>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter2" title="Thêm"><i
                        class="fas fa-plus"></i>
                    Thêm mới kích thước</a>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter3" title="Thêm"><i
                        class="fas fa-plus"></i>
                    Thêm mới màu sắc</a>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter4" title="Thêm"><i
                        class="fas fa-plus"></i>
                    Thêm mới loại sản phẩm</a>
            </div>
        </div>

        {{-- Danh sách nhãn hiệu --}}
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ url('/danh-sach-chung') }}"><b>Danh sách nhãn hiệu</b></a>
                </li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>
                                    {{-- <th>STT</th> --}}
                                    <th>Tên nhãn hiệu</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($brand as $index => $item)
                                    <tr>
                                        {{-- <td>{{ $index + 1 }}</td> <!-- STT --> --}}
                                        <td>{{ $item->tennhanhieu }}</td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Còn hàng
                                            @else
                                                Hết hàng
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <form id="deleteForm-{{ $item->id }}"
                                                action="{{ url('/xoa-nhan-hieu', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <a href="{{ url('/chinh-sua-nhan-hieu', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm edit" type="button" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                                    data-toggle="modal"
                                                    data-target="#confirmDeleteModal-{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                    data-backdrop="static" data-keyboard="false">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <h4 class="modal-title mt-4 mb-3">Cảnh báo</h4>
                                                                <h5 class="control-label">Bạn có chắc muốn xóa không?</h5>
                                                                <div class="form-group mt-4">
                                                                    <button class="btn btn-primary mr-2"
                                                                        onclick="submitDeleteForm({{ $item->id }})">Xóa</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy bỏ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="tile-footer">
                        <h6>Tổng cộng: {{ $brand->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>



        {{-- Danh sách kích thước --}}
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ url('/danh-sach-chung') }}"><b>Danh sách kích
                            thước</b></a>
                </li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên kích thước</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($size as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- STT -->
                                        <td>{{ $item->tensize }}</td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Còn hàng
                                            @else
                                                Hết hàng
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>

                                        <td>
                                            <form id="deleteForm"
                                                action="{{ url('/xoa-kich-thuoc', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/chinh-sua-kich-thuoc', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm edit" type="button" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                                    data-toggle="modal"
                                                    data-target="#confirmDeleteModal-{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" data-backdrop="static"
                                                    data-keyboard="false">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <h4 class="modal-title mt-4 mb-3">Cảnh báo</h4>
                                                                <h5 class="control-label">Bạn có chắc muốn xóa không?</h5>
                                                                <div class="form-group mt-4">
                                                                    <button class="btn btn-primary mr-2"
                                                                        onclick="submitDeleteForm({{ $item->id }})">Xóa</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy bỏ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-footer">
                        <h6>Tổng cộng: {{ $size->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách màu sắc --}}
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ url('/danh-sach-chung') }}"><b>Danh sách màu sắc</b></a>
                </li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên màu sắc</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($color as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- STT -->
                                        <td>{{ $item->tenmau }}</td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Còn hàng
                                            @else
                                                Hết hàng
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>

                                        <td>
                                            <form id="deleteForm" action="{{ url('/xoa-mau-sac', ['id' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/chinh-sua-mau-sac', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm edit" type="button" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-primary btn-sm trash" type="button"
                                                    title="Xóa" data-toggle="modal"
                                                    data-target="#confirmDeleteModal-{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" data-backdrop="static"
                                                    data-keyboard="false">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <h4 class="modal-title mt-4 mb-3">Cảnh báo</h4>
                                                                <h5 class="control-label">Bạn có chắc muốn xóa không?</h5>
                                                                <div class="form-group mt-4">
                                                                    <button class="btn btn-primary mr-2"
                                                                        onclick="submitDeleteForm({{ $item->id }})">Xóa</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy bỏ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-footer">
                        <h6>Tổng cộng: {{ $color->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
        {{-- Danh sách loại sản phẩm --}}
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ url('/danh-sach-chung') }}"><b>Danh sách loại sản
                            phẩm</b></a>
                </li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên loại sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($category as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- STT -->
                                        <td>{{ $item->tenloaisp }}</td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Còn hàng
                                            @else
                                                Hết hàng
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <form id="deleteForm-{{ $item->id }}"
                                                action="{{ url('/xoa-loai', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/chinh-sua-loai', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm edit" type="button" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button class="btn btn-primary btn-sm trash" type="button"
                                                    title="Xóa" data-toggle="modal"
                                                    data-target="#confirmDeleteModal-{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" data-backdrop="static"
                                                    data-keyboard="false">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <h4 class="modal-title mt-4 mb-3">Cảnh báo</h4>
                                                                <h5 class="control-label">Bạn có chắc muốn xóa không?</h5>
                                                                <div class="form-group mt-4">
                                                                    <button class="btn btn-primary mr-2"
                                                                        onclick="submitDeleteForm({{ $item->id }})">Xóa</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy bỏ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tile-footer">
                        <h6>Tổng cộng: {{ $category->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL thêm nhãn hiệu -->
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <h5 class="modal-title text-center mt-4 mb-4">Tạo nhãn hiệu mới</h5>
                            <form class="row" action="{{ route('them-nhan-hieu') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label class="control-label">Nhập tên nhãn hiệu mới</label>
                                        <input class="form-control" type="text" name="tennhanhieu"
                                            placeholder="Tên nhãn hiệu">
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                        <select id="inputState" name="trangthai" class="form-control">
                                            <option>-- Chọn tình trạng --</option>
                                            <option value="0">Còn hàng</option>
                                            <option value="1">Hết hàng</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 text-center">
                                        <button class="btn btn-save mr-2" type="submit">Lưu lại</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy
                                            bỏ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL -->

        <!--MODAL thêm kích thước-->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="form-group  col-md-12">
                            <span class="thong-tin-thanh-toan">
                                <h5>Tạo kích thước mới</h5>
                            </span>

                            <form class="row" action="{{ route('them-kich-thuoc') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label">Nhập tên kích thước mới</label>
                                        <input class="form-control" type="text" name="tensize"
                                            placeholder="Tên kích thước">
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                        <select id="inputState" name="trangthai" class="form-control">
                                            <option>-- Chọn tình trạng --</option>
                                            <option value="0">Còn hàng</option>
                                            <option value="1">Hết hàng</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-save" type="submit">Lưu lại</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy
                                            bỏ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL-->

        <!--MODAL thêm màu sắc-->
        <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="form-group  col-md-12">
                            <span class="thong-tin-thanh-toan">
                                <h5>Tạo màu mới</h5>
                            </span>

                            <form class="row" action="{{ route('them-mau-sac') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label">Nhập tên màu mới</label>
                                        <input class="form-control" type="text" name="tenmau" placeholder="Tên màu">
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                        <select id="inputState" name="trangthai" class="form-control">
                                            <option>-- Chọn tình trạng --</option>
                                            <option value="0">Còn hàng</option>
                                            <option value="1">Hết hàng</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-save" type="submit">Lưu lại</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy
                                            bỏ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL-->

        <!--MODAL thêm loại-->
        <div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group  col-md-12">
                            <span class="thong-tin-thanh-toan">
                                <h5>Tạo loại sản phẩm mới</h5>
                            </span>
                            <form class="row" action="{{ route('them-loai') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label">Nhập tên loại sản phẩm mới</label>
                                        <input class="form-control" type="text" name="tenloaisp"
                                            placeholder="Tên loại sản phẩm">
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                        <select id="inputState" name="trangthai" class="form-control">
                                            <option>-- Chọn tình trạng --</option>
                                            <option value="0">Còn hàng</option>
                                            <option value="1">Hết hàng</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button class="btn btn-save" type="submit">Lưu lại</button>
                                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy
                                            bỏ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL-->

        <!-- Modal xóa ngay-->
        {{-- <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h4 class="modal-title mt-4 mb-3">Cảnh báo</h4>
                        <h5 class="control-label">Bạn có chắc muốn xóa không?</h5>
                        <div class="form-group mt-4">
                            <button id="confirmDeleteBtn-{{ $item->id }}" class="btn btn-primary mr-2">Xác
                                nhận</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('confirmDeleteBtn-{{ $item->id }}').addEventListener('click', function() {
                document.getElementById('deleteForm-{{ $item->id }}').submit();
            });
        </script> --}}

        {{-- <script>
            function submitDeleteForm(itemId) {
                document.getElementById('deleteForm-' + itemId).submit();
            }
        </script> --}}
    </main>
@endsection
