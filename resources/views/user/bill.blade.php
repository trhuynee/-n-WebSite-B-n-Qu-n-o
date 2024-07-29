@extends('layout.master')

@section('title', 'Thông tin User')


@section('content')
    <!-- Profile Update Form -->
    <div class="container pt-5">
        <div class="row justify-content-center">
            <h6 class="text-center">Danh sách đơn hàng</h6>
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
                                    <th width="10"></th>
                                    <th>STT</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng</th>
                                    <th>Thanh toán</th>
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
                                        <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                        <td>{{ ++$index }}</td>
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
                                                <form method="GET" action="{{ route('billShow', ['id' => $order->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm edit"
                                                        title="Sửa">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
