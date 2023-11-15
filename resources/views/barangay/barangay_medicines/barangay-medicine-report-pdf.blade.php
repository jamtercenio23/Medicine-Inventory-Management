<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Medicine Report</title>
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

        th,
        td {
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
    <h2>Barangay Medicine Report</h2>
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
            @foreach ($reportData as $barangayMedicine)
                <tr>
                    <td>{{ $barangayMedicine->id }}</td>
                    <td>{{ $barangayMedicine->generic_name }}</td>
                    <td>{{ $barangayMedicine->brand_name }}</td>
                    <td>{{ $barangayMedicine->medicine->category->name }}</td>
                    <td>{{ $barangayMedicine->stocks }}</td>
                    <td>{{ $barangayMedicine->price }}</td>
                    <td>{{ $barangayMedicine->expiration_date }}</td>
                    <td>{{ $barangayMedicine->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
