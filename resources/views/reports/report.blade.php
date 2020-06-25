<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name', 'Laravel') }} - Daily Report</title>

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
          <img src="{{asset('img/zai_cafe.png')}}" style="height: auto;width: 950%; align-items: center"/>
          </pre>
            </td>
            <td align="right" style="font-size: 20px;line-height: 1.5;">
                ZAI CAFE
            </td>
            <td align="right">
                <span style="font-size: 20px;font-weight: bold; text-align: right;">Daily Report</span><br><br>
            </td>
        </tr>
    </table>
    <table id="items">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Portions</th>
                <th>Unit Cost</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $sno = 1;
            @endphp @foreach ($items as $item)
            @php
            $subtotal = $item->price * $item->portions;
            @endphp
            <tr>
                <td>{{$sno}}</td>
                <td>{{$item->item}}</td>
                <td align="right">{{$item->quantity}}</td>
                <td align="right">{{$item->portions}}</td>
                <td align="right">{{number_format($item->price,2)}}</td>
                <td align="right">
                    @php $sno += 1; $total += $subtotal;
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
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td></td>

            <td colspan="2">
                <table id="summation">
                    <tr>
                        <td>Expected Income</td>
                        <td><b>{{number_format($total,2)}}</b></td>
                    </tr>
                    <tr>
                        <td>Actual Income</td>
                        <td><b>{{number_format($report->actual_amount,2)}}</b>
                            {{$report->currency}}</td>
                    </tr>

                    <tr style="background-color: #D7CECE;">
                        <td><b>DIFFERENCE</b></td>
                        <td>
                            <b>{{number_format(($report->actual_amount-$total),2)}}

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>