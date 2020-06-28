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

        .td-w-12{
            width:12%;
            height:20px;
            padding: 5px;
        }
        .td-w-15{
            width:15%;
            height:20px;
            padding: 5px;
        }

        .td-w-28{
            width:28%;
            height:20px;
            padding: 5px;
        }



        .td-w-12{
            width:12%;
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

    </style>

</head>
<body>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("d/m/Y");
?>

<div style="padding: 20px">
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">CLOSING STOCK & VALUE</div>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <?php

            $to_date = date('d-m-Y', $to_date);
            ?>

            <h4>As On Date: {{$to_date}}</h4>



            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th>Item Particular</th>
                    <th>Carton Qty</th>
                    <th>Pieces</th>
                    <th>Qty Per Carton </th>
                    <th>Closing Quantity</th>
                    <th>Rate</th>
                    <th>Stock Value</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $total_c = 0;
                $total_p = 0;
                $total = 0;
                $total_amount = 0;
                ?>
                @foreach($info_arr as $key => $value)
                    <?php
                    if (sizeof($info_arr[$key]) != 0){
                    $cat_name =\Illuminate\Support\Facades\DB::table('catagory')->where('id', $key)->first()->cname;
                    $infos = $info_arr[$key];

                    $sub_total_c = 0;
                    $sub_total_p = 0;
                    $sub_total = 0;
                    $sub_total_amount = 0;

                    ?>
                    <tr >
                        <td colspan="7"><b style="font-size: 20px; padding: 15px">{{$cat_name}}</b></td>
                    </tr>

                    @foreach($infos as  $info)

                        <?php
                        if (sizeof($info) != 0){
                        $product_name = $info['product_name'];
                        $carton = $info['carton'];
                        $pieces = $info['pieces'];
                        $qt_per_carton = $info['qt_per_carton'];
                        $quantity = $info['quantity'];
                        $rate = $info['rate'];
                        $amount = $info['amount'];

                        $sub_total_c += $carton;
                        $sub_total_p += $pieces;
                        $sub_total += $quantity;
                        $sub_total_amount += $amount;


                        $total_c += $carton;
                        $total_p += $pieces;
                        $total += $quantity;
                        $total_amount += $amount;
                        ?>
                        <tr >
                            <td ><span style="margin-left: 50px">{{$product_name}}</span></td>
                            <td class="txt_align_right">{{$carton}} x {{$qt_per_carton}}</td>
                            <td class="txt_align_right">{{$pieces}}</td>
                            <td class="txt_align_right">{{$qt_per_carton}}</td>
                            <td class="txt_align_right">{{$quantity}}</td>
                            <td class="txt_align_right">{{$rate}}</td>
                            <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                        </tr>

                        <?php } ?>
                    @endforeach

                    <tr >
                        <td class="txt_align_right"><b>Sub Total:</b></td>
                        <td class="txt_align_right"><b>{{$sub_total_c}}</b></td>
                        <td class="txt_align_right"><b>{{$sub_total_p}}</b></td>
                        <td class="txt_align_right"><b></b></td>
                        <td class="txt_align_right"><b>{{$sub_total}}</b></td>
                        <td class="txt_align_right"><b></b></td>
                        <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sub_total_amount)}}</b></td>
                    </tr>
                    <?php } ?>
                @endforeach

                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr >
                    <td class="txt_align_right"><b style="font-size: 20px; padding: 15px">Total:</b></td>
                    <td class="txt_align_right"><b style="font-size: 20px; ">{{$total_c}}</b></td>
                    <td class="txt_align_right"><b style="font-size: 20px; ">{{$total_p}}</b></td>
                    <td class="txt_align_right"><b></b></td>
                    <td class="txt_align_right"><b style="font-size: 20px; ">{{$total}}</b></td>
                    <td class="txt_align_right"><b style="font-size: 20px; "></b></td>
                    <td class="txt_align_right"><b style="font-size: 20px; ">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
                </tr>
                </tbody>

            </table>

        </div>
    </div>
</div>
</body>
</html>
