@extends('layout.master_ad')

@section('title', 'Quản lí nhân viên | Quản trị viên')

@section('content')
    <style>
        /* .text-align-center th,
                                                            td {
                                                                text-align: center;
                                                            } */

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
                <li class="breadcrumb-item active"><a href="{{ route('quan-li-nhan-vien') }}"><b>Danh sách quản trị
                            viên</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">
                                <a class="btn btn-add btn-sm" href="{{ route('them-admin') }}" title="Thêm">
                                    <i class="fas fa-plus"></i> Tạo mới quản trị viên
                                </a>
                            </div>

                            <div class="ml-auto">
                                <form action="{{ url('/quan-li-nhan-vien') }}" method="GET"
                                    class="d-flex align-items-center">
                                    <input type="search" id="searchInput" name="search"
                                        class="form-control form-control-sm mr-2" style="width: 200px; height: 40px;"
                                        placeholder="Nhập từ khóa tìm kiếm..." aria-controls="sampleTable"
                                        value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary btn-sm"><i
                                            class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <table class="table table-hover table-bordered mt-3" id="sampleTable">
                            <thead class="text-align-center">
                                <tr class="bg-gray text-dark font-weight-bold">
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Địa chỉ</th>
                                    <th>SĐT</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Chức vụ</th>
                                    <th>Trạng thái</th>
                                    <th>Tính năng</th>
                                </tr>
                            </thead>
                            <tbody class="text-align-center">
                                @foreach ($admin as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- STT -->
                                        <td>{{ $item->hovaten }}</td>
                                        <td>{{ $item->diachi }}</td>
                                        <td>{{ $item->sdt }}</td>
                                        <td>
                                            @if ($item->gioitinh === 'male')
                                                Nam
                                            @else
                                                Nữ
                                            @endif
                                        </td>
                                        <td>{{ $item->ngaysinh }}</td>
                                        <td>
                                            @if ($item->phanquyen === 1)
                                                Quản trị viên
                                            @else
                                                {{ $item->phanquyen }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->trangthai == 0)
                                                Hoạt động
                                            @else
                                                Vô hiệu hóa
                                            @endif
                                        </td>
                                        <td>
                                            <form id="deleteForm-{{ $item->id }}"
                                                action="{{ url('/xoa-admin', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/chi-tiet-admin', ['id' => $item->id]) }}"
                                                    class="btn btn-add btn-sm" title="Xem chi tiết">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ url('/chinh-sua-tai-khoan', ['id' => $item->id]) }}"
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
                                                                    <button id="confirmDeleteBtn-{{ $item->id }}"
                                                                        class="btn btn-primary mr-2">Xác
                                                                        nhận</button>
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

                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="sampleTable_info" role="status" aria-live="polite">
                                    <h6>Có {{ $admin->total() }} thông tin được tìm thấy</h6>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                                    <ul class="pagination">
                                        {{-- Link đến trang trước --}}
                                        @if ($admin->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $admin->previousPageUrl() }}" rel="prev">&laquo;</a>
                                            </li>
                                        @endif

                                        {{-- Các trang phân trang --}}
                                        @foreach ($admin->getUrlRange(1, $admin->lastPage()) as $page => $url)
                                            @if ($page == $admin->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Link đến trang tiếp theo --}}
                                        @if ($admin->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $admin->nextPageUrl() }}"
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
    </main>
@endsection
