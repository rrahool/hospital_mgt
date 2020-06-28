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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">STORE WISE ITEMS</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <?php
            $warehouse_info = \Illuminate\Support\Facades\DB::table('warehouse')->where('id', $warehouse_id)->first();
            ?>

                <h4>{{$warehouse_info->warehouse_name}} <br> Opening Balance: {{$op_qt}} </h4>

                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                    <thead>
                    <tr >
                        <th>Sl.</th>
                        <th>Catagory</th>
                        <th>Particulars</th>
                        <th>Qty Per Carton</th>
                        <th>Buy</th>
                        <th>Sale</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Sale Return</th>
                        <th>Purchase Return</th>
                        <th>Balance</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php
                        $i = 1;
                    $total_c = 0;
                    $total_buy = 0;
                    $total_sale = 0;
                    $total_in = 0;
                    $total_out = 0;
                    $total_sr = 0;
                    $total_pr = 0;
                    $total_bl = 0;
                    ?>
                    @foreach($info_array as $info)

                        <?php

                            $purchase_qt = $info['purchase_qt'];
                            $qt_per_carton = $info['qt_per_carton'];
                            $sale_qt = $info['sale_qt'];
                            $product_in_qt = $info['product_in_qt'];
                            $product_out_qt = $info['product_out_qt'];
                            $sale_return_qt = $info['sale_return_qt'];
                            $purchase_return_qt = $info['purchase_return_qt'];
                            $op_qt += $purchase_qt - $purchase_return_qt - $sale_qt + $sale_return_qt + $product_in_qt - $product_out_qt;


                            $total_c = 0;
                            $total_buy += $purchase_qt;
                            $total_sale += $sale_qt;
                            $total_in += $product_in_qt;
                            $total_out += $product_out_qt;
                            $total_sr += $sale_return_qt;
                            $total_pr += $purchase_return_qt;
                            $total_bl = $op_qt;
                        ?>
                        <tr >
                            <td>{{$i}}</td>
                            <td>{{$info['cat_name']}}</td>
                            <td>{{$info['product_name']}}</td>
                            <td class="txt_align_right">{{$qt_per_carton}}</td>
                            <td class="txt_align_right">{{$purchase_qt}}</td>
                            <td class="txt_align_right">{{$sale_qt}}</td>
                            <td class="txt_align_right">{{$product_in_qt}}</td>
                            <td class="txt_align_right">{{$product_out_qt}}</td>
                            <td class="txt_align_right">{{$sale_return_qt}}</td>
                            <td class="txt_align_right">{{$purchase_return_qt}}</td>
                            <td class="txt_align_right">{{$op_qt}}</td>
                        </tr>

                        <?php $i++;?>
                    @endforeach
                    </tbody>
                    <tr >

                        <td class="txt_align_right" colspan="4  "><b>Total:</b></td>
                        <td class="txt_align_right"><b>{{$total_buy}}</b></td>
                        <td class="txt_align_right"><b>{{$total_sale}}</b></td>
                        <td class="txt_align_right"><b>{{$total_in}}</b></td>
                        <td class="txt_align_right"><b>{{$total_out}}</b></td>
                        <td class="txt_align_right"><b>{{$total_sr}}</b></td>
                        <td class="txt_align_right"><b>{{$total_pr}}</b></td>
                        <td class="txt_align_right"><b>{{$total_bl}}</b></td>
                    </tr>
                </table>

        </div>
    </div>
</div>
</body>
</html>
