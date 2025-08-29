<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Booking baru telah dilakukan:</h1>

    <p>Kode Booking : {{ $booking->kode_booking }}</p>
    <p>User : {{ $booking->user->name }} ({{ $booking->user->email }})</p>
    <p>Event : {{ $booking->event->name }}</p>
    <p>Jumlah Tiket : {{ $booking->jumlah }}</p>
    <p>Total Harga : Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

    <p>Silakan cek sistem untuk detail lebih lanjut.</p>

</body>

</html>
