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
            text-align: center
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


<div style="padding: 20px">
    <?php
    //$from_date_arr = explode('-', $from_date);
    //$to_date_arr = explode('-', $to_date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">SALE MEMO (Office Copy)</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 20px; ">
                <div style="margin-left: 20px">
                    @if($sell_view->patient_name)
                        <tr style="border: none">
                            <td style="text-align: left; border: none"><b>Patient Name: </b></td>
                            <td style="border: none">{{ $sell_view->patient_name}}<br></td>
                        </tr>
                    @endif
                    @if($sell_view->client_name)
                        <b>Referrer Name: </b>{{ $sell_view->client_name }}<br>
                    @endif

                    @if($sell_view->address)
                        <b>Address:</b> {{ $sell_view->address }}<br>
                    @endif

                    @if($sell_view->contact_no)
                        <b>Mob No: </b>{{ $sell_view->contact_no }}
                    @endif
                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">
{{--                <h4>CHALLAN</h4>--}}
                <b>Memo No: </b>{{$sell_view->memo_no }}<br>
                <tr style="border: none">
                    <td style="text-align: left; border: none"><b>Delivery Date: </b></td>
                    <td style="border: none"><?=date('d-M-Y',$sell_view->delivery_date)?><br></td>
                </tr>
                <b>Date: </b> <?=date('d-M-Y',$sell_view->entry_date)?>
            </div>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ; margin-top: 20px" >
                <thead>
                <tr >
                    <th>SL No.</th>
                    <th>Test Name</th>
                    <th>Rate</th>
                </tr>
                </thead>
                <tbody>

                @if(sizeof($single_sale_entries) > 0)
                    <?php $i = 1; $total_quantity = 0;?>
                    @foreach($single_sale_entries as $single_sale_entry)

                        <?php

                        $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_sale_entry->product_id)->first();
                        $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_sale_entry->product_type_id)->first();
                        $total_quantity += $single_sale_entry->quantity;
                        $warehouse_name = \Illuminate\Support\Facades\DB::table('warehouse')->select('warehouse_name')->where('id', $single_sale_entry->warehouse_id)->first()->warehouse_name;
                        ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                {{ $product_info->product_name }}<br>
                            </td>
                            <td>{{$single_sale_entry->total}}</td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                @else
                    <tr>
                        <td style="color: red">Data not found ....</td>
                    </tr>
                @endif
                </tbody>

                <?php
                if($sell_view->discount != 0 && $sell_view->vat != 0 && $sell_view->tax != 0)
                {
                    $row_span = 4;
                }
                else if($sell_view->discount != 0 && $sell_view->vat != 0 || $sell_view->discount != 0 && $sell_view->tax != 0 || $sell_view->tax != 0 && $sell_view->vat != 0)
                {
                    $row_span = 3;
                }
                else if($sell_view->discount != 0 || $sell_view->vat != 0 || $sell_view->tax != 0)
                {
                    $row_span = 2;
                }
                else $row_span = 1;
                ?>
                <tr>

                    <td colspan="2" class="lower_parts_text_class">Total Amount</td>
                    <td class="lower_parts_class"><?=$sell_view->total_price?></td>
                </tr>
                @if($sell_view->discount != 0)
                    <tr >
                        <td colspan="2" class="lower_parts_text_class">Discount (-<?=$sell_view->discount_p?>%)</td>
                        <td class="lower_parts_class"><?=$sell_view->discount?></td>
                    </tr>

                    <tr >
                        <td colspan="2" class="lower_parts_text_class">Grand Total</td>
                        <td class="lower_parts_class"><?= $sell_view->total_price - $sell_view->discount?></td>
                    </tr>
                @endif
                @if($sell_view->vat != 0)
                    <tr >
                        <td colspan="2" class="lower_parts_text_class">Vat (+<?=$sell_view->vat_p?>%)</td>
                        <td class="lower_parts_class"><?=$sell_view->vat?></td>
                    </tr>
                @endif
                @if($sell_view->tax != 0)
                    <tr >
                        <td colspan="2" class="lower_parts_text_class">Tax (+<?=$sell_view->tax_p ?>%)</td>
                        <td class="lower_parts_class"><?=$sell_view->tax ?></td>
                    </tr>
                @endif

                <?php
                $paid_info = \Illuminate\Support\Facades\DB::table('entries')->select('dr_total')->where('sale_purchase_id', 'sale_received_'.$id)->first();
                ?>

                @if(!empty($paid_info))
                    <tr >
                        <td colspan="4"></td>
                        <td colspan="2" class="lower_parts_text_class">Paid Amount</td>
                        <td class="lower_parts_class"><?=$paid_info->dr_total?></td>
                    </tr>
                @endif


            </table>
        </div>

    </div>



        <script>
            window.print();
        </script>

</div>
