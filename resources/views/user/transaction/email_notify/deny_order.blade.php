<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng bị từ chối</title>
</head>
<body>
<p>Xin chào {{$transaction->customer_name}}</p>
<p>Đơn hàng: <b>{{$transaction->code}}</b> đã bị từ chối.</p>
Rất vui lòng được giao dịch với bạn vào lần sau!
</body>
</html>