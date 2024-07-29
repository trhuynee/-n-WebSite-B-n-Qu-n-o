@extends('layout.master_ad')

@section('title', 'Thêm sản phẩm | Quản trị viên')

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

        .thumbimage {
            height: 200px;
            width: 150px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: block;
        }

        .removeimg {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;

        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/quan-li-san-pham') }}">Danh sách sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/them-san-pham') }}">Thêm sản phẩm</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới sản phẩm</h3>
                    <div class="tile-body">
                        <form class="row" action="{{ route('xu-li-them-san-pham') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="form-group col-md-3">
                                <label class="control-label">Mã sản phẩm </label>
                                <input class="form-control" type="text" name="masanpham" placeholder="Mã sản phẩm">
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label class="control-label">Tên sản phẩm</label>
                                <input type="text" name="tensanpham" class="form-control" placeholder="Tên sản phẩm">
                                <div class="error-message">{{ $errors->first('tensanpham') }}</div>
                            </div>
                            <div class="form-group  col-md-3">
                                <label class="control-label">Số lượng</label>
                                <input class="form-control" type="number" name="soluong" placeholder="Số lượng">
                                <div class="error-message">{{ $errors->first('soluong') }}</div>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="exampleSelect1" class="control-label">Tình trạng</label>
                                <select id="inputState" name="trangthai" class="form-control">
                                    <option>-- Chọn tình trạng --</option>
                                    <option value="0">Còn hàng</option>
                                    <option value="1">Hết hàng</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="exampleSelect1" class="control-label">Danh mục</label>
                                <select class="form-control" id="exampleSelect1" name="loaisp_id">
                                    <option>-- Chọn danh mục --</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->tenloaisp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 ">
                                <label for="exampleSelect1" class="control-label">Nhãn hiệu</label>
                                <select class="form-control" id="exampleSelect1" name="nh_id">
                                    <option>-- Chọn nhãn hiệu --</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->tennhanhieu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Giá bán</label>
                                <input type="number" name="dongia" class="form-control" placeholder="Đơn giá">
                                <div class="error-message">{{ $errors->first('dongia') }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Giảm giá</label>
                                <input type="number" name="giamgia" class="form-control" placeholder="Giảm giá">
                                <div class="error-message">{{ $errors->first('giamgia') }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Ảnh sản phẩm</label>
                                <div id="thumbbox">
                                    <!-- Khu vực hiển thị ảnh thumbnail trước khi upload -->
                                    <!-- Placeholder cho các ảnh sẽ được thêm vào sau -->
                                </div>
                                <div id="boxchoice">
                                    <!-- Button chọn ảnh từ máy tính -->
                                    <label for="uploadfile" class="Choicefile btn btn-primary"><i
                                            class="fas fa-cloud-upload-alt"></i> Chọn ảnh</label>
                                    <!-- Input hidden để chọn file -->
                                    <input type="file" id="uploadfile" name="image[]" onchange="previewImages(this);"
                                        multiple style="display: none;" />
                                    <!-- Thông báo lựa chọn ảnh -->
                                    <p style="clear:both"></p>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="mota" id="mota"></textarea>
                                <div class="error-message">{{ $errors->first('mota') }}</div>
                                <script>
                                    CKEDITOR.replace('mota');
                                </script>
                            </div>
                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Lưu lại</button>
                                <a class="btn btn-cancel" href="{{ url('/them-san-pham') }}">Hủy bỏ</a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Đoạn js hiển thị nhiều ảnh khi tạo sản phẩm -->
    <script>
        function previewImages(input) {
            var preview = document.querySelector('#thumbbox');
            preview.innerHTML = ''; // Xóa các ảnh trước đó trong khu vực hiển thị

            if (input.files) {
                var filesAmount = input.files.length;

                for (var i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgElement = document.createElement('img');
                        imgElement.setAttribute('src', event.target.result);
                        imgElement.setAttribute('height', '200');
                        imgElement.setAttribute('width', '150');
                        imgElement.classList.add('thumbimage');

                        var removeImgElement = document.createElement('a');
                        removeImgElement.classList.add('removeimg');
                        removeImgElement.setAttribute('href', 'javascript:');

                        removeImgElement.onclick = function() {
                            imgElement.remove();
                            removeImgElement.remove();
                        };

                        var container = document.createElement('div');
                        container.style.position = 'relative';
                        container.style.display = 'inline-block';
                        container.appendChild(imgElement);
                        container.appendChild(removeImgElement);

                        preview.appendChild(container);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }
    </script>



@endsection
