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

        .td-w-20{
            width:20%;
            height:20px;
            padding: 5px;
        }



        .td-w-22{
            width:22%;
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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">RECEIPTS & PAYMENT DETAILS</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>
    </div>


        {{-- Opening Balance --}}

        <div style="margin-top: 20px">
            <div>
                <h3>Opening Balance</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        {{--<th class="td-w-8 txt_align_center" >Doc No.</th>--}}
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-20 txt_align_center" >Remarks</th>
                        <th class="td-w-12 txt_align_center" >Debit Amount</th>
                        <th class="td-w-12 txt_align_center" >Credit Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sub_total_bank_opening_balance = 0;
                    ?>

                    @foreach($bank_cash_leds as $led)

                        <?php

                        $led_info = \App\Ledger::where('id', $led->led_id)->first();
                        $led_dr_amount = \App\SingleEntry::selectRaw('sum(amount) as dr')
                            ->where('ledger_id', $led->led_id)
                            ->where('dc', 'D')
                            ->whereBetween('transaction_date', [$constant_date, $before_from_date])
                            ->first();

                        $led_cr_amount = \App\SingleEntry::selectRaw('sum(amount) as cr')
                            ->where('ledger_id', $led->led_id)
                            ->where('dc', 'C')
                            ->whereBetween('transaction_date', [$constant_date, $before_from_date])
                            ->first();



                        $diff = $led_info->op_balance + $led_dr_amount->dr - $led_cr_amount->cr;
                        $sub_total_bank_opening_balance += $diff;
                        $name = str_replace('_', ' ', $led_info->name);
                        $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                        ?>
                        <tr >
                            <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                            {{--<td class="td-w-8 txt_align_center" ></th>--}}
                            <td class="td-w-20 txt_align_left" >{{$name}}</td>
                            <td class="td-w-20 txt_align_left" ></td>
                            <td class="td-w-20 txt_align_center" ></td>
                            <td class="td-w-12 txt_align_right" >{{$diff }}</td>
                            <td class="td-w-12 txt_align_right" ></td>
                        </tr>

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th></th>
                        <th class="txt_align_right th1"><span class="margin_right">Sub Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$sub_total_bank_opening_balance}}</span></th>
                        <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>


        {{-- Received Balance --}}

        <div style="margin-top: 20px">
            <div>
                <h3>Received During The Period</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        {{--<th class="td-w-8 txt_align_center" >Doc No.</th>--}}
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-20 txt_align_center" >Remarks</th>
                        <th class="td-w-12 txt_align_center" >Debit Amount</th>
                        <th class="td-w-12 txt_align_center" >Credit Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $total_received = 0;
                    ?>

                    @foreach($rec_entries as $entry)

                        <?php

                        $dr_led_name = \App\Ledger::select('name')->where('id', $entry->ledger_id)->first()->name;
                        $dr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_name));

                        $cr_led_info = \App\SingleEntry::select('ledger_id', 'amount', 'transaction_date')->where('entry_id', $entry->entry_id)->where('dc', 'C')->first();
                        $cr_led_name = \App\Ledger::select('name')->where('id', $cr_led_info->ledger_id)->first()->name;
                        $cr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_name));

                        $total_received += $cr_led_info->amount;

                        $transaction_date_arr = explode('-', $cr_led_info->transaction_date);
                        $transaction_date = $transaction_date_arr[2].'/'.$transaction_date_arr[1].'/'.$transaction_date_arr[0];




                        ?>
                        <tr >
                            <td class="td-w-8 txt_align_center">{{$transaction_date}}</td>
                            {{--<td class="td-w-8 txt_align_center" >0</th>--}}
                            <td class="td-w-20 txt_align_left" >{{$dr_led_name}}</td>
                            <td class="td-w-20 txt_align_left" >{{$cr_led_name}}</td>
                            <td class="td-w-20 txt_align_center" ></td>
                            <td class="td-w-12 txt_align_right" >{{$cr_led_info->amount }}</td>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                        </tr>

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th></th>
                        <th class="txt_align_right th1"><span class="margin_right">Sub Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$total_received}}</span></th>
                        <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>


        <div style="margin-top: 20px">
            <div>
                <h3>Payment During The Period</h3>
            </div>
                <div >
                    <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                        <thead>

                        <tr >
                            <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                            {{--<th class="td-w-8 txt_align_center" >Doc No.</th>--}}
                            <th class="td-w-20 txt_align_center" >Debit</th>
                            <th class="td-w-20 txt_align_center" >Credit</th>
                            <th class="td-w-20 txt_align_center" >Remarks</th>
                            <th class="td-w-12 txt_align_center" >Debit Amount</th>
                            <th class="td-w-12 txt_align_center" >Credit Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $total_payment = 0;
                        ?>

                        @foreach($pay_entries as $entry)

                            <?php

                            $cr_led_name = \App\Ledger::select('name')->where('id', $entry->ledger_id)->first()->name;
                            $cr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_name));

                            $dr_led_info = \App\SingleEntry::select('ledger_id', 'amount', 'transaction_date')->where('entry_id', $entry->entry_id)->where('dc', 'D')->first();
                            $dr_led_name = \App\Ledger::select('name')->where('id', $dr_led_info->ledger_id)->first()->name;
                            $dr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_name));

                            $total_payment += $dr_led_info->amount;

                            $transaction_date_arr = explode('-', $dr_led_info->transaction_date);
                            $transaction_date = $transaction_date_arr[2].'/'.$transaction_date_arr[1].'/'.$transaction_date_arr[0];
                            ?>
                            <tr >
                                <td class="td-w-8 txt_align_center">{{$transaction_date}}</td>
                                {{--<td class="td-w-8 txt_align_center" >0</th>--}}
                                <td class="td-w-20 txt_align_left" >{{$dr_led_name}}</td>
                                <td class="td-w-20 txt_align_left" >{{$cr_led_name}}</td>
                                <td class="td-w-20 txt_align_center" ></td>
                                <td class="td-w-12 txt_align_right" >0.00</td>
                                <td class="td-w-12 txt_align_right" >{{$dr_led_info->amount }}</td>
                            </tr>

                        @endforeach

                        <tr>
                            <th class="td-w-8"></th>
                            <th></th>
                            <th></th>
                            <th class="txt_align_right th1"><span class="margin_right">Sub Total: </span></th>
                            <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                            <th class="txt_align_right"><span class="margin_right">{{$total_payment}}</span></th>
                        </tr>

                        </tbody>
                    </table>
                </div>
        </div>


        {{-- Closing Balance --}}

        <div style="margin-top: 20px">
            <div>
                <h3>Closing Balance</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        {{--<th class="td-w-8 txt_align_center" >Doc No.</th>--}}
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-20 txt_align_center" >Remarks</th>
                        <th class="td-w-12 txt_align_center" >Debit Amount</th>
                        <th class="td-w-12 txt_align_center" >Credit Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sub_total_bank_opening_balance = 0;
                    ?>

                    @foreach($bank_cash_leds as $led)

                        <?php

                        $led_info = \App\Ledger::where('id', $led->led_id)->first();
                        $led_dr_amount = \App\SingleEntry::selectRaw('sum(amount) as dr')
                            ->where('ledger_id', $led->led_id)
                            ->where('dc', 'D')
                            ->whereBetween('transaction_date', [$constant_date, $to_date])
                            ->first();

                        $led_cr_amount = \App\SingleEntry::selectRaw('sum(amount) as cr')
                            ->where('ledger_id', $led->led_id)
                            ->where('dc', 'C')
                            ->whereBetween('transaction_date', [$constant_date, $to_date])
                            ->first();

                        $diff = $led_info->op_balance + $led_dr_amount->dr - $led_cr_amount->cr;
                        $sub_total_bank_opening_balance += $diff;

                        $led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_info->name));
                        ?>
                        <tr >
                            <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                            {{--<td class="td-w-8 txt_align_center" >0</th>--}}
                            <td class="td-w-20 txt_align_left" >{{$led_name}}</td>
                            <td class="td-w-20 txt_align_left" ></td>
                            <td class="td-w-20 txt_align_center" ></td>
                            <td class="td-w-12 txt_align_right" >{{$diff }}</td>
                            <td class="td-w-12 txt_align_right" >0.00</td>
                        </tr>

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th></th>
                        <th class="txt_align_right th1"><span class="margin_right">Sub Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$sub_total_bank_opening_balance}}</span></th>
                        <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>

{{-- Journal Balance --}}

        <div style="margin-top: 20px">
            <div>
                <h3>Non Cash Journal</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        {{--<th class="td-w-8 txt_align_center" >JV No.</th>--}}
                        <th class="td-w-22 txt_align_center" >Debited To</th>
                        <th class="td-w-22 txt_align_center" >Credited To</th>
                        <th class="td-w-20 txt_align_center" >Remarks</th>
                        <th class="td-w-20 txt_align_center" >Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $journal_balance = 0;
                    ?>

                    @foreach($non_cash_entries as $entry)

                        <?php

                        $dr_count = \App\SingleEntry::select('id')->where('entry_id', $entry->entry_id)->where('dc', 'D')->get()->count();
                        $cr_count = \App\SingleEntry::select('id')->where('entry_id', $entry->entry_id)->where('dc', 'C')->get()->count();

                        if ($dr_count == 1){
                            $dr_name = \App\SingleEntry::select('ledgers.name')->where('entry_id', $entry->entry_id)->where('dc', 'D')->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')->first()->name;
                            $dr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_name));
                            $cr_infos = \App\SingleEntry::where('entry_id', $entry->entry_id)->where('dc', 'C')->get();

                            foreach ($cr_infos as $cr_info){

                                $cr_name = \App\Ledger::select('name')->where('id', $cr_info->ledger_id)->first()->name;
                                $cr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_name));
                                $journal_balance += $cr_info->amount;
                                ?>

                                <tr >
                                    <td class="td-w-8 txt_align_center">{{$cr_info->transaction_date}}</td>
                                    {{--<td class="td-w-8 txt_align_center" ></th>--}}
                                    <td class="td-w-20 txt_align_left" >{{$dr_name}}</td>
                                    <td class="td-w-20 txt_align_left" >{{$cr_name}}</td>
                                    <td class="td-w-20 txt_align_center" ></td>
                                    <td class="td-w-12 txt_align_right" >{{$cr_info->amount}}</td>
                                </tr>
                        <?php
                            }

                        }else if($cr_count == 1){

                        $cr_name = \App\SingleEntry::select('ledgers.name')->where('entry_id', $entry->entry_id)->where('dc', 'C')->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')->first()->name;

                        $dr_infos = \App\SingleEntry::where('entry_id', $entry->entry_id)->where('dc', 'D')->get();

                        foreach ($dr_infos as $cr_info){

                        $cr_name = \App\Ledger::select('name')->where('id', $cr_info->ledger_id)->first()->name;
                        $journal_balance += $cr_info->amount;
                        ?>

                        <tr >
                            <td class="td-w-8 txt_align_center">{{$cr_info->transaction_date}}</td>
                            {{--<td class="td-w-8 txt_align_center" >0</th>--}}
                            <td class="td-w-20 txt_align_left" >{{$dr_name}}</td>
                            <td class="td-w-20 txt_align_left" >{{$cr_name}}</td>
                            <td class="td-w-20 txt_align_center" ></td>
                            <td class="td-w-12 txt_align_right" >{{$cr_info->amount}}</td>
                        </tr>
                        <?php
                            }
                        }
                        ?>


                    @endforeach
                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th></th>
                        <th class="txt_align_right th1"><span class="margin_right">Sub Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$journal_balance}}</span></th>
                    </tr>


                    </tbody>
                </table>
            </div>

        </div>


</div>
