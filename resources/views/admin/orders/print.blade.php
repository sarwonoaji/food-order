<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Order</title>

    <style>
        *{
            box-sizing: border-box;
        }

        body{
            font-family: monospace;
            width: 300px;
            margin: 0 auto;
            padding: 10px;
            color: #000;
            font-size: 12px;
        }

        .text-center{
            text-align: center;
        }

        .bold{
            font-weight: bold;
        }

        .line{
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .space-top{
            margin-top: 10px;
        }

        .header h2{
            margin: 0;
            font-size: 18px;
        }

        .header p{
            margin: 2px 0;
        }

        .info{
            width: 100%;
            margin-top: 10px;
        }

        .info td{
            padding: 2px 0;
            vertical-align: top;
        }

        .items{
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items td{
            padding: 4px 0;
            vertical-align: top;
        }

        .item-name{
            font-weight: bold;
        }

        .item-detail{
            font-size: 11px;
        }

        .text-right{
            text-align: right;
        }

        .total-section{
            margin-top: 10px;
        }

        .total-section table{
            width: 100%;
        }

        .total-section td{
            padding: 3px 0;
        }

        .grand-total{
            font-size: 14px;
            font-weight: bold;
        }

        .footer{
            margin-top: 15px;
            text-align: center;
            font-size: 11px;
        }

        @media print {

            body{
                width: 300px;
                padding: 0;
            }

            @page{
                margin: 5mm;
            }

        }
    </style>
</head>

<body onload="window.print()">

    {{-- HEADER --}}
    <div class="header text-center">

        <h2>RESTO APP</h2>

        <p>Jl. Contoh No.1</p>

        <p>0812-3456-7890</p>

    </div>

    <div class="line"></div>

    {{-- INFO ORDER --}}
    <table class="info">

        <tr>
            <td>Order</td>
            <td class="text-right">#{{ $order->id }}</td>
        </tr>

        <tr>
            <td>Customer</td>
            <td class="text-right">
                {{ $order->customer_name }}
            </td>
        </tr>

        <tr>
            <td>Meja</td>
            <td class="text-right">
                {{ $order->table_number }}
            </td>
        </tr>

        <tr>
            <td>Tanggal</td>
            <td class="text-right">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </td>
        </tr>

    </table>

    <div class="line"></div>

    {{-- ITEM --}}
    <table class="items">
        @php
            $itemsByBatch = $order->items->groupBy('batch');
        @endphp

        @foreach($itemsByBatch as $batch => $items)
        
        <tr>
            <td colspan="2" style="font-weight: bold; padding-top: 8px;">
                --- Batch {{ $batch }} ---
            </td>
        </tr>

        @foreach($items as $item)

        <tr>
            <td colspan="2" class="item-name">
                {{ $item->product->name }}
            </td>
        </tr>

        <tr>
            <td class="item-detail">
                {{ $item->qty }} x Rp {{ number_format($item->price) }}
            </td>

            <td class="text-right item-detail">
                Rp {{ number_format($item->qty * $item->price) }}
            </td>
        </tr>

        @endforeach

        @endforeach

    </table>

    <div class="line"></div>

    {{-- TOTAL --}}
    <div class="total-section">

        <table>

            <tr class="grand-total">
                <td>TOTAL</td>

                <td class="text-right">
                    Rp {{ number_format($order->total) }}
                </td>
            </tr>

        </table>

    </div>

    <div class="line"></div>

    <table width="100%">

    <tr>
        <td>Bayar</td>

        <td class="text-right">
            Rp {{ number_format($paid) }}
        </td>
    </tr>

    <tr>
        <td>Kembalian</td>

        <td class="text-right">
            Rp {{ number_format($change) }}
        </td>
    </tr>

</table>

    {{-- FOOTER --}}
    <div class="footer">

        <div>Terima Kasih 🙏</div>

        <div>Selamat Menikmati</div>

    </div>

</body>
</html>