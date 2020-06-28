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

        .th1{
            width:60%;
            height:20px;
            padding: 5px;
        }

        .th2{
            width:20%;
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
        $closing_balance = $opening_balance;
        ?>
        <div style="text-align: center">
            <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
            <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
            <div style="margin-top: 5px; font-size: 20px; font-weight: bold">RECEIPTS & PAYMENT STATEMENT - LEDGER</div>
            <div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> For <span style="font-weight: bold">{{$led_info->name}}</span> </div><br>
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
                        <th class="th1 txt_align_center"><span style="margin-left: 10px">Particular</span></th>
                        <th class="th2 txt_align_center" >Debit Amount</th>
                        <th class="th2 txt_align_center" >Credit Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr >
                        <th colspan="3" class="txt_align_left th1"><span style="margin-left: 10px" >Cash In Hand</span></th>
                    </tr>

                        <tr >
                            <?php
                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_info->name));
                            ?>
                            <td class="txt_align_left"><span style="margin-left: 50px">{{$name}}</span></td>
                            <td class="txt_align_right">{{$opening_balance }}</td>
                            <td class="txt_align_right">0.00</td>
                        </tr>

                    <tr>
                        <th class="txt_align_right th1"><span style="margin-left: 50px">Sub Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$opening_balance}}</span></th>
                        <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                    </tr>



                    <tr class="row">
                        <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Opening Balance Total: </span></th>
                        <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">{{$opening_balance}}</span></th>
                        <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">0.00</span></th>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>


            {{-- Received Balance --}}

            <div style="margin-top: 50px">
                <div class="card-title">
                    <h3>Received During The Period</h3>
                </div>

                <div class="row">
                    <table width="100%" cellspacing="0" cellpadding="2"  align="center" style="border:1px solid black ;">
                        <thead>

                        <tr>
                            <th class="th1"><span style="margin-left: 10px">Particular</span></th>
                            <th class="th2"  >Debit Amount</th>
                            <th class="th2" >Credit Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="row">
                            <th colspan="3" class="txt_align_left"><span style="margin-left: 10px">Party</span></th>
                        </tr>
                        <?php
                        $sub_total_received_balance = 0;
                        ?>
                        @foreach($entry_ids as $entry_id)

                            <?php
                            $entry_info = \App\SingleEntry::where('entry_id', $entry_id->entry_id)->where('dc', 'C')->where('ledger_id', '!=', $led_info->id)->first();

                            if (!empty($entry_info)){
                                $rec_led_amount = \App\SingleEntry::selectRaw('sum(amount) as dr')->where('entry_id', $entry_id->entry_id)->where('dc', 'C')->first();
                                $rec_led_info = \App\Ledger::where('id', $entry_info->ledger_id)->first();
                                $sub_total_received_balance += $rec_led_amount->dr;
                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $rec_led_info->name));
                            ?>

                            <tr class="row">
                                <td class=""><span style="margin-left: 50px">{{$name}}</span></td>
                                <td class="txt_align_right">{{$rec_led_amount->dr }}</td>
                                <td class="txt_align_right">0.00</td>
                            </tr>
                            <?php } ?>
                        @endforeach
                        <tr >
                            <th class="txt_align_right th1"><span style="margin-left: 10px">Sub Total: </span></th>
                            <th class="txt_align_right"><span class="margin_right">{{$sub_total_received_balance}}</span></th>
                            <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                        </tr>

                        <tr class="row">
                            <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Received Total: </span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">{{$sub_total_received_balance}}</span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">0.00</span></th>
                        </tr>
                        <?php
                        $closing_balance += $sub_total_received_balance;
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Payment Balance --}}

            <div style="margin-top: 50px">
                <div class="card-title">
                    <h3>Payment During The Period</h3>
                </div>

                <div class="row">
                    <table width="100%" cellspacing="0" cellpadding="2"  align="center" style="border:1px solid black ;">
                        <thead>

                        <tr>
                            <th class="th1"><span style="margin-left: 10px">Particular</span></th>
                            <th class="th2"  >Debit Amount</th>
                            <th class="th2" >Credit Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="row">
                            <th colspan="3" class="txt_align_left"><span style="margin-left: 10px">Party</span></th>
                        </tr>
                        <?php
                        $sub_total_payment_balance = 0;
                        ?>
                        @foreach($entry_ids as $entry_id)

                            <?php
                            $entry_info = \App\SingleEntry::where('entry_id', $entry_id->entry_id)->where('dc', 'D')->where('ledger_id', '!=', $led_info->id)->first();

                            if (!empty($entry_info)){
                                $pay_led_amount = \App\SingleEntry::selectRaw('sum(amount) as dr')->where('entry_id', $entry_id->entry_id)->where('dc', 'C')->first();
                                $pay_led_info = \App\Ledger::where('id', $entry_info->ledger_id)->first();
                                $sub_total_payment_balance += $pay_led_amount->dr;
                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $pay_led_info->name));

                            ?>

                            <tr class="row">
                                <td class=""><span style="margin-left: 50px">{{$name}}</span></td>
                                <td class="txt_align_right">0.00</td>
                                <td class="txt_align_right">{{$pay_led_amount->dr }}</td>
                            </tr>
                            <?php } ?>
                        @endforeach
                        <tr >
                            <th class="txt_align_right th1"><span style="margin-left: 10px">Sub Total: </span></th>
                            <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                            <th class="txt_align_right"><span class="margin_right">{{$sub_total_payment_balance}}</span></th>
                        </tr>

                        <tr class="row">
                            <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Payment Total: </span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">0.00</span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">{{$sub_total_payment_balance}}</span></th>
                        </tr>

                        <?php
                        $closing_balance -= $sub_total_payment_balance;
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Closing Balance --}}
            <div style="margin-top: 50px">
                <div>
                    <h3>Closing Balance</h3>
                </div>

                <div >
                    <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                        <thead>

                        <tr >
                            <th class="th1 txt_align_center"><span style="margin-left: 10px">Particular</span></th>
                            <th class="th2 txt_align_center" >Debit Amount</th>
                            <th class="th2 txt_align_center" >Credit Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr >
                            <th colspan="3" class="txt_align_left th1"><span style="margin-left: 10px" >Cash In Hand</span></th>
                        </tr>

                        <tr >
                            <?php
                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_info->name));
                            ?>
                            <td class="txt_align_left"><span style="margin-left: 50px">{{$name}}</span></td>
                            <td class="txt_align_right">{{$closing_balance }}</td>
                            <td class="txt_align_right">0.00</td>
                        </tr>

                        <tr>
                            <th class="txt_align_right th1"><span style="margin-left: 50px">Sub Total: </span></th>
                            <th class="txt_align_right"><span class="margin_right">{{$closing_balance}}</span></th>
                            <th class="txt_align_right"><span class="margin_right">0.00</span></th>
                        </tr>



                        <tr class="row">
                            <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Closing Balance Total: </span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">{{$closing_balance}}</span></th>
                            <th class="txt_align_right" style="font-size: 18px"><span class="margin_right">0.00</span></th>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

    </div>


</body>
</html>
