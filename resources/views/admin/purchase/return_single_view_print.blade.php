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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PURCHASE RETURN</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 20px; ">
                <div style="margin-left: 20px">
                    <b>Company Name : </b>{{ $supplier_info->executive_name }} <br>
                    <b>Supplier Name : </b>{{ $supplier_info->supplier_name }} <br>
                    @if($supplier_info->address )
                        <b>Address : </b>{{ ucfirst($supplier_info->address )}} <br>
                    @endif
                    @if($supplier_info->email)
                        <b>E-mail : </b>{{ $supplier_info->email }} <br>
                    @endif
                    @if($supplier_info->contact_no)
                        <b>Contact : </b>{{ $supplier_info->contact_no }} <br>
                    @endif
                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">
                <b>Supplier Memo No : </b>{{ $supplier_info->memo_no }}<br>
                ref : <strong>RP</strong>-{{ $supplier_info->r_id }}
                <br> {{ date('d-M-Y',$supplier_info->entry_date) }} <br>
            </div>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ; margin-top: 20px" >
                <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Product Description</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>
                </thead>

                <tbody>
                @if(sizeof($single_purchases_return) > 0)
                    <?php $i = 1; ?>
                    @foreach($single_purchases_return as $single_purchase)

                        <?php

                        $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_purchase->product_id)->first();
                        $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_purchase->product_type_id)->first();
                        ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$product_type_info->cname}}<br>
                                {{ $product_info->product_name }}<br>
                                {{ $product_info->description }}<br>
                            </td>
                            <td>{{$single_purchase->quantity}}</td>
                            <td>{{$single_purchase->product_rate}}</td>
                            <td>{{$single_purchase->total}}</td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                @else
                    <tr>
                        <td style="color: red">Data not found ....</td>
                    </tr>
                @endif
                </tbody>

                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>{{$supplier_info->total}}</td>
                </tr>

                <tr>

                    <td rowspan="1" colspan="2">

                        <?php

                        $t = $supplier_info->total;
                        $tt = str_replace(",","", $t);

                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                        $n = $f->format($tt);


                        ?>


                        <center><b><?=ucwords($n)?> Taka Only</b></center>

                    </td>

                    <td colspan="2"> Total</td>

                    <td colspan=""> <?=$supplier_info->total?></td>

                </tr>
                </tfoot>
            </table>

            <div style="margin-left: 15px; font-size: 16px">
                <p>
                    Kindly acknowledge the receipt and take your necessary action.<br/><br/>
                    ------------<br/>
                    <?php echo '<b>'.ucfirst($supplier_info->username).'</b>'; ?>
                </p>
            </div>
        </div>

    </div>





</div>
