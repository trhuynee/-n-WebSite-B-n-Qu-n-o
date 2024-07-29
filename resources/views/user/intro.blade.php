@extends('layout.master')

@section('title', 'Trang Chủ')

@section('content')
    <style>
        h4 {
            text-align: center;
        }
    </style>
    <!-- ***** Services Area Starts ***** -->
    <section class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="service-item">
                        <h4>Giới thiệu về STYLE VISTA </h4>
                        <span>STYLE VISTA hướng tới việc trở thành điểm đến hàng đầu cho người tiêu dùng đam mê thời trang,
                            cung cấp sự đa dạng, chất lượng, và trải nghiệm mua sắm trực tuyến tiện lợi. Tầm nhìn của STYLE
                            VISTA là trở thành một cộng đồng thời trang trực tuyến, nơi mọi người có thể tìm thấy không chỉ
                            sản phẩm tốt nhất mà còn là nguồn cảm hứng thời trang.</span>
                    </div>
                    <div class="service-item">
                        <h4>Chính Sách Bảo Hành</h4>
                        <p>STYLE VISTA cam kết cung cấp sản phẩm chất lượng cao. Thời gian bảo hành cơ bản là 12 tháng kể từ
                            ngày mua hàng. Tuy nhiên, có thể có chính sách bảo hành khác nhau cho từng loại sản phẩm, vui
                            lòng kiểm tra chi tiết trên trang sản phẩm hoặc liên hệ với bộ phận chăm sóc khách hàng để biết
                            thêm thông tin.</p>
                    </div>
                    <div class="service-item">
                        <h4>Chính Sách Đổi Trả</h4>
                        <p>Thời Gian Đổi Trả: Khách hàng có quyền đổi trả sản phẩm trong vòng 30 ngày kể từ ngày mua hàng.
                        </p>
                        <p>Điều Kiện Đổi Trả:

                            Sản phẩm chưa sử dụng.
                            Bao bì nguyên vẹn và giữ lại tất cả phụ kiện.</p>
                        <p>Quy Trình Đổi Trả:

                            Liên hệ Chăm Sóc Khách Hàng để bắt đầu quy trình.
                            Xác nhận yêu cầu và nhận hướng dẫn đổi trả.
                            Gửi sản phẩm trở lại theo hướng dẫn nhận được.</p>
                    </div>
                    <div class="service-item">
                        <h4>Chăm Sóc Khách Hàng</h4>
                        <p>Chúng tôi tự hào với đội ngũ chăm sóc khách hàng chuyên nghiệp và tận tâm. Nhân viên chăm sóc
                            khách hàng của chúng tôi được đào tạo để cung cấp trải nghiệm mua sắm tốt nhất và giải quyết mọi
                            vấn đề của khách hàng.</p>
                    </div>
                    <div class="service-item">
                        <h4>Vận Chuyển</h4>
                        <img src="{{ asset('img/6.png') }}" alt="Ảnh giới thiệu 2" class="img-fluid mx-auto d-block mb-3"
                            style="max-width: 600px;">

                    </div>
                    <div class="service-item">
                        <h4>Lời Cám Ơn</h4>
                        <p>Chúng tôi xin gửi lời cám ơn sâu sắc và chân thành đến quý khách hàng đã ủng hộ chúng tôi. Sự tin
                            tưởng và lòng quý mến của bạn là động lực quan trọng, giúp chúng tôi không ngừng nỗ lực để mang
                            đến
                            những sản phẩm/dịch vụ tốt nhất.</p>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </section>
    <!-- ***** Services Area Ends ***** -->
@endsection
