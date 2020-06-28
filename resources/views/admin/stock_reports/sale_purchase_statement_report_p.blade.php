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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PURCHASE STATEMENT</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th>Item Particulars</th>
                    <th>Unit</th>
                    <th>Carton</th>
                    <th>Pieces</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $grand_carton = 0;
                $grand_pieces = 0;
                $grand_qty = 0;
                $grand_amount = 0;
                ?>
                @foreach($entry_dates as $entry_date )

                    <?php
                    $purchase_infos = \Illuminate\Support\Facades\DB::table('purchase_main')->select('purchase_main.entry_no','purchase_main.discount','purchase_main.vat','purchase_main.tax','purchase_main.due','purchase_main.id','purchase_main.warehouse_id', 'supplier_info.supplier_name')->where('entry_date',$entry_date->entry_date)
                        ->join('supplier_info', 'supplier_info.id', '=', 'purchase_main.supplier_id')->get();
                    ?>

                    @foreach($purchase_infos as $purchase_info)
                        <tr>
                            <td colspan="7"><b>DATE: {{date('d/m/Y', $entry_date->entry_date)}}     ----    PARTY NAME: {{$purchase_info->supplier_name}}     ----    BILL NO: {{$purchase_info->entry_no}}     @if($purchase_info->discount != 0)----    Discount: {{$purchase_info->discount}}@endif     @if($purchase_info->tax != 0)----    Tax: {{$purchase_info->tax}}@endif     @if($purchase_info->vat!=0)----    Vat: {{$purchase_info->vat}}@endif     ----    Total: {{$purchase_info->due}}</b></td>
                        </tr>

                        <?php
                        $purchase_entries = \Illuminate\Support\Facades\DB::table('purchase_single')->where('purchase_id', $purchase_info->id)->get();

                        $total_carton = 0;
                        $total_pieces = 0;
                        $total_qty = 0;
                        $total_amount = 0;
                        ?>
                        @foreach($purchase_entries as $purchase_entry)
                            <?php
                            $product_name = \Illuminate\Support\Facades\DB::table('product_info')->select('product_name')->where('id', $purchase_entry->product_id)->first()->product_name;
                            $store_name = \Illuminate\Support\Facades\DB::table('warehouse')->select('warehouse_name')->where('id', $purchase_info->warehouse_id)->first()->warehouse_name;

                            $carton = intval($purchase_entry->quantity / $purchase_entry->qt_per_carton);
                            $pieces = intval($purchase_entry->quantity % $purchase_entry->qt_per_carton);
                            $amount = str_replace(',', '', $purchase_entry->quantity) * str_replace(',', '', $purchase_entry->product_rate);


                            $total_carton += $carton;
                            $total_pieces += $pieces;
                            $total_qty += $purchase_entry->quantity;
                            $total_amount += $amount;
                            ?>
                            <tr>
                                <td class="txt_align_left">{{$product_name}}</td>
                                <td class="txt_align_center">{{$store_name}}</td>
                                <td class="txt_align_center">{{$carton}} x {{$purchase_entry->qt_per_carton}}</td>
                                <td class="txt_align_center">{{$pieces}}</td>
                                <td class="txt_align_center">{{$purchase_entry->quantity}}</td>
                                <td class="txt_align_right">{{$purchase_entry->product_rate}}</td>
                                  <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="txt_align_right" colspan="2"><b>Sub Total</b></td>
                            <td class="txt_align_center"><b>{{$total_carton}}</b></td>
                            <td class="txt_align_center"><b>{{$total_pieces}}</b></td>
                            <td class="txt_align_center"><b>{{$total_qty}}</b></td>
                            <td class="txt_align_right"></td>
                            <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
                        </tr>
                        <?php
                        $grand_carton += $total_carton;
                        $grand_pieces += $total_pieces;
                        $grand_qty += $total_qty;
                            $grand_amount += str_replace(',', '', $purchase_info->due);
//                        $grand_amount += $total_amount;
                        ?>
                    @endforeach


                @endforeach

                <tr>
                    <td class="txt_align_right" colspan="2"><h3>Grand Total</h3></td>
                    <td class="txt_align_center"><h3>{{$grand_carton}}</h3></td>
                    <td class="txt_align_center"><h3>{{$grand_pieces}}</h3></td>
                    <td class="txt_align_center"><h3>{{$grand_qty}}</h3></td>
                    <td class="txt_align_right"></td>
                    <td class="txt_align_right"><h3>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $grand_amount)}}</h3></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
