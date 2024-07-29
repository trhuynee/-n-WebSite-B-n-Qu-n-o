@extends('layout.master')

@section('title', 'Trang Chủ')

@section('content')
    <style>
        .product-img img {
            width: 100%;
            height: 400px;
            /* Chiều cao cố định cho hình ảnh */
            object-fit: cover;
            /* Đảm bảo hình ảnh được cắt đúng kích thước mà không bị méo */
        }

        .btn-primary.radius-border {
            border-radius: 10px;
            /* Điều chỉnh giá trị cho độ bo tròn mong muốn */
        }

        .position-relative {
            position: relative;
        }

        .overlay-content {
            position: absolute;
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
            color: white;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            /* Màu nền mờ */
            padding: 20px;
            border-radius: 10px;
            font-style: italic;
        }
    </style>


    <!-- Slideshow Start-->
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 410px;">
                <img class="img-fluid" src="{{ asset('img/1.png') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="img-fluid" src="{{ asset('img/2.png') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="img-fluid" src="{{ asset('img/3.png') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
    <!-- Slideshow End-->



    <!-- Sản phẩm phân theo brand start -->
    <div class="container-fluid pt-5">
        @foreach ($brands as $brand)
            <div class="text-center mb-4">
                <h4 class="section-title px-5"><span class="px-2">{{ $brand->tennhanhieu }}</span></h4>
            </div>
            <div class="row px-xl-5 pb-3">
                @php
                    $brand_products = $products->where('nh_id', $brand->id);
                @endphp
                @if ($brand_products->count() > 0)
                    @foreach ($brand_products->take(4) as $item)
                        @php
                            $firstImage = $item->image->first();
                        @endphp
                        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                @if ($firstImage)
                                    <div
                                        class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <a href="{{ url('/detail', ['id' => $item->id]) }}"><img class="img-fluid w-100"
                                                src="{{ asset('storage/' . $firstImage->tenimage) }}"
                                                alt="{{ $item->tensanpham }}">
                                    </div>
                                @endif
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">
                                        <a href="{{ url('/detail', ['id' => $item->id]) }}">{{ $item->tensanpham }}</a>
                                    </h6>
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($item->giamgia > 0)
                                            <div class="mb-2">
                                                <h5>{{ number_format($item->dongia * (1 - $item->giamgia / 100)) }}₫</h5>
                                                <div class="d-flex justify-content-center align-items-center mt-2">
                                                    <h6 class="text-muted mb-0 mr-2">
                                                        <del>{{ number_format($item->dongia) }}₫</del>
                                                    </h6>
                                                    <span class="badge badge-danger">{{ $item->giamgia }}%</span>
                                                </div>
                                            </div>
                                        @else
                                            <h5>{{ number_format($item->dongia) }}₫</h5>
                                        @endif

                                    </div>
                                </div>
                                <div class="border">
                                    {{-- Additional action buttons if needed --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 text-right mt-4 pr-4">
                        <a href="{{ route('trang-nhan-hieu', ['id' => $brand->id]) }}"
                            class="btn btn-primary radius-border">Xem các sản
                            phẩm
                            khác của {{ $brand->tennhanhieu }}</a>
                    </div>
                @else
                    <div class="col-12 text-center">
                        <p>Không tìm thấy sản phẩm cho nhãn hiệu {{ $brand->tennhanhieu }}.</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <!-- Sản phẩm phân theo brand end -->



    <!-- Subscribe Start -->
    <div class="container-fluid pt-5">
        <a href="{{ url('/shop') }}">
            <img class="img-fluid" src="{{ asset('img/4.png') }}" alt="Image">
        </a>
    </div>

    <!-- Subscribe End -->


    <!-- Sản Phẩm mới start-->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h4 class="section-title px-5"><span class="px-2">Sản Phẩm Mới</span></h4>
        </div>
        <div class="row px-xl-5 pb-3" id="product-list">
            @foreach ($products->take(12) as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            @php
                                $firstImage = $product->image->first();
                            @endphp
                            @if ($firstImage)
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $firstImage->tenimage) }}"
                                        alt="{{ $product->tensanpham }}">
                                </div>
                            @endif
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <!-- Hiển thị tên sản phẩm -->
                            <h5 class="text-truncate mb-3">
                                <a href="{{ url('/detail', ['id' => $product->id]) }}">{{ $product->tensanpham }}</a>
                            </h5>
                            <div class="d-flex justify-content-center align-items-center">
                                @if ($item->giamgia > 0)
                                    <div class="mb-2">
                                        <h5>{{ number_format($item->dongia * (1 - $item->giamgia / 100)) }}₫</h5>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <h6 class="text-muted mb-0 mr-2">
                                                <del>{{ number_format($item->dongia) }}₫</del>
                                            </h6>
                                            <span class="badge badge-danger">{{ $item->giamgia }}%</span>
                                        </div>
                                    </div>
                                @else
                                    <h5>{{ number_format($item->dongia) }}₫</h5>
                                @endif

                            </div>
                        </div>
                        <div class="border">
                            {{-- Additional action buttons if needed --}}
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12 text-right mt-4 pr-4">
                <a href="{{ url('/shop') }}" class="btn btn-primary radius-border">Xem các sản phẩm khác</a>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="position-relative">
            <a href="{{ url('/shop') }}">
                <img class="img-fluid" src="{{ asset('img/5.png') }}" alt="Image">
                <div class="overlay-content">
                    <h4>Thời Trang Cao Cấp</h4>
                    <p>"Thời trang không chỉ là quần áo, mà còn là cách bạn sống và cảm nhận thế giới."</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Sản phẩm mới end -->
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h4 class="section-title px-5"><span class="px-2">Dịch Vụ</span></h4>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Sản Phẩm Chất Lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Miễn Phí Vận Chuyển</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hoàn Trong 14 Ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ Trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->



    <!-- Vendor Start -->
    {{-- <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="img/1.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/2.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/3.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/4.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        $(document).ready(function() {
            // Xử lý khi nhấn nút Trước
            $('.prev-btn').click(function() {
                var target = $($(this).data('target')).find('.product-slide.active');
                var prev = target.prev();
                if (prev.length === 0) {
                    prev = target.siblings().last();
                }
                target.removeClass('active');
                prev.addClass('active');
            });

            // Xử lý khi nhấn nút Tiếp
            $('.next-btn').click(function() {
                var target = $($(this).data('target')).find('.product-slide.active');
                var next = target.next();
                if (next.length === 0) {
                    next = target.siblings().first();
                }
                target.removeClass('active');
                next.addClass('active');
            });
        });
    </script>
    <!-- Vendor End -->
@endsection
