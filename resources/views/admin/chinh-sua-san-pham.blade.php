@extends('layout.master_ad')

@section('title', 'Sửa sản phẩm | Quản trị viên')

@section('content')
    <style>
        .Choicefile {
            display: block;
            background: #14142B;
            border: 1px solid #fff;
            color: #fff;
            width: 150px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            padding: 5px 0px;
            border-radius: 5px;
            font-weight: 500;
            align-items: center;
            justify-content: center;
        }

        .Choicefile:hover {
            text-decoration: none;
            color: white;
        }

        #uploadfile,
        .removeimg {
            display: none;
        }

        #thumbbox {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .thumb {
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .thumb img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .removeimg {
            height: 25px;
            position: absolute;
            background-repeat: no-repeat;
            top: 5px;
            left: 5px;
            background-size: 25px;
            width: 25px;
            /* border: 3px solid red; */
            border-radius: 50%;

        }

        .removeimg::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            content: '';
            border: 1px solid red;
            background: red;
            text-align: center;
            display: block;
            margin-top: 11px;
            transform: rotate(45deg);
        }

        .thumb .removeimg {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            z-index: 10;
        }

        .thumb:hover .removeimg {
            display: block;
        }

        .checkbox-container {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 20;
        }

        .removeimg::after {
            /* color: #FFF; */
            /* background-color: #DC403B; */
            content: '';
            background: red;
            border: 1px solid red;
            text-align: center;
            display: block;
            transform: rotate(-45deg);
            margin-top: -2px;
        }

        .checkbox-container input[type="checkbox"] {
            position: relative;
            z-index: 30;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/quan-li-san-pham') }}">Danh sách sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/chinh-sua-san-pham' . $product->id) }}">Chỉnh sửa sản phẩm</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
                    <div class="tile-body">
                        <form class="row" action="{{ route('cap-nhat-san-pham', ['id' => $product->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group col-md-3">
                                <label class="control-label">Tên sản phẩm</label>
                                <input type="text" name="tensanpham" class="form-control"
                                    value="{{ $product->tensanpham }}" placeholder="Tên sản phẩm">
                                <div class="error-message">{{ $errors->first('tensanpham') }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Số lượng</label>
                                <input class="form-control" type="number" name="soluong" value="{{ $product->soluong }}"
                                    placeholder="Số lượng">
                                <div class="error-message">{{ $errors->first('soluong') }}</div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                <select id="inputState" name="trangthai" class="form-control">
                                    <option value="0" {{ $product->trangthai == 0 ? 'selected' : '' }}>Còn hàng
                                    </option>
                                    <option value="1" {{ $product->trangthai == 1 ? 'selected' : '' }}>Hết hàng
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleSelect1" class="control-label">Danh mục</label>
                                <select class="form-control" id="exampleSelect1" name="loaisp_id">
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $product->loaisp_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->tenloaisp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="exampleSelect1" class="control-label">Nhãn hiệu</label>
                                <select class="form-control" id="exampleSelect1" name="nhanhieu_id">
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $product->nh_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->tennhanhieu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Giá bán</label>
                                <input type="number" name="dongia" class="form-control" value="{{ $product->dongia }}"
                                    placeholder="Đơn giá">
                                <div class="error-message">{{ $errors->first('dongia') }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Giảm giá</label>
                                <input type="number" name="giamgia" class="form-control" value="{{ $product->giamgia }}"
                                    placeholder="Giảm giá">
                                <div class="error-message">{{ $errors->first('giamgia') }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Ảnh sản phẩm</label>
                                <div class="row" id="image-row">
                                    @foreach ($image as $item)
                                        <div class="col-md-2 mb-3 thumb" data-id="{{ $item->id }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $item->tenimage) }}" alt="Product Image"
                                                    class="img-fluid">
                                                <div class="checkbox-container">
                                                    <input type="checkbox" name="remove_images[]"
                                                        value="{{ $item->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Input cho phép chọn ảnh mới -->
                                <div id="boxchoice">
                                    <!-- Button chọn ảnh từ máy tính -->
                                    <label for="uploadfile" class="Choicefile"><i class="fas fa-cloud-upload-alt"></i> Chọn
                                        ảnh</label>
                                    <!-- Input hidden để chọn file -->
                                    <input type="file" id="uploadfile" name="image[]" onchange="previewImages(this);"
                                        multiple style="display: none;" />
                                    <!-- Thông báo lựa chọn ảnh -->
                                    <p style="clear:both"></p>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="mota" id="mota">{{ $product->mota }}</textarea>
                                <div class="error-message">{{ $errors->first('mota') }}</div>
                                <script>
                                    CKEDITOR.replace('mota');
                                </script>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Cập nhật</button>
                                <a class="btn btn-cancel" href="{{ url('/quan-li-san-pham') }}">Hủy bỏ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{--
    <script>
        // Hàm này được gọi khi người dùng chọn một file ảnh
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#thumbimage').attr('src', e.target.result); // Hiển thị ảnh đã chọn
                    $('#thumbimage').show(); // Hiển thị thẻ img
                };

                reader.readAsDataURL(input.files[0]); // Đọc nội dung file và chuyển thành URL dạng base64
            }
        }

        // Hàm này được gọi khi người dùng muốn xóa ảnh đã chọn
        function removeImage(element) {
            $(element).closest('.thumb').remove(); // Xóa thẻ cha của nút X (đại diện cho ảnh)
        }
    </script> --}}
    <script>
        function removeSelectedImages() {
            // Lấy danh sách các checkbox được chọn
            let checkboxes = document.querySelectorAll('#image-row input[type="checkbox"]:checked');

            // Lặp qua từng checkbox được chọn và xóa phần tử cha của nó (có class là 'thumb')
            checkboxes.forEach(checkbox => {
                let thumb = checkbox.closest('.thumb');
                if (thumb) {
                    let imageId = thumb.getAttribute('data-id');
                    thumb.remove();

                    // Xóa ảnh khỏi danh sách các ảnh cần xóa (nếu đã lưu vào input remove_images)
                    let removeImagesInput = document.querySelector('input[name="remove_images[]"][value="' +
                        imageId + '"]');
                    if (removeImagesInput) {
                        removeImagesInput.remove();
                    }
                }
            });
        }
    </script>
@endsection
