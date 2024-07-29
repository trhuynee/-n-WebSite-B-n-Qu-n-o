@extends('layout.master')

@section('title', 'Chi Tiết Sản Phẩm')


@section('content')
    <style>
        .preserve-format {
            white-space: pre-wrap;
        }

        .btn-disabled {
            opacity: 0.5;
            /* Reduce opacity to indicate disabled state */
            pointer-events: none;
            /* Disable pointer events */
        }
    </style>
    <!-- Page Header Start -->
    <div class="container-fluid mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <img src="{{ asset('img/1.png') }}" alt="" style="width:100%; height:400px;object-fit: cover;">
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($image as $index => $img)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset('storage/' . $img->tenimage) }}"
                                    alt="Product Image">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->tensanpham }}</h3>
                <div class="d-flex mb-3">
                    {{-- <div class="text-primary mr-2">
                        @for ($i = 0; $i < 5; $i++)
                            <small class="fas fa-star{{ $i < $product->rating ? '' : '-half-alt' }}"></small>
                        @endfor
                    </div>
                    <small class="pt-1">({{ $product->reviews_count }} Đánh giá)</small> --}}
                </div>
                <h3 class="font-weight-semi-bold mb-4">
                    {{ number_format($product->dongia - ($product->dongia * $product->giamgia) / 100, 0, ',', '.') }} ₫
                    <del style="font-size: 16px;">
                        {{ number_format($product->dongia, 0, ',', '.') }} ₫
                    </del>
                </h3>
                @if (isset($uniqueDetails))
                    @php
                        $usedColors = [];
                        $usedSizes = [];
                    @endphp

                    <div class="d-flex mb-4">
                        <p class="text-dark font-weight-medium mb-0 mr-3">Màu sắc</p>
                        <form id="product-options">
                            @foreach ($uniqueDetails as $detail)
                                @if (!in_array($detail->color->tenmau, $usedColors))
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input onclick="CheckDisableQuantityBtn()" type="radio"
                                            class="custom-control-input" id="color-{{ $detail->mau_id }}" name="color"
                                            value="{{ $detail->mau_id }}">
                                        <label class="custom-control-label"
                                            for="color-{{ $detail->mau_id }}">{{ $detail->color->tenmau }}</label>
                                    </div>
                                    @php
                                        $usedColors[] = $detail->color->tenmau;
                                    @endphp
                                @endif
                            @endforeach
                    </div>

                    <div class="d-flex mb-4">
                        <p class="text-dark font-weight-medium mb-0 mr-3">Kích thước</p>
                        @foreach ($uniqueDetails as $detail)
                            @if (!in_array($detail->size->tensize, $usedSizes))
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick="CheckDisableQuantityBtn()" type="radio" class="custom-control-input"
                                        id="size-{{ $detail->size_id }}" name="size" value="{{ $detail->size_id }}">
                                    <label class="custom-control-label"
                                        for="size-{{ $detail->size_id }}">{{ $detail->size->tensize }}</label>
                                </div>
                                @php
                                    $usedSizes[] = $detail->size->tensize;
                                @endphp
                            @endif
                        @endforeach
                        </form>
                    </div>

                @endif

                <div class="d-flex align-items-center mb-4 pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Số lượng</p>
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input id="input_soluong" type="text" class="form-control bg-secondary text-center"
                            name="quantity" value="1">
                        <div class="input-group-btn">
                            <button id="btn-plus" class="btn btn-primary btn-plus" disabled="true">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <span class="ml-2" id="stock-quantity">{{ $product->totalStock }} sản phẩm có sẵn</span>
                </div>

                <div class="d-flex align-items-center mb-4 pt-2">
                    <form action="{{ route('them-gio-hang') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size_id" id="selectedSizeId" value="">
                        <input type="hidden" name="mau_id" id="selectedColorId" value="">
                        <input type="hidden" name="soluong" id="selectedQuantity" value="1">
                        <button type="submit" class="btn btn-primary px-3 mr-2" id="btn-add-to-cart">
                            <i class="fa fa-shopping-cart mr-1"></i> Thêm Vào Giỏ Hàng
                        </button>
                    </form>
                    <!-- Nút thêm vào danh sách yêu thích -->
                    <form action="{{ route('wishlist.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-danger px-3" id="btn-add-to-wishlist">
                            <i class="fa fa-heart mr-1"></i> Yêu Thích
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Bình Luận
                    ({{ $product->reviews_count }})</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Mô tả sản phẩm</h4>
                    <p class="preserve-format">{{ $product->mota }}</p>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="ratings-container">
                                <!-- Đây là nơi hiển thị dữ liệu đánh giá được cập nhật bằng Ajax -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Viết đánh giá</h5>
                                </div>
                                <div class="card-body">
                                    <form id="comment-form">
                                        <div class="form-group">
                                            <label for="rating">Đánh giá của bạn:</label>
                                            <div class="text-warning" id="rating-stars">
                                                <i class="far fa-star fa-lg" data-index="0"></i>
                                                <i class="far fa-star fa-lg" data-index="1"></i>
                                                <i class="far fa-star fa-lg" data-index="2"></i>
                                                <i class="far fa-star fa-lg" data-index="3"></i>
                                                <i class="far fa-star fa-lg" data-index="4"></i>
                                            </div>
                                            <input type="hidden" name="rating" id="rating" value="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="message">Đánh giá của bạn:</label>
                                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="btn-submit-review">Gửi
                                            Đánh
                                            Giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function CheckDisableQuantityBtn() {
            var selectedSize = $('input[name="size"]:checked').val();
            var selectedColor = $('input[name="color"]:checked').val();
            var soluong_conlai = @json($uniqueDetails).filter(detail => detail.mau_id ==
                selectedColor && detail.size_id == selectedSize)[0].soluong;
            if (soluong_conlai == 0) {
                $('#input_soluong').val(0)
                $('#selectedQuantity').val(0);
                $(".btn-plus").attr("disabled", true);
                return;
            }

            $('#input_soluong').val(1)
            $('#selectedQuantity').val(1);
            if (soluong_conlai == 1) {
                $(".btn-plus").attr("disabled", true);
            } else {
                $(".btn-plus").attr("disabled", false);
            }

        }

        $(document).ready(function() {
            // Xử lý khi nhấn nút +
            $('.btn-plus').click(function(e) {
                e.preventDefault();
                var quantityInput = $(this).closest('.input-group').find('input[name="quantity"]');
                var currentValue = parseInt(quantityInput.val());
                if (!isNaN(currentValue)) {
                    quantityInput.val(currentValue + 1);
                    updateSelectedQuantity(currentValue + 1);

                }
            });

            // Xử lý khi nhấn nút -
            $('.btn-minus').click(function(e) {
                e.preventDefault();
                var quantityInput = $(this).closest('.input-group').find('input[name="quantity"]');
                var currentValue = parseInt(quantityInput.val());
                if (!isNaN(currentValue) && currentValue > 1) {
                    //Dòng này là trừ 1
                    quantityInput.val(currentValue - 1);
                    updateSelectedQuantity(currentValue - 1);
                }
            });

            // Xử lý khi thay đổi màu sắc
            $('input[name="color"]').change(function() {
                var selectedColor = $(this).val();
                updateSelectedColor(selectedColor);
                updateAddToCartButton();
                //CheckDisableQuantityBtn(); // Gọi hàm kiểm tra sau khi thay đổi số lượng
            });

            // Xử lý khi thay đổi kích thước
            $('input[name="size"]').change(function() {
                var selectedSize = $(this).val();
                updateSelectedSize(selectedSize);
                updateAddToCartButton();
                //CheckDisableQuantityBtn(); // Gọi hàm kiểm tra sau khi thay đổi số lượng
            });

            // Hàm cập nhật size đã chọn
            function updateSelectedSize(sizeId) {
                $('#selectedSizeId').val(sizeId);
            }

            // Hàm cập nhật màu đã chọn
            function updateSelectedColor(colorId) {
                $('#selectedColorId').val(colorId);
            }

            // Hàm cập nhật số lượng đã chọn
            function updateSelectedQuantity(quantity) {
                $('#selectedQuantity').val(quantity);
                var selectedSize = $('input[name="size"]:checked').val();
                var selectedColor = $('input[name="color"]:checked').val();
                var soluong_conlai = @json($uniqueDetails).filter(detail => detail.mau_id ==
                    selectedColor && detail.size_id == selectedSize)[0].soluong;

                var soluong_nhap = $("#input_soluong").val();
                if (soluong_nhap >= soluong_conlai || soluong_conlai == 0) {
                    $(".btn-plus").attr("disabled", true);
                } else {
                    $(".btn-plus").attr("disabled", false);
                }

            }

            // Hàm cập nhật nút Thêm vào Giỏ Hàng
            function updateAddToCartButton() {
                var selectedColor = $('input[name="color"]:checked').val();
                var selectedSize = $('input[name="size"]:checked').val();
                if (selectedColor && selectedSize) {
                    // Lọc chi tiết sản phẩm dựa trên màu và kích thước
                    var filteredDetail = @json($uniqueDetails).filter(detail => detail.mau_id ==
                        selectedColor && detail.size_id == selectedSize);
                    if (filteredDetail.length > 0) {
                        // Cập nhật số lượng tồn kho
                        var stockQuantity = filteredDetail[0].soluong;

                        if (stockQuantity > 0) {
                            $('#stock-quantity').text(stockQuantity + ' sản phẩm có sẵn').css('color', '');
                            // Enable nút Thêm vào Giỏ Hàng
                            $('#btn-add-to-cart').removeClass('btn-disabled').prop('disabled', false);
                        } else {
                            // Nếu số lượng tồn kho bằng 0
                            $('#stock-quantity').text('Hết hàng').css('color', 'red');
                            // Disable nút Thêm vào Giỏ Hàng
                            $('#btn-add-to-cart').addClass('btn-disabled').prop('disabled', true);
                            $('#input_soluong').val(0)
                            $('#selectedQuantity').val(0);
                            $(".btn-plus").attr("disabled", true);
                            //$(".btn-minus").attr("disabled", true);
                        }
                    } else {
                        // Nếu không tìm thấy chi tiết sản phẩm phù hợp
                        $('#stock-quantity').text('Hết hàng').css('color', 'red');
                        // Disable nút Thêm vào Giỏ Hàng
                        $('#btn-add-to-cart').addClass('btn-disabled').prop('disabled', true);
                        // Disable khi hết hàng
                        $('#input_soluong').val(0)
                        $('#selectedQuantity').val(0);
                        $(".btn-plus").attr("disabled", true);
                        $(".btn-minus").attr("disabled", true);
                    }
                } else {
                    // Nếu chưa chọn màu sắc hoặc kích thước
                    $('#stock-quantity').text('{{ $product->totalStock }} sản phẩm có sẵn').css('color', '');
                    // Disable nút Thêm vào Giỏ Hàng
                    $('#btn-add-to-cart').addClass('btn-disabled').prop('disabled', true);
                }
            }
            // Gọi hàm cập nhật khi trang được tải lần đầu
            updateAddToCartButton();
            //CheckDisableQuantityBtn(); // Gọi hàm kiểm tra sau khi thay đổi số lượng
        });
    </script>

    <script>
        $(document).ready(function() {
            // Rating stars interaction
            $('#rating-stars i').on('click', function() {
                let currentIndex = parseInt($(this).data('index')) + 1;
                $('#rating').val(currentIndex);
                highlightStars(currentIndex - 1); // Highlight stars up to the clicked one
            });

            function highlightStars(index) {
                resetStars();
                for (let i = 0; i <= index; i++) {
                    $('#rating-stars i:eq(' + i + ')').removeClass('far').addClass('fas');
                }
            }

            function resetStars() {
                $('#rating-stars i').removeClass('fas').addClass('far');
            }

            // Submit review form via Ajax
            $('#comment-form').submit(function(event) {
                event.preventDefault();
                let formData = {
                    rating: $('#rating').val(),
                    message: $('#message').val(),
                    product_id: '{{ $product->id }}', // Include product_id here
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '/rating',
                    data: formData,
                    dataType: 'json',
                    encode: true,
                    success: function(data) {
                        console.log(data);
                        // Optionally, you can show a success message or update the UI
                        // Clear form fields after successful submission
                        resetStars(); // Reset stars after submission
                        $('#message').val('');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                        // Handle errors here, if any
                    }
                });
            });
        });
    </script>

    <script>
        console.log('{{ $product->id }}');
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '/getrating/{{ $product->id }}',
                dataType: 'json',
                success: function(response) {
                    if (response.ratings.length > 0) {
                        var ratingsHtml = '';
                        response.ratings.forEach(function(rating) {
                            ratingsHtml += '<div class="media mb-3">';
                            ratingsHtml += '<div class="media-body">';
                            ratingsHtml += '<h5 class="mt-0">' + rating.user.hovaten + '</h5>';
                            ratingsHtml += '<p>';
                            // Thay thế phần rating bằng biểu tượng số sao (vd: FontAwesome)
                            ratingsHtml += 'Đánh giá: ';
                            for (var i = 0; i < rating.rating; i++) {
                                ratingsHtml +=
                                    '<i class="fas fa-star"></i>'; // Sử dụng class của FontAwesome cho sao đầy
                            }
                            for (var i = rating.rating; i < 5; i++) {
                                ratingsHtml +=
                                    '<i class="far fa-star"></i>'; // Sử dụng class của FontAwesome cho sao rỗng
                            }
                            ratingsHtml += '</p>';
                            ratingsHtml += '<p>Nội dung: ' + rating.message + '</p>';
                            ratingsHtml += '</div>';
                            ratingsHtml += '</div>';
                        });
                        $('#ratings-container').html(ratingsHtml);
                    } else {
                        $('#ratings-container').html('<p>Chưa có đánh giá nào cho sản phẩm này.</p>');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(xhr.responseText);
                    // Xử lý lỗi nếu có
                }
            });
        });
    </script>


@endsection
