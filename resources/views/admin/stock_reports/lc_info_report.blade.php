<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>

<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("d/m/Y");
?>

<div style="padding: 20px">
    <?php
    //$from_date_arr = explode('-', $from_date);
    //$to_date_arr = explode('-', $to_date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">L/C Basic Information</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>

    {{-- Credit Balance --}}


    <div style="margin-top: 20px">


        <div >

            <table style="width: 100%; border: none" >
                <div style="width: 100%; ">
                    <div style="width: 50% ; float: left;">
                        <h3>L/C No: {{$lc_info->lc_no}}</h3>
                    </div>
                    <div style="width: 50%; float: left; text-align: center">
                        <?php
                        $lc_date = date('d-m-Y', $lc_info->lc_date);
                        ?>
                        <h3>L/C Date: {{$lc_date}}</h3>
                    </div>
                </div>
                <tr>

                    <td style="width: 16%;">Importer Name </td>
                    <td style="width: 16%;">: {{$lc_info->importer_name}}</td>
                    <td style="width: 16%">Beneficiary</td>
                    <td style="width: 16%">:{{$lc_info->beneficiary}}</td>
                    <td style="width: 16%"></td>
                    <td style="width: 16%"></td>
                </tr>


                <tr>
                    <td style="width: 16%;">MC Name</td>
                    <td style="width: 16%;">: {{$lc_info->mc_name}}</td>
                    <td style="width: 16%;">MC No</td>
                    <td style="width: 16%;">: {{$lc_info->mc_no}}</td>
                    <td style="width: 16%;">MC Date</td>
                    <?php
                        $mc_date = date('d-m-Y', $lc_info->mc_date);
                    ?>
                    <td style="width: 16%;">: {{$mc_date}}</td>
                </tr>
                <tr>
                    <td>SCPI No.</td>
                    <td>: {{$lc_info->scpi_no}}</td>
                    <td>SCPI Date</td>
                    <?php
                    $scpi_date = date('d-m-Y', $lc_info->scpi_date);
                    ?>
                    <td>: {{$scpi_date}}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>MPI No</td>
                    <td>: </td>
                    <td>MPI Date</td>
                    <td>: </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>L/C Value (USD)</td>
                    <td>: {{$lc_info->lc_usd}}</td>
                    <td>L/C Value Exchange Rate</td>
                    <td>: {{$lc_info->lc_exchange_rate}}</td>
                    <td>L/C Value (BDT)</td>
                    <td>: {{$lc_info->lc_bdt}}</td>
                </tr>
                <tr>
                    <td colspan="3">{{$lc_info->remarks}}</td>
                </tr>
            </table>
        </div>

    </div>





</div>
