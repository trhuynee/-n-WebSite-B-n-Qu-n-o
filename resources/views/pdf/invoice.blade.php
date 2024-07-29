<!DOCTYPE html>
<html>

<head>
    <title>Danh sách đơn hàng</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Danh sách đơn hàng</h1>
    <table>
        <thead>
            <tr>
                <th>ID đơn hàng</th>
                <th>Khách hàng</th>
                <th>Đơn hàng</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            @php
                $index = 0;
            @endphp
            @foreach ($orders as $order)
                @foreach ($order->orderdetail as $item)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $order->khachangorder->hovaten }}</td>
                        <td>{{ $item->product->tensanpham }}</td>
                        <td>{{ $item->soluong }}</td>
                        <td>{{ number_format($item->thanhtien) }} đ</td>
                        <td>{{ $order->orderstatus->value }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
