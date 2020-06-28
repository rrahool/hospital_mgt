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

        .td-w-25{
            width:25%;
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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">SUMMARIZED STATEMENT - {{$report_type}}</div>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">

        <div >
            <?php
            if ($warehouse_id != 'all'){

                $warehouse_name =\Illuminate\Support\Facades\DB::table('warehouse')->where('id', $warehouse_id)->first()->warehouse_name;
            }else{
                $warehouse_name = $warehouse_id;
            }

//            $cat_name =\Illuminate\Support\Facades\DB::table('catagory')->where('id', $cat_id)->first()->cname;
            $from_date = date('d-m-Y', $from_date);
            $to_date = date('d-m-Y', $to_date);
            ?>

            <h4>Store Name: {{$warehouse_name}} <br> From: {{$from_date}} To {{$to_date}}</h4>



            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th>Item Particular</th>
                    <th>Carton Qty</th>
                    <th>Qty Per Carton </th>
                    <th>Pieces</th>
                    <th>Quantity</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $total_c = 0;
                $total_p = 0;
                $total = 0;
                ?>
                @foreach($info_arr as $key => $value)
                    <?php
                    if (sizeof($info_arr[$key]) != 0){
                    $cat_name =\Illuminate\Support\Facades\DB::table('catagory')->where('id', $key)->first()->cname;
                    $infos = $info_arr[$key];
                    $sub_total_c = 0;
                    $sub_total_p = 0;
                    $sub_total = 0;

                    ?>
                    <tr >
                        <td colspan="4"><b style="font-size: 20px; padding: 15px">{{$cat_name}}</b></td>
                    </tr>

                    @foreach($infos as  $info)

                        <?php
                        if (sizeof($info) != 0){
                        $carton = $info['carton'];
                        $pieces = $info['pieces'];
                        $quantity = $info['quantity'];
                        $qt_per_carton = $info['qt_per_carton'];

                        if($pieces > $qt_per_carton){
                            $carton1 = intval($pieces / $qt_per_carton);
                            $pieces = intval($pieces % $qt_per_carton);

                            $carton += $carton1;
                        }

                        $sub_total_c += $carton;
                        $sub_total_p += $pieces;
                        $sub_total += $quantity;

                        $total_c += $carton;
                        $total_p += $pieces;
                        $total += $quantity;
                        ?>

                        <tr >
                            <td ><span style="margin-left: 10px">{{$info['product_name']}}</span></td>
                            <td class="txt_align_center">{{$carton}}</td>
                            <td class="txt_align_center">{{$qt_per_carton}}</td>
                            <td class="txt_align_center">{{$pieces}}</td>
                            <td class="txt_align_center">{{$quantity}}</td>
                        </tr>

                        <?php } ?>
                    @endforeach

                    {{--<tr >
                        <td class="txt_align_right"><b>Sub Total:</b></td>
                        <td class="txt_align_center"><b>{{$sub_total_c}}</b></td>
                        <td class="txt_align_center"><b></b></td>
                        <td class="txt_align_center"><b>{{$sub_total_p}}</b></td>
                        <td class="txt_align_center"><b>{{$sub_total}}</b></td>
                    </tr>--}}
                    <?php } ?>
                @endforeach

                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr >
                    <td class="txt_align_right"><b style="font-size: 20px; padding: 15px">Total:</b></td>
                    <td class="txt_align_center"><b>{{$total_c}}</b></td>
                    <td class="txt_align_center"><b></b></td>
                    <td class="txt_align_center"><b>{{$total_p}}</b></td>
                    <td class="txt_align_center"><b>{{$total}}</b></td>
                </tr>
                </tbody>

            </table>

        </div>
    </div>



    <div class="row" style=" margin-top: 80px">

        <table width="100%" border="0">
            <tr  style="border: 0px">
                <td class="td-w-25" style="border: 0px">
                    <div style="text-align: center">_________________________________</div>
                    <div style="text-align: center">Prepared By</div>
                </td>
                <td class="td-w-25" style="border: 0px">
                    <div style="text-align: center">_________________________________</div>
                    <div style="text-align: center">Received By</div>
                </td>
                <td class="td-w-25" style="border: 0px">
                    <div style="text-align: center">_________________________________</div>
                    <div style="text-align: center">Checked By</div>
                </td>
                <td class="td-w-25" style="border: 0px">
                    <div style="text-align: center">_________________________________</div>
                    <div style="text-align: center">Authorized By</div>
                </td>
            </tr>
        </table>

    </div>
</div>
</body>
</html>
