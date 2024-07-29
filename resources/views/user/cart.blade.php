@extends('layout.master')

@section('title', 'Giỏ Hàng')
@section('content')
    <style>
        .custom-back-button {
            background-color: #D19C97;
            border-color: #D19C97;
        }

        .custom-white-button {
            background-color: #e3dede;
            border-color: #e3dede;
        }

        .custom-back-button:hover {
            background-color: #D19C97;
            border-color: #D19C97;
        }

        #temporary-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            /* Đảm bảo rằng thông báo luôn hiển thị trên các phần tử khác */
        }
    </style>
    <!-- Page Header Start -->
    <div class="container-fluid mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <img src="img/1.png" alt="" style="width:100%; height:400px;object-fit: cover;">
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div id="temporary-alert" class="alert alert-warning" role="alert" style="display: none;">
                Vui lòng chọn sản phẩm!
            </div>
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            {{-- <th width="10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                    <label class="form-check-label" for="checkAll">

                                    </label>
                                </div>
                            </th> --}}
                            </th>
                            <th>Sản Phẩm</th>
                            <th>Đơn Giá</th>
                            <th>Số lượng</th>
                            <th>Số tiền</th>
                            <th>Xóa</th>
                            {{-- <th>Ton</th> --}}
                        </tr>
                    </thead>

                    <tbody class="align-middle">
                        @foreach ($giohang as $item)
                            <tr>
                                {{-- <td>{{ $item->isPayment }}</td> --}}
                                {{-- <td class="align-middle" width="10">
                                    <input id="product-checkbox-{{ $item->id }}"
                                        onclick="checkPayment({{ $item->id }})" type="checkbox" class="product-checkbox"
                                        data-price="{{ $item->dongia * $item->soluong }}">
                                </td>
                                </td> --}}
                                {{-- Sản phẩm --}}
                                <td class="align-middle text-left">
                                    <div class="d-flex align-items-center">
                                        <div id="carouselExample{{ $item->id }}" class="carousel slide mr-3"
                                            data-ride="carousel" style="width: 80px; height: 80px;">
                                            <div class="carousel-inner">


                                                <div class="carousel-item active">
                                                    <img class="d-block w-100"
                                                        src="{{ asset('storage/' . $item->productDetail->firstImage->tenimage) }}"
                                                        alt="Product Image"
                                                        style="width: 80px; height: 80px; object-fit: contain;">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0">{{ $item->productDetail->product->tensanpham }}</p>
                                            <p class="mb-0">
                                                <span class="product-attribute" style="font-size: smaller;">Màu: <span
                                                        class="color"
                                                        style="color: #333;">{{ $item->productDetail->color->tenmau }}</span></span>,
                                                <span class="product-attribute" style="font-size: smaller;">Kích thước:
                                                    <span class="size"
                                                        style="color: #333;">{{ $item->productDetail->size->tensize }}</span></span>,
                                                <span class="product-attribute" style="font-size: smaller;">Tồn kho:
                                                    <span class="soluongconlai"
                                                        style="color: #333;">{{ $item->soluongconlai }}</span></span>
                                            </p>

                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" width="250">
                                    @php
                                        $originalPrice = $item->product->dongia;
                                        $discountedPrice = $item->dongia;
                                    @endphp

                                    <del style="font-size: 14px;margin-right: 5px;">
                                        {{ number_format($originalPrice, 0, ',', ',') }}₫
                                    </del>
                                    {{ number_format($discountedPrice, 0, ',', ',') }}₫
                                </td>
                                <td class="align-middle" style="text-align: center;">
                                    <form id="updateQuantityForm-{{ $item->id }}"
                                        action="{{ route('cap-nhat-so-luong', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        <div class="input-group quantity mx-auto" style="width: 130px;">
                                            <div class="input-group-btn">
                                                <button @if ($item->soluong == 0) disabled @endif
                                                    class="btn btn-primary btn-minus" type="button"
                                                    data-id="{{ $item->id }}" data-price="{{ $item->dongia }}"
                                                    onclick="checkDisableBtnMinus(this)"
                                                    id="btn-minus-{{ $item->id }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control bg-secondary text-center input-quantity" name="soluong"
                                                value="{{ $item->soluong }}" data-id="{{ $item->id }}"
                                                data-price="{{ $item->dongia }}">

                                            <div class="input-group-btn">
                                                <button @if ($item->soluong == $item->soluongconlai || $item->soluongconlai == 0) disabled @endif
                                                    class="btn btn-primary btn-plus" type="button"
                                                    data-id="{{ $item->id }}" data-price="{{ $item->dongia }}"
                                                    onclick="checkDisableBtnPlus(this)" id="btn-plus-{{ $item->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </td>
                                <td class="align-middle total-price-{{ $item->id }}" style="color: #D19C97;"
                                    width="200">
                                    {{ number_format($item->dongia * $item->soluong, 0, ',', ',') }}₫
                                </td>

                                <td class="align-middle" width="200">
                                    <form id="deleteForm-{{ $item->id }}"
                                        action="{{ url('/cart', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                class="fa fa-times"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12">
                <div class="card border-secondary mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Phần chọn tất cả (10) và nút Xóa nằm ngang nhau -->
                                <div class="d-flex align-items-center mt-3">

                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body" id="modal-body">
                                            Bạn có muốn bỏ các sản phẩm đã chọn?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary custom-back-button"
                                                data-dismiss="modal">Trở lại</button>
                                            <button type="button"
                                                class="btn btn-secondary custom-white-button">Có</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Form mã giảm giá -->

                                <div class="d-flex justify-content-between mt-4">
                                    <h6 class="font-weight-bold" id="total-summary">Tổng thanh toán: </h6>
                                    <h5 class="font-weight-bold" id="total-price">
                                        {{ number_format($tong, 0, ',', ',') }}₫</h5>
                                </div>
                                <!-- Form Mua Ngay -->
                                <form id="checkoutForm" action="{{ route('checkout') }}" method="GET">
                                    <button type="d" class="btn btn-block btn-primary mt-3 py-3"
                                        id="checkoutButton">Mua ngay</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart End -->

    <script>
        // Hàm cập nhật tổng số tiền
        function updateTotalPrice() {
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-price'));
                }
            });
            totalPriceElement.textContent = total > 0 ? total.toLocaleString('vi-VN') + ' đ' : '0 đ';
        }
    </script>
    <script>
        // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
        function updateCartItemQuantity(input, newQuantity) {
            const id = input.getAttribute('data-id');
            const price = parseFloat(input.getAttribute('data-price'));

            // Cập nhật số lượng trong ô input
            input.value = newQuantity;

            // Gửi yêu cầu AJAX để cập nhật số lượng trên server
            fetch(`{{ url('update-cart') }}/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        soluong: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật giá tiền của sản phẩm
                        const totalPriceElement = document.querySelector(`.total-price-${id}`);
                        totalPriceElement.textContent = `${(newQuantity * price).toLocaleString()}₫`;

                        // Cập nhật tổng giá tiền sau khi cập nhật số lượng
                        // updateTotalPrice();
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật số lượng sản phẩm.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật số lượng sản phẩm.');
                });
        }

        function checkDisableBtnPlus(element) {
            const item_id = element.attributes['data-id']['nodeValue'];
            var soluong_conlai = @json($giohang).filter(item => item.id == item_id)[0]
                .soluongconlai;
            const input = element.parentNode.parentNode.querySelector('.input-quantity');
            $(`#btn-minus-${item_id}`).attr("disabled", false);
            if (soluong_conlai == 0 || parseInt(input.value) >= soluong_conlai) {
                element.disabled = true
            } else {
                element.disabled = false
                var newQuantity = parseInt(input.value) + 1;
                updateCartItemQuantity(input, newQuantity);

                //Disable luôn nút cộng nếu giá trị mới bằng số lượng còn lại
                if (newQuantity == soluong_conlai) {
                    element.disabled = true
                }
            }
        }

        function checkDisableBtnMinus(element) {
            const item_id = element.attributes['data-id']['nodeValue'];
            var soluong_conlai = @json($giohang).filter(item => item.id == item_id)[0]
                .soluongconlai;
            $(`#btn-plus-${item_id}`).attr("disabled", false);
            const input = element.parentNode.parentNode.querySelector('.input-quantity');
            if (soluong_conlai == 0 || input.value == 1) {
                element.disabled = true
            } else {
                element.disabled = false
                var newQuantity = parseInt(input.value) - 1;
                updateCartItemQuantity(input, newQuantity);

                //Disable luôn nút trừ nếu giá trị mới bằng 0
                if (newQuantity == 1) {
                    element.disabled = true
                }
            }
        }

        // Xử lý sự kiện khi thay đổi số lượng trực tiếp
        document.querySelectorAll('.input-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const newQuantity = Math.max(1, parseInt(this.value));
                updateCartItemQuantity(this, newQuantity);
            });
        });

        // Gọi hàm cập nhật tổng giá tiền khi tài liệu được tải
        document.addEventListener('DOMContentLoaded', (event) => {
            updateTotalPrice();
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button mà người dùng đã click để mở modal
                var itemId = button.data('itemid'); // Lấy ID của sản phẩm từ thuộc tính data-itemid

                // Gán action xóa cho nút "Có"
                var confirmButton = $(this).find('.btn-confirm-delete');
                confirmButton.data('itemid', itemId); // Gán lại itemid cho nút xác nhận

                // Xử lý khi người dùng nhấn nút "Có"
                confirmButton.click(function() {
                    var itemId = $(this).data('itemid');
                    var url = "{{ route('xoa-gio-hang', ':id') }}";
                    url = url.replace(':id', itemId);

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            alert('Sản phẩm đã được xóa khỏi giỏ hàng');
                            $('#confirmDeleteModal').modal(
                                'hide'); // Đóng modal sau khi xóa thành công
                            window.location.reload(); // Hoặc cập nhật giao diện tương ứng
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:',
                                error);
                            alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng');
                        });
                });
            });
        });
    </script>

@endsection
