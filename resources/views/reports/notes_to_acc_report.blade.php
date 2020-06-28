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
    $from_date_arr = explode('-', $from_date);
    $to_date_arr = explode('-', $to_date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">NOTES TO ACCOUNT</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                <thead>

                <tr >
                    <th class="td-w-28 txt_align_center"><span style="margin-left: 10px"></span></th>
                    <th colspan="2" class=" txt_align_center" >Opening Balance</th>
                    <th colspan="2" class="td-w-12 txt_align_center" >Transaction Between</th>
                    <th colspan="2" class="td-w-12 txt_align_center" >Closing Balance</th>
                </tr>
                <tr >
                    <th class="td-w-28 txt_align_center"><span style="margin-left: 10px">Particulars</span></th>
                    <th class="td-w-12 txt_align_center" >Debit</th>
                    <th class="td-w-12 txt_align_center" >Credit</th>
                    <th class="td-w-12 txt_align_center" >Debit</th>
                    <th class="td-w-12 txt_align_center" >Credit</th>
                    <th class="td-w-12 txt_align_center" >Debit</th>
                    <th class="td-w-12 txt_align_center" >Credit</th>
                </tr>
                </thead>
                <tbody>

                @foreach($leds as $led)
                    <?php

//                    $led_name = str_replace('_', ' ', $led->name);
                    $led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led->name));

                    //opening balance
                    $op_dr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->whereBetween('transaction_date', [$constant_date, $before_from_date])->sum('amount');
                    $op_cr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->whereBetween('transaction_date', [$constant_date, $before_from_date])->sum('amount');
                    $op_balance = $led->op_balance + $op_dr_amount - $op_cr_amount;


                    //between date balance
                    $dr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->whereBetween('transaction_date', [$from_date, $to_date])->sum('amount');
                    $cr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->whereBetween('transaction_date', [$from_date, $to_date])->sum('amount');
                    $balance = $dr_amount - $cr_amount;

                    //after date balance
                    $cl_dr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->whereBetween('transaction_date', [$constant_date, $to_date])->sum('amount');
                    $cl_cr_amount = \App\SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->whereBetween('transaction_date', [$constant_date, $to_date])->sum('amount');
                    $cl_balance = $cl_dr_amount - $cl_cr_amount;


                    ?>
                    <tr >
                        <td class="td-w-28 txt_align_left"><span style="margin-left: 10px">{{$led_name}}</span></td>
                        @if($op_balance >= 0)
                            <td class="td-w-12 txt_align_right" >{{$op_balance}}</td>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                        @elseif($op_balance < 0)
                            <?php $op_balance = str_replace('-', '', $op_balance); ?>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                            <td class="td-w-12 txt_align_right" >{{$op_balance}}</td>
                        @endif
                        @if($balance >= 0)
                            <td class="td-w-12 txt_align_right" >{{$balance}}</td>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                        @else
                            <?php $balance = str_replace('-', '', $balance); ?>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                            <td class="td-w-12 txt_align_right" >{{$balance}}</td>
                        @endif
                        @if($cl_balance >= 0)
                            <td class="td-w-12 txt_align_right" >{{$cl_balance}}</td>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                        @else
                            <?php $cl_balance = str_replace('-', '', $cl_balance); ?>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                            <td class="td-w-12 txt_align_right" >{{$cl_balance}}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>





</div>
