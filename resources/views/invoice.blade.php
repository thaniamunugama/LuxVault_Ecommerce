<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .order-info {
            margin-bottom: 30px;
        }
        .order-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-info td {
            padding: 5px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .items-table td {
            background-color: #fff;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #000;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Luxe Vault</h1>
        <p>Invoice</p>
    </div>

    <div class="order-info">
        <table>
            <tr>
                <td><strong>Order ID:</strong> #{{ $order->order_id }}</td>
                <td class="text-right"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Customer:</strong> {{ $order->customer->fname }} {{ $order->customer->lname }}</td>
                <td class="text-right"><strong>Email:</strong> {{ $order->customer->email }}</td>
            </tr>
        </table>
    </div>

    <h3>Order Items</h3>
    <table class="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Product Unavailable' }}</td>
                <td>{{ $item->product->brand ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->price, 2) }}</td>
                <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>${{ number_format($order->total_price, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    @if($order->shipping_address)
    <div style="margin-top: 30px;">
        <h3>Shipping Address</h3>
        <p>
            {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
            {{ $order->shipping_country }}<br>
            Phone: {{ $order->shipping_phone }}
        </p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>Luxe Vault - Luxury Handbags & Accessories</p>
    </div>
</body>
</html>

