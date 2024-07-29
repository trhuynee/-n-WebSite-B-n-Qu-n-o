@extends('layout.master_ad')

@section('title', 'Quản Lý Nhập Xuất | Quản trị viên')

@section('content')
    <main class="app-content">

        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/doanh-thu') }}"><b>Quản Lý Nhập Xuất</b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-lg-6 d-flex align-items-center">
                <form id="filterForm" action="{{ route('nhap-xuat') }}" method="GET" class="d-flex align-items-center">
                    <label for="datepicker" class="me-2">Chọn Ngày:</label>
                    <input type="text" id="datepicker" name="ngay" class="form-control me-2" style="width: 150px;">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>
                <div class="col-sm-2">
                    <a id="exportPdfBtn" class="btn btn-delete btn-sm pdf-file" href="#" title="In"><i
                            class="fas fa-file-pdf"></i> Xuất PDF</a>
                </div>
            </div>


        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">SẢN PHẨM NHẬP</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
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
                                @foreach ($sanPhamNhap as $item)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $item->tensanpham }}</td>
                                        <td>{{ $item->dongia }}</td>
                                        <td>{{ $item->soluong }} sản phẩm</td>
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
                        <h3 class="tile-title">SẢN PHẨM XUẤT</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá tiền</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $index = 0;
                                @endphp
                                @foreach ($sanPhamXuat as $item)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $item?->orderdetail[0]?->product->tensanpham ?? 'N/A' }}</td>
                                        <td>{{ $item?->orderdetail[0]?->product->dongia ?? 'N/A' }}</td>
                                        <td>{{ $item->orderdetail[0]?->soluong ?? 0 }} sản phẩm</td>
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
                        <h3 class="tile-title">TỒN KHO</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá tiền</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @php
                                        $index = 0;
                                    @endphp
                                    @foreach ($tonKho as $item)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $item->tensanpham }}</td>
                                    <td>{{ $item->dongia }}</td>
                                    <td>{{ $item->soluong }} sản phẩm</td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
            var exportPdfBtn = document.getElementById('exportPdfBtn');
            if (exportPdfBtn) {
                exportPdfBtn.href = "{{ route('xuat-nhap-pdf') }}?ngay=" + ngay;
            }
        });
    </script>
@endsection
