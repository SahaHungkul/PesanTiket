<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
        }

        h1 {
            color: #2c3e50;
            font-size: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        td {
            padding: 8px 5px;
            border-bottom: 1px solid #eee;
        }

        td.label {
            font-weight: bold;
            width: 35%;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Booking Dikonfirmasi</h1>

        <p>Halo <strong>{{ $booking->user->name }}</strong>,</p>
        <p>Terima kasih telah melakukan booking. Berikut detail pemesanan Anda:</p>

        <table>
            <tr>
                <td class="label">Kode Booking</td>
                <td>{{ $booking->kode_booking }}</td>
            </tr>
            <tr>
                <td class="label">Event</td>
                <td>[{{ $booking->event->id }}] {{ $booking->event->judul }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Tiket</td>
                <td>{{ $booking->jumlah }}</td>
            </tr>
            <tr>
                <td class="label">Total Harga</td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <p class="footer">
            Simpan kode booking Anda sebagai bukti.
            Email ini otomatis dikirim, mohon tidak membalas.
        </p>
    </div>
</body>

</html>
