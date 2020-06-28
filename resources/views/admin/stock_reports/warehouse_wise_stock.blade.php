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
    //$to_date_arr = explode('-', $to_date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">ITEM WISE STORE STOCK</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>


    <div >
        @foreach($product_ids as $product_id)
            <?php
            $product_name = \Illuminate\Support\Facades\DB::table('product_info')->select('product_name')->where('id', $product_id->product_id)->first()->product_name;
            ?>


            <b>ITEN NAME: {{$product_name}}</b>
        <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ; margin-bottom: 20px; margin-top: 5px" >
            <thead>
            <tr >
                <th >Warehouse</th>
                <th >Carton Quantity</th>
                <th >Pieces</th>
                {{--<th >Pieces/Carton</th>--}}
                <th >Closing Quantity</th>
                <th >Stock Value</th>
            </tr>
            </thead>

            <tbody>





                <?php
                    $warehouse_infos = \Illuminate\Support\Facades\DB::table('warehouse_product')
                        ->select('warehouse_product.*', 'warehouse.warehouse_name')
                        ->join('warehouse', 'warehouse.id', '=', 'warehouse_product.warehouse_id')
                        ->where('product_id', $product_id->product_id)->get();

                    $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $product_id->product_id)->first();

                    $warehouse_wise_carton_qt = 0;
                    $warehouse_wise_pieces_qt = 0;
                    $warehouse_wise_pp_carton = 0;
                    $warehouse_wise_closing_qt = 0;
                    $warehouse_wise_stock_value = 0;

                ?>
                @foreach($warehouse_infos as $warehouse_info)
                    <?php
                    $rate_per_quantity = $product_info->sell;
                    $available_qt = $warehouse_info->available_qt;
                    $available_carton = intval($available_qt / $product_info->qt_per_carton);
                    $available_pieces = intval($available_qt % $product_info->qt_per_carton);
                    $closing_qt = $available_qt;
                    $stock_value = $closing_qt * $rate_per_quantity;

                    $warehouse_wise_carton_qt += $available_carton;
                    $warehouse_wise_pieces_qt += $available_pieces;
                    $warehouse_wise_pp_carton += $product_info->qt_per_carton;
                    $warehouse_wise_closing_qt += $closing_qt;
                    $warehouse_wise_stock_value += $stock_value;

                    ?>
                <tr>
                    <td class="txt_align_left td-w-20">{{$warehouse_info->warehouse_name}}</td>
                    <td class="txt_align_right td-w-20">{{$available_carton}} x {{$product_info->qt_per_carton}}</td>
                    <td class="txt_align_right td-w-20">{{$available_pieces}}</td>
                    {{--<td class="txt_align_right"></td>--}}
                    <td class="txt_align_right td-w-20">{{$available_qt}}</td>
                    <td class="txt_align_right td-w-20">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $stock_value)}}</td>
                </tr>
                    @endforeach
                <tr>
                    <td class="txt_align_right"><b>Total: </b></td>
                    <td class="txt_align_right"><b>{{$warehouse_wise_carton_qt}}</b></td>
                    <td class="txt_align_right"><b>{{$warehouse_wise_pieces_qt}}</b></td>
                    {{--<td class="txt_align_right"><b>{{$warehouse_wise_pp_carton}}</b></td>--}}
                    <td class="txt_align_right"><b>{{$warehouse_wise_closing_qt}}</b></td>
                    <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $warehouse_wise_stock_value)}}</b></td>
                </tr>

            </tbody>
        </table>
        @endforeach
    </div>
</div>
</div>
</body>
</html>
