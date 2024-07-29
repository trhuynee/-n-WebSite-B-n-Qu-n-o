@extends('layout.master')

@section('title', 'Thanh Toán')


@section('content')
    {{-- <div class="container-fluid mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <img src="img/banner.png" alt="" style="width:100%; height:400px;object-fit: cover;">
        </div>
    </div> --}}
    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form id="checkoutForm" action="{{ route('tao-hoa-don') }}" method="POST">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-7">
                    <div class="mb-4">
                        <h5 class="font-weight-semi-bold mb-4">Thông tin giao hàng</h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Họ tên</label>
                                <input class="form-control" type="text" name="tenkhachhang" placeholder="Họ"
                                    value="{{ Auth::user()->hovaten }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" name="sodienthoai" placeholder="+123 456 789"
                                    value="{{ Auth::user()->sdt }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control" type="text" name="diachi" placeholder="Địa chỉ"
                                    value="{{ Auth::user()->diachi }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h5 class="font-weight-semi-bold m-0">Tổng thanh toán</h5>
                        </div>
                        @foreach ($checkout as $item)
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="carousel">
                                            <div class="carousel-item active">
                                                <img class="d-block w-100"
                                                    src="{{ asset('storage/' . $item->productDetail->firstImage->tenimage) }}"
                                                    alt="Product Image"
                                                    style="width: 80px; height: 80px; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="product-details ml-3">
                                            <div class="mb-2">
                                                <h6 class="font-weight-medium">
                                                    {{ $item->productDetail->product->tensanpham }}</h6>
                                            </div>

                                            <div class="mb-2">
                                                <p>Đơn giá: {{ number_format($item->dongia) }}đ</p>
                                            </div>
                                            <div class="mb-2">
                                                <p>Số lượng: {{ $item->soluong }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <p>Kích thước: {{ $item->productDetail->size->tensize }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <p>Màu: {{ $item->productDetail->color->tenmau }}</p>
                                            </div>
                                            <hr class="my-2">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="mb-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-normal">Tổng tiền hàng </h6>
                                    <h6 class="font-weight-normal">
                                        {{ number_format($tong) }}đ</h6>
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-normal">Phí vận chuyển</h6>
                                    @php
                                        if ($tong >= 500000) {
                                            $phi = 0;
                                        } else {
                                            $phi = 20000;
                                        }
                                    @endphp
                                    <h6 class="font-weight-normal">{{ number_format($phi) }}đ</h6>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="font-weight-bold">Tổng thanh toán</h6>
                                <h6 class="font-weight-normal">
                                    {{ number_format($tong + $phi) }}đ</h6>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex">
                        <!-- Payment method selection form -->
                        <form id="paymentMethodForm" action="{{ route('tao-hoa-don') }}" method="POST">
                            @csrf
                            @foreach ($checkout as $item)
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="size_id" value="{{ $item->user_id }}">
                                <!-- <input type="hidden" name="mau_id" value="{{ $item->mau_id }}"> -->
                                <input type="hidden" name="soluong" value="{{ $item->soluong }}">
                                <input type="hidden" name="giaohang" value="0">
                            @endforeach

                            <button type="submit" class="btn btn-primary">Thanh toán khi nhận hàng</button>
                        </form>
                        <form style="margin-left: 10px;" id="paymentMethodForm" action="{{ route('vnpay-payment') }}"
                            method="POST">
                            @csrf
                            @foreach ($checkout as $item)
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                <input type="hidden" name="address" value="{{ Auth::user()->diachi }}">
                                <input type="hidden" name="chitietietsp_id" value="{{ $item->productDetail->id }}">
                                <input type="hidden" name="tongtien" value="{{ $tong + $phi }}">
                                <input type="hidden" name="soluong" value="{{ $item->soluong }}">
                                <input type="hidden" name="giaohang" value="1">
                            @endforeach

                            <button type="submit" class="btn btn-primary">Thanh toán qua VNPAY</button>
                        </form>
                    </div>

                </div>
            </div>
        </form>
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
                Đặt hàng thành công.
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


@push('scripts')
    <script>
        function submitForm(formId) {
            var form = document.getElementById(formId);
            form.submit();
        }
    </script>
@endpush
