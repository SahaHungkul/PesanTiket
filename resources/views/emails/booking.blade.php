<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Terima kasih telah booking!</h1>
    <p>Event: {{ $booking->event->judul }}</p>
    <p>Jumlah tiket: {{ $booking->jumlah }}</p>
    <p>Kode booking: <strong>{{ $booking->kode_booking }}</strong></p>
</body>

</html>
