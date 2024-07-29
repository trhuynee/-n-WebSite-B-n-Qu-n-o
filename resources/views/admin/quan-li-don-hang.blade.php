@extends('layout.master_ad')

@section('title', 'Quản lí đơn hàng | Quản trị viên')

@section('content')
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

        .text-center {
            text-align: center;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .btn {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }

        .badge {
            padding: 5px 10px;
            font-size: 12px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .text-align-center th {
            text-align: center;
        }

        .modal-xl {
            max-width: 60% !important;
        }

        .bg-gray {
            background-color: #f2f2f2;
            /* Màu nền xám */
        }

        .text-dark {
            color: #000000;
            /* Màu chữ đen */
        }

        .font-weight-bold {
            font-weight: bold;
            /* Chữ in đậm */
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .form-control-sm.d-inline-block {
            display: inline-block;
            width: auto;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mt-3 {
            margin-top: 0.5rem;
        }

        .pagination {
            justify-content: flex-end;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="{{ url('/quan-li-don-hang') }}"><b>Danh sách đơn hàng</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-9">
                <form action="{{ route('quan-li-don-hang') }}" method="GET" class="form-inline">
                    <div class="form-group mr-2">
                        <select name="status" class="form-control">
                            <option value="">Tất cả tình trạng</option>
                            @foreach ($orderStatuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <select name="payment" class="form-control">
                            <option value="">Tất cả trạng thái thanh toán</option>
                            <option value="1" {{ request('payment') == '1' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="0" {{ request('payment') == '0' ? 'selected' : '' }}>Chưa thanh toán
                            </option>
                            <option value="2" {{ request('payment') == '2' ? 'selected' : '' }}>Đã hoàn tiền</option>
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"
                            placeholder="Từ ngày">
                    </div>
                    <div class="form-group mr-2">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"
                            placeholder="Đến ngày">
                    </div>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button mb-3">
                        </div>
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead class="text-align-center">
                                <tr>

                                    <th>ID đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng</th>
                                    <th>Thanh toán</th>
                                    <th>Chi tiết</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $index = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    @php
                                        $paymentStatusBadgeClass =
                                            $order->ttvanchuyen == '1'
                                                ? 'bg-success'
                                                : ($order->ttvanchuyen == '2'
                                                    ? 'bg-danger'
                                                    : 'bg-warning');
                                    @endphp

                                    <tr>
                                        <td> {{ $order->id }} </td>
                                        <td>{{ $order->khachangorder->hovaten }}</td>
                                        <td>{{ number_format($order->ttthanhtoan) }} đ</td>
                                        <td>
                                            @php
                                                $orderStatus = $order->orderstatus->value;
                                                $statusBadgeClass = '';
                                                switch ($orderStatus) {
                                                    case 'Đang Xử Lý':
                                                        $statusBadgeClass = 'bg-warning';
                                                        break;
                                                    case 'Đang Giao Hàng':
                                                        $statusBadgeClass = 'bg-info';
                                                        break;
                                                    case 'Đã Xong':
                                                        $statusBadgeClass = 'bg-success';
                                                        break;
                                                    case 'Đã Hủy':
                                                        $statusBadgeClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $statusBadgeClass = 'bg-secondary';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $statusBadgeClass }} ">{{ $orderStatus }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $paymentStatusBadgeClass }}">
                                                @if ($order->ttvanchuyen == 1)
                                                    Đã thanh toán
                                                @elseif ($order->ttvanchuyen == 0)
                                                    Chưa thanh toán
                                                @else
                                                    Đã hoàn tiền
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <form method="GET"
                                                    action="{{ route('chinh-sua-don-hang', ['id' => $order->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm edit"
                                                        title="Sửa">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if ($order->orderstatus->id == 1)
                                                    <form method="POST"
                                                        action="{{ route('thay-doi-trang-thai-don-hang', ['id' => $order->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            title="Xác nhận đơn hàng">
                                                            Xác nhận đơn hàng
                                                        </button>
                                                    </form>
                                                @elseif ($order->orderstatus->id == 3)
                                                    <span class="badge bg-success">Đã xác nhận đơn</span>
                                                @elseif ($order->orderstatus->id == 2)
                                                    <span class="badge bg-success">Đã xác nhận đơn</span>
                                                @elseif ($order->orderstatus->id == 4)
                                                    <span class="badge bg-danger">Đã hủy đơn</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="sampleTable_info" role="status" aria-live="polite">
                                    <h6>Có {{ $orders->total() }} thông tin được tìm thấy</h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                                    <ul class="pagination">
                                        {{-- Link đến trang trước --}}
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $orders->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                        @endif

                                        {{-- Các trang phân trang --}}
                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            @if ($page == $orders->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Link đến trang tiếp theo --}}
                                        @if ($orders->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $orders->nextPageUrl() }}"
                                                    rel="next">&raquo;</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
