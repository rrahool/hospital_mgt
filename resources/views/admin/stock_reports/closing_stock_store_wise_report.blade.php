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

        .td-w-8{
            width:8%;
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
        .td-w-20{
            width:20%;
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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">ITEM STOCK</div>
        <div style="margin-top: 5px"> <span style="font-weight: bold">Date: {{$to_date_arr[0].'/'.$to_date_arr[1].'/'.$to_date_arr[2]}}</span> </div><br>
        {{--        <div>Till {{$date}}</div>--}}
    </div>


    <div >


        <b>WAREHOUSE NAME: {{$warehouse_name}}</b><br>
        <b>CATAGORY NAME: {{$cat_name}}</b><br><br>
        <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ; margin-bottom: 20px; margin-top: 5px" >
            <thead>
            <tr >
                <th >Product Name</th>
                <th >Carton Quantity</th>
                <th >Pieces</th>
                {{--<th >Pieces/Carton</th>--}}
                <th >Closing Quantity</th>
                <th >Stock Value</th>
            </tr>
            </thead>

            <tbody>

            @foreach($info_array as $key => $value)

                <?php
                $info = $info_array[$key];
                $product_name = $info['product_name'];
                $qt_per_carton = $info['qt_per_carton'];
                $carton = $info['carton'];
                $pieces = $info['pieces'];
                $closing_qt = $info['closing_qt'];
                $amount = $info['amount'];

                ?>

                <tr>
                    <td class="txt_align_left td-w-20">{{$product_name}}</td>
                    <td class="txt_align_right td-w-20">{{$carton}} x {{$qt_per_carton}}</td>
                    <td class="txt_align_right td-w-20">{{$pieces}}</td>
                    {{--<td class="txt_align_right"></td>--}}
                    <td class="txt_align_right td-w-20">{{$closing_qt}}</td>
                    <td class="txt_align_right td-w-20">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>
</div>
</div>
</body>
</html>
