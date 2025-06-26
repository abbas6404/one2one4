<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Assigned to Your Blood Request</title>
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
        .progress {
            background-color: #f9f9f9;
            border-radius: 4px;
            height: 20px;
            margin: 20px 0;
            overflow: hidden;
        }
        .progress-bar {
            background-color: #e74c3c;
            height: 100%;
            text-align: center;
            color: white;
            font-weight: bold;
            line-height: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Donor Assigned to Your Blood Request</h1>
            <p>Good news! A donor has been assigned to your blood request.</p>
        </div>

        <p>Dear <strong>{{ $requester->name }}</strong>,</p>

        <p>We're pleased to inform you that a donor has been assigned to your blood request for <strong>{{ $bloodRequest->patient_name }}</strong>.</p>

        <div class="blood-type">
            Blood Type: {{ $bloodRequest->blood_type }}
        </div>

        <div class="details">
            <h3>Request Progress</h3>
            <p><strong>Units Requested:</strong> {{ $bloodRequest->units_needed }}</p>
            <p><strong>Donors Assigned:</strong> {{ $bloodRequest->donations->count() }} of {{ $bloodRequest->units_needed }}</p>
            
            <div class="progress">
                <div class="progress-bar" style="width: {{ ($bloodRequest->donations->count() / $bloodRequest->units_needed) * 100 }}%">
                    {{ round(($bloodRequest->donations->count() / $bloodRequest->units_needed) * 100) }}%
                </div>
            </div>
        </div>

        <div class="details">
            <h3>Donor Information</h3>
            <p><strong>Name:</strong> {{ $donor->name }}</p>
            <p><strong>Phone:</strong> {{ $donor->phone }}</p>
            <p><strong>Email:</strong> {{ $donor->email }}</p>
            <p><strong>Blood Type:</strong> {{ $donor->blood_group }}</p>
        </div>

        <p>Please contact the donor as soon as possible to coordinate the donation process. You can also view all assigned donors in your dashboard.</p>

        <a href="{{ url('/frontend/blood-requests/assigned-donors/' . $bloodRequest->id) }}" class="button">View Assigned Donors</a>

        <div class="contact-info">
            <p>If you have any questions or need assistance, please contact us:</p>
            <p>Email: info@one2one4.org | Phone: +880 123 456 7890</p>
        </div>

        <div class="footer">
            <p>Thank you for using One2One4 Blood Donation platform.</p>
            <p>&copy; {{ date('Y') }} One2One4 Blood Donation. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 