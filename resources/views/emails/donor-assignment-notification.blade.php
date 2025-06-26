<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #e74c3c;
            margin: 0;
            font-size: 24px;
        }
        .blood-type {
            font-size: 28px;
            font-weight: bold;
            color: #e74c3c;
            text-align: center;
            margin: 20px 0;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .details h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            color: #e74c3c;
        }
        .details p {
            margin: 8px 0;
        }
        .details strong {
            font-weight: bold;
        }
        .button {
            display: block;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px auto;
            width: 200px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .contact-info {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Blood Donation Assignment</h1>
            <p>Thank you for being a registered donor with One2One4 Blood Donation!</p>
        </div>

        <p>Dear <strong>{{ $donor->name }}</strong>,</p>

        <p>You have been assigned as a donor for a blood request. Your donation is urgently needed and can save a life!</p>

        <div class="blood-type">
            Blood Type: {{ $bloodRequest->blood_type }}
        </div>

        <div class="details">
            <h3>Request Details</h3>
            <p><strong>Patient Name:</strong> {{ $bloodRequest->patient_name }}</p>
            <p><strong>Hospital:</strong> {{ $bloodRequest->hospital_name }}</p>
            <p><strong>Location:</strong> {{ $bloodRequest->hospital_address }}</p>
            <p><strong>Needed By:</strong> {{ $bloodRequest->needed_date ? $bloodRequest->needed_date->format('F d, Y') : 'As soon as possible' }}</p>
            <p><strong>Urgency Level:</strong> {{ ucfirst($bloodRequest->urgency_level) }}</p>
        </div>

        <div class="details">
            <h3>Requester Contact Information</h3>
            <p><strong>Name:</strong> {{ $requester->name }}</p>
            <p><strong>Phone:</strong> {{ $requester->phone }}</p>
            <p><strong>Email:</strong> {{ $requester->email }}</p>
        </div>

        <p>Please contact the requester as soon as possible to coordinate the donation process. You can also view the details in your donor dashboard.</p>

        <a href="{{ url('/frontend/dashboard') }}" class="button">View in Dashboard</a>

        <div class="contact-info">
            <p>If you have any questions or need assistance, please contact us:</p>
            <p>Email: info@one2one4.org | Phone: +880 123 456 7890</p>
        </div>

        <div class="footer">
            <p>Thank you for your generosity and commitment to saving lives.</p>
            <p>&copy; {{ date('Y') }} One2One4 Blood Donation. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 