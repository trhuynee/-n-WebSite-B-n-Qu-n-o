<!DOCTYPE html>
<html>


<head>
    <title>Báo cáo doanh thu</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .col-md-6 {
            width: 50%;
            padding: 10px;
        }

        .col-lg-3 {
            width: 25%;
            padding: 10px;
        }

        .widget-small {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .widget-small h4 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .widget-small p {
            margin: 5px 0;
            font-size: 16px;
        }

        .icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .tile {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .tile-title {
            margin-bottom: 15px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <h2>Báo cáo doanh thu</h2>
    <div class="row">
        <div class="col-md-2 col-lg-2">
            <div class="widget-small info"><i class='icon bx bxs-purchase-tag-alt'></i>
                <div class="info">
                    <h4>Tổng sản phẩm</h4>
                    <p><b>{{ $totalSanPham }} sản phẩm</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <div class="widget-small warning"><i class='icon bx bxs-shopping-bag-alt'></i>
                <div class="info">
                    <h4>Tổng đơn hàng</h4>
                    <p><b>{{ $totalDonHang }} đơn hàng</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <div class="widget-small primary"><i class='icon bx bxs-chart'></i>
                <div class="info">
                    <h4>Tổng thu nhập</h4>
                    <p><b>{{ number_format($totalThuNhap, 0, ',', '.') }} vnđ</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <div class="widget-small danger"><i class='icon bx bxs-tag-x'></i>
                <div class="info">
                    <h4>Hết hàng</h4>
                    <p><b>{{ $SanPhamDaHet }} đơn hàng</b></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
                <div class="tile-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($tongDonHang as $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $item->orderdetail[0]->product->tensanpham }}</td>
                                    <td>{{ $item->ttthanhtoan }} đ</td>
                                    <td>{{ $item->orderdetail[0]->product->category->tenloaisp }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">TỔNG ĐƠN HÀNG</h3>
                <div class="tile-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($tongDonHang as $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $item->orderdetail[0]->product->tensanpham }}</td>
                                    <td>{{ number_format($item->ttthanhtoan, 0, ',', '.') }} đ</td>
                                    <td>{{ $item->orderdetail[0]->product->category->tenloaisp }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div>
                    <h3 class="tile-title">SẢN PHẨM ĐÃ HẾT</h3>
                </div>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Size</th>
                                <th>Màu</th>
                                <th>Tình trạng</th>
                                <th>Giá tiền</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($totalSanPhamDaHet as $sanPhamDaHet)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $sanPhamDaHet->product->tensanpham }}</td>

                                    <td>{{ $sanPhamDaHet->size->tensize }} </td>
                                    <td>{{ $sanPhamDaHet->color->tenmau }} </td>
                                    <td><span class="badge bg-danger">Hết hàng</span></td>
                                    <td>{{ $sanPhamDaHet->product->dongia }}</td>
                                    <td>{{ $sanPhamDaHet->product->brand->tennhanhieu }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
