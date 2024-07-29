@extends('layout.master')

@section('title', 'Danh sách yêu thích')
@section('content')
    <div class="container">
        <h2 class="mb-4">Danh sách yêu thích</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Xem chi tiết</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wishlistItems as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->product->image[0]->tenimage) }}" alt="Product Image"
                                style="width: 80px; height: 80px; object-fit: contain;">
                        </td>
                        <td>
                            <p>{{ $item->product->tensanpham }}</p>
                            <p>{{ number_format($item->product->dongia, 0, ',', ',') }}₫</p>
                        </td>
                        <td>
                            <a href="{{ url('/detail', ['id' => $item->product->id]) }}" class="btn btn-primary">Xem chi
                                tiết</a>
                        </td>
                        <td>
                            <form id="deleteForm-{{ $item->id }}"
                                action="{{ url('/wishlist/remove', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
