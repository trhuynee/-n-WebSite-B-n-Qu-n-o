@extends('layout.master')

@section('title', 'Sản Phẩm Theo Loại')

@section('content')
    <style>
        .product-img img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h4 class="section-title px-5"><span class="px-2">{{ $category->tenloaisp }}</span></h4>
        </div>
        <div class="row px-xl-5">
            @if ($products->isEmpty())
                <h6 class="text-center">Không có sản phẩm nào thuộc danh mục này.</h6>
            @else
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <!-- Hiển thị sản phẩm -->
                        <div class="card product-item border-0 mb-4">
                            <!-- Hiển thị ảnh sản phẩm -->
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

                            <!-- Hiển thị thông tin sản phẩm -->
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h5 class="text-truncate mb-3">
                                    <a href="{{ url('/detail', ['id' => $product->id]) }}">{{ $product->tensanpham }}</a>
                                </h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    @php
                                        $finalPrice = $product->dongia * (1 - $product->giamgia / 100);
                                    @endphp
                                    <h5>{{ number_format($finalPrice) }} ₫</h5>
                                    @if ($product->giamgia > 0)
                                        <h6 class="text-muted ml-2">
                                            <del>{{ number_format($product->dongia) }} ₫</del>
                                        </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Phân trang -->
        <div class="col-12 pb-1">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-3">
                    @if ($products->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

    </div>
    <!-- Shop End -->
@endsection
