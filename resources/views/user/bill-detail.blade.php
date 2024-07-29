@extends('layout.master')

@section('title', 'Thông tin User')

@section('content')
    <!-- Profile Update Form -->
    <div class="container pt-5">
        <div class="row justify-content-center">
            <h6 class="text-center">Danh sách đơn hàng</h6>
        </div>
        <div class="row">
            <!-- Cột bên trái -->
            <div class="col-md-2">
                <div class="tile">
                    <h3 class="tile-title">Thông tin đơn hàng</h3>
                    <div class="tile-body">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Mã đơn hàng</label>
                                <input class="form-control" type="text" name="madonhang" value="{{ $order[0]->ma_hd }}"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Ngày đặt hàng</label>
                                <input class="form-control" type="text" name="ngaydathang"
                                    value="{{ $order[0]->created_at }}" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Trạng thái đơn hàng</label>

                                @php
                                    $status = $order[0]->order[0]->orderstatus->value;
                                    $badgeClass = '';
                                    switch ($status) {
                                        case 'Đang Xử Lý':
                                            $badgeClass = 'bg-warning';
                                            break;
                                        case 'Đang Giao Hàng':
                                            $badgeClass = 'bg-info';
                                            break;
                                        case 'Đã Xong':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'Đã Hủy':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary';
                                    }
                                @endphp
                                <input class="form-control" type="text" name="ngaydathang"
                                    value="{{ $order[0]->order[0]->orderstatus->value }}" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Cột bên phải -->
            <div class="col-md-10">
                <div class="tile">
                    <h3 class="tile-title">Chi tiết sản phẩm</h3>
                    <div class="tile-body">
                        <table class="table table-detail" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Kích Thước</th>
                                    <th>Màu</th>
                                    <th>Đánh giá</th>
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
                                        <td class="align-middle">{{ $item->product->tensanpham }}</td>
                                        <td class="align-middle">{{ $item->soluong }}</td>
                                        <td class="align-middle">{{ number_format($item->thanhtien) }} đ</td>
                                        <td class="align-middle">{{ $item->sizeDetail->tensize }} </td>
                                        <td class="align-middle">{{ $item->colorDetail->tenmau }} </td>
                                        <td class="align-middle">
                                            @if ($order[0]->order[0]->orderstatus->id == 3)
                                                <form method="GET"
                                                    action="{{ route('chi-tiet-san-pham-user', ['id' => $order[0]->product->id]) }}">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-primary">Đánh giá </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group mt-5">
                        @if ($order[0]->order[0]->orderstatus->id == 2)
                            <form method="post" action="{{ route('billUpdate', ['id' => $order[0]->ma_hd]) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Đã nhận được hàng</button>
                            </form>
                        @elseif($order[0]->order[0]->orderstatus->id == 1)
                            <form method="post" action="{{ route('billUpdate', ['id' => $order[0]->ma_hd]) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">Xác nhận hủy đơn</button>
                            </form>
                            {{-- @elseif($order[0]->order[0]->orderstatus->id == 3)
                            <form method="GET"
                                action="{{ route('chi-tiet-san-pham-user', ['id' => $order[0]->product->id]) }}">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-primary">Đánh giá sản phẩm</button>
                            </form> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast for success message -->
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div class="toast" style="position: absolute; top: 10px; right: 10px;" data-autohide="false">
            <div class="toast-header">
                <strong class="mr-auto">Thông báo</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Thông tin đã được cập nhật thành công.
            </div>
        </div>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            $('#profile-form').submit(function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.toast').toast('show');
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
