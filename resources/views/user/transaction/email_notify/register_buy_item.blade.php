<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký mua hàng thành công</title>
</head>
<body>
<p>Xin chào {{$transaction->customer_name}}</p>
<p>Bạn đã đăng ký mua hàng thành công tại 24hSchool của chúng tôi.</p>
<p>Dưới đây là mã số đơn hàng của bạn: <b>{{$transaction->code}}</b></p>
</body>
</html>