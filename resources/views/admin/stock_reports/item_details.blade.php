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

        .td-w-40{
            width:40%;
            height:20px;
            padding: 5px;
        }



        .td-w-50{
            width:60%;
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
    //$to_date_arr = explode('-', $to_date);
    //$closing_balance = $opening_balance;
    ?>
    <div style="text-align: center">
        <div style="font-size: 20px; font-weight: bold">SATKANIA FANCY STORE</div>
        <div style="margin-top: 5px">Golam Rasul Market, Reazuddin Bazar, Chittagong</div>
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">ITEM DETAILS</div>
        {{--<div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>--}}
    </div>


        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border-collapse:collapse; margin-top: 20px" >
                <thead>
                <tr >
                    <th class="td-w-60">Item Particulars</th>
                    <th class="td-w-40">Brand</th>
                </tr>
                </thead>

                <tbody>

                    @foreach($catagories as $catagory)
                        <?php
                        $product_count = \Illuminate\Support\Facades\DB::table('product_info')->where('product_type_id', $catagory->id)->count();
                        ?>
                        @if($product_count > 0)
                            <tr>
                                <td colspan="2"><b style="margin-left: 10px">{{$catagory->cname}}</b></td>
                            </tr>

                            <?php
                                $products = \Illuminate\Support\Facades\DB::table('product_info')->where('product_type_id', $catagory->id)->get();
                            ?>
                                @foreach($products as $product)
                                    <tr >
                                        <td><span class="margin_left_50">{{$product->product_name}}</span></td>
                                        <td class="txt_align_center">{{$product->brand}}</td>
                                    </tr>
                                @endforeach
                        @endif
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>
</body>
</html>
