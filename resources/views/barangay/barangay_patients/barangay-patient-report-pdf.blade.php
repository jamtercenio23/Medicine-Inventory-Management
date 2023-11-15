<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Patient Report</title>
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
    <h2>Barangay Patient Report</h2>
    <p>Date Range: {{ $fromDate }} to {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birthdate</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $barangayPatient)
                <tr>
                    <td>{{ $barangayPatient->id }}</td>
                    <td>{{ $barangayPatient->first_name }}</td>
                    <td>{{ $barangayPatient->last_name }}</td>
                    <td>{{ $barangayPatient->birthdate }}</td>
                    <td>{{ $barangayPatient->age }}</td>
                    <td>{{ $barangayPatient->gender }}</td>
                    <td>{{ $barangayPatient->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
