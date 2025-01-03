<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage Claim Voucher</title>
    <style>
        body {
            font-family: "Times New Roman", Serif;
            margin: 0;
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

        .text-right {
            text-align: right;
        }

        table tr td, table tr th {
            font-size: 12px;
        }

        .arabic-text {
            font-family: "Tajawal", sans-serif;
            font-weight: normal;
        }

        .fw-bold {
            font-weight: bold;
        }

        .arabic-text {
            font-family: "Tajawal", sans-serif;
            font-weight: 400;
        }

        tr, td {
            margin: 0;
            padding: 2px;
        }

        table {
            border-collapse: collapse;
        }
        .fw-normal{
            font-weight: normal;
        }
        .ff-tnr{
            font-family: "Times New Roman", serif;
        }
        .label-color {
            color: #d1652b
        }
        .border-dotted{
            border-bottom: 2px dotted #d1652b;
        }
        .border-radius{
            border: 2px solid #d1652b;
        }
    </style>
</head>
<body>
<div>

    <header style="width: 100%;">
        <table width="100%">
            <tr>
                <td style="text-align: right;">
                    <small>
                        <strong>Generated
                            AT: {{ \Illuminate\Support\Carbon::parse(now())->format('d/m/Y H:i:s') }}</strong>
                    </small>
                </td>
            </tr>
        </table>
    </header>
    <div>
        <table width="100%">
            <tr>
                <td>
                    <div class="">
                        <img width="140"
                             src="{{--{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('/uploads/images/logo.png')))}}--}}">
                    </div>
                </td>
                <td align="right">
                    <div style="color: #d1652b; font-size: 18px;">
                        <h2 style="">Abdul Razeq Olfat Used Car Tr L.L.C</h2>
                    </div>
                </td>
            </tr>
        </table>
        <hr style="color: #403a94; margin: 6px;">
    </div>

    <div>

        <table style="width: 100%">
            <tr>
                <td align="left" style="padding-right: 12px;">
                    <table>
                        <tr>
                            <td class="border-radius" style="padding: 12px 20px;"><strong>{{ number_format(abs($data->approve_amount), 2) }}</strong></td>
                            <td class="border-radius" style="padding: 12px;">AED</td>
                        </tr>
                    </table>
                </td>
                <td align="center">
                    <div><div class="label-color ff-tnr" style="font-size: 20px;">DAMAGE CLAIM</div></div>
                </td>
                <td align="right">
                    <div style="">
                        <span class="label-color fw-bold border-dotted">DATE:</span>
                        <span class="fw-bold" dir="ltr" style="border-bottom: 2px dotted #000;">
                            {{ \Carbon\Carbon::parse($data->approve_reject_at)->format('d-m-Y') }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br> <br>
    <section>
        <h4 class="border-dotted" style="margin-bottom: 30px;">
            <span class="label-color">CUSTOMER NAME:</span>
            <span class="fw-normal" dir="ltr">
                {{ $data->vehicle->customer?->name }}
            </span>
        </h4>
        <h4 class="border-dotted" style="margin-bottom: 30px;">
            <span class="label-color">CLAIM AMOUNT:</span>
            <span class="fw-bold" dir="ltr">
                {{ number_format(abs($data->claim_amount), 2) }}
            </span>
        </h4>
        <h4 class="border-dotted" style="margin-bottom: 30px;">
            <span class="label-color">APPROVED AMOUNT:</span>
            <span class="fw-bold" dir="ltr">
                {{ number_format( abs($data->approve_amount), 2 ) }}
            </span>
        </h4>
        <h4 class="border-dotted" style="margin-bottom: 30px;">
            <span class="label-color">VIN:</span>
            <span class="fw-normal" dir="ltr">
                {{ $data?->vehicle?->vin }} ({{ $data->title }})
            </span>
        </h4>

        <h4 class="border-dotted" style="margin-bottom: 30px;">
            <span class="label-color">DESCRIPTION:</span>
            <span class="fw-normal" dir="ltr">
                {!! $data->description !!}
            </span>
        </h4>
    </section>

    <div class="mb-5" style="width: 100%; padding: 10px;">
        <table style="margin-top: 50px; margin-bottom: 10px; width: 100%;">
            <tr>
                <td style=" color: #d1652b; text-align: left; height: 70px;  vertical-align:  bottom;">
                    <h3 style="width: 130px; text-align: center; vertical-align:  sub;">
                        <div class="voucher-text-container">
                            <span class="voucher-text" style="border-top: 2px dotted #d1652b;">Customer Sign</span>
                        </div>
                    </h3>
                </td>
                <td style=" color: #d1652b; text-align: right; height: 70px;  vertical-align:  bottom;">
                    <h3 style="width: 130px; text-align: center;">
                        <div class="voucher-text-container">
                            <span class="voucher-text" style="border-top: 2px dotted #d1652b;">Authorized By</span>
                        </div>
                    </h3>
                </td>
            </tr>
        </table>
    </div>
    <br>

    <div style="border-top: 4px solid #403a94;">
        <div style="margin-top: 5px;">
            <div style="font-size: 13px; margin-bottom: 0; text-align: center" >Tel: 065360031, Mob: 0562826798, P.O.Box:83864, Street #23, Industrial Area No. 4, Sharjah- U.A.E</div>
            <div style="font-size: 13px; margin-bottom: 0; margin-top: 5px; text-align: center" >E-mail: info@olfatshipping.com / olfatshipping@outlook.com / www.olfatshipping.com</div>
        </div>
    </div>
</div>
</body>
</html>
