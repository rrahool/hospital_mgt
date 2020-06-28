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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PARTY WISE SUMMARIZED SALES STATEMENT</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 0px; ">
                <div style="margin-left: 0px">
                    <h4>PARTY NAME: {{$client_name}}</h4>

                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">

            </div>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th>Item Name</th>
                    <th>Carton Qty</th>
                    <th>Pieces</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Discount</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody>
                    @foreach($catagories as $catagory)
                        <tr>
                            <td colspan="6">
                                <?php
                                    $cat_name = \Illuminate\Support\Facades\DB::table('catagory')->where('id',$catagory->id)->first()->cname;
                                ?>
                                <b>Catagory Particular: {{$cat_name}}</b>
                            </td>
                        </tr>

                        <?php
                            $memo_infos = \Illuminate\Support\Facades\DB::table('memo_entry')
                                ->select('product_info.product_name', 'memo_entry.qt_per_carton', 'memo_entry.single_discount', 'memo_entry.quantity','memo_entry.product_rate')
                                ->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
                                ->join('product_info', 'product_info.id', '=', 'memo_entry.product_id')
                                ->whereBetween('memo_account.entry_date', [$from_date, $to_date])
                                ->where('memo_account.client_id', $client_id)
                                ->where('memo_entry.product_type_id', $catagory->id)
                                ->get();

                            $total_carton = 0;
                            $total_pieces = 0;
                            $total_discount = 0;
                            $total_amount = 0;
                            $total_qt = 0;
                        ?>

                        @foreach($memo_infos as $memo_info)
                            <?php
                            $single_discount = $memo_info->single_discount;
                            $carton = intval($memo_info->quantity / $memo_info->qt_per_carton);
                            $pieces = intval($memo_info->quantity % $memo_info->qt_per_carton);
                            $amount = str_replace(',', '', $memo_info->quantity) * str_replace(',', '', $memo_info->product_rate);
                            $amount -= $single_discount;

                            $total_carton += $carton;
                            $total_pieces += $pieces;
                            $total_discount += $single_discount;
                            $total_amount += $amount;
                            $total_qt += $memo_info->quantity;
                            ?>
                            <tr>
                                <td><span style="margin-left: 25px">{{$memo_info->product_name}}</span></td>
                                <td class="txt_align_right">{{$carton}} x {{$memo_info->qt_per_carton}}</td>
                                <td class="txt_align_right">{{$pieces}}</td>
                                <td class="txt_align_right">{{$memo_info->quantity}}</td>
                                <td class="txt_align_right">{{$memo_info->product_rate}}</td>
                                <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $single_discount)}}</td>
                                <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="txt_align_right"><b>CATAGORY WISE TOTAL: </b></td>
                            <td class="txt_align_right"><b>{{$total_carton}}</b></td>
                            <td class="txt_align_right"><b>{{$total_pieces}}</b></td>
                            <td class="txt_align_right">{{$total_qt}}</td>
                            <td class="txt_align_right"></td>
                            <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_discount)}}</b></td>
                            <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
