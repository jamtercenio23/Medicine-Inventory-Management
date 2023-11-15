<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Out of Stock Report</title>
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
    <h2>Barangay Out of Stock Report</h2>
    <p>Date Range: {{ $fromDate }} to {{ $toDate }}</p>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Generic Name</th>
                <th>Brand Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Expiration Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $barangayMedicine)
                <tr>
                    <td>{{ $barangayMedicine->id }}</td>
                    <td>{{ $barangayMedicine->generic_name }}</td>
                    <td>{{ $barangayMedicine->brand_name }}</td>
                    <td>{{ $barangayMedicine->medicine->category->name }}</td>
                    <td>{{ $barangayMedicine->price }}</td>
                    <td>{{ $barangayMedicine->expiration_date }}</td>
                    <td>{{ $barangayMedicine->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
