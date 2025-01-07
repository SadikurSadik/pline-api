<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: "Times New Roman", Serif;
        }

        header {
            width: 100%;
            position: fixed;
            top: -15px;
            font-size: 10px;
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

        .text-center {
            text-align: center;
        }

        .color-blue {
            color: darkslateblue;
            font-family: Serif;
        }

        table.add-border {
            border-collapse: collapse;
        }

        table.add-border td, table.add-border th {
            border: 1px solid #CCC;
            padding-left: 3px;
        }

        table.add-border-2 td {
            border: 1px solid #CCC;
            padding-left: 3px;
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }
    </style>
</head>

<body>
<header style="width: 100%;">
    <table width="100%">
        <tr>
            <td style="text-align: right;"><small><strong>Generated
                        AT: {{ \Illuminate\Support\Carbon::parse($invoicePayment->created_at)->format('d/m/Y H:i:s') }}</strong></small>
            </td>
        </tr>
    </table>
</header>
<div>
    <div style="margin-top: 10px;">
        <table width="100%">
            <tr>
                <td>
                    <div class="">
                        <img width="140"
                             src="{{'data:image/png;base64,'.base64_encode(file_get_contents('https://vaccount.olfatshipping.com/storage/uploads/logo/logo-olfat.png'))}}">
                    </div>
                </td>
                <td>
                    <div style="color: #d1652b; text-align: right; font-size: 20px;">
                        <h2 style="text-align: right;">Abdul Razeq Olfat Used Car Tr L.L.C</h2>
                    </div>
                </td>
            </tr>
        </table>
        <hr style="color: #403a94">
    </div>

    <div>
        <table style="width: 100%; margin-bottom: 20px; margin-top: -10px;">
            <tr>
                <td style="color: #d1652b;">
                    <h3 style="margin: 0;">NO. <span
                                style="color: black; border-bottom: 2px dotted #d1652b">{{ $invoicePayment->reference }}   </span>
                    </h3>
                </td>
                <td style="padding: 0 30px;">
                    <h3 style="color: #d1652b; margin: 0; text-align: center;">{{ $invoicePayment->invoice->ak_type === 'inventory' ? 'VEHICLE' : 'SHIPPING' }}
                        RECEIPT VOUCHER</h3>
                </td>
                <td>
                    <h3 style="margin: 0; text-align: right;">Date: <span
                                style="border-bottom: 2px dotted #d1652b; color: black">{{ date('d/m/Y', strtotime($invoicePayment->date)) }}</span>
                    </h3>
                </td>
            </tr>
        </table>
    </div>

    <div>
        <div class="">
            <h4 style="color: #d1652b; min-width: 70px; border-bottom: 2px dotted #d1652b; padding-bottom: 5px; margin: 5px 0;">
                Customer Name: <span
                        style="color: black; margin-left: 20px;">{{ data_get($invoicePayment, 'invoice.customer.name')  }}</span>
            </h4>
        </div>
        <div class="">
            <h4 style="color: #d1652b; min-width: 70px; border-bottom: 2px dotted #d1652b; padding-bottom: 5px; margin: 5px 0;">
                Received From: <span
                        style="color: black; margin-left: 20px;">{{ data_get($invoicePayment, 'received_from')  }}</span>
            </h4>
        </div>
        <div class="">
            <h4 style="color: black; min-width: 70px; padding-bottom: 5px; margin: 5px 0; border-bottom: 2px dotted black;">
                Description: <span style="color: black; margin-left: 20px;"></span>
            </h4>
        </div>
    </div>
</div>

<div>
    <table cellpadding="1" style="width: 100%; font-size: 12px; margin-top: 20px;">
        <tbody>
        <tr>
            <th style="text-align: center;">SL</th>
            <th style="text-align: center;">Picture</th>
            <th style="text-align: left; padding-left: 35px;">Vehicle</th>
            <th style="text-align: center;">Invoice NO.</th>
            <th style="text-align: center;">Total Amount</th>
            <th style="text-align: center;">Previously Paid</th>
            <th style="text-align: center;">Paid Amount</th>
            <th style="text-align: center;">Balance USD</th>
        </tr>

        @php $totalAmount = 0; $totalAmountAed = 0; @endphp
        @foreach($invoiceData as $key => $value)
            @php
                $totalAmount += $value->amount;
                $totalAmountAed += ($value->amount*$value->invoice->aed_rate);
            @endphp
            <tr>
                <td colspan="8">
                    <div style="border-top: 1px solid #CCC; margin-top: 2px; margin-bottom: 2px;"></div>
                </td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="text-align: center;"><strong>{{ $key + 1 }}</strong></td>

                <td>
                    @php
                        $photoUrl = 'https://system.olfatshipping.com/assets/images/car-default-photo.png';
                        if(!empty($value->invoice->inventory) && Arr::get($value->invoice->inventory->misc, 'photo_url')) {
                            $photoUrl = $value->invoice->inventory->misc['photo_url'];
                        }
                    @endphp
                    <img width="60"
                         src="{{'data:image/png;base64,'.base64_encode(file_get_contents($photoUrl))}}">
                </td>
                <td>{{ optional($value->invoice->inventory)->description }}
                    <br> {{ optional($value->invoice->inventory)->name }}</td>
                <td style="text-align: center;">{{ $value->invoice->invoice_id_str }}</td>
                <td style="text-align: center;">{{ number_format(data_get($value, 'invoice.total_amount'), 2) }}</td>
                <td style="text-align: center;">{{ number_format($value->invoice->payments->where('id', '<', $value->id)->sum('amount'), 2) }}</td>
                <td style="text-align: center;">{{ number_format($value->amount, 2) }}</td>
                <td style="text-align: center;">{{ number_format(data_get($value, 'invoice.total_amount')-$value->invoice->payments->where('id', '<=', $value->id)->sum('amount'), 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <img style="z-index: -100; position: absolute; width: 150px;
            margin-left: -100px;
            margin-top: -20px;
            padding-left: 45%;" src="https://vaccount.olfatshipping.com/assets/images/received_watter_mark.png"
         alt="Received">
</div>

<div class="" style="width: 100%; padding: 10px;">
    <table class="add-border"
           style="width: 300px; float: right;">
        <tr>
            <td rowspan="2" style="text-align: center;">TOTAL PAID</td>
            <td style="text-align: right; padding-right: 5px;">USD: {{ number_format($totalAmount, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 5px;">AED: {{ number_format($totalAmountAed, 2) }}</td>
        </tr>
    </table>
</div>

<div style="clear:both; width: 100%; padding: 10px; margin-top: 70px;">
    <table>
        <tr>
            <td>
                <h4 style="color: #d1652b; min-width: 300px; padding-bottom: 5px; margin: 0; border-bottom: {{ empty($invoicePayment->description) ? '2px dotted #d1652b;' : 'none;' }}">
                    Note: @if(!empty($invoicePayment->description))
                        <span
                                style="color: black; border-bottom: 2px dotted #d1652b; display: inline; line-height: 1.6">{{ $invoicePayment->description }} </span>
                    @endif
                </h4>
            </td>
            <td>
                <table style="margin-top: 30px">
                    <tr>
                        <td style=" color: #d1652b; padding: 0 50px">
                            <img style="position: absolute; margin-top: -65px; margin-left: 20px;"
                                 width="100"
                                 src="{{ $invoicePayment->cashier_signature }}"
                                 alt="Signature">
                            <h4 style="min-width: 100px; text-align: center; border-top: 2px dotted  #d1652b; margin: 0;">
                                Receiver
                                Sign</h4>
                        </td>
                        <td style=" color: #d1652b; padding-left: 70px">
                            @if(!empty($invoicePayment->signature_url))
                                <img style="position: absolute; margin-top: -50px; margin-left: 10px; z-index: -100;"
                                     width="100"
                                     src="{{\Illuminate\Support\Facades\Storage::url($invoicePayment->signature_url)}}"
                                     alt="Signature">
                            @endif
                            <h4 style="min-width: 90px; text-align: center;border-top: 2px dotted  #d1652b; margin: 0;">Payer Sign</h4>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<div style="border-top: 1px solid #333; margin-top: 20px;">
    <div style="font-size: 8px; font-weight: bold;">
        <p>
            Tel: 065360031, Mob: 0562826798, P.O.Box:83864, Street #23, Industrial Area No. 4, Sharjah- U.A.E
            <span style="float: right;">E-mail: info@olfatshipping.com / olfatshipping@outlook.com / www.olfatshipping.com</span>
        </p>
    </div>
</div>

</body>

</html>
