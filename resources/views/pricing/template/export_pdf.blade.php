<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Reset some default styles */

        .content {
            position: relative;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        .watermark {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            top: 50%;
            left: 50%;
            transform: translate(-45%, -15%);
            opacity: 0.3; /* Adjust opacity as needed */
        }

        body, h5, table {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 10px 0px 0px 0px;
            /* padding: 20px; */
        }

        .full-width {
            width: 100%;
        }


        .row {
            display: block;
            width: 100%;
        }

        .col-half {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            margin-right: 2%;
        }

        .col-half:last-child {
            margin-right: 0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table th {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tr > td {
            padding-left: 4px;
        }

        .page-break {
            clear: both;
            page-break-after: always;
        }
        ol li {
            line-height: 20px;
        }
    </style>
</head>
<body>
<div class="watermark">
    <img width="700px" style="opacity: 0.3 !important;"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}">
</div>

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div style=" border-top-style: none; ">
    @if(count($prepareArray) > 0)
        @foreach($prepareArray as $keyIndex => $singleData)
            <div class="container" style="margin-top: 0;">
                @php
                    $pieces = $singleData['prices'];
                @endphp

                <div class="full-width">

                    <table
                            style="margin-bottom: -1px; border-left-style:none; border-right-style:none; border-top-style:none; ">
                        <tr>
                            <td style="padding-top: 10px; border-top-style:none; margin-top: 0;"></td>
                        </tr>
                        <tr style="text-align: center; font-weight:bold; background: #1f3664; color: white;">
                            <td style=" padding: 10px 0px;">Export Price</td>
                        </tr>
                    </table>

                    <div class="row">
                        <div>
                            <div class="table-responsive" style="margin-bottom: 0px">
                                <table class="" style="border-left-style: none; border-bottom-style: none;">
                                    <thead style="page-break-before: avoid">
                                    <tr style="background: #acb8ca;">
                                        <th class="text-uppercase text-right" style="width: 15%;">SEQ.V</th>
                                        <th class="text-uppercase text-right" style="width: 25%">Departure Country</th>
                                        <th class="text-uppercase text-right" style="width: 25%">Destination Country</th>
                                        <th class="text-uppercase text-right" style="width: 15%;">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody style="font-size:12px;">
                                    @foreach($pieces as $i => $price)
                                        <tr>
                                            <td class="text-right">{{ $i+1 }}</td>
                                            <td class="text-right">{{ $price['departure_country'] }}</td>
                                            <td class="text-right">{{ $price['destination_country'] }}</td>
                                            <td class="text-right">$ {{ number_format($price['price']) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

</body>
</html>
