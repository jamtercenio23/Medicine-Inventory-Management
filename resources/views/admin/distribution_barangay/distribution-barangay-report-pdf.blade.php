<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribution for Barangay Report</title>
    <style>
        /* Add your custom styles for the PDF report here */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Mabini Health Center</h1>
    <h2>Distribution for Barangay Report</h2>
    <p>Date Range: {{ $fromDate }} to {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Barangay Name</th>
                <th>Medicine Name</th>
                <th>Stocks</th>
                <th>Distribution Date</th>
                <th>Created At</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $distribution_barangay)
                <tr>
                    <td>{{ $distribution_barangay->id }}</td>
                    <td>{{ $distribution_barangay->barangay->name }}</td>
                    <td>{{ $distribution_barangay->medicine->generic_name }} - {{ $distribution_barangay->medicine->brand_name }}</td>
                    <td>{{ $distribution_barangay->stocks }}</td>
                    <td>{{ $distribution_barangay->distribution_date }}</td>
                    <td>{{ $distribution_barangay->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
