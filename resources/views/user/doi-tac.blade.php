@extends('layout.master')

@section('title', 'Giới thiệu')

@section('content')
    <!-- ***** Services Area Starts ***** -->
    <section class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="service-item text-center">
                        <a href="https://yame.vn/" class="text-primary" target="_blank">
                            <h4>Yame</h4>
                        </a>
                        <img src="{{ asset('img/8.png') }}" alt="Ảnh giới thiệu 2" style="max-width: 600px;">

                    </div>
                    <div class="service-item text-center">
                        <a href="https://benandtod.com/" class="text-primary" target="_blank">
                            <h4>Ben&Tod</h4>
                        </a>
                        <img src="{{ asset('img/9.png') }}" alt="Ảnh giới thiệu 2" style="max-width: 600px;">
                    </div>
                    <div class="service-item text-center">
                        <a href="https://somehow.vn/" class="text-primary" target="_blank">
                            <h4>Somehow</h4>
                        </a>
                        <img src="{{ asset('img/10.png') }}" alt="Ảnh giới thiệu 2" style="max-width: 600px;">

                    </div>
                    <div class="service-item text-center">
                        <a href="https://chuottrang.vn/" class="text-primary" target="_blank">
                            <h4>Chuột trắng</h4>
                        </a>
                        <img src="{{ asset('img/11.png') }}" alt="Ảnh giới thiệu 2" style="max-width: 200px;">

                    </div>
                    <div class="service-item text-center">
                        <a href="https://www.uniqlo.com/vn/vi/" class="text-primary" target="_blank">
                            <h4>Uniqlo</h4>
                        </a>
                        <img src="{{ asset('img/7.png') }}" alt="Ảnh giới thiệu 2" style="max-width: 100px;">

                    </div>
                </div>

            </div>
        </div>

        </div>
    </section>
    <!-- ***** Services Area Ends ***** -->
@endsection
