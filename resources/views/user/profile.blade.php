@extends('layout.master')

@section('title', 'Thông Tin Khách Hàng')

@section('content')
    <style>
        .btn-bold {
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
    <!-- Profile Update Form -->
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4 text-center">THÔNG TIN NGƯỜI DÙNG</h4>
                        <div class="row">
                            <!-- Hàng đầu tiên -->
                            <div class="col-md-6 form-group">
                                <label>Họ tên</label>
                                <input class="form-control" type="text" name="hovaten" placeholder="Họ và tên"
                                    value="{{ Auth::user()->hovaten }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" name="sodienthoai" placeholder="Số điện thoại"
                                    value="{{ Auth::user()->sdt }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control" type="text" name="diachi" placeholder="Địa chỉ"
                                    value="{{ Auth::user()->diachi }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="email" placeholder="Email"
                                    value="{{ Auth::user()->email }}">
                            </div>
                            <!-- Hàng thứ hai -->
                            <div class="col-md-6 form-group">
                                <label>Giới tính</label>
                                <select class="form-control" name="gioitinh">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="Nam" {{ Auth::user()->gioitinh == 'Nam' ? 'selected' : '' }}>Nam
                                    </option>
                                    <option value="Nữ" {{ Auth::user()->gioitinh == 'Nữ' ? 'selected' : '' }}>Nữ
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Ngày sinh</label>
                                <input class="form-control" type="date" name="ngaysinh"
                                    value="{{ Auth::user()->ngaysinh }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Avatar và nút lưu -->
                            <div class="col-md-12 form-group">
                                <label for="avatar">Ảnh đại diện</label>
                                <input type="file" class="form-control-file" id="avatar" name="avatar"
                                    onchange="previewAvatar(this)">
                                @if (Auth::user()->avatar)
                                    <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        class="mt-2" style="max-width: 200px; max-height: 200px;" alt="Ảnh đại diện">
                                @else
                                    <img id="avatar-preview" src="{{ asset('path/to/default_avatar.jpg') }}" class="mt-2"
                                        style="max-width: 200px; max-height: 200px;" alt="Ảnh đại diện">
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-bold">CẬP NHẬT THÔNG
                                    TIN</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Cập nhật thông tin thành công'
                    });

                    // Cập nhật lại thông tin người dùng trên giao diện
                    $('input[name="hovaten"]').val(response.user.hovaten);
                    $('input[name="sodienthoai"]').val(response.user.sdt);
                    $('input[name="diachi"]').val(response.user.diachi);
                    $('input[name="email"]').val(response.user.email);
                    $('select[name="gioitinh"]').val(response.user.gioitinh);
                    $('input[name="ngaysinh"]').val(response.user.ngaysinh);

                    // Cập nhật ảnh đại diện nếu có thay đổi
                    $('#avatar-preview').attr('src', response.user.avatar ? '/storage/' + response.user
                        .avatar : '/path/to/default_avatar.jpg');
                },
                error: function(error) {
                    console.log('Error:', error);
                    // Xử lý lỗi nếu cần thiết
                }
            });
        });
    </script>
@endsection
