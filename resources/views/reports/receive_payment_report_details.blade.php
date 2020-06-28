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

    </style>

</head>
<body>


            <?php
                $from_date_arr = explode('-', $from_date);
                $to_date_arr = explode('-', $to_date);
            ?>

            <div style="padding: 20px">

                <div style="text-align: center">
                    <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
                    <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
                    <div style="margin-top: 5px; font-size: 20px; font-weight: bold">RECEIPTS & PAYMENT STATEMENT </div>
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
                                        <th class="th1 txt_align_center"><span style="margin-left: 10px">Particular</span></th>
                                        <th class="th2 txt_align_center" >Debit Amount</th>
                                        <th class="th2 txt_align_center" >Credit Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sub_total_bank_opening_balance = 0;
                                    ?>

                                    @foreach($op_bl_arr as $key=>$value)
                                        <?php
                                            $info = $op_bl_arr[$key];
                                            $led_name = str_replace('_', ' ', $info['name']);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_name));
                                            $op_bl = $info['op_bl'];
                                            $sub_total_bank_opening_balance += $op_bl;
//                                            $op_bl = number_format($op_bl, 2, '.', ',');
                                            $op_bl  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $op_bl);


                                        ?>
                                        <tr>
                                            <td class="th1"><span style="margin-left: 50px">{{$name}}</span></td>
                                            <td class="txt_align_right" >{{$op_bl}}</td>
                                            <td class="txt_align_right"  >0.00</td>
                                        </tr>
                                        <?php

                                        ?>
                                    @endforeach

                                    <?php
//                                    $sub_total_bank_opening_balance = number_format($sub_total_bank_opening_balance, 2, '.', ',');
                                    $sub_total_bank_opening_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sub_total_bank_opening_balance);
                                    ?>

                                    <tr class="row">
                                        <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Opening Balance Total: </span></th>
                                        <th class="txt_align_right" style="font-size: 18px">{{$sub_total_bank_opening_balance}}</th>
                                        <th class="txt_align_right" style="font-size: 18px">0.00</th>
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

                                    <?php
                                    $sub_total_received_balance = 0;
                                    ?>

                                    @foreach($received_arr as $key=>$value)
                                        <?php
                                        if (sizeof($received_arr[$key]) != 0){
                                            $infos = $received_arr[$key];

                                            foreach ($infos as $key=>$value){

                                                $info = $infos[$key];
                                                $id  = $info['id'];
                                                $amount = $info['amount'];
                                                $cr_led = str_replace('_', ' ', $info['ledger']);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led));
                                                $sub_total_received_balance += str_replace(',', '', $amount);
//                                                $amount = number_format($amount, 2, '.', ',')
                                                $amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);

                                        ?>
                                        <tr>
                                            <td class="th1"><span style="margin-left: 50px">{{$name}}</span></td>
                                            <td class="txt_align_right"  >0.00</td>
                                            <td class="txt_align_right" >{{$amount}}</td>
                                        </tr>

                                        <?php
                                            }
                                        }
                                        ?>
                                    @endforeach

                                    <?php
//                                    $sub_total_received_balance = number_format($sub_total_received_balance, 2, '.', ',');
                                    $sub_total_received_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sub_total_received_balance);
                                    ?>

                                    <tr class="row">
                                        <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Received Total: </span></th>
                                        <th class="txt_align_right" style="font-size: 18px">0.00</th>
                                        <th class="txt_align_right" style="font-size: 18px">{{$sub_total_received_balance}}</th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>


                {{--Payment--}}
                <div style="margin-top: 50px">
                    <div class="card-title">
                        <h3>Payment During The Period</h3>
                    </div>

                    <div class="row">
                        <table width="100%" cellspacing="0" cellpadding="2"  align="center" style="border:1px solid black ;">
                            <thead>

                            <tr class="row">
                                <th class="th1"><span style="margin-left: 10px">Particular</span></th>
                                <th class="th2" >Debit Amount</th>
                                <th class="th2">Credit Amount</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $sub_total_payment_balance = 0;
                            ?>

                            @foreach($payment_arr as $key=>$value)
                                <?php
                                 if (sizeof($payment_arr[$key]) != 0){
                                       $infos = $payment_arr[$key];

                                       foreach ($infos as $key=>$value){
                                           $info = $infos[$key];
                                           $id  = $info['id'];
                                           $amount = $info['amount'];
                                           $cr_led = str_replace('_', ' ', $info['ledger']);
                                           $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led));
                                           $sub_total_payment_balance += str_replace(',', '', $amount);
//                                           $amount = number_format($amount, 2, '.', ',');
                                           $amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);


                                ?>
                                        <tr class="row">
                                            <td class="txt_align_left"><span style="margin-left: 50px">{{$name}}</span></td>
                                            <td class="txt_align_right">{{$amount}}</td>
                                            <td class="txt_align_right">0.00</td>
                                        </tr>
                                        <?php
                                       }
                                }
                                ?>
                            @endforeach
                            <?php
//                            $sub_total_payment_balance = number_format($sub_total_payment_balance, 2, '.', ',');
                            $sub_total_payment_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sub_total_payment_balance);
                            ?>

                            <tr class="row">
                                <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Payment Total: </span></th>
                                <th class="txt_align_right" style="font-size: 18px">{{$sub_total_payment_balance}}</th>
                                <th class="txt_align_right" style="font-size: 18px">0.00</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>



                {{--Closing balance--}}
                <div style="margin-top: 20px">
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
                            <?php
                            $sub_total_bank_closing_balance = 0;
                            ?>

                            @foreach($cl_bl_arr as $key=>$value)
                                <?php
                                $info = $cl_bl_arr[$key];


                                $led_name = str_replace('_', ' ', $info['name']);
                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_name));
                                $cl_bl = $info['cl_bl'];
//                                $bl = number_format($cl_bl, 2, '.', ',');
                                $bl  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $cl_bl);
                                $sub_total_bank_closing_balance += $cl_bl;
                                ?>
                                <tr>
                                    <td class="th1"><span style="margin-left: 50px">{{$name}}</span></td>
                                    <td class="txt_align_right" >{{$bl}}</td>
                                    <td class="txt_align_right"  >0.00</td>
                                </tr>
                                <?php

                                ?>
                            @endforeach

                            <?php
//                            $sub_total_bank_closing_balance = number_format($sub_total_bank_closing_balance, 2, '.', ',');
                            $sub_total_bank_closing_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sub_total_bank_closing_balance);

                            ?>

                            <tr class="row">
                                <th class="txt_align_right th1"><span style="margin-left: 10px; font-size: 18px">Opening Balance Total: </span></th>
                                <th class="txt_align_right" style="font-size: 18px">{{$sub_total_bank_closing_balance}}</th>
                                <th class="txt_align_right" style="font-size: 18px">0.00</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>



            </div>



</body>
</html>
