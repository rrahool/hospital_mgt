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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PURCHASE MEMO</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 20px; ">
                <div style="margin-left: 20px">
                    Supplier Name : {{ $showInfo->supplier_name }}<br>
                    @if($showInfo->executive_name)
                        Company Name : {{ $showInfo->executive_name }}<br>
                    @endif
                    @if($showInfo->address)
                        Address : {{ $showInfo->address }}<br>
                    @endif
                    @if($showInfo->email)
                        E-mail : {{ $showInfo->email}}<br>
                    @endif
                    @if($showInfo->remarks != null)
                        Remarks : {{ $showInfo->remarks }} <br>
                    @endif
                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">
                @if($showInfo->contact_no)
                    Contact : {{ $showInfo->contact_no }}<br>
                @endif
                Supplier Memo No : {{ $showInfo->memo_no }} <br>

                Ref : <strong>P-{{ $showInfo->pid }}</strong> <br>
                Date : {{ date('d-M-Y',$showInfo->entry_date) }}<br>
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
                @if(sizeof($single_purchases) > 0)
                    <?php $i = 1; ?>
                    @foreach($single_purchases as $single_purchase)

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
                    <td>{{$showInfo->total}}</td>
                </tr>

                <?php
                if($showInfo->discount != 0 && $showInfo->vat != 0 && $showInfo->tax != 0)
                {
                    $row_span = 4;
                }
                else if($showInfo->discount != 0 && $showInfo->vat != 0 || $showInfo->discount != 0 && $showInfo->tax != 0 || $showInfo->tax != 0 && $showInfo->vat != 0)
                {
                    $row_span = 3;
                }
                else if($showInfo->discount != 0 || $showInfo->vat != 0 || $showInfo->tax != 0)
                {
                    $row_span = 2;
                }
                else $row_span = 1;
                ?>

                @if($showInfo->discount != 0)
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">Discount (-{{$showInfo->discount_p}}%)</td>
                        <td class="lower_parts_class">{{$showInfo->discount}} </td>
                    </tr>
                @endif

                @if($showInfo->vat != 0)
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">VAT (+{{$showInfo->vat_p}}%)</td>
                        <td class="lower_parts_class"><b>{{$showInfo->vat}} </td>
                    </tr>
                @endif

                @if($showInfo->tax != 0)
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">TAX (+{{$showInfo->tax_p}}%)</td>
                        <td class="lower_parts_class">{{$showInfo->tax}}</td>
                    </tr>
                @endif

                <tr>
                    <td rowspan="<?=$row_span?>" colspan="2">
                        <?php
                        $due = 0;
                        $due += str_replace(",","", $showInfo->total);
                        $due -= str_replace(",","", $showInfo->discount);
                        $due += str_replace(",","", $showInfo->vat);
                        $due += str_replace(",","", $showInfo->tax);

                        //$t = $ac['due'];
                        $t = $due;
                        $tt = str_replace(",","", $t);


                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                        $n = $f->format($tt);
                        ?>
                        <center><b><?=ucfirst($n)?> Taka Only</b></center>
                    </td>

                    <td colspan="2"><b>Grand Total</b></td>
                    <td class="lower_parts_class"><b><?=number_format($due, 2, '.', ',');//$ac['due']?></b></td>
                </tr>
                </tfoot>
            </table>

            <div style="margin-left: 15px; font-size: 16px">
                <p>
                    Kindly acknowledge the receipt and take your necessary action.<br/><br/>
                    ------------<br/>
                    <?php echo '<b>'.ucfirst($showInfo->username).'</b>'; ?>
                </p>
            </div>
        </div>

    </div>





</div>
