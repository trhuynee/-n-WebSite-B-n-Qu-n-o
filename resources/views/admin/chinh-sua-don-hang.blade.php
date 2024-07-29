@extends('layout.master_ad')

@section('title', 'Sửa đơn hàng | Quản trị viên')

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
            /* border: 3px solid red; */
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
            /* color: #FFF; */
            /* background-color: #DC403B; */
            content: '';
            background: red;
            border: 1px solid red;
            text-align: center;
            display: block;
            transform: rotate(-45deg);
            margin-top: -2px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .table-detail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-detail th,
        .table-detail td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-detail th {
            background-color: #f2f2f2;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('/get-order-details/{id}') }}"><b>Chỉnh sửa đơn
                            hàng</b></a></li>
            </ul>
        </div>
        <div class="col-sm-2">
            <a id="exportPdfBtn" class="btn btn-delete btn-sm pdf-file" href="#" title="In"><i
                    class="fas fa-file-pdf"></i> Xuất PDF</a>
        </div>
        <div class="row">
            <!-- Cột bên trái -->
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Thông tin đơn hàng</h3>
                    <div class="tile-body">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Mã đơn hàng</label>
                                <input id="orderInput" class="form-control" type="text" name="madonhang"
                                    data-order-id="{{ $order[0]->ma_hd }}" value="{{ $order[0]->ma_hd }}" readonly>
                            </div>
                            <pre id="order-details"></pre>
                            <div class="form-group">
                                <label class="control-label">Ngày đặt hàng</label>
                                <input class="form-control" type="text" name="ngaydathang"
                                    value="{{ $order[0]->created_at }}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Trạng thái đơn hàng</label>
                                <input class="form-control" type="text" name="ngaydathang"
                                    value="{{ $order[0]->order[0]->orderstatus->value }}" readonly>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
            <!-- Cột bên phải -->
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Chi tiết sản phẩm</h3>
                    <div class="tile-body">
                        <table class="table table-detail">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Kích thước</th>
                                    <th>Màu</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $item)
                                    <tr>
                                        <td>
                                            <img class="d-block w-100"
                                                src="{{ asset('storage/' . $item->productDetail->firstImage->tenimage) }}"
                                                alt="Product Image" style="width: 40px; height: 40px; object-fit: contain;">
                                        </td>
                                        <td>{{ $item->product->tensanpham }}</td>
                                        <td>{{ $item->sizeDetail->tensize }} </td>
                                        <td>{{ $item->colorDetail->tenmau }} </td>
                                        <td>{{ $item->soluong }}</td>
                                        <td>{{ number_format($item->thanhtien) }} đ</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group mt-5">
                        @if ($order[0]->order[0]->orderstatus->id == 1)
                            <form method="post"
                                action="{{ route('thay-doi-trang-thai-don-hang', ['id' => $order[0]->ma_hd]) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Xác nhận đơn hàng</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Hàm này được gọi khi người dùng chọn một file ảnh
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#thumbimage').attr('src', e.target.result); // Hiển thị ảnh đã chọn
                    $('#thumbimage').show(); // Hiển thị thẻ img
                };

                reader.readAsDataURL(input.files[0]); // Đọc nội dung file và chuyển thành URL dạng base64
            }
        }

        // Hàm này được gọi khi người dùng muốn xóa ảnh đã chọn
        function removeImage(element) {
            $(element).closest('.thumb').remove(); // Xóa thẻ cha của nút X (đại diện cho ảnh)
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var exportPdfBtn = document.getElementById('exportPdfBtn');
            if (exportPdfBtn) {
                console.log('Check');
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var orderInput = document.getElementById('orderInput');

            if (orderInput) {
                var orderId = orderInput.getAttribute('data-order-id');
                getOrderDetails(orderId);

                // Update href of export PDF button with orderId parameter
                var doanhthuPdfBtn = document.getElementById('exportPdfBtn');
                if (doanhthuPdfBtn) {
                    doanhthuPdfBtn.href = "{{ route('exportdetail-pdf', ['id' => ':id']) }}".replace(':id',
                        orderId);
                }
            }

            function getOrderDetails(orderId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/get-order-details/' + orderId, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var orderDetails = JSON.parse(xhr.responseText);
                        console.log(orderDetails);
                        document.getElementById('order-details').innerText = JSON.stringify(orderDetails, null,
                            2);
                    }
                };
                xhr.send();
            }
        });
    </script>



@endsection
