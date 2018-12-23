<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Giao dịch thành công</title>
</head>
<body>
<p>Xin chào {{$transaction->customer_name}}</p>
<p>Giao dịch thành công</p>
<p>Dưới đây là mã số đơn hàng của bạn: <b>{{$transaction->code}}</b></p>
</body>
</html>