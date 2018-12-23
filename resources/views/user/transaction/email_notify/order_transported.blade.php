<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng đang được vận chuyển</title>
</head>
<body>
<p>Xin chào {{$transaction->customer_name}}</p>
<p>Đơn hàng của bạn đang được vận chuyển đến cho bạn.</p>
<p>Hoàn tất các bước thanh toán để nhận được sản phẩm</p>
<p>Dưới đây là mã số đơn hàng của bạn: <b>{{$transaction->code}}</b></p>
</body>
</html>