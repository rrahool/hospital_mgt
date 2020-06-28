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

        .td-w-15{
            width:15%;
            height:20px;
            padding: 5px;
        }

        .td-w-40{
            width:40%;
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
    $from_date_arr = explode('/', $from_d);
    $to_date_arr = explode('/', $to_d);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PARTY WISE SUMMARIZED {{$heading}} STATEMENT</div>
        <div style="margin-top: 5px"> <span style="font-weight: bold">From: {{$from_date_arr[1]}}/{{$from_date_arr[0]}}/{{$from_date_arr[2]}} To: {{$to_date_arr[1]}}/{{$to_date_arr[0]}}/{{$to_date_arr[2]}}</span> </div><br>
        {{--        <div>Till {{$date}}</div>--}}
    </div>


    <div >


        <b>PARTY NAME: {{$party_name}}</b><br>
        <table width="100%"  cellspacing="0" cellpadding="0"  align="center" style="border-collapse: collapse;border:1px solid black ; margin-bottom: 20px; margin-top: 5px" >
            <thead>
            <tr >
                <th >Product Name</th>
                <th >Carton Quantity</th>
{{--                <th >Pieces</th>--}}
                <th >Rate</th>
                <th >Amount</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $total_amount = 0;
            $total_carton_qt = 0;
            $total_pieces = 0;
            ?>

            @foreach($arr_info as $key => $value)

                @if($arr_info[$key] != null)
                    <tr style="height: 40px">
                        <td colspan="5"><b>{{$key}}</b></td>
                    </tr>
                    <?php
                    $products_arr = $arr_info[$key];
                    $c_amount = 0;
                    $c_carton_qt = 0;
                    $c_pieces = 0;
                    foreach ($products_arr as $k=>$val){
                    $product_info = $products_arr[$k];
                    $product_name = $product_info['product_name'];
                    $rate = $product_info['rate'];
                    $qt_per_carton = $product_info['qt_per_carton'];
                    $sale_qt = $product_info['sale_qt'];
                    $carton_amount = $product_info['carton_amount'];
                    $amount = $product_info['amount'];

                    $carton_qt = intval($sale_qt / $qt_per_carton);
                    $pieces = intval($sale_qt % $qt_per_carton);

                    //$amount = $sale_qt*$rate;

                    $c_carton_qt += $carton_qt;
                    $c_pieces += $pieces;
                    $c_amount += $amount;

                    $total_carton_qt += $carton_qt;
                    $total_pieces += $pieces;
                    $total_amount += $amount;

                    ?>
                    <tr>
                        <td class="txt_align_center td-w-40">{{$product_name}}</td>
                        <td class="txt_align_right td-w-15">{{$carton_qt}}</td>
                        {{--                    <td class="txt_align_right td-w-15">{{$pieces}}</td>--}}
                        <td class="txt_align_right td-w-15">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $carton_amount)}}</td>
                        <td class="txt_align_right td-w-15">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                    </tr>
                    <?php
                    }?>
                    <tr>
                        <td class="txt_align_right td-w-40"><b>CATEGORY WISE TOTAL</b></td>
                        <td class="txt_align_right td-w-15"><b>{{$c_carton_qt}}</b></td>
                        {{--                    <td class="txt_align_right td-w-15"><b>{{$c_pieces}}</b></td>--}}
                        <td class="txt_align_right td-w-15"></td>
                        <td class="txt_align_right td-w-15"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $c_amount)}}</b></td>
                    </tr>
                    <?php

                    ?>

                @endif
            @endforeach
            <tr>
                <td class="txt_align_right td-w-40"><b>TOTAL</b></td>
                <td class="txt_align_right td-w-15"><b>{{$total_carton_qt}}</b></td>
{{--                <td class="txt_align_right td-w-15"><b>{{$total_pieces}}</b></td>--}}
                <td class="txt_align_right td-w-15"></td>
                <td class="txt_align_right td-w-15"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
            </tr>

            </tbody>
        </table>

    </div>
</div>
</div>
</body>
</html>
