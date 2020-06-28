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

        .td-w-7{
            width:7%;
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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">ITEM REGISTER - QTY WISE</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <?php
            $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $product_id)->first();
            ?>
            <h3>Product: {{$product_info->product_name}}</h3>
            @foreach($info_array_new as $key => $value)
                <?php
                $warehouse_name =\Illuminate\Support\Facades\DB::table('warehouse')->where('id', $key)->first()->warehouse_name;

                $op_qt = 0;

                $op_purchase_qt = DB::table('purchase_single')->select('purchase_single.quantity')
                    ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
                    ->whereBetween('purchase_single.entry_date', [$constant_date, $before_from_date])
                    ->where('purchase_single.product_id', $product_id)
                    ->where('purchase_main.warehouse_id', $key)
                    ->sum('purchase_single.quantity');

                $op_purchase_return_qt = DB::table('purchase_return_main')->select('quantity')->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
                    ->whereBetween('purchase_return_main.entry_date', [$constant_date, $before_from_date])
                    ->where('purchase_return_details.product_id', $product_id)
                    ->where('purchase_return_main.warehouse_id', $key)
                    ->sum('quantity');

                $op_sales_qt = DB::table('memo_entry')->select('quantity')->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
                    ->whereBetween('memo_account.entry_date', [$constant_date, $before_from_date])
                    ->where('memo_entry.product_id', $product_id)
                    ->where('memo_entry.warehouse_id', $key)
                    ->sum('quantity');
                $op_sale_return_qt = DB::table('return_memo_account')->select('quantity')->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
                    ->whereBetween('return_memo_account.entry_date', [$constant_date, $before_from_date])
                    ->where('return_memo_entry.product_id', $product_id)
                    ->where('return_memo_entry.warehouse_id', $key)
                    ->sum('quantity');

                $op_product_in_qt = DB::table('warehouse_product_transfer')->select('quantity')
                    ->where('warehouse_product_transfer.product_id', $product_id)
                    ->where('warehouse_product_transfer.to_warehouse', $key)
                    ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');

                $op_product_out_qt = DB::table('warehouse_product_transfer')->select('quantity')
                    ->where('warehouse_product_transfer.product_id', $product_id)
                    ->where('warehouse_product_transfer.from_warehouse', $key)
                    ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');


                $op_qt += $op_purchase_qt - $op_sales_qt - $op_purchase_return_qt  + $op_sale_return_qt + $op_product_in_qt - $op_product_out_qt;
                ?>


                <h4>Store: {{$warehouse_name}} <br> Opening Balance: {{$op_qt}} </h4>

                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                    <thead>
                    <tr >
                        <th class="td-w-10">Date</th>
                        <th class="td-w-20">Particulars</th>
                        <th class="td-w-7">C. Qty</th>
                        <th class="td-w-7">Pieces</th>
                        <th class="td-w-7">Buy</th>
                        <th class="td-w-7">Sale</th>
                        <th class="td-w-7">Memo</th>
                        <th class="td-w-7">In</th>
                        <th class="td-w-7">Out</th>
                        <th class="td-w-7">Sale Return</th>
                        <th class="td-w-7">Purchase Return</th>
                        <th class="td-w-7">Balance</th>
                    </tr>
                    </thead>

                    <?php
                    $total_c = 0;
                    $total_buy = 0;
                    $total_sale = 0;
                    $total_in = 0;
                    $total_out = 0;
                    $total_sr = 0;
                    $total_pr = 0;
                    $total_bl = 0;
                    ?>
                    @foreach($info_array_new[$key] as $info)
                        <?php
                        $date = date('d/m/Y', $info['entry_date']);
                        $quantity = $info['quantity'];
                        $flag= $info['flag'];
                        $id= $info['id'];
                        $memo= $info['memo'];
                        $qt_per_carton= $info['qt_per_carton'];


                        if($flag == 'purchase' || $flag == 'purchase_return')
                            $name = \Illuminate\Support\Facades\DB::table('supplier_info')->where('id', $id)->first()->supplier_name;
                        elseif($flag == 'sale' || $flag == 'sale_return')
                            $name = \Illuminate\Support\Facades\DB::table('clients')->where('id', $id)->first()->client_name;
                        elseif($flag == 'in' || $flag == 'out')
                            $name = \Illuminate\Support\Facades\DB::table('warehouse')->where('id', $id)->first()->warehouse_name;

                        ?>
                        <tbody>
                        <tr >
                            <td>{{$date}}</td>
                            <td>{{$name}}</td>
                            <td class="txt_align_right">{{intval($quantity / $qt_per_carton)}}</td>
                            <td class="txt_align_right">{{intval($quantity % $qt_per_carton)}}</td>

                            @if($flag == 'purchase')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt+= $quantity;  $total_buy += $quantity; ?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif

                            @if($flag == 'sale')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt -= $quantity; $total_sale += $quantity; ?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif

                            <td class="txt_align_center">{{$memo}}</td>
                            @if($flag == 'in')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt += $quantity; $total_in += $quantity;?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif
                            @if($flag == 'out')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt -= $quantity; $total_out += $quantity;?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif

                            @if($flag == 'sale_return')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt += $quantity; $total_sr += $quantity;?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif

                            @if($flag == 'purchase_return')
                                <td class="txt_align_right">{{$quantity}}</td>
                                <?php $op_qt -= $quantity; $total_pr += $quantity;?>
                            @else
                                <td class="txt_align_right">0</td>
                            @endif

                            <td class="txt_align_right">{{$op_qt}}</td>
                        </tr>
                        </tbody>
                    @endforeach
                    <tr >

                        <td class="txt_align_right"></td>
                        <td class="txt_align_right"><b>Total:</b></td>
                        <td class="txt_align_right"></td>
                        <td class="txt_align_right"></td>
                        <td class="txt_align_right"><b>{{$total_buy}}</b></td>
                        <td class="txt_align_right"><b>{{$total_sale}}</b></td>
                        <td class="txt_align_right"><b></b></td>
                        <td class="txt_align_right"><b>{{$total_in}}</b></td>
                        <td class="txt_align_right"><b>{{$total_out}}</b></td>
                        <td class="txt_align_right"><b>{{$total_sr}}</b></td>
                        <td class="txt_align_right"><b>{{$total_pr}}</b></td>
                        <td class="txt_align_right"><b>{{$op_qt}}</b></td>
                    </tr>
                </table>
                <div style="text-align: right;"><b>C/P Qty: {{$qt_per_carton}}  Carton: {{intval($op_qt / $qt_per_carton)}}  Pieces Qty: {{intval($op_qt % $qt_per_carton)}}  Qty: {{$op_qt}}</b></div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
