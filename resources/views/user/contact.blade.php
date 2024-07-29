@extends('layout.master')

@section('title', 'Liên Hệ')

@section('content')

    <!-- Page Header Start -->
    {{-- <div class="container-fluid  mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <img src="img/1.png" alt="" style="width:100%; height:400px;object-fit: cover;">
        </div>
    </div> --}}
    <!-- Page Header End -->
    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Liên Hệ</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <h5 class="font-weight-semi-bold mb-3">Chăm sóc khách hàng</h5>
                <p>Chúng tôi cam kết cung cấp dịch vụ chăm sóc khách hàng tốt nhất để đáp ứng mọi nhu cầu của bạn. Hãy để
                    chúng tôi giúp đỡ bạn!</p>
                <div class="d-flex align-items-center">
                    <i class="fa fa-envelope text-primary mr-2"></i>
                    <a href="https://forms.gle/o6huqcAoBiecwrNs5" class="text-primary" target="_blank">Hãy nhấn vào đây để
                        phản hồi hoặc đóng góp ý kiến!</a>
                </div>
            </div>

            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">Hãy liên hệ với chúng tôi</h5>
                <p>Đừng ngần ngại liên hệ với chúng tôi nếu bạn cần bất kỳ sự trợ giúp nào. Chúng tôi luôn ở đây để lắng
                    nghe và hỗ trợ bạn!</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Cửa hàng </h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>65 Huỳnh Thúc Kháng, Quận 1,
                        TP.Hồ Chí Minh</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>stylevistashop@gmail.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>(+84) 387236892</p>
                </div>
                {{-- <div class="d-flex flex-column">
                    <h5 class="font-weight-semi-bold mb-3">Cửa hàng 2</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Địa chỉ 2</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>Email 1</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>SĐT 2</p>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
