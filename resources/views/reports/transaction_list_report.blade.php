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
        <div style="margin-top: 5px; font-size: 20px; font-weight: bold">TRANSACTION LIST</div>
        <div style="margin-top: 5px">From <span style="font-weight: bold">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</span>  To <span style="font-weight: bold">{{$to_date_arr[2].'/'.$to_date_arr[1].'/'.$to_date_arr[0]}}</span> </div><br>
    </div>

    {{-- Credit Balance --}}

    <div style="margin-top: 20px">
        <div>
            <h3>Received</h3>
        </div>

        <div >
            <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                <thead>

                <tr >
                    <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                    <th class="td-w-8 txt_align_center" >V No.</th>
                    <th class="td-w-20 txt_align_center" >Debit</th>
                    <th class="td-w-20 txt_align_center" >Credit</th>
                    <th class="td-w-12 txt_align_center" >Amount</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $dr_total = 0;
                ?>

                @foreach($dr_entry_infos as $led)

                    <?php

                    $dr_led_info = \App\Ledger::where('id', $led->ledger_id)->first();
                    $entry_info = \App\SingleEntry::select('*')->where('single_entry.entry_id', $led->entry_id)->where('dc', 'C')->first();
                    $cr_led_info = \App\Ledger::where('id', $entry_info->ledger_id)->first();
                    $dr_total += $entry_info->amount;


                    $dr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_info->name));
                    $cr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_info->name));

                    ?>
                    <tr >
                        <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                        <td class="td-w-8 txt_align_center" >0</th>
                        <td class="td-w-20 txt_align_left" >{{$dr_name}}</td>
                        <td class="td-w-20 txt_align_left" >{{$cr_name}}</td>
                        <td class="td-w-20 txt_align_right" >{{$entry_info->amount}}</td>
                    </tr>

                @endforeach

                <tr>
                    <th class="td-w-8"></th>
                    <th></th>
                    <th class="txt_align_right"><span class="margin_right"></span></th>
                    <th class="txt_align_right th1"><span class="margin_right">Total: </span></th>
                    <th class="txt_align_right"><span class="margin_right">{{$dr_total}}</span></th>
                </tr>

                </tbody>
            </table>
        </div>

    </div>




        {{-- Debit Balance --}}

    <div style="margin-top: 20px">
            <div>
                <h3>Payment</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        <th class="td-w-8 txt_align_center" >V No.</th>
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-12 txt_align_center" >Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $cr_total = 0;
                    ?>

                    @foreach($cr_entry_infos as $led)

                        <?php

                        $cr_led_info = \App\Ledger::where('id', $led->ledger_id)->first();
                        $entry_info = \App\SingleEntry::select('*')->where('single_entry.entry_id', $led->entry_id)->where('dc', 'D')->first();
                        $dr_led_info = \App\Ledger::where('id', $entry_info->ledger_id)->first();
                        $cr_total += $entry_info->amount;

                        $dr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_info->name));
                        $cr_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_info->name));
                        ?>
                        <tr >
                            <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                            <td class="td-w-8 txt_align_center" >0</th>
                            <td class="td-w-20 txt_align_left" >{{$dr_name}}</td>
                            <td class="td-w-20 txt_align_left" >{{$cr_name}}</td>
                            <td class="td-w-20 txt_align_right" >{{$entry_info->amount}}</td>
                        </tr>

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th class="txt_align_right"><span class="margin_right"></span></th>
                        <th class="txt_align_right th1"><span class="margin_right">Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$cr_total}}</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>



        {{-- Journal Balance --}}

    <div style="margin-top: 20px">
            <div>
                <h3>Journal</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        <th class="td-w-8 txt_align_center" >V No.</th>
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-12 txt_align_center" >Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $journal_total = 0;
                    ?>

                    @foreach($journal_entries as $entry)

                        <?php

                            $dr_entries_count = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'D')->get()->count();
                            $cr_entries_count = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'C')->get()->count();

                        $sale_purchase_id = \Illuminate\Support\Facades\DB::table('entries')->select('sale_purchase_id')
                            ->where('id',$entry->entry_id)->first()->sale_purchase_id;

                        /*elseif (strpos( $sale_purchase_id , 'purchase_' ) !== false){

                        }*/


                        ?>
                        @if($dr_entries_count== 1)
                            <?php
                            $dr_entry_info = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'D')->first();
                            $dr_led_name = \App\Ledger::select('name')->where('id', $dr_entry_info->ledger_id)->first()->name;
//                            $dr_led_name = str_replace('_', ' ', $dr_led_name);
                            $cr_entries = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'C')->get();
                            $dr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_name));

                            ?>

                            @foreach($cr_entries as $cr_entry)
                                <?php
                                $cr_led_name = \App\Ledger::select('name')->where('id', $cr_entry->ledger_id)->first()->name;
//                                $cr_led_name = str_replace('_', ' ', $cr_led_name);
                                $journal_total += $cr_entry->amount;
                                $cr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_name));
                                if(strpos( $sale_purchase_id , 'sale_journal_' ) !== false){

                                    $memo_id = trim(str_replace("sale_journal_","",$sale_purchase_id));

                                    $memo_info = \Illuminate\Support\Facades\DB::table('memo_account')->select('total_price')->where('id', $memo_id)->first();
                                    if (!empty($memo_info)){
                                        $amount = $memo_info->total_price;
                                    }
                                }else{

                                    $amount = $cr_entry->amount;
                                }
                                ?>
                                <tr >
                                    <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                                    <td class="td-w-8 txt_align_center" >0</th>
                                    <td class="td-w-20 txt_align_left" >{{$dr_led_name}}</td>
                                    <td class="td-w-20 txt_align_left" >{{$cr_led_name}}</td>
                                    <td class="td-w-20 txt_align_right" >{{$amount}}</td>
                                </tr>
                            @endforeach
                        @elseif($cr_entries_count==1)

                            <?php
                            $cr_entry_info = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'C')->first();
                            $cr_led_name = \App\Ledger::select('name')->where('id', $cr_entry_info->ledger_id)->first()->name;
//                            $cr_led_name = str_replace('_', ' ', $cr_led_name);
                            $cr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_name));
                            $dr_entries = \App\SingleEntry::select('*')->where('entry_id', $entry->entry_id)->where('dc', 'D')->get();
                            ?>

                            @foreach($dr_entries as $dr_entry)
                                <?php
                                $dr_led_name = \App\Ledger::select('name')->where('id', $dr_entry->ledger_id)->first()->name;
//                                $dr_led_name = str_replace('_', ' ', $dr_led_name);
                                $dr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_name));
                                $journal_total += $dr_entry->amount;
                                ?>
                                <tr >
                                    <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                                    <td class="td-w-8 txt_align_center" >0</th>
                                    <td class="td-w-20 txt_align_left" >{{$dr_led_name}}</td>
                                    <td class="td-w-20 txt_align_left" >{{$cr_led_name}}</td>
                                    <td class="td-w-20 txt_align_right" >{{$dr_entry->amount}}</td>
                                </tr>
                            @endforeach

                        @endif

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th class="txt_align_right"><span class="margin_right"></span></th>
                        <th class="txt_align_right th1"><span class="margin_right">Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$journal_total}}</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>




        {{-- Debit Balance --}}

        <div style="margin-top: 20px">
            <div>
                <h3>Contra</h3>
            </div>

            <div >
                <table width="100%" cellspacing="0" cellpadding="0"  align="center" style="border:1px solid black ;" >
                    <thead>

                    <tr >
                        <th class="td-w-8 txt_align_center"><span style="margin-left: 10px">Date</span></th>
                        <th class="td-w-8 txt_align_center" >V No.</th>
                        <th class="td-w-20 txt_align_center" >Debit</th>
                        <th class="td-w-20 txt_align_center" >Credit</th>
                        <th class="td-w-12 txt_align_center" >Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $contra_total = 0;
                    ?>

                    @foreach($contra_entries as $contra_entry)

                        <?php

                        $dr_led_info = \App\Ledger::where('id', $contra_entry->ledger_id)->first();
                        $entry_info = \App\SingleEntry::select('*')->where('single_entry.entry_id', $contra_entry->entry_id)->where('dc', 'C')->first();
                        $cr_led_info = \App\Ledger::where('id', $entry_info->ledger_id)->first();
                        $contra_total += $entry_info->amount;

                        $dr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $dr_led_info->name));
                        $cr_led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $cr_led_info->name));
                        ?>
                        <tr >
                            <td class="td-w-8 txt_align_center">{{$from_date_arr[2].'/'.$from_date_arr[1].'/'.$from_date_arr[0]}}</td>
                            <td class="td-w-8 txt_align_center" >0</th>
                            <td class="td-w-20 txt_align_left" >{{$dr_led_name}}</td>
                            <td class="td-w-20 txt_align_left" >{{$cr_led_name}}</td>
                            <td class="td-w-20 txt_align_right" >{{$entry_info->amount}}</td>
                        </tr>

                    @endforeach

                    <tr>
                        <th class="td-w-8"></th>
                        <th></th>
                        <th class="txt_align_right"><span class="margin_right"></span></th>
                        <th class="txt_align_right th1"><span class="margin_right">Total: </span></th>
                        <th class="txt_align_right"><span class="margin_right">{{$contra_total}}</span></th>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>




</div>
