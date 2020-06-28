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

        .td-w-5{
            width:7%;
            height:20px;
            padding: 5px;
        }

        .td-w-10{
            width:10%;
            height:20px;
            padding: 5px;
        }

        .td-w-25{
            width:25%;
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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">STORE WISE ITEM REGISTER</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <?php
            $warehouse_info = \Illuminate\Support\Facades\DB::table('warehouse')->where('id', $warehouse_id)->first();
            ?>

            <h4>Store: {{$warehouse_info->warehouse_name}} <br>Product Name: {{$product_name}}<br> Opening Balance: {{$op_qt}} </h4>


            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th class="td-w-10">Date</th>
                    <th class="td-w-25">Particulars</th>
                    <th class="td-w-5">C Qty</th>
                    <th class="td-w-5">Buy</th>
                    <th class="td-w-5">Sale</th>
                    <th class="td-w-10">Memo</th>
                    <th class="td-w-5">In</th>
                    <th class="td-w-5">Out</th>
                    <th class="td-w-5">Sale Return</th>
                    <th class="td-w-5">Purchase Return</th>
                    <th class="td-w-10">Balance</th>
                </tr>
                </thead>


                <tbody>
                <?php
                $closing_qt = $op_qt;
                $total_carton_qt = 0;
                $total_purchase = 0;
                $total_purchase_r = 0;
                $total_sale = 0;
                $total_sale_r = 0;
                $total_in = 0;
                $total_out = 0;
                ?>
                    @foreach($info_array as $k => $val)
                       <?php

                                $date = $val['date'];
                                $party = $val['party'];
                                $memo = $val['memo'];
                                $c_qt = $val['c_qt'];
                                $purchase = $val['p'];
                                $purchase_return = $val['p_r'];
                                $sale = $val['s'];
                                $sale_return = $val['s_r'];
                                $in = $val['in'];
                                $out = $val['out'];

                                $closing_qt += $purchase - $sale - $purchase_return  + $sale_return + $in - $out;
                                $total_purchase += $purchase;
                                $total_purchase_r += $purchase_return;
                                $total_sale += $sale;
                                $total_sale_r += $sale_return;
                                $total_in += $in;
                                $total_out += $out;
                                $total_carton_qt += $c_qt;
                                ?>
                       <tr >
                           <td class="txt_align_center">{{$date}}</td>
                           <td class="txt_align_left">{{$party}}</td>
                           <td class="txt_align_right">{{$c_qt}}</td>
                           <td class="txt_align_right">{{$purchase}}</td>
                           <td class="txt_align_right">{{$sale}}</td>
                           <td class="txt_align_center">{{$memo}}</td>
                           <td class="txt_align_right">{{$in}}</td>
                           <td class="txt_align_right">{{$out}}</td>
                           <td class="txt_align_right">{{$sale_return}}</td>
                           <td class="txt_align_right">{{$purchase_return}}</td>
                           <td class="txt_align_right">{{$closing_qt}}</td>
                       </tr>

                    @endforeach
                <tr >
                    <td class="txt_align_right" style="height: 30px" colspan="2"><b>TOTAL</b></td>
                    <td class="txt_align_right"><b>{{$total_carton_qt}}</b></td>
                    <td class="txt_align_right"><b>{{$total_purchase}}</b></td>
                    <td class="txt_align_right"><b>{{$total_sale}}</b></td>
                    <td class="txt_align_right"></td>
                    <td class="txt_align_right"><b>{{$total_in}}</b></td>
                    <td class="txt_align_right"><b>{{$total_out}}</b></td>
                    <td class="txt_align_right"><b>{{$total_sale_r}}</b></td>
                    <td class="txt_align_right"><b>{{$total_purchase_r}}</b></td>
                    <td class="txt_align_right"><b>{{$closing_qt}}</b></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</body>
</html>
