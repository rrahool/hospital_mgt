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

    </style>

</head>
<body>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("d/m/Y");
?>

<div style="padding: 20px">
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">PARTY WISE SUMMARIZED STATEMENT - SALES</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{date('d/m/Y', $from_date)}}</span>  To <span style="font-weight: bold">{{date('d/m/Y', $to_date)}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div style="width: 100%; ">
            <div style="width: 50%;float: left;margin-bottom: 0px; ">
                <div style="margin-left: 0px">

                </div>
            </div>
            <div style="width: 50%; float: left; margin-bottom: 20px;">

            </div>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th class="td-w-10">Sl No.</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody>
                <?php $i =1; $total_amount = 0; ?>
                @foreach($client_ids as $client)
                    <?php
                        $client_name = \Illuminate\Support\Facades\DB::table('clients')->select('client_name')->where('id', $client->client_id)->first()->client_name;
                        $memos = \Illuminate\Support\Facades\DB::table('memo_account')->select('total_price', 'discount', 'vat', 'tax')->whereBetween('entry_date', [$from_date, $to_date])->where('client_id', $client->client_id)->get();
                        $amount = 0;
                        foreach ($memos as $memo){
                            $amount += str_replace(',','', $memo->total_price) - str_replace(',','', $memo->discount) + str_replace(',','', $memo->tax) + str_replace(',','', $memo->vat);
                        }
                    $total_amount += $amount;
                    ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$client_name}}</td>
                        <td class="txt_align_right">{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount)}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
                <tr>
                    <td class="txt_align_right" colspan="2"><b>Grand Total: </b></td>
                    <td class="txt_align_right"><b>{{preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_amount)}}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
