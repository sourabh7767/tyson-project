<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Team Apex</title>
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light Blue Background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h1 {
            color: #007BFF; /* Blue Text Color */
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Team Apex</h1>
        <p>Dear {{$details['full_name']}},</p>
        <p>Your Team Apex account has been created successfully. Here are your login details:</p>
        <ul>
            <li><strong>Email:</strong> {{$details['email']}},</li>
            <li><strong>Password:</strong> {{$details['password']}},</li>
        </ul>
        <p>We recommend changing your password after your first login for security purposes.</p>
        <p>Thank you for joining Team Apex. If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        <p>Best regards,<br>Team Apex</p>
    </div>
</body>
</html>