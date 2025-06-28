<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event ? $event->title . ' - ' : '' }}Internal Program Registrations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            width: calc(33% - 20px);
            box-sizing: border-box;
        }
        .stat-box h3 {
            margin-top: 0;
            font-size: 14px;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .print-date {
            text-align: right;
            margin-bottom: 20px;
            font-style: italic;
        }
        @media print {
            body {
                padding: 0;
                margin: 15mm;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $event ? $event->title . ' - ' : '' }}Internal Program Registrations</h1>
        @if($event)
            <p>Event Date: {{ $event->start_date->format('d M, Y') }} {{ $event->end_date ? ' to ' . $event->end_date->format('d M, Y') : '' }}</p>
            <p>Location: {{ $event->location }}</p>
        @endif
    </div>
    
    <div class="print-date">
        Printed on: {{ now()->format('d M, Y h:i A') }}
    </div>
    
    <div class="stats-container">
        <div class="stat-box">
            <h3>Total Registrations</h3>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Pending</h3>
            <div class="stat-value">{{ $stats['pending'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Approved</h3>
            <div class="stat-value">{{ $stats['approved'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Rejected</h3>
            <div class="stat-value">{{ $stats['rejected'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Total Approved Payment</h3>
            <div class="stat-value">৳ {{ number_format($stats['total_approved_payment'], 2) }}</div>
        </div>
        <div class="stat-box">
            <h3>Total Payment</h3>
            <div class="stat-value">৳ {{ number_format($stats['total_payment'], 2) }}</div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>T-Shirt Size</th>
                <th>Location</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>TRX ID</th>
                <th>Status</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $registration)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->blood_group }}</td>
                    <td>{{ $registration->tshirt_size }}</td>
                    <td>
                        {{ optional($registration->division())->name ?? '' }} / 
                        {{ optional($registration->district())->name ?? '' }} / 
                        {{ optional($registration->upazila)->name ?? '' }}
                    </td>
                    <td>{{ $registration->payment_method }}</td>
                    <td>৳ {{ number_format($registration->payment_amount, 2) }}</td>
                    <td>{{ $registration->trx_id }}</td>
                    <td>
                        @if($registration->status == 'pending')
                            <span style="color: #f39c12;">Pending</span>
                        @elseif($registration->status == 'approved')
                            <span style="color: #27ae60;">Approved</span>
                        @elseif($registration->status == 'rejected')
                            <span style="color: #e74c3c;">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $registration->created_at->format('d M, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">No registrations found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Generated from One2One4 Admin Panel</p>
    </div>
    
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Print This Page</button>
        <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; margin-left: 10px;">Close</button>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html> 