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

<p style="color: red; text-align: right; margin-bottom: 0px; margin-right: 10px; font-size: 10px;">{{$date}}</p>
<div class="page_one content">
    <img width="700px"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://plineshipping.com/assets/images/logo.png'))}}"
         style="position: fixed; top: 25%;">
</div>

<div class="page-break"></div>


<h3>TERM AND CONDITION:</h3>
<ol style="font-size: 12px;">
    <li>All USD exchange rates to AED are subject to a fixed rate of 3.67, no wire fees will be charged to customers.
    </li>
    <li>All rates will be charged to the customers as per the vehicles loading date, not Purchase date</li>
    <li>All vehicles subject to Export will be excluded from CUSTOMS & VAT</li>
    <li>All export documents must be submitted to PLINE NAZAROV SHIPPING office within 150 days otherwise we will
        charge 5 % custom and 5 % VAT
    </li>
    <li>All vehicles subject to Local Registration, will be charged 5 % custom and 5% VAT according to UAE Law</li>
    <li>All SUV vehicles not limited to, will be charged 150 $ extra</li>
    <li>All vehicles purchased from Broker states such as (AL. MI, OH and WI) are subject to an extra charge of 50$
        to 100$ per vehicle
    </li>
    <li>PLINE NAZAROV SHIPPING is not taking responsibility for purchased cars that cannot be shipped or have title
        issues.
    </li>
    <li>After the full payment of vehicle. The vehicle will be picked up in 3 business days, excluding the payment
        date.
    </li>
    <li>vehicles with none exportable documents will be charged 400$ extra, ACQ (ACQUISITION Bill of Sale) will be
        charged 600$.
    </li>
    <li>MV907/A, Lien papers, NV907, M-30, will have additional charges, moreover will have delay in shipping as
        well.
    </li>
    <li>If the Auction says (Key Yes) BUT vehicle key missed in the auction PLINE NAZAROV SHIPPING is not responsible for it.
    </li>
    <li>All Sublot Locations will be charged 150$ extra (if same city) but will charge more if in different city.
    </li>
    <li>Any damages occurred to the vehicle in the auction after purchase, PLINE NAZAROV SHIPPING is not responsible for it.
    </li>
    <li>If any vehicle is damaged in the container or in our warehouses, PLINE NAZAROV SHIPPING will only pay for
        the repair cost as per market value.
    </li>
    <li>For larger vehicles, there is an additional fee of $50 to $100 on top of the standard towing charges.
        Additionally, scrap cars and big vehicles with extensive damage will incur an extra charge of $150 or more, in
        addition to the regular towing fees.
    </li>
    <li>Please be aware that due to global emergency conditions, there could be unforeseen adjustments in prices.
        Rest assured; you will be promptly informed of any changes in pricing.
    </li>
    <li>The adjustment in the Expected Time of Arrival (ETA) is based on alterations in the schedules and timings of
        the shipping lines. The company
    </li>
    <li>is not accountable or responsible for any changes in timings or delays in the arrival of ships.</li>
    <li>PLINE NAZAROV SHIPPING does not assume responsibility for delays in towing if the cars are from the SUB-LOT
        LOCATION or OFFSITE.
    </li>
    <li>PLINE NAZAROV SHIPPING disclaims responsibility for the cars that are withdrawn from the auction without
        Exhaust, knowing that the company is doing its best in this regard.
    </li>
    <li>In accordance with UAE Rules & Regulations, an attestation fee of $50 is applicable when the vehicle value
        exceeds AED 10,000. and certificate of country of origin of 15$ is applicable to all vehicle.</li>
    <li>PLINE NAZAROV SHIPPING is not responsible for any type of inspection in USA and UAE customs.</li>
    <li>Customer must check photos of by day of vehicles arrival to our warehouse in USA, if any damage is seen must
        inform PLINE NAZAROV SHIPPING within 24 hours, otherwise damage claim will not be accepted.
    </li>
    <li>All damage claims of UAE yards must be claimed within 30 days of arrival, late reported claims will be
        rejected.
    </li>
</ol>

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
<table class="content"
       style="border-left-style:none; border-right-style:none; border-bottom-style: dotted; border-width: 2px;">
    <thead>
    <tr>
        <td colspan="4"
            style="padding-top: 5px; padding-bottom: 5px; font-weight: bold;  font-size:18px; border-left: none;  border-top-style:none;">
            Please try not to buy vehicles with below Titles types
        </td>
    </tr>
    </thead>
</table>

<table style="border-collapse: collapse; width: 100%;" border="1">
    <colgroup>
        <col style="width: 25.0627%;">
        <col style="width: 25.0627%;">
        <col style="width: 25.0627%;">
        <col style="width: 24.812%;">
    </colgroup>
    <tbody>
    <tr>
        <td>No.</td>
        <td>Title Type</td>
        <td>Delay in Shipping</td>
        <td>Extra Cost</td>
    </tr>
    <tr>
        <td>1</td>
        <td>FL - CASH FOR CLUNKERS</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>2</td>
        <td>MI - SCRAP - BILL OF SALES</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>3</td>
        <td>NY - MV-37-DISMANTLE OR SCRAP</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>4</td>
        <td>CANADIAN TITLE</td>
        <td>Not Exportable</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>5</td>
        <td>NON - REPAIRABLE</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>6</td>
        <td>BILL OF SALE</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>7</td>
        <td>JUNK CERTIFICATE</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>8</td>
        <td>AB JUNK</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>9</td>
        <td>CA-JUNK</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>10</td>
        <td>PARTS ONLY</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>11</td>
        <td>KY &ndash; PARTS ONLY</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>12</td>
        <td>LIEN PAPERS&nbsp;</td>
        <td>More then 6 months</td>
        <td>not clear</td>
    </tr>
    <tr>
        <td>13</td>
        <td>CA &ndash; LIEN&nbsp;</td>
        <td>More then 6 months</td>
        <td>not clear</td>
    </tr>
    <tr>
        <td>14</td>
        <td>SCRAP</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>15</td>
        <td>ACQ (ACQUISITAION)</td>
        <td>90 Days</td>
        <td>600USD</td>
    </tr>
    <tr>
        <td>16</td>
        <td>CA - BILL OF SALE (ACQ)</td>
        <td>90 Days</td>
        <td>600USD</td>
    </tr>
    <tr>
        <td>17</td>
        <td>MV907</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>18</td>
        <td>MV907/A</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>19</td>
        <td>NV907&nbsp;</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>20</td>
        <td>M &ndash; 30&nbsp;</td>
        <td>60 DAYS</td>
        <td>450USD</td>
    </tr>
    <tr>
        <td>21</td>
        <td>ABANONED</td>
        <td>90 Days</td>
        <td>600USD</td>
    </tr>
    </tbody>
</table>

</body>
</html>
