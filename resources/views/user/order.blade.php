@extends('layout.master')

@section('title', 'Đơn Hàng')

@section('content')
    <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="left-content">
                        <li><a href="/thong-tin-khach-hang">Thông tin tài khoản</a></li>
                        <li><a href="/don-hang">Đơn hàng của bạn</a></li>
                        <li><a href="/doi-mat-khau">Đổi mật khẩu</a></li>
                        <li><a href="/dia-chi">Sổ địa chỉ</a></li>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="right-content">
                        <h4>ĐƠN HÀNG CỦA BẠN</h4>
                        <table>
                            <thead class="thead-default">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên đơn hàng</th>
                                    <th>số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Địa chỉ</th>
                                    <th>TT thanh toán</th>
                                    <th>TT đơn hàng</th>
                                    <th>chức năng</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach ($donhang as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->cthdb->sanpham->tensanpham }}</td>
                                        <td>{{ $item->cthdb->soluong }}</td>
                                        <td>{{ $item->cthdb->thanhtien }}</td>
                                        <td>{{ $item->cthdb->diachi }}</td>
                                        <td>
                                            @if ($item->ttthanhtoan == 0)
                                                Chưa thanh toán
                                            @else
                                                Đã thanh toán
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->ttvanchuyen == 0)
                                                Shop đang chuẩn bị
                                            @elseif($item->ttvanchuyen == 1)
                                                Đang vận chuyển
                                            @elseif($item->ttvanchuyen == 2)
                                                Đã nhận được hàng
                                            @elseif($item->ttvanchuyen == 3)
                                                Đã hủy
                                            @elseif($item->ttvanchuyen == 4)
                                                Hoàn trả
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->ttvanchuyen == 0)
                                                <form action="{{ route('khach-hang.xu-li-huy-hang', ['id' => $item->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit">Hủy hàng</button>
                                                </form>
                                                <button disabled>Đã nhận được hàng</button>
                                                <button disabled>Hoàn trả</button>
                                            @elseif($item->ttvanchuyen == 1)
                                                <button disabled>Hủy hàng</button>
                                                <button disabled>Đã nhận được hàng</button>
                                                <button disabled>Hoàn trả</button>
                                            @elseif ($item->ttvanchuyen == 2 && $item->ttthanhtoan == 1)
                                                <button type="submit">Đánh giá</button>
                                                <button type="submit">Mua lại</button>
                                                <button type="submit">Hoàn trả</button>
                                            @elseif($item->ttvanchuyen == 5)
                                                <button type="submit" disabled>Đơn hàng hủy từ shop</button>
                                                <button type="submit">Mua lại</button>
                                            @elseif ($item->ttvanchuyen == 3)
                                                <button type="submit" disabled>Đã hủy đơn hàng</button>
                                                <button type="submit">Mua lại</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
