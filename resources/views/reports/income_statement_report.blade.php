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
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">INCOME STATEMENT</div>
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
                    <th class="th1 txt_align_center"><span style="margin-left: 10px">Head Particulars</span></th>
                    <th class="th2 txt_align_center" > Amount</th>
                </tr>
                </thead>
                <tbody>


                <?php
                    $total_income = 0;
                    $total_expense = 0;
                ?>
                @foreach($inc_led_ids as $inc_led_id)
                    <?php
                        $led_name = \App\Ledger::select('name')->where('id', $inc_led_id->ledger_id)->first()->name;
                        $amount = \App\SingleEntry::select('amount')->where('ledger_id', $inc_led_id->ledger_id)->where('dc', 'C')->whereBetween('transaction_date', [$from_date, $to_date])->sum('amount');
                        $total_income += $amount;
                        $led_name = str_replace('_', ' ', $led_name);
                    ?>

                <tr >
                    <td class="txt_align_left"><span style="margin-left: 50px">{{$led_name}}</span></td>
                    <td class="txt_align_right">{{$amount}}</td>
                </tr>
                @endforeach
                <tr >
                    <th class="txt_align_right th1"><span style="margin-left: 10px">Total Income: </span></th>
                    <th class="txt_align_right"><span class="margin_right">{{$total_income}}</span></th>
                </tr>


                @foreach($ex_led_ids as $ex_led_id)
                    <?php
                    $led_name = \App\Ledger::select('name')->where('id', $ex_led_id->ledger_id)->first()->name;
                    $amount = \App\SingleEntry::select('amount')->where('ledger_id', $ex_led_id->ledger_id)->where('dc', 'D')->whereBetween('transaction_date', [$from_date, $to_date])->sum('amount');
                    $total_expense += $amount;

//                    $led_name = str_replace('_', ' ', $led_name);
                    $led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led_name));
                    ?>

                    <tr >
                        <td class="txt_align_left"><span style="margin-left: 50px">{{$led_name}}</span></td>
                        <td class="txt_align_right">{{$amount}}</td>
                    </tr>
                @endforeach
                <tr >
                    <th class="txt_align_right th1"><span style="margin-left: 10px">Total Expense: </span></th>
                    <th class="txt_align_right"><span class="margin_right">{{$total_expense}}</span></th>
                </tr>

                @if($total_income > $total_expense)
                    <?php $profit = $total_income - $total_expense; ?>
                <tr >
                    <th class="txt_align_right th1"><span style="margin-left: 10px">Net Profit: </span></th>
                    <th class="txt_align_right"><span class="margin_right">{{$profit}}</span></th>
                </tr>
                    @else
                    <?php $loss = $total_expense - $total_income; ?>
                    <tr >
                        <th class="txt_align_right th1"><span style="margin-left: 10px">Total Loss: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$loss}}</span></th>
                    </tr>
                @endif


                </tbody>
            </table>
        </div>

    </div>



</div>


</body>
</html>
