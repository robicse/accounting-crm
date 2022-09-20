<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        * {
            font-size: 16px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            /*border-top: 1px solid black;*/
            /*border-top: 1px dotted black;*/
            /*border-collapse: collapse;*/
        }

        td.product,
        th.product {
            width: 160px;
            max-width: 160px;
            text-align: left;
        }

        td.quantity,
        th.quantity {
            width: 60px;
            max-width: 60px;
            text-align: left;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 60px;
            max-width: 60px;
            text-align: left;
            word-break: break-all;
        }

        td.empty_space,
        th.empty_space {
            width: 100px;
            max-width: 100px;
            text-align: left;
        }

        td.left_text,
        th.left_text {
            width: 120px;
            max-width: 120px;
            text-align: left;
            word-break: break-all;
        }

        td.right_text,
        th.right_text {
            width: 60px;
            max-width: 60px;
            text-align: left;
            word-break: break-all;
        }

        .bottom_space {
            height: 20px !important;
            width: 280px !important;
            max-width: 280px !important;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            /*width: 155px;*/
            /*max-width: 155px;*/
            width: 280px;
            max-width: 280px;
        }

        .ticket img{
            max-width: 180px !important;
            height: auto !important;
            display: block !important;
            padding: 0px 50px 15px 50px;
        }

        /*img {*/
        /*    max-width: inherit;*/
        /*    width: inherit;*/
        /*}*/

        /*@media print {*/
        /*    .hidden-print,*/
        /*    .hidden-print * {*/
        /*        display: none !important;*/
        /*    }*/
        /*}*/

        @page {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="ticket">
    <img src="{{asset('uploads/logo.png')}}" alt="Logo">
    <p class="centered">Sales Invoice
        <br>Shop: 24, Level 5</p>
    <table>
        <thead>
        <tr>
            <th class="product">Product</th>
            <th class="quantity">Qty</th>
            <th class="price">Tk.</th>
        </tr>
        </thead>
        <tbody>
        @php
            date_default_timezone_set('Asia/Dhaka');
            $date = date('l jS F Y h:i:s A');

            $grand_total_value = $productSale->total_amount;
            $vat_amount_value = $productSale->vat_amount;
            $discount_amount_value = $productSale->discount_amount;
            $paid_amount_value = $productSale->paid_amount;
            $due_amount_value = $productSale->due_amount;

            $subtotal = 0;
        @endphp

        @foreach($productSaleDetails as $productSaleDetail)
            @php
                $subtotal += $productSaleDetail->sub_total;
            @endphp
            <tr>
                <td class="product">{{$productSaleDetail->name}}</td>
                <td class="quantity">{{$productSaleDetail->qty}}</td>
                <td class="price">{{$productSaleDetail->price}}</td>
            </tr>
        @endforeach
        <tr>
            <td class="empty_space"></td>
            <td class="left_text">Sub TOTAL</td>
            <td class="right_text">{{$subtotal}}</td>
        </tr>
        </tbody>
    </table>
    <table>
        <thead>
        <tr>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr style="margin-top: 50px;">
            <td class="empty_space"></td>
            <td class="left_text">vat</td>
            <td class="right_text">{{$vat_amount_value}}</td>
        </tr>
        <tr>
            <td class="empty_space"></td>
            <td class="left_text">discount</td>
            <td class="right_text">{{$discount_amount_value}}</td>
        </tr>
        <tr>
            <td class="empty_space"></td>
            <td class="left_text">Grand Total</td>
            <td class="right_text">{{$grand_total_value}}</td>
        </tr>
        <tr>
            <td class="empty_space"></td>
            <td class="left_text"><strong>Paid</strong></td>
            <td class="right_text"><strong>{{$paid_amount_value}}</strong></td>
        </tr>
        <tr>
            <td class="empty_space"></td>
            <td class="left_text">Due</td>
            <td class="right_text">{{$due_amount_value}}</td>
        </tr>
        <tr>
            <td class="empty_space"></td>
            <td class="left_text">Payment Type</td>
            <td class="right_text">Cash</td>
        </tr>
        </tbody>
    </table>
    <p class="centered">Thanks for your purchase!
        <br>simco.com.bd</p>
    <p class="centered">{{$date}}</p>
    <p class="bottom_space">&nbsp;</p>
</div>
</body>
</html>

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
