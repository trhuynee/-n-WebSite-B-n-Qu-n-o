@extends('layout.master_ad')

@section('title', 'Trang chủ | Quản trị viên')

@section('content')
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}"><b>Trang chủ</b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <!--Left-->
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
                            <div class="info">
                                <h4>Tổng khách hàng</h4>
                                <p><b>{{ $count }} khách hàng</b></p>
                                <p class="info-tong">Tổng số khách hàng được quản lý.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
                            <div class="info">
                                <h4>Tổng sản phẩm</h4>
                                <p><b>{{ $count_product }} sản phẩm</b></p>
                                <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
                            <div class="info">
                                <h4>Tổng đơn hàng</h4>
                                <p><b>{{ $completedOrdersCount }} đơn hàng</b></p>
                                <p class="info-tong">Tổng số hóa đơn đã hoàn thành.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
                            <div class="info">
                                <h4>Sắp hết hàng</h4>
                                <p><b>{{ $product_stt }} sản phẩm</b></p>
                                <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-12 -->
                    <div class="col-md-12">
                        <div class="tile">
                            <h4 class="tile-title">Tình Trạng Đơn Hàng
                                <div class="float-right">
                                    <a href="{{ url('/quan-li-don-hang') }}" class="btn btn-sm btn-primary">Xem thêm >></a>
                                </div>
                            </h4>
                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID đơn hàng</th>
                                            <th>Tên khách hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->khachangorder->hovaten }}</td>
                                                <td>
                                                    @php
                                                        $totalAmount = 0;
                                                        foreach ($order->orderdetail as $item) {
                                                            $totalAmount += $item->thanhtien;
                                                        }
                                                    @endphp
                                                    {{ number_format($totalAmount) }} đ
                                                </td>
                                                <td>
                                                    @php
                                                        $statusBadgeClass = '';
                                                        $statusText = '';

                                                        switch ($order->trangthai) {
                                                            case 1:
                                                                $statusBadgeClass = 'bg-info'; // Chờ xử lý
                                                                $statusText = 'Chờ xử lý';
                                                                break;
                                                            case 2:
                                                                $statusBadgeClass = 'bg-warning'; // Đang vận chuyển
                                                                $statusText = 'Đang vận chuyển';
                                                                break;
                                                            case 3:
                                                                $statusBadgeClass = 'bg-success'; // Đã hoàn thành
                                                                $statusText = 'Đã hoàn thành';
                                                                break;
                                                            case 4:
                                                                $statusBadgeClass = 'bg-danger'; // Đã hủy
                                                                $statusText = 'Đã hủy';
                                                                break;
                                                            default:
                                                                $statusBadgeClass = 'bg-secondary'; // Trạng thái khác
                                                                $statusText = 'Không xác định';
                                                                break;
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $statusBadgeClass }}">{{ $statusText }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- / div trống-->
                        </div>
                    </div>
                    <!-- / col-12 -->
                    <!-- col-12 -->
                    <div class="col-md-12">
                        <div class="tile">
                            <h4 class="tile-title">Khách Hàng Mới
                                <div class="float-right">
                                    <a href="{{ url('/quan-li-khach-hang') }}" class="btn btn-sm btn-primary">Xem thêm
                                        >></a>
                                </div>
                            </h4>
                            <div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Họ và tên</th>
                                            <th>Địa chỉ</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- STT -->
                                                <td>{{ $item->hovaten }}</td>
                                                <td>{{ $item->diachi }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- / col-12 -->
                </div>
            </div>
            <!--END left-->
            <!--Right-->
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">Dữ liệu 12 tháng đầu vào</h3>
                            <div class="embed-responsive embed-responsive-16by9">
                                <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">Thống kê 12 tháng doanh thu</h3>
                            <div class="embed-responsive embed-responsive-16by9">
                                <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--END right-->
        </div>
    @endsection
