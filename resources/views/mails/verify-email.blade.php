<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            margin: 0;
            color: #333333;
        }
        .content {
            text-align: center;
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }
        .otp {
            display: inline-block;
            margin: 20px 0;
            padding: 15px 25px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            background-color: #f0f0f0;
            border-radius: 8px;
            color: #333333;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Sh-api Email Verification</h2>
        </div>
        <div class="content">
            <p>Use the following verification code to verify your email address:</p>
            <div class="otp">{{ $code }}</div>
            <p>This code will expire in {{ $expiresIn }} minutes.</p>
            <p>If you did not request this, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>