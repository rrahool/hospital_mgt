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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PARTY WISE SALES STATEMENT - DETAILS</div>
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
                    <th>Invoice</th>
                    <th>Store Name</th>
                    <th>Catagory</th>
                    <th>Item Particulars</th>
                    <th>Carton Qty</th>
                    <th>Pieces</th>
                    <th>Total Quantity</th>
                    <th>Rate</th>
                    <th>Particular <br> Discount</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody>

                @foreach($dates_arr as  $key=>$value)
                    <?php
                        $sale_info_date = $dates_arr[$key];
                        $date = date('d/m/Y', $sale_info_date);
                        $discounts =DB::table('memo_account')->select('discount', 'total_price', 'tax', 'vat')->where('client_id', $client_id)->where('entry_date', $sale_info_date)->get();

                        $total_discount = 0;
                        $total_vat = 0;
                        $total_tax = 0;
                        $net_amount = 0;

                        foreach ($discounts as $discount){
                            $total_discount += str_replace(',', '', $discount->discount);
                            $total_vat += str_replace(',', '', $discount->vat);
                            $total_tax += str_replace(',', '', $discount->tax);
                            $net_amount += str_replace(',', '', $discount->total_price);
                        }
                        $sale_infos = DB::table('memo_account')->where('client_id', $client_id)->where('entry_date', $sale_info_date)->get();

                    ?>
                <tr>
                    <td colspan="9"><b>Date: {{$date}} ---- Total Discount: {{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_discount)}} ---- Total VAT: {{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_vat)}} ---- Total TAX: {{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_tax)}}  ---- Net Amount: {{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $net_amount-$total_discount+$total_vat+$total_tax)}}</b></td>
                </tr>

                    <?php
                        $total_carton = 0;
                        $total_pieces = 0;
                        $total_quantity = 0;
                        $total_amount = 0;
                    ?>

                    @foreach($sale_infos as $sale_info)
                        <?php
                            $sale_entries = \Illuminate\Support\Facades\DB::table('memo_entry')->where('memo_id', $sale_info->id)->get();
                        ?>
                        @foreach($sale_entries as $sale_entry)
                            <?php
                                $warehouse_name = \Illuminate\Support\Facades\DB::table('warehouse')->select('warehouse_name')->where('id', $sale_entry->warehouse_id)->first()->warehouse_name;
                                $product_name = \Illuminate\Support\Facades\DB::table('product_info')->select('product_name')->where('id', $sale_entry->product_id)->first()->product_name;
                                $total_qt = $sale_entry->quantity;
                                $carton = intval($total_qt / $sale_entry->qt_per_carton);
                                $pieces = $total_qt % $sale_entry->qt_per_carton;
                                $product_rate = $sale_entry->product_rate;
                                $single_discount = $sale_entry->single_discount;
                                $amount = str_replace(',', '', $sale_entry->product_rate )* str_replace(',', '', $total_qt);
                                $amount -= $single_discount;

                                $cat_name = \Illuminate\Support\Facades\DB::table('catagory')->select('cname')->where('id',$sale_entry->product_type_id)->first()->cname;

                            $total_carton += $carton;
                            $total_pieces += $pieces;
                            $total_quantity += $total_qt;
                            $total_amount += $amount;
                            ?>
                            <tr >
                                <td class="txt_align_center">{{$sale_info->memo_no}} </td>
                                <td class="txt_align_center">{{$warehouse_name}}</td>
                                <td class="txt_align_center">{{$cat_name}}</td>
                                <td class="txt_align_center">{{$product_name}}</td>
                                <td class="txt_align_right">{{$carton}} x {{$sale_entry->qt_per_carton}}</td>
                                <td class="txt_align_right">{{$pieces}}</td>
                                <td class="txt_align_right">{{$total_qt}}</td>
                                <td class="txt_align_right">{{$product_rate}}</td>
                                <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $single_discount)}}</td>
                                <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                            </tr>
                         @endforeach
                    @endforeach
                    <tr >
                        <td colspan="3"></td>
                        <td class="txt_align_right"><b>Sub Total: </b></td>
                        <td class="txt_align_right"><b>{{$total_carton}}</b></td>
                        <td class="txt_align_right"><b>{{$total_pieces}}</b></td>
                        <td class="txt_align_right"><b>{{$total_quantity}}</b></td>
                        <td></td>
                        <td></td>
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
