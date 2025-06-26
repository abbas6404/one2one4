<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $replySubject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
        .message {
            padding: 15px 0;
        }
        .original-message {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $replySubject }}</h2>
    </div>
    
    <div class="message">
        <p>Dear {{ $contact->name }},</p>
        
        {!! nl2br(e($replyMessage)) !!}
    </div>
    
    <div class="footer">
        <p>This is an automated response from One2One4 Blood Donation. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} One2One4 Blood Donation. All rights reserved.</p>
    </div>
</body>
</html> 