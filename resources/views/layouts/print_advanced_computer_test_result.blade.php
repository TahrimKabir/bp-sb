<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Exam Result</title>
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> <!-- Font Awesome for icons -->
    <style>
        /* General styles for printing */
        @media print {
            /* Hide buttons and unnecessary elements */
            .no-print {
                display: none !important;
            }

            /* Ensure proper margins */
            body {
                margin: 20px;
                font-size: 14px;
            }

            /* Ensure tables take full width and are styled well */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding: 8px;
                text-align: left;
            }

            h3, p {
                text-align: center;
                margin: 10px 0;
            }
        }

        /* Styles for on-screen view */
        .container {
            margin: 20px;
        }

        table {
            margin-top: 20px;
            width: 100%;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Top Print Button Styles */
        .print-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .print-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn i {
            margin-right: 5px;
        }

        .print-btn:hover {
            background-color: #218838;
        }

        .print-btn:focus {
            outline: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Print Button at the top -->
        <div class="print-btn-container no-print">
            <button onclick="window.print()" class="print-btn">
                <i class="fas fa-print"></i> Print this page
            </button>
        </div>

        @yield('content')
    </div>

</body>
</html>
