<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquery</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Print styles */
        @media print {
            .btn {
                display: none; /* Hide buttons during print */
            }
            table {
                border: 1px solid #000;
            }
            th, td {
                border: 1px solid #000;
            }
            th {
                background-color: #ddd; /* Lighter background for header on print */
            }
            body {
                margin: 0; /* Remove margin for print */
                padding: 0;
            }
            h1 {
                margin-top: 0; /* Remove margin for print */
            }
        }
    </style>
</head>
<body>
    <h1>Inquery Report</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Vehicle</th>
                <th>Year</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $key => $record)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ ucwords($record->name) }}</td>
                    <td>{{ $record->vehicle }}</td>
                    <td>{{ $record->year }}</td>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
