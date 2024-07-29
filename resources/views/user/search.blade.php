@extends('layout.master')

@section('content')
    <style>
        .product-img img {
            width: 100%;
            height: 400px;
            /* Chiều cao cố định cho hình ảnh */
            object-fit: cover;
            /* Đảm bảo hình ảnh được cắt đúng kích thước mà không bị méo */
        }
    </style>
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h4 class="section-title px-5"><span class="px-2">Kết quả tìm kiếm cho: "{{ request('keyword') }}"</span></h4>
        </div>
        <div class="row px-xl-5 pb-3">
            @if ($products->count() > 0)
                @foreach ($products as $item)
                    @php
                        $firstImage = $item->image->first();
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            @if ($firstImage)
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $firstImage->tenimage) }}"
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
            @else
                <div class="col-12 text-center">
                    <p>Không có sản phẩm nào phù hợp với từ khóa tìm kiếm của bạn.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
