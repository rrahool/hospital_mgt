<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill Report</title>

    <style>


        td{
            padding: 5px;
            /*border: 1px solid black;*/
        }
        th{
            font-size: 18px;
            /*border: 1px solid black;*/
        }

        .no_border{
            border: none;
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

        .signature{
            text-decoration: overline;
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
        <div style="font-size: 20px; font-weight: bold">CENTRAL CITY HOSPITAL & DIAGNOSTIC</div>
        <div style="margin-top: 5px">1284/A O.R. Nizam Rd, Chittagong 4203</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">MONEY RECEIPT</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">

            <div style="width: 100%;float: left;margin-bottom: 40px; ">
                <div style="margin-left: 20px">

                    <table cellspacing="0" cellpadding="0"  style="border-collapse: collapse; align: right; border: none">

                        <tr style="border: none">
                            <td style="text-align: left; border: none"> <b>Bill No </b> </td>
                            <td style="text-align: left; border: none">: {{$sell_view->memo_no }}</td>
                            <td style="text-align: left; border: none"> <b>Date </b> </td>
                            <td style="text-align: left; border: none">: <?=date('d-M-Y',$sell_view->entry_date)?></td>
                            <td><br></td>
                            <td style="text-align: left; border: none"> <b>Delivery Date </b> </td>
                            <td style="text-align: left; border: none">: <?=date('d-M-Y',$sell_view->delivery_date)?></td>
                        </tr>


                        <tr style="border: none">
                            <td style="text-align: left; border: none"> <b>Patient Name  </b> </td>
                            <td style="text-align: left; border: none">: {{ $sell_view->patient_name}}</td>
                        </tr>

                        <tr style="border: none">
                            <td style="text-align: left; border: none"> <b>Sex </b> </td>
                            <td style="text-align: left; border: none">: {{ $sell_view->gender}}</td>
                            <td style="text-align: left; border: none"> <b>Age  </b> </td>
                            <td style="text-align: left; border: none">: {{ $sell_view->age}}</td>
                            <td><br></td>
                            <td style="text-align: left; border: none"> <b>Contact No.  </b> </td>
                            <td style="text-align: left; border: none">: {{ $sell_view->contact_no}}</td>
                        </tr>

                        <tr style="border: none">
                            <td style="text-align: left; border: none"> <b>Ref By </b> </td>
                            <td style="text-align: left; border: none">: {{ $sell_view->client_name}}</td>
                        </tr>

                    </table>

                </div>
            </div>

        </div>
        
        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style=" margin-top: 20px" >
                <thead>
                <tr class="no_border" style="width: 100%">
                    <th class="no_border">Code</th>
                    <th class="no_border txt_align_left">Description</th>
                    <th class="no_border txt_align_left">Price (Tk.)</th>
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
                        ?>
                        <tr class="no_border">
                            <td class="no_border txt_align_center" style="width: 10%">{{$product_info->code }}</td>
                            <td class="no_border txt_align_left">
                                {{ $product_info->product_name }}<br>
                            </td>
                            <td class="no_border txt_align_left" style="width: 20%">{{number_format($single_sale_entry->total, 2)}}</td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                @else
                    <tr class="no_border">
                        <td class="no_border" style="color: red">Data not found ....</td>
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

                    <td class="no_border txt_align_right" colspan="2" class="lower_parts_text_class">Total Amount: </td>
                    <td class="no_border" class="lower_parts_class"><?=$sell_view->total_price?></td>
                </tr>
                @if($sell_view->discount != 0)
                    <tr class="no_border">
                        <td class="no_border txt_align_right" colspan="2" class="lower_parts_text_class">Discount (-<?=$sell_view->discount_p?>%):</td>
                        <td class="no_border" class="lower_parts_class"><?=number_format($sell_view->discount, 2)?></td>
                    </tr>

                    
                @endif
                @if($sell_view->vat != 0)
                    <tr >
                        <td class="no_border txt_align_right" colspan="2" class="lower_parts_text_class">Advance: </td>
                        <td class="no_border" class="lower_parts_class"><?=number_format($sell_view->vat, 2)?></td>
                    </tr>

                    <tr class="no_border" >

                        <td class="no_border" colspan="2" class="lower_parts_text_class">
                            
                            <div class="row">
                                <div class="col-md-8" style="font-size: 30px; font-weight: bold; text-align: center;">
                                    @if($sell_view->total_price - $sell_view->discount == $sell_view->vat)
                                        <span>Paid</span>
                                    @else
                                        <span>Due</span>
                                    @endif
                                </div>

                                <div class="col-md-4" style="font-size: 18px; text-align: right; font-weight: bold">
                                     Balance:
                                </div>
                            </div>
                        </td>
                        <td class="no_border" class="lower_parts_class" style="font-weight: bold;">
                            <br><br>
                            <?= 
                                number_format($sell_view->total_price - $sell_view->vat - $sell_view->discount, 2);
                            ?>
                        </td>
                    </tr>
                @endif
                @if($sell_view->tax != 0)
                    <tr >
                        <td class="no_border" colspan="2" class="lower_parts_text_class">Tax (+<?=$sell_view->tax_p ?>%)</td>
                        <td class="lower_parts_class no_border"><?=$sell_view->tax ?></td>
                    </tr>
                @endif

                <?php
                $paid_info = \Illuminate\Support\Facades\DB::table('entries')->select('dr_total')->where('sale_purchase_id', 'sale_received_'.$id)->first();
                ?>

                @if(!empty($paid_info))
                    <tr class="no_border">
                        <td class="no_border" colspan="2"></td>
                        <td class="no_border" colspan="2" class="lower_parts_text_class">Paid Amount</td>
                        <td class="lower_parts_class no_border"><?=$paid_info->dr_total?></td>
                    </tr>
                @endif

            </table>

            <table width="75%" cellspacing="0" cellpadding="0"  align="center" style=" margin-top: 20px">
                <tr>
                    <td><br></td>
                </tr>
                <tr style="border: none" >
                        <td class="no_border txt_align_left signature">Prepared by</td>
                        <td class="no_border txt_align_right signature">Authorized by</td>
                </tr>
            </table>
        </div>

    </div>


        <script>
            window.print();
        </script>



</div>
