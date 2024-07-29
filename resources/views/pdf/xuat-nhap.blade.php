<!DOCTYPE html>
<html>

<head>
    <title>Báo cáo Xuất Nhập Tồn</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>SẢN PHẨM NHẬP</h2>
    <table>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá tiền</th>
                <th>Danh mục</th>
            </tr>
        </thead>
        <tbody>
            @php
            $index = 0;
            @endphp
            @foreach ($sanPhamNhap as $item )
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->tensanpham }}</td>
                <td>{{ $item->dongia }}</td>
                <td>{{ $item->soluong }} sản phẩm</td>
            </tr>
            @endforeach
        </tbody>
        </tbody>
    </table>

    <h2>SẢN PHẨM XUẤT</h2>
    <table>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @php
            $index = 0;
            @endphp
            @foreach ($sanPhamXuat as $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->orderdetail[0]->product->tensanpham }}</td>
                <td>{{ $item->orderdetail[0]->product->dongia }}</td>
                <td>{{ $item->orderdetail[0]->soluong }} sản phẩm</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>TỒN KHO</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php
                $index = 0;
                @endphp
                @foreach ($tonKho as $item)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $item->tensanpham }}</td>
                <td>{{ $item->dongia }}</td>
                <td>{{ $item->soluong }} sản phẩm</td>
            </tr>
            @endforeach
            </tr>
        </tbody>
    </table>
</body>

</html>