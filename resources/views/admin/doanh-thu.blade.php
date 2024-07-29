@extends('layout.master_ad')

@section('title', 'Doanh thu | Quản trị viên')


@section('content')
    <main class="app-content">

        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/doanh-thu') }}"><b>Báo cáo doanh thu</b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-6 d-flex align-items-center">
                <form action="{{ route('doanh-thu') }}" method="GET" class="d-flex align-items-center">
                    <label for="datepicker" class="me-2">Chọn Ngày:</label>
                    <input type="text" id="datepicker" name="ngay" class="form-control me-2" style="width: 150px;">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>
                <div class="col-sm-2">
                    <a id="doanhthuPdfBtn" class="btn btn-delete btn-sm pdf-file" href="#" title="In"><i
                            class="fas fa-file-pdf"></i> Xuất PDF</a>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x'></i>
                    <div class="info">
                        <h4>Tổng sản phẩm</h4>
                        <p><b>{{ $totalSanPham }} sản phẩm</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-shopping-bag-alt'></i>
                    <div class="info">
                        <h4>Tổng đơn hàng</h4>
                        <p><b>{{ $totalDonHang }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class='icon fa-3x bx bxs-chart'></i>
                    <div class="info">
                        <h4>Tổng thu nhập</h4>
                        <p><b>{{ number_format($totalThuNhap, 0, ',', '.') }} vnđ</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-tag-x'></i>
                    <div class="info">
                        <h4>Hết hàng</h4>
                        <p><b>{{ $SanPhamDaHet }} đơn hàng</b></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">SẢN PHẨM BÁN CHẠY</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
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
                    <div>
                        <h3 class="tile-title">TỔNG ĐƠN HÀNG</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Khách hàng</th>
                                    <th>Đơn hàng</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $index = 0;
                                @endphp
                                @foreach ($tongDonHang as $item)
                                    @php
                                        $totalQuantity = 0;
                                        foreach ($item->orderdetail as $detail) {
                                            $totalQuantity += $detail->soluong;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $item->khachangorder->hovaten }}</td>
                                        <td>{{ $item->orderdetail[0]->product->tensanpham }}</td>
                                        <td>{{ $totalQuantity }} sản phẩm</td>
                                        <td>{{ number_format($item->ttthanhtoan, 0, ',', '.') }} đ</td>
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
                                    <th>Ảnh</th>
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
                                        <td>
                                            <img class="d-block w-100"
                                                src="{{ asset('storage/' . $sanPhamDaHet->firstImage->tenimage) }}"
                                                alt="Product Image" style="width: 40px; height: 40px; object-fit: contain;">
                                        </td>
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
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">DỮ LIỆU HÀNG THÁNG</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">THỐNG KÊ DOANH SỐ</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </main>


    <script>
        // Function to extract query parameter from URL
        function getQueryParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Wait for document to be ready
        document.addEventListener('DOMContentLoaded', function() {
            // Get ngay value from URL
            var ngay = getQueryParameter('ngay');

            // Update href of export PDF button with ngay parameter
            var doanhthuPdfBtn = document.getElementById('doanhthuPdfBtn');
            if (doanhthuPdfBtn) {
                doanhthuPdfBtn.href = "{{ route('doanh-thu-pdf') }}?ngay=" + ngay;
            }
        });
    </script>


@endsection
