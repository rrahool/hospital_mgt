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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">SALE STATEMENT</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th>Catagory</th>
                    <th>Item Particulars</th>
                    <th>Unit</th>
                    <th>Carton</th>
                    <th>Pieces</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Particular Discount</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $grand_carton = 0;
                $grand_pieces = 0;
                $grand_qty = 0;
                $grand_discount = 0;
                $grand_amount = 0;
                ?>
                    @foreach($entry_dates as $entry_date )

                        <?php
                            $memo_infos = \Illuminate\Support\Facades\DB::table('memo_account')->select('memo_account.memo_no','memo_account.id', 'clients.client_name')->where('entry_date',$entry_date->entry_date)
                                ->join('clients', 'clients.id', '=', 'memo_account.client_id')->get();
                        ?>

                        @foreach($memo_infos as $memo_info)
                        <tr>
                            <td colspan="8"><b>DATE: {{date('d/m/Y', $entry_date->entry_date)}}     ----    PARTY NAME: {{$memo_info->client_name}}     ----    BILL NO: {{$memo_info->memo_no}} </b></td>
                        </tr>

                            <?php
                                $memo_entries = \Illuminate\Support\Facades\DB::table('memo_entry')->where('memo_id', $memo_info->id)->get();

                            $total_carton = 0;
                            $total_pieces = 0;
                            $total_qty = 0;
                            $total_discount = 0;
                            $total_amount = 0;
                            ?>
                            @foreach($memo_entries as $memo_entry)
                                <?php
                                    $product_name = \Illuminate\Support\Facades\DB::table('product_info')->select('product_name')->where('id', $memo_entry->product_id)->first()->product_name;
                                    $store_name = \Illuminate\Support\Facades\DB::table('warehouse')->select('warehouse_name')->where('id', $memo_entry->warehouse_id)->first()->warehouse_name;
                                $cat_name = \Illuminate\Support\Facades\DB::table('catagory')->select('cname')->where('id',$memo_entry->product_type_id)->first()->cname;

                                $carton = intval($memo_entry->quantity / $memo_entry->qt_per_carton);
                                $pieces = intval($memo_entry->quantity % $memo_entry->qt_per_carton);
                                $single_discount = $memo_entry->single_discount;
                                $amount = str_replace(',', '', $memo_entry->quantity) * str_replace(',', '', $memo_entry->product_rate);
                                $amount -= $single_discount;


                                $total_carton += $carton;
                                $total_pieces += $pieces;
                                $total_qty += $memo_entry->quantity;
                                $total_discount += $single_discount;
                                $total_amount += $amount;
                                    ?>
                                <tr>
                                    <td class="txt_align_left">{{$cat_name}}</td>
                                    <td class="txt_align_left">{{$product_name}}</td>
                                    <td class="txt_align_center">{{$store_name}}</td>
                                    <td class="txt_align_center">{{$carton}} x {{$memo_entry->qt_per_carton}}</td>
                                    <td class="txt_align_center">{{$pieces}}</td>
                                    <td class="txt_align_center">{{$memo_entry->quantity}}</td>
                                    <td class="txt_align_right">{{$memo_entry->product_rate}}</td>
                                    <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $single_discount)}}</td>
                                    <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="txt_align_right" colspan="3"><b>Sub Total</b></td>
                                <td class="txt_align_center"><b>{{$total_carton}}</b></td>
                                <td class="txt_align_center"><b>{{$total_pieces}}</b></td>
                                <td class="txt_align_center"><b>{{$total_qty}}</b></td>
                                <td class="txt_align_right"></td>
                                <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_discount)}}</b></td>
                                <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
                            </tr>
                            <?php
                            $grand_carton += $total_carton;
                            $grand_pieces += $total_pieces;
                            $grand_qty += $total_qty;
                            $grand_discount += $total_discount;
                            $grand_amount += $total_amount;
                            ?>
                        @endforeach


                    @endforeach
                    <tr>
                        <td class="txt_align_right" colspan="3"><h3>Grand Total</h3></td>
                        <td class="txt_align_center"><h3>{{$grand_carton}}</h3></td>
                        <td class="txt_align_center"><h3>{{$grand_pieces}}</h3></td>
                        <td class="txt_align_center"><h3>{{$grand_qty}}</h3></td>
                        <td class="txt_align_right"></td>
                        <td class="txt_align_right"><h3>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $grand_discount)}}</h3></td>
                        <td class="txt_align_right"><h3>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $grand_amount)}}</h3></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
