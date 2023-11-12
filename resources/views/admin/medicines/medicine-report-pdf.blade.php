<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Report</title>
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
    <h2>Medicine Report</h2>
    <p>Date Range: {{ $fromDate }} to {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Generic Name</th>
                <th>Brand Name</th>
                <th>Category</th>
                <th>Stocks</th>
                <th>Price</th>
                <th>Expiration Date</th>
                <th>Created_at</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $medicine)
                <tr>
                    <td>{{ $medicine->id }}</td>
                    <td>{{ $medicine->generic_name }}</td>
                    <td>{{ $medicine->brand_name }}</td>
                    <td>{{ $medicine->category->name }}</td>
                    <td>{{ $medicine->stocks }}</td>
                    <td>{{ $medicine->price }}</td>
                    <td>{{ $medicine->expiration_date }}</td>
                    <td>{{ $medicine->created_at }}</td>
                    <!-- Add more cells based on your Medicine model properties -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
