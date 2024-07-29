<style>
    .user-menu {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .user-menu .user-menu-items {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 120px;
        /* Điều chỉnh chiều rộng tối thiểu của menu */
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 10px;
        /* Bo viền tròn cho toàn bộ menu */
        overflow: hidden;
        padding: 5px 0;
        /* Điều chỉnh khoảng cách bên trong menu */
        text-align: center;
    }

    .user-menu:hover .user-menu-items {
        display: block;
    }

    .user-menu-items a {
        color: black;
        padding: 8px 16px;
        /* Điều chỉnh khoảng cách của các mục trong menu */
        text-decoration: none;
        display: block;
    }

    .user-menu-items a:hover {
        background-color: #f0f0f0;
        /* Đổi màu nền khi hover */
    }

    .navbar-vertical {
        width: calc(100% - 30px);
        /* Đảm bảo chiều rộng */
        z-index: 10;
    }

    .navbar-nav a {
        padding: 10px 15px;
    }
</style>

<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="{{ route('trang-chu-user') }}" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border px-3 mr-1">E</span>StyleVista</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="{{ route('tim-kiem-khach-hang') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-3 col-6 text-right">
            <a href="{{ url('/cart') }}" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge">{{ $cartCount }}</span>
            </a>
            <a href="{{ url('/wishlist') }}" class="btn border">
                <i class="fa fa-heart mr-1 text-primary"></i>
                <span class="badge">{{ $WishlistCount }}</span>
            </a>


            {{-- <a href="" class="btn border">
                <i class="far fa-heart text-primary"></i>
                <span class="badge"></span>
            </a> --}}
            @if (Auth::check())
                <a href="#" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
                <div class="nav-item nav-link user-menu">

                    <span class="user-name">{{ Auth::user()->hovaten }}</span>
                    <div class="user-menu-items">
                        <a class="nav-item" href="{{ route('profile') }}">Tài khoản</a>
                        <a class="nav-item" href="{{ route('billUser') }}">Đơn mua</a>
                        <a class="nav-item" href="{{ route('dang-xuat') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng xuất
                        </a>

                        <form id="logout-form" action="{{ route('dang-xuat') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('auth') }}" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
            @endif
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" data-target="#navbar-vertical"
                style="height: 65px; margin-top: -1px; padding: 0 40px; width:">
                <h6 class="m-0">DANH MỤC</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 10; ">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 420px">
                    @foreach ($categories as $category)
                        <a href="{{ route('trang-loai', ['id' => $category->id]) }}"
                            class="nav-item nav-link">{{ $category->tenloaisp }}</a>
                    @endforeach
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>StyleVista</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ url('/') }}" class="nav-item nav-link">TRANG CHỦ</a>
                        <a href="{{ url('/shop') }}" class="nav-item nav-link">SẢN PHẨM</a>
                        <a href="{{ url('/intro') }}" class="nav-item nav-link">GIỚI THIỆU</a>
                        <a href="{{ url('/contact') }}" class="nav-item nav-link">LIÊN HỆ</a>
                    </div>

                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
