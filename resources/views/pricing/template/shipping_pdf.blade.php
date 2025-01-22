<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Reset some default styles */

        @page {
            margin: 10px;
        }

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

        tr > td {
            padding-left: 4px;
        }

        .page-break {
            clear: both;
            page-break-after: always;
        }
    </style>
</head>
<body>

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div class="page_one">
    <img width="100%" height="1060px"
         src="https://plineshipping.com/assets/images/logo.png">
</div>
<div class="page-break"></div>

{{--<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>--}}
<div class="watermark">
    <img width="700px" style="opacity: 0.3 !important;"
         src="https://plineshipping.com/assets/images/logo.png">
</div>

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div style=" border-top-style: none; ">
    @if(count($prepareArray) > 0)
        @foreach($prepareArray as $keyIndex => $singleData)
            @if($keyIndex !== 0)
            <div class="page-break"></div>
            @endif
            <table class="content" style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px; margin-bottom: 0;">
                <thead>
                <tr>
                    <td style="border-right: none; border-top-style:none;">
                        <img width="80px" src="https://plineshipping.com/assets/images/logo.png">
                    </td>
                    <td colspan="6" style="padding-top: 15px; padding-bottom: 15px; font-weight: bold;  font-size:28px; border-left: none;  border-top-style:none; margin-bottom: 0;">
                        TOWING + SHIPPING + CLEARANCE PRICES
                    </td>
                </tr>
                </thead>
            </table>
            <div class="container" style="margin-top: 0;">
                @php
                    $pieces = array_chunk($singleData['prices'], ceil(count($singleData['prices']) / 2));
                @endphp

                <div class="full-width">

                    <table
                        style="margin-bottom: -1px; border-left-style:none; border-right-style:none; border-top-style:none; ">
                        <tr>
                            <td style="padding-top: 10px; border-top-style:none; margin-top: 0;"></td>
                        </tr>
                        <tr style="text-align: center; font-weight:bold;">
                            <td style=" padding: 10px 0px">{{  $singleData['state_name'] }}
                                - {{ $singleData['location_name']  }}</td>
                        </tr>
                    </table>

                    <div class="row">
                        <div>
                            <div class="table-responsive" style="margin-bottom: 0px">
                                <table class="" style="border-left-style: none; border-bottom-style: none;">
                                    <thead style="page-break-before: avoid">
                                        <tr>
                                            <th class="text-uppercase" style=" width: 13%">Code</th>
                                            <th class="text-uppercase" style="width: 20%">City</th>
                                            <th class="text-uppercase" style="width: 15%;">Price</th>
                                            <th rowspan="{{ count($pieces[0]) + 1 }}" style="width: 4%;"></th>
                                            <th class="text-uppercase" style="border-left-style: none; width: 13%">Code</th>
                                            <th class="text-uppercase" style="width: 20%;">City</th>
                                            <th class="text-uppercase" style="width: 15%;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size:12px;">
                                    @foreach($pieces[0] as $i => $price)
                                        <tr>
                                            <td style=" color: gray">{{ $price['state_short_code'] }}</td>
                                            <td style="color: gray"> {{ $price['city_name'] }} </td>
                                            <td style="font-weight: bold;">
                                                <table style="border:none">
                                                    <tr>
                                                        <td style="border:none">$</td>
                                                        <td style="border:none; text-align: right;">{{ number_format($price['price']) }}</td>
                                                    </tr>
                                                </table>
                                            </td>

                                            @if(isset($pieces[1]))
                                                <td style="border-left-style: none; color: gray">{{ array_key_exists($i, $pieces[1]) ? $pieces[1][$i]['state_short_code'] : ''}}</td>
                                                <td style="color: gray"> {{ array_key_exists($i, $pieces[1]) ? $pieces[1][$i]['city_name'] : ''}} </td>
                                                <td style="font-weight: bold;">
                                                    <table style="border:none">
                                                        <tr>
                                                            <td style="border:none">{{ array_key_exists($i, $pieces[1]) ?  '$' : '' }}</td>
                                                            <td style="border:none; text-align: right;">{{ array_key_exists($i, $pieces[1]) ? number_format($pieces[1][$i]['price']) : '' }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            @else
                                                <td style="border-left-style: none; color: gray"></td>
                                                <td style="color: gray"></td>
                                                <td style="font-weight: bold;"></td>
                                            @endif
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

<div class="page-break"></div>
<table class="content" style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px;">
    <thead>
    <tr>
       <td style="border-right: none;  border-top-style:none;">
           <img width="80px" src="https://plineshipping.com/assets/images/logo.png">
        </td>
        <td colspan="6" style="padding-top: 5px; padding-bottom: 5px; font-weight: bold;  font-size:18px; border-left: none;  border-top-style:none;">
        </td>
    </tr>
    </thead>
</table>


<div class="page-break"></div>
<table class="content" style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px;">
    <thead>
    <tr>
        <td style="border-right: none;  border-top-style:none;">
            <img width="80px" src="https://plineshipping.com/assets/images/logo.png">
        </td>
        <td colspan="6" style="padding-top: 5px; padding-bottom: 5px; font-weight: bold;  font-size:18px; border-left: none;  border-top-style:none;">
        </td>
    </tr>
    </thead>
</table>

<div class="page-break"></div>
<div class="page_one">
    <img width="100%" height="1060px"
         src="">
</div>

</body>
</html>
