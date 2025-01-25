@php
    $color = '#ffffff';
@endphp
        <!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
            href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
            rel="stylesheet">

    <style>
        body {
            font-family: "Times New Roman", Serif;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .customer-info h1, .customer-info p {
            margin: 0;
            padding: 0;
        }

        .logo img {
            max-width: 100%;
            height: auto;
        }

        h1,
        h2 {
            margin-top: 0;
            margin-bottom: 0;
            font-weight: 500;
            line-height: 1.2;
        }

        .pt-5 {
            padding-top: 48px;
        }

        .mb-4 {
            margin-bottom: 25px;
            padding: 0px 5px;
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        table tr td, thead tr th {
            border: 1px solid #333;
            padding: 4px;
            font-size: 10px;
            text-align: center;
        }


        .border-light td {
            border: 1px solid #afa8a8;
        }

        .heading td {
            font-size: 12px;
            text-align: center;
        }

        .heading.text-left td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .tr-text-right td {
            text-align: right;
        }

        th {
            font-weight: bold;
        }

    </style>

</head>

<body class="">
<div>
    <table class="header-table">
        <tr style="background-color: white !important;">
            <td class="customer-info" style="border: none !important; text-align: left">
                <strong>Abdul Razeq Olfat Used Cars TR LLC</strong> <br>
                Street No.23 - Ind.Area.No.4 <br>
                Sharjah, Sharjah 00971 AE <br>
                +971 564023099 <br>
                Olfatshipping@outlook.com <br>
                www.olfatshipping.com
            </td>
            <td class="logo" style="border: none !important; text-align: right">
                <img width="150"
                     src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://vaccount.olfatshipping.com/storage/uploads/logo/logo-olfat.png'))}}">
            </td>
        </tr>
    </table>

    <h4 style="margin-top: -5px">Statement</h4>


    <table class="header-table" style="margin-top:-15px !important;">
        <tr style="background-color: white !important;">
            <td class="customer-info" style="border: none !important; text-align: left">
                <h2><strong>To</strong></h2>
                <strong>{{ $customer->billing_name }}</strong> <br>
                {{ $customer->contact }} <br>
                {{ $customer->email }} <br>
                {{$customer->billing_state}}-{{ $customer->billing_city }}<br>
                {{$customer->billing_country}} <br>
            </td>
            <td class="logo" style="border: none !important; text-align: right; font-size: 12px">
                <p><strong>Date : </strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }} </p>
                <p><strong>Total Due : </strong> {{ number_format($totalDue, 2) }} </p>
                <p><strong>Enclosed </strong></p>
            </td>
        </tr>
    </table>

    <table class="custom_tbl_class" cellpadding="1" style="width: 100%; font-size: 12px; margin-top: 10px;">
        <tbody>

        <tr style="border-bottom: 1px solid #333; margin-bottom: 3px">
            <th>NO.</th>
            <th>PICTURE</th>
            <th>VEHICLE</th>
            <th>INVOICE</th>
            <th>TOTAL</th>
            <th>PAID</th>
            <th>BALANCE</th>
            <th style="min-width: 60px;">DUE DATE</th>
        </tr>

        @php $sl = 1; @endphp
        @foreach( $invoices as $invoice )

            <tr style="border-bottom: 1px solid #ccc;">
                <td style="font-size: 12px; text-align: center; border: none; height: 40px">{{ $sl++ }}</td>
                <td style="font-size: 12px; text-align: center; border: none">
                    @php
                        $photoUrl = 'https://system.olfatshipping.com/assets/images/car-default-photo.png';
                        if(!empty($invoice->inventory) && \Illuminate\Support\Arr::get($invoice->inventory->misc, 'photo_url')) {
                            $photoUrl = $invoice->inventory->misc['photo_url'];
                        }
                    @endphp
                    <img height="40" width="53" src="{{'data:image/png;base64,'.base64_encode(file_get_contents($photoUrl))}}">
                </td>

                <td style="font-size: 12px; text-align: center; border: none; text-transform: uppercase">
                    {{ optional($invoice->inventory)->description }} <br>
                    {{ optional($invoice->inventory)->name }}
                </td>
                <td style="font-size: 12px; text-align: center; border: none">{{ $invoice->invoice_id_str }}</td>
                <td style="font-size: 12px; text-align: center; border: none">{{ number_format($invoice->getTotal(), 2) }}</td>
                <td style="font-size: 12px; text-align: center; border: none">{{ number_format($invoice->getTotal() - $invoice->getDue(), 2) }}</td>
                <td style="font-size: 12px; text-align: center; border: none">{{ number_format($invoice->getDue(), 2) }}</td>
                <td style="font-size: 12px; text-align: center; border: none">{{ \Illuminate\Support\Carbon::parse( $invoice->due_date )->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
