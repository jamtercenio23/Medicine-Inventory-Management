<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Distribution for Patient Report</title>
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
    <h2>Barangay Distribution for Patient Report</h2>
    <p>Date Range: {{ $fromDate }} to {{ $toDate }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Medicine Name</th>
                <th>Stocks</th>
                <th>Diagnose</th>
                <th>Checkup Date</th>
                <th>Created At</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>

            @foreach ($reportData as $barangayDistribution)
                @if (auth()->user()->isBHW() && $barangayDistribution->bhw_id != auth()->user()->id)
                    @continue
                @endif
                <tr>
                    <td>{{ $barangayDistribution->id }}</td>
                    <td>{{ $barangayDistribution->barangayPatient->first_name }}
                        {{ $barangayDistribution->barangayPatient->last_name }}</td>
                    <td>{{ $barangayDistribution->barangayMedicine->generic_name }} -
                        {{ $barangayDistribution->barangayMedicine->brand_name }}</td>
                    <td>{{ $barangayDistribution->stocks }}</td>
                    <td>{{ $barangayDistribution->diagnose }}</td>
                    <td>{{ $barangayDistribution->checkup_date }}</td>
                    <td>{{ $barangayDistribution->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
