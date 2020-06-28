<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>


        td{
            padding: 5px;
            border: 1px solid black;
        }
        th{
            border: 1px solid black;
        }

        .td-w-10{
            width:10%;
            height:20px;
            padding: 5px;
        }

        .td-w-10{
            width:10%;
            height:20px;
            padding: 5px;
        }

        .td-w-15{
            width:15%;
            height:20px;
            padding: 5px;
        }
        .td-w-30{
            width:30%;
            height:20px;
            padding: 5px;
        }





        .txt_align_center{
            text-align: center;
        }

        .txt_align_left{
            text-align: left;
        }

        .txt_align_right{
            text-align: right;
        }

        .margin_right{
            margin-right: 5px
        }


        .margin_left_50{
            margin-left: 50px;
        }

    </style>

</head>
<body>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("d/m/Y");
?>

<div style="padding: 20px">
    <?php
    //$from_date_arr = explode('-', $from_date);
    $to_date_arr = explode('/', $date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">CLOSING STOCK & VALUE</div>
        <div style="margin-top: 5px"> <span style="font-weight: bold">AS ON DATE: {{$to_date_arr[0].'/'.$to_date_arr[1].'/'.$to_date_arr[2]}}</span> </div><br>
        {{--        <div>Till {{$date}}</div>--}}
    </div>


    <div >


{{--        <b>ITEN NAME: {{$product_name}}</b>--}}
        <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse: collapse;border:1px solid black ; margin-bottom: 20px; margin-top: 5px" >
            <thead>
            <tr >
                <th class="td-w-30">Item Particular</th>
                <th class="td-w-10">Carton Quantity</th>
                <th class="td-w-10">Pieces</th>
                <th class="td-w-10">Pieces/Carton</th>
                <th class="td-w-10">Closing Quantity</th>
                <th class="td-w-15">Rate</th>
                <th class="td-w-15">Stock Value</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $total_carton = 0;
            $total_pieces = 0;
            $total_closing_qt = 0;
            $total_amount = 0;
            ?>
            @foreach($info_arr as $key => $value)

                <?php
                $info = $info_arr[$key];
                $product_name = $info['product_name'];
                $carton = $info['carton'];
                $pieces = $info['pieces'];
                $qt_per_carton = $info['qt_per_carton'];
                $closing_qt = $info['closing_qt'];
                $rate = $info['rate'];
                $amount = $info['amount'];

                $total_carton += $carton;
                $total_pieces += $pieces;
                $total_closing_qt += $closing_qt;
                $total_amount += $amount;

                ?>

                <tr>
                    <td class="txt_align_center ">{{$product_name}}</td>
                    <td class="txt_align_right">{{$carton}}</td>
                    <td class="txt_align_right ">{{$pieces}}</td>
                    <td class="txt_align_right">{{$qt_per_carton}}</td>
                    <td class="txt_align_right ">{{$closing_qt}}</td>
                    <td class="txt_align_right ">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rate)}}</td>
                    <td class="txt_align_right ">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                </tr>

            @endforeach
            <tr>
                <td class="txt_align_right "><b>TOTAL:</b></td>
                <td class="txt_align_right"><b>{{$total_carton}}</b></td>
                <td class="txt_align_right "><b>{{$total_pieces}}</b></td>
                <td class="txt_align_right"></td>
                <td class="txt_align_right "><b>{{$total_closing_qt}}</b></td>
                <td class="txt_align_right "></td>
                <td class="txt_align_right "><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
            </tr>
            </tbody>
        </table>

    </div>
</div>
</div>
</body>
</html>
