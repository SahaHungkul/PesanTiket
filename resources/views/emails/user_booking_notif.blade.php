<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Booking di konfirmasi</h1>
    <br>
    <p>Kode Booking: {{ $booking->$kode_booking }} </p>
    <p>User: {{ $booking->user->name }} ({{ $booking->user->email }}) </p>
    <p>Event: {{ $booking->event->name }} </p>
    <p>Jumlah Tiket: {{ $booking->jumlah }} </p>
    <p>Total Harga: RP.{{ number_format($booking->total_price,0,',','.') }} </p>

    <p>Terima kasih telah melakukan booking di sistem kami.</p>
</body>
</html>
