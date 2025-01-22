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
    </style>
</head>
<body>

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div class="page_one">
    <img width="700px"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}"
         style="top: 50%;
            left: 50%;">
</div>

<div class="page-break"></div>
<table class="content" style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px;">
    <thead>
    <tr>
        <td style="border-right: none;  border-top-style:none;">
            <img width="80px" src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}">
        </td>
        <td colspan="6" style="padding-top: 5px; padding-bottom: 5px; font-weight: bold;  font-size:18px; border-left: none;  border-top-style:none;">
            TERM AND CONDITION:
        </td>
    </tr>
    </thead>
</table>

<table style="border-collapse: collapse; width: 98.8736%; height: 1299.54px;" border="1"><colgroup><col style="width: 100%;"></colgroup>
    <tbody>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">1. All USD exchange rates to AED are subject to a fixed rate of <span style="color: rgb(224, 62, 45);">3.67</span>, no wire fees will be charged to customers</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">2. All rates will be charged to the customers as per <span style="color: rgb(224, 62, 45);">the vehicles loading date, not Purchase date</span></td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">3. All vehicles subject to Export will be excluded from <span style="color: rgb(224, 62, 45);">CUSTOMS &amp; VAT</span></td>
    </tr>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">4. All export documents must be submitted to PLINE NAZAROV SHIPPING office within 150 days otherwise we will charge 5 % custom and 5 % VAT</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">5. All vehicles subject to Local Registration, will be charged 5 % custom and 5% VAT according to UAE Law</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">6. All SUV vehicles not limited to, will be charged <span style="color: rgb(224, 62, 45);">150 $</span> extra</td>
    </tr>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">7. All vehicles purchased from Broker states such as (AL. MI, OH and WI) are subject to an extra charge of 50$ to 100$ per vehicle</td>
    </tr>
    {{--        <tr style="height: 22.3984px;">--}}
    {{--            <td style="height: 22.3984px;">8. All vehicles will have a 30 days free parking, afterwards will get a <span style="color: rgb(224, 62, 45);">10AED per day parking charges</span>,</td>--}}
    {{--        </tr>--}}
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">9. PLINE NAZAROV SHIPPING is not taking responsibility for purchased cars that cannot be shipped or have title issues.</td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>10. After the full payment of vehicle. The vehicle will be picked up in 3 business days, excluding the payment date.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>11. Vehicles with none exportable documents will be charged 400$ extra, ACQ (ACQUISITION Bill of Sale) will be charged 600$.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>12. &nbsp;MV907/A, Lien papers, NV907, M-30, will have additional charges, moreover will have delay in shipping as well.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>13. &nbsp;if the Auction says (Key Yes) BUT vehicle key missed in the auction PLINE NAZAROV SHIPPING is not responsible for it</p>
        </td>
    </tr>
    <tr style="height: 54.3984px;">
        <td style="height: 54.3984px;">
            <p>14. &nbsp;All Sublot Locations will be charged 150$ extra (if same city) but will charge more if in different city</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>15. &nbsp;Any damages occurred to the vehicle in the auction after purchase, PLINE NAZAROV SHIPPING is not responsible for it.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>16. &nbsp;If any vehicle is damaged in the container or in our warehouses, PLINE NAZAROV SHIPPING will only pay for the repair cost as per market value.</p>
        </td>
    </tr>
    <tr style="height: 99.1953px;">
        <td style="height: 99.1953px;">
            <p>17. &nbsp;For larger vehicles, there is an additional fee of $50 to $100 on top of the standard towing charges. Additionally, scrap cars and big vehicles
                with extensive damage will incur an extra charge of $150 or more, in addition to the regular towing fees</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>18. &nbsp;Please be aware that due to global emergency conditions, there could be unforeseen adjustments in prices. Rest assured; you will be promptly
                informed of any changes in pricing.
            </p>
        </td>
    </tr>
    <tr style="height: 99.1953px;">
        <td style="height: 99.1953px;">
            <p>19. &nbsp;The adjustment in the Expected Time of Arrival (ETA) is based on alterations in the schedules and timings of the shipping lines. The company
                is not accountable or responsible for any changes in timings or delays in the arrival of ships.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>20. &nbsp;PLINE NAZAROV SHIPPING does not assume responsibility for delays in towing if the cars are from the SUB-LOT LOCATION or OFFSITE.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>21. &nbsp;PLINE NAZAROV SHIPPING disclaims responsibility for the cars that are withdrawn from the auction without Exhaust, knowing that the company
                is doing its best in this regard.</p>
        </td>
    </tr>
    <tr style="height: 76.7969px;">
        <td style="height: 76.7969px;">
            <p>22. &nbsp;In accordance with UAE Rules &amp; Regulations, an atte</p>
        </td>
    </tr>
    <tr style="height: 10px;">
        <td style="height: 10px;">
            <p>23. &nbsp;PLINE NAZAROV SHIPPING is not responsible for any type of inspection in USA and UAE customs.</p>
        </td>
    </tr>
    <tr style="height: 10px;">
        <td style="height: 10px;">
            <p>24. &nbsp;Customer must check photos of by day of vehicles arrival to our warehouse in USA, if any damage is seen must inform PLINE NAZAROV SHIPPING
                within 24 hours, otherwise damage claim will not be accepted.</p>
        </td>
    </tr>
    <tr style="height: 10px;">
        <td style="height: 10px;">
            <p>25. &nbsp;All damage claims of UAE yards must be claimed within 30 days of arrival, late reported claims will be rejected</p>
        </td>
    </tr>
    </tbody>
</table>

<div class="page-break"></div>

{{--<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>--}}
<div class="watermark">
    <img width="700px" style="opacity: 0.3 !important;"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}">
</div>

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div style=" border-top-style: none; ">
    @if(count($prepareArray) > 0)
        @foreach($prepareArray as $keyIndex => $singleData)
            @if($keyIndex !== 0)
            <div class="page-break"></div>
            @endif
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
                            <td style=" padding: 10px 0px;">{{  $singleData['state_name'] }}
                                - {{ $singleData['location_name']  }}</td>
                        </tr>
                    </table>

                    <div class="row">
                        <div>
                            <div class="table-responsive" style="margin-bottom: 0px">
                                <table class="" style="border-left-style: none; border-bottom-style: none;">
                                    <thead style="page-break-before: avoid">
                                        <tr style="background: #acb8ca;">
                                            <th class="text-uppercase text-right" style="width: 15%;">SEQ.V</th>
                                            <th class="text-uppercase text-right" style="width: 20%">Code</th>
                                            <th class="text-uppercase text-right" style="width: 25%">State</th>
                                            <th class="text-uppercase text-right" style="width: 25%">City</th>
                                            <th class="text-uppercase text-right" style="width: 15%;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size:12px;">
                                    @foreach($pieces as $i => $price)
                                        <tr>
                                            <td class="text-right">{{ $i+1 }}</td>
                                            <td class="text-right">{{ $price['state_short_code'] }}</td>
                                            <td class="text-right">{{ $price['state_name'] }}</td>
                                            <td class="text-right">{{ $price['city_name'] }}</td>
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

<div class="page-break"></div>
<table class="content" style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px;">
    <thead>
    <tr>
        <td style="border-right: none;  border-top-style:none;">
            <img width="80px" src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}">
        </td>
        <td colspan="6" style="padding-top: 5px; padding-bottom: 5px; font-weight: bold;  font-size:18px; border-left: none;  border-top-style:none;">
            Please try not to buy vehicles with below Titles types
        </td>
    </tr>
    </thead>
</table>

<table style="border-collapse: collapse; width: 100%; height: 559.96px;" border="1"><colgroup><col style="width: 25.0627%;"><col style="width: 25.0627%;"><col style="width: 25.0627%;"><col style="width: 24.812%;"></colgroup>
    <tbody>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">No.</td>
        <td style="height: 22.3984px;">Title Type</td>
        <td style="height: 22.3984px;">Delay in Shipping</td>
        <td style="height: 22.3984px;">Extra Cost</td>
    </tr>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">1</td>
        <td style="height: 44.7969px;">FL - CASH FOR CLUNKERS</td>
        <td style="height: 44.7969px;">60 DAYS</td>
        <td style="height: 44.7969px;">450USD</td>
    </tr>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">2</td>
        <td style="height: 44.7969px;">MI - SCRAP - BILL OF SALES</td>
        <td style="height: 44.7969px;">60 DAYS</td>
        <td style="height: 44.7969px;">450USD</td>
    </tr>
    <tr style="height: 44.7969px;">
        <td style="height: 44.7969px;">3</td>
        <td style="height: 44.7969px;">NY - MV-37-DISMANTLE OR SCRAP</td>
        <td style="height: 44.7969px;">60 DAYS</td>
        <td style="height: 44.7969px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">4</td>
        <td style="height: 22.3984px;">CANADIAN TITLE</td>
        <td style="height: 22.3984px;">Not Exportable</td>
        <td style="height: 22.3984px;">&nbsp;</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">5</td>
        <td style="height: 22.3984px;">NON - REPAIRABLE</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">6</td>
        <td style="height: 22.3984px;">BILL OF SALE</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">7</td>
        <td style="height: 22.3984px;">JUNK CERTIFICATE</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">8</td>
        <td style="height: 22.3984px;">AB JUNK</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">9</td>
        <td style="height: 22.3984px;">CA-JUNK</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">10</td>
        <td style="height: 22.3984px;">PARTS ONLY</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">11</td>
        <td style="height: 22.3984px;">KY &ndash; PARTS ONLY</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">12</td>
        <td style="height: 22.3984px;">LIEN PAPERS&nbsp;</td>
        <td style="height: 22.3984px;">More then 6 months</td>
        <td style="height: 22.3984px;">not clear</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">13</td>
        <td style="height: 22.3984px;">CA &ndash; LIEN&nbsp;</td>
        <td style="height: 22.3984px;">More then 6 months</td>
        <td style="height: 22.3984px;">not clear</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">14</td>
        <td style="height: 22.3984px;">SCRAP</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">15</td>
        <td style="height: 22.3984px;">ACQ (ACQUISITAION)</td>
        <td style="height: 22.3984px;">90 Days</td>
        <td style="height: 22.3984px;">600USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">16</td>
        <td style="height: 22.3984px;">CA - BILL OF SALE (ACQ)</td>
        <td style="height: 22.3984px;">90 Days</td>
        <td style="height: 22.3984px;">600USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">17</td>
        <td style="height: 22.3984px;">MV907</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">18</td>
        <td style="height: 22.3984px;">MV907/A</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">19</td>
        <td style="height: 22.3984px;">NV907&nbsp;</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">20</td>
        <td style="height: 22.3984px;">M &ndash; 30&nbsp;</td>
        <td style="height: 22.3984px;">60 DAYS</td>
        <td style="height: 22.3984px;">450USD</td>
    </tr>
    <tr style="height: 22.3984px;">
        <td style="height: 22.3984px;">21</td>
        <td style="height: 22.3984px;">ABANONED</td>
        <td style="height: 22.3984px;">90 Days</td>
        <td style="height: 22.3984px;">600USD</td>
    </tr>
    </tbody>
</table>

<div class="page-break"></div>
<div class="page_one">
    <img width="100%" height="1060px"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}">
</div>

</body>
</html>
