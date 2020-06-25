<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>{{ config('app.name', 'Laravel') }} - Proforma</title>

        <style type="text/css">
            * {
                font-family: Verdana, Arial, sans-serif;
            }

            table {
                font-size: x-small;
            }

            #summation {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                text-align: right;
            }

            #summation td,
            #summation th {
                border: 1px solid #ddd;
                font-size: 10px;
                padding: 4px
            }

            #items {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #items td,
            #items th {
                border: 1px solid #ddd;
                font-size: 10px;
                padding: 4px,
            }

            #items tr:nth-child(even) {
                /*background-color: #f2f2f2;*/
            }

            .gray {
                background-color: lightgray;
            }
        </style>
    </head>

    <body>
        <table width="100%">
            <tr>
                <td>
                    <pre>
          <img src="{{public_path('img/netphone.jpg')}}" style="height: auto;width: 950%; align-items: center"/>
          </pre>
                </td>
                <td align="right" style="font-size: 9px;line-height: 1.5;">
                    www.netphone.co.tz <br>
                    P.0.Box 13992, Arusha-Tanzania.<br>
                    Kaloleni, near Kaloleni Secondary School <br>
                    Office: +255 272 545 746, Mobile: +255 765 037 010 <br>
                    Email: info@netphone.co.tz, william@netphone.co.tz<br>
                </td>
                <td align="right">
                    <span style="font-size: 20px;font-weight: bold; text-align: right;">Proforma Invoice</span><br><br>
                    <span>TIN: 121-378-507</span> <br />
                    <span>VRN: 40-033236-I</span> 
                    
                </td>
            </tr>
            <tr>
                <td style="line-height: 1.6">
                    <b>Customer</b><br>
                    {{$proforma->name}} <br>
                    P.O BOX {{$proforma->postal}} <br>
                    {{$proforma->location}} <br>
                    {{$proforma->contact}} <br>
                </td>
                <td style="line-height: 1.6" align="center">
                    <b>Proforma Number</b> <br>
                    {{$proforma->notes}} <br><br>
                    <b>Date of Issue</b> <br>
                    {{$proforma->date}}

                </td>
                <td style="line-height: 1.6" align="center">
                    <b>Exchange Rate</b> <br>
                    {{$proforma->exchange_rate??"0.00"}} <br><br>
                    <b>Currency</b> <br>
                    {{$proforma->currency}}
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <h4 class="text-capitalize">FOR: {{strtoupper($proforma->for)}}</h4>
                </td>
            </tr>
        </table>
        <table id="items">
            <thead style="background-color: lightgray;">
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; $sno = 1;
                @endphp @foreach ($items as $item)
                <tr>
                    <td>{{$sno}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->specification}}</td>
                    <td align="right">{{$item->quantity}}</td>
                    <td align="right">{{number_format($item->price,2)}}</td>
                    <td align="right">
                        @php $subtotal = $item->price * $item->quantity; $sno += 1; $total += $subtotal;
                        echo(number_format($subtotal,2));
                        @endphp
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table style="width:100%">
            <tr>
                <td colspan="3" style="border: 1px lightblue">
                    <span><b>Bank Account Details</b></span><br><br>
                    NETPHONE TECHNOLOGY<br>
                    NMB-BANK PLC<br>
                    SWIFT CODE: NMIBTZTZ <br>
                    TZS Account: 42810004541<br>
                </td>
                <td></td>

                <td colspan="2">
                    <table id="summation">
                        <tr>
                            <td>Material Cost</td>
                            <td><b>{{number_format($total,2)}}</b> {{$proforma->currency}}</td>
                        </tr>
                        <tr>
                            <td>Labor Charge</td>
                            <td><b>{{number_format($proforma->labor_charge,2)}}</b>
                                {{$proforma->currency}}</td>
                        </tr>
                        <tr>
                            <td>VAT Cost<small>({{$proforma->vat}}%)</small>
                            </td>
                            <td>@php $vat = ($total+$proforma->labor_charge) * ($proforma->vat/100); @endphp
                                <b>{{number_format($vat,2)}}</b>{{$proforma->currency}}
                            </td>
                        </tr>
                        <tr style="background-color: #D7CECE;">
                            <td><b>TOTAL COST</b></td>
                            <td>
                                @php
                                $final_total=($total + $proforma->labor_charge +$vat);
                                @endphp
                                <b>{{number_format($final_total,2)}}
                                </b>{{$proforma->currency}}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 9px">Advance Payments</td>
                            <td>{{$proforma->advance}} %
                                <small>({{number_format($final_total * ($proforma->advance / 100),2)}})</small>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <h3 style="text-align: center;background-color: darkblue;color: white">TERMS AND CONDITIONS</h3>
        <table>
            <tr style="font-size: 9px">
                <td>
                    <ol>
                        <li>This quotation is valid for 30 days from the date of issue</li>
                        <li><b>Payment: {{$proforma->advance}}% Advance</b>. Overdue accounts will be charged at 3% per
                            month</li>
                        <li>Delivery period: 7-15 days from the date of payment confirmation from our bank.</li>
                        <li>Prices are net FOB source. We can arrange for the delivery of the goods at an additional
                            cost for
                            all towns outside our delivery footage.
                        </li>
                    </ol>
                </td>
                <td>
                    <ol start="5">
                        <li>Relation of title: Title and right of property of the product shall pass to the buyer only
                            after the
                            product has been paid in full to the seller
                        </li>
                        <li>E & OE - Netphone Technologies reserves the right to correct any errors</li>
                        <li>All prices exclude VAT, unless otherwise stated</li>
                        <li>Specification: Our quotation covers the items of equipment specified only and does not cover
                            any alterations or addition that may be necessary to either new or existing building or
                            installations
                        </li>
                        <li>Installation not included unless otherwise stated.</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;font-size: 8px">
                    <b>Our services</b> <br> Intercom (PBX & VOIP) | LAN | WAN | Fiber Network solution | Computer
                    Hardware & Software
                    maintenance | CCTV & security systems | Electric Fence | Website design and hosting VSAT Satellite |
                    Internet Services
                </td>
            </tr>
        </table>
    </body>

</html>