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

        .td-w-10{
            width:10%;
            height:20px;
            padding: 5px;
        }

        .td-w-40{
            width:40%;
            height:20px;
            padding: 5px;
        }

        .td-w-60{
            width:60%;
            height:20px;
            padding: 5px;
        }
        .td-w-30{
            width:30%;
            height:20px;
            padding: 5px;
        }





        .txt_align_center{
            text-align: center;
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


        .margin_left_50{
            margin-left: 50px;
        }

    </style>

</head>
<body>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("d/m/Y");
?>

<div style="padding: 20px">
    <?php
    //$from_date_arr = explode('-', $from_date);
    $to_date_arr = explode('/', $to_d);
    $from_date_arr = explode('/', $from_d);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PARTY WISE SUMMARIZED STATEMENT - {{$heading}}</div>
        <div style="margin-top: 5px"> <span style="font-weight: bold">FROM {{$from_date_arr[1].'/'.$from_date_arr[0].'/'.$from_date_arr[2]}} TO {{$to_date_arr[1].'/'.$to_date_arr[0].'/'.$to_date_arr[2]}}</span> </div><br>
        {{--        <div>Till {{$date}}</div>--}}
    </div>


    <div >


        <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse: collapse;border:1px solid black ; margin-bottom: 20px; margin-top: 5px" >
            <thead>
            <tr >
                <th class="td-w-10">Sl</th>
                <th class="td-w-60">Particulars</th>
                <th class="td-w-40">Amount</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $total_amount = 0;
            $i = 1;
            ?>
            @foreach($arr_info as $key => $value)

                <?php
                $info = $arr_info[$key];
                $name = $info['name'];
                $amount = $info['amount'];

                $total_amount += $amount;

                ?>

                <tr>
                    <td class="txt_align_center ">{{$i}}</td>
                    <td class="txt_align_left">{{$name}}</td>
                    <td class="txt_align_right ">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                </tr>
                <?php $i++; ?>

            @endforeach
            <tr>
                <td class="txt_align_right " colspan="2"><b>TOTAL:</b></td>
                <td class="txt_align_right "><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>

            </tr>
            </tbody>
        </table>

    </div>
</div>
</div>
</body>
</html>
