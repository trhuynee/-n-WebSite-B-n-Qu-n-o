<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
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
</head>

<body>
    <div class="row">
        <!-- Cột bên trái -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Thông tin đơn hàng</h3>
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label">Mã đơn hàng</label>
                        <p>{{ $order[0]->ma_hd }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Ngày đặt hàng</label>
                        <p>{{ $order[0]->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Trạng thái đơn hàng</label>
                        <p>{{ $order[0]->order[0]->orderstatus->value }}</p>
                    </div>
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
                                    <td>{{ $item->product->tensanpham }}</td>
                                    <td>{{ $item->sizeDetail->tensize }} </td>
                                    <td>{{ $item->colorDetail->tenmau }} </td>
                                    <td>{{ $item->soluong }} </td>
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
</body>

</html>
