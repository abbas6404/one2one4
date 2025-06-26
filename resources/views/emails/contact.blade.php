<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            padding: 20px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
        }
        .header {
            background-color: #a51c1c;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px;
        }
        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Message</h1>
        </div>
        
        <p>You have received a new message from your website's contact form.</p>
        
        <div class="field">
            <span class="field-label">Name:</span>
            {{ $name }}
        </div>
        
        <div class="field">
            <span class="field-label">Email:</span>
            {{ $email }}
        </div>
        
        @if(isset($phone) && $phone)
        <div class="field">
            <span class="field-label">Phone:</span>
            {{ $phone }}
        </div>
        @endif
        
        <div class="field">
            <span class="field-label">Subject:</span>
            {{ $subject }}
        </div>
        
        <div class="message-content">
            <span class="field-label">Message:</span>
            <p>{{ $message }}</p>
        </div>
        
        <div class="footer">
            <p>This email was sent from the One2One4 contact form.</p>
        </div>
    </div>
</body>
</html> 