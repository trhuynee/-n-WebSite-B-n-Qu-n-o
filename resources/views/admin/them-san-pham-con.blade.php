@extends('layout.master_ad')

@section('title', 'Thêm sản phẩm con | Quản trị viên')

@section('content')
    <style>
        .text-align-center th,
        td {
            text-align: center;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/quan-li-san-pham') }}">Danh sách sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/them-san-pham-con', ['id' => $product->id]) }}">Thêm sản phẩm
                        con</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h4 class="tile-title">Màu sắc - Kích thước</h4>
                    <div class="tile-body">
                        <form class="row" action="{{ route('xu-li-them-con', ['id' => $product->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-3">
                                <label class="control-label">Tên sản phẩm</label>
                                <input type="text" name="tensanpham" class="form-control"
                                    value="{{ $product->tensanpham }}" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Số lượng hiện có</label>
                                <input type="text" class="form-control" value="{{ $product->soluong }}" readonly>
                            </div>
                            <div class="form-group col-md-3">

                            </div>
                            <div class="form-group col-md-3">

                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState" class="control-label">Màu sắc</label>
                                <select id="inputState" name="mau" class="form-control">
                                    <option value="">-- Chọn màu sắc --</option>
                                    @foreach ($colors as $item)
                                        <option value="{{ $item->id }}">{{ $item->tenmau }}</option>
                                    @endforeach
                                </select>
                                @error('mau')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState" class="control-label">Kích thước</label>
                                <select id="inputState" name="size" class="form-control">
                                    <option value="">-- Chọn kích thước --</option>
                                    @foreach ($sizes as $item)
                                        <option value="{{ $item->id }}">{{ $item->tensize }}</option>
                                    @endforeach
                                </select>
                                @error('size')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Số lượng</label>
                                <input type="number" name="soluong" class="form-control" placeholder="Số lượng">
                                @error('soluong')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Lưu lại</button>
                                <a class="btn btn-cancel" href="{{ url('/quan-li-san-pham') }}">Hủy bỏ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h4 class="tile-title">Danh sách màu sắc - kích thước tồn kho</h4>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>
                                    <th>STT</th>
                                    <th>Màu sắc</th>
                                    <th>Kích thước</th>
                                    <th>Số lượng tồn kho</th>
                                    <th>Tình trạng</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($subProducts as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- STT -->
                                        <td>{{ $item->color->tenmau }}</td>
                                        <td>{{ $item->size->tensize ?? 'N/A' }}</td>
                                        <td>{{ $item->soluong }}</td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Còn hàng
                                            @else
                                                Hết hàng
                                            @endif
                                        </td>
                                        <td>
                                            <form id="deleteForm-{{ $item->id }}"
                                                action="{{ route('delete_child', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
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
                                                                    <button id="confirmDeleteBtn-{{ $item->id }}"
                                                                        class="btn btn-primary mr-2">Xác
                                                                        nhận</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Hủy
                                                                        bỏ</button>
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
                        <h6>Tổng số lượng tồn kho: {{ $total }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     var soluongInput = document.querySelector('input[name="soluong"]');
        //     var remainingQuantity = {{ $remainingQuantity }};
        //     var errorSpan = document.createElement('span');
        //     errorSpan.className = 'text-danger';
        //     soluongInput.parentNode.appendChild(errorSpan);

        //     soluongInput.addEventListener('input', function() {
        //         var inputValue = parseInt(this.value);
        //         if (inputValue > remainingQuantity) {
        //             errorSpan.textContent = 'Số lượng không được vượt quá ' + remainingQuantity;
        //             this.value = remainingQuantity;
        //         } else if (inputValue < 1) {
        //             errorSpan.textContent = 'Số lượng phải lớn hơn 0';
        //         } else {
        //             errorSpan.textContent = '';
        //         }
        //     });
        // });
    </script>
@endsection
