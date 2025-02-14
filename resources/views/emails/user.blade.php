<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Bergabung!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 22px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            color: #555555;
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        Selamat Bergabung di Perusahaan Kami!
    </div>

    <div class="content">
        <h2>Halo, {{ $user->nama }}!</h2>
        <p>
            Kami dengan senang hati menyambut Anda sebagai bagian dari tim kami.
        </p>

        <p>
            Anda bergabung sebagai <strong>{{ $user->username }}</strong>
        </p>

        <p>
            Email anda <strong>{{ $user->email }}</strong>
        </p>

        <p>
            No. WhatsApp Anda <strong>{{ $user->whatsapp }}</strong>.
        </p>

        <p>
            Kami berharap Anda dapat memberikan kontribusi terbaik dan berkembang bersama kami.
            Jika ada pertanyaan, jangan ragu untuk menghubungi tim HRD kami.
        </p>

        <a href="https://yourcompany.com" class="button">Kunjungi Website</a>
    </div>

    <div class="footer">
        &copy; 2025 Your Company. All rights reserved.
    </div>
</div>

</body>
</html>
