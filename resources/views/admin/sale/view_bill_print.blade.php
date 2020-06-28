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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">SALE RETURN MEMO</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 20px; ">
                <div style="margin-left: 20px">
                    <h4>To,</h4>
                    @if($view_bill->client_name)
                        <b>{{ $view_bill->client_name }}</b><br>
                    @endif

                    @if($view_bill->address)
                        {{ $view_bill->address }}<br>
                    @endif

                    @if($view_bill->contact_no)
                        {{ $view_bill->contact_no }}
                    @endif
                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">
                <h4>Return Invoice</h4>
                <b>Ref No:</b>{{$sell_view->ref_no }}<br>
                <b>Date : </b> <?=date('d-M-Y',$view_bill->entry_date)?>
            </div>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ; margin-top: 20px" >
                <thead>
                <tr >
                    <th>SL No.</th>
                    <th>Product Description</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>

                @if(sizeof($entry_info) > 0)
                    <?php $i = 1; $total_quantity = 0;?>
                    @foreach($entry_info as $single_sale_entry)

                        <?php

                        $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_sale_entry->product_id)->first();
                        $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_sale_entry->product_type_id)->first();
                        $total_quantity += $single_sale_entry->quantity;
                        ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$product_type_info->cname}}<br>
                                {{ $product_info->product_name }}<br>
                                {{ $product_info->description }}<br>
                            </td>
                            <td>{{$single_sale_entry->quantity}}</td>
                            <td>{{$single_sale_entry->product_rate}}</td>
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

                <tr>
                    <td rowspan="" colspan="2">

                    </td>
                    <td colspan="2" class="lower_parts_text_class">Total Amount</td>
                    <td class="lower_parts_class"><?=$view_bill->total_payable?></td>
                </tr>


                <tr>
                    <td colspan="2" class="">
                    <?php
                    $t = $view_bill->total_payable;
                    $tt = str_replace(",","", $t);
                    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                    $n = $f->format($tt);

                    //$ntw = new \NTWIndia\NTWIndia();
                    //$n = $ntw->numToWord( $tt );
                    ?>
                    <!-- <p class="balance_words"><b>Total: <?php //echo ucfirst($n)?> Taka Only</b></p>						 -->
                        <b class="text-left"><?=ucwords($n)?> Taka Only</b>
                    </td>
                    <td colspan="2" class="lower_parts_text_class"><b>Grand Total</b></td>
                    <td class="lower_parts_class"><b><?=$view_bill->total_payable ?></b></td>
                </tr>
            </table>
        </div>

    </div>


        <script>
            window.print();
        </script>


</div>
