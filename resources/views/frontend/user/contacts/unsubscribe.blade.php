<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Unsubscribe</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .unsubscribe-container {
            max-width: 600px;
            margin: 80px auto;
            background: #ffffff;
            padding: 40px;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .unsubscribe-container h1 {
            color: #ed1c24;
            font-size: 28px;
            font-weight: normal;
            margin-bottom: 20px;
        }

        .unsubscribe-container p {
            color: #555;
            font-size: 15px;
            line-height: 1.6;
        }

        .email {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>

<div class="unsubscribe-container">

    <h1>You have been unsubscribed</h1>

    <p>
        <span class="email">
            {{ $contact->contact_email }}
        </span>
    </p>

    <p>
        You will no longer receive marketing emails from us.
    </p>

    <p>
        If you unsubscribed by mistake, please contact us.
    </p>

</div>

</body>
</html>