<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->short_ulid }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, 'sans-serif';
            color: #374151;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f3f4f6;
            padding: 40px;
            line-height: 1.6;
        }

        .invoice-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 40px;
            width: 90%;
            margin: 0 auto;
        }

        table {
            font-size: 14px;
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
        }

        td, th {
            padding: 16px;
            border-bottom: 1px solid #f1f1f1;
        }

        th {
            background-color: #f9fafb;
            color: #111827;
            font-weight: bold;
            text-align: left;
        }

        .header-table {
            margin-bottom: 48px;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }

        .company-details {
            text-align: right;
        }

        .company-details h3 {
            color: #111827;
            font-size: 32px;
            font-weight: bold;
        }

        .company-details h4 {
            color: #111827;
            font-size: 16px;
            font-weight: bold;
        }

        .company-details pre {
            color: #6b7280;
            line-height: 1.8;
        }

        .items-table {
            border-radius: 8px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }

        .items-table th {
            background-color: #1f2937;
            color: white;
        }

        .items-table th:first-child {
            border-top-left-radius: 8px;
        }

        .items-table th:last-child {
            border-top-right-radius: 8px;
        }

        .text-right {
            text-align: right;
        }

        .totals-table td {
            border: none;
            padding: 12px 16px;
            vertical-align: bottom;
        }

        .totals-table tr:last-child td {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
            background-color: #f9fafb;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .total-subtitle {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6b7280;
            margin-bottom: 4px;
            letter-spacing: 0.05em;
        }

        .address-block {
            color: #6b7280;
            line-height: 1.8;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <table class="header-table">
        <tr>
            <td>
                <div class="address-block">
                    {{ $invoice->user->name }}<br>
                    123 Business Street<br>
                    City, State 12345<br>
                    United States<br>
                    Phone: (555) 123-4567<br>
                    Email: {{ $invoice->user->email }}
                </div>
            </td>
            <td class="company-details">
                <h3>INVOICE</h3>
                <h4>#{{ $invoice->short_ulid }}</h4>

                <pre>
                    {{ $invoice->created_at->format('D j M, Y') }}
                    {{ $invoice->user->name }}
                </pre>
            </td>
        </tr>
    </table>

    <div class="section-title">TIME ENTRIES</div>
    <table class="items-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th class="text-right">Hours</th>
            <th class="text-right">Rate</th>
            <th class="text-right">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->entries as $index => $entry)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $entry->date->format('j M, Y') }}</td>
                <td class="text-right">{{ number_format($entry->hours, 2) }}</td>
                <td class="text-right">{{ $entry->formatted_rate }}</td>
                <td class="text-right">{{ $entry->earned }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot class="totals-table">
        <tr>
            <td colspan="3"></td>
            <td class="text-right">
                <div class="total-subtitle">HOURS</div>
                TOTAL
            </td>
            <td class="text-right">
                <div class="total-subtitle">{{ number_format($invoice->hours, 2) }}</div>
                {{ $invoice->total }}
            </td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
