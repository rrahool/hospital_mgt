@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Balance Sheet</h4>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                        <table class="table">
                                            <thead>
                                            <tr class="row">
                                                <th class="col-md-8">Assets (Dr)</th>
                                                <th class="col-md-4" >Amount ($)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i=0; ?>

                                            @foreach($assets as $asset)
                                                <tr class="row">
                                                    <th class="col-md-8">{{$asset->name}}</th>
                                                    <?php
//                                                    $asset_amount = number_format($asset_amount_arr[$i], 2, '.', ',' ) ;
                                                    $asset_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $asset_amount_arr[$i]);
                                                    ?>
                                                    <th class="col-md-4"><span style="margin-left: 15px" >Dr {{$asset_amount}}</span></th>
                                                </tr>
                                                <?php
                                                $ledgers = \App\Ledger::select('*')->where('group_id', $asset->id)->get();
                                                ?>

                                                @foreach($ledgers as $ledger)
                                                    <?php
                                                    $process_info = \App\Process::where('ledger_id',$ledger->id)->first();
                                                    $led_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger->name));

                                                    if ($ledger->dr_pos == 1){
                                                        $type = ($process_info['cl_balance']<0)?"Cr":"Dr";
                                                        $balance = str_replace('-','', $process_info['cl_balance']);
//                                                        $balance  = number_format($balance, 2, '.', ',' ) ;
                                                        $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $balance);
                                                    }else{
                                                        $type = "Dr";
                                                        $balance = $process_info['cl_balance'];
//                                                        $balance  = number_format($balance, 2, '.', ',' ) ;
                                                        $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $balance);
                                                    }
                                                    ?>
                                                    <tr class="row">
                                                        <td class="col-md-8"><span style="margin-left: 15px">{{$led_name}}</span></td>
                                                        <td class="col-md-4" >{{$type}} {{$balance}} </td>
                                                    </tr>
                                                @endforeach
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </div>

                                <div class="col-lg-6">
                                        <table class="table">
                                            <thead>
                                            <tr class="row">
                                                <th class="col-md-8">Liabilities and Owners Equity (Cr)</th>
                                                <th class="col-md-4">Amount ($)</th>
                                            </tr>
                                            </thead>
                                            <tody>
                                                <?php $i=0;?>

                                                @foreach($liabilities as $liability)
                                                    <tr class="row">

                                                        <?php
//                                                        $liability_amount  = number_format($liability_amount_arr[$i], 2, '.', ',' ) ;
                                                        $liability_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $liability_amount_arr[$i]);
                                                        ?>
                                                        <th class="col-md-8">{{$liability->name}}</th>
                                                        <th class="col-md-4"><span style="margin-left: 15px" >Cr {{$liability_amount}}</span></th>
                                                    </tr>
                                                    <?php
                                                    $ledgers = \App\Ledger::select('*')->where('group_id', $liability->id)->get();
                                                    /*if ($ledger->dr_pos == 0){
                                                        $type = ($process_info['cl_balance']<0)?"Cr":"Dr";
                                                        $balance = str_replace('-','', $process_info['cl_balance']);
                                                    }else{
                                                        $type = "Dr";
                                                        $balance = $process_info['cl_balance'];
                                                    }*/
                                                    ?>

                                                    @foreach($ledgers as $ledger)
                                                        <?php
                                                        $process_info = \App\Process::where('ledger_id',$ledger->id)->first();
                                                        //$name = str_replace('_', ' ', $ledger->name);
                                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger->name));
//                                                            $balance  = number_format($process_info->cl_balance, 2, '.', ',' ) ;
                                                            $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $process_info->cl_balance);

                                                            ?>
                                                        <tr class="row">
                                                            <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                            <td class="col-md-4" >Cr {{$balance}}</td>
                                                        </tr>
                                                    @endforeach
                                                    <?php $i++; ?>
                                                @endforeach


                                            </tody>
                                        </table>

                                    <table class="table">
                                        <?php
                                        $j=0;
                                        $total_income = 0;
                                        ?>
                                        {{-- $incomes --}}
                                        @foreach($incomes as $income)
                                            <?php
//                                                $income_amount  = number_format($income_amount_arr[$j], 2, '.', ',' ) ;
                                                $income_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $income_amount_arr[$j]);
                                                ?>
                                            <tr class="row">
                                                <th class="col-md-8">{{$income->name}}</th>
                                                <th class="col-md-4"><span style="margin-left: 15px" >Cr {{$income_amount}}</span></th>
                                                <?php $total_income += $income_amount_arr[$j]; ?>
                                            </tr>
                                            <?php
                                            $ledgers = \App\Ledger::select('*')->where('group_id', $income->id)->get();
                                            ?>

                                            @foreach($ledgers as $ledger)
                                                <?php
                                                $process_info = \App\Process::where('ledger_id',$ledger->id)->first();
//                                                $name = str_replace('_', ' ', $ledger->name);
                                                    $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger->name));
//                                                    $cl_balance = number_format($process_info->cl_balance, 2, '.', ',' ) ;
                                                    $cl_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $process_info->cl_balance);

                                                    ?>
                                                <tr class="row">
                                                    <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                    <td class="col-md-4" >Cr {{$cl_balance}}</td>
                                                </tr>
                                            @endforeach
                                            <?php $j++; ?>
                                        @endforeach
                                    </table>


                                    <table class="table">
                                        <?php
                                        $k=0;
                                        $total_expense = 0;
                                        ?>
                                        {{-- $incomes --}}
                                        @foreach($expenses as $expense)
                                                <?php
//                                                $expense_amount  = number_format($expense_amount_arr[$k], 2, '.', ',' ) ;
                                                $expense_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $expense_amount_arr[$k]);

                                                ?>
                                            <tr class="row">
                                                <th class="col-md-8">{{$expense->name}}</th>
                                                <th class="col-md-4"><span style="margin-left: 15px" >Dr {{$expense_amount}}</span></th>
                                                <?php $total_expense+= $expense_amount_arr[$k];?>
                                            </tr>
                                            <?php
                                            $ledgers = \App\Ledger::select('*')->where('group_id', $expense->id)->get();
                                            ?>

                                            @foreach($ledgers as $ledger)
                                                <?php
                                                $process_info = \App\Process::where('ledger_id',$ledger->id)->first();
//                                                $name = str_replace('_', ' ', $ledger->name);
                                                    $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger->name));
//                                                        $cl_balance = number_format($process_info->cl_balance, 2, '.', ',' ) ;
                                                        $cl_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $process_info->cl_balance);
                                                        ?>
                                                <tr class="row">
                                                    <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                    <td class="col-md-4" >Dr {{$cl_balance}}</td>
                                                </tr>
                                            @endforeach
                                            <?php $k++; ?>
                                        @endforeach
                                    </table>


                                    <table class="table">
                                        <?php
                                        $x=0;
                                        $total_withdraw = 0;
                                        ?>
                                        {{-- $incomes --}}
                                        @foreach($withdraws as $withdraw)

                                            <?php
//                                                $withdraw_amount = number_format($withdraw_amount_arr[$x], 2, '.', ',' ) ;
                                                $withdraw_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $withdraw_amount_arr[$x]);

                                                ?>
                                            <tr class="row">
                                                <th class="col-md-8">{{$withdraw->name}}</th>
                                                <th class="col-md-4"><span style="margin-left: 15px" >Cr {{$withdraw_amount}}</span></th>
                                                <?php $total_withdraw += $withdraw_amount_arr[$x]; ?>
                                            </tr>
                                            <?php
                                            $ledgers = \App\Ledger::select('*')->where('group_id', $withdraw->id)->get();
                                            ?>

                                            @foreach($ledgers as $ledger)
                                                <?php
                                                $process_info = \App\Process::where('ledger_id',$ledger->id)->first();
//                                                $name = str_replace('_', ' ', $ledger->name);
                                                    $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger->name));
//                                                    $cl_balance = number_format($process_info->cl_balance, 2, '.', ',' ) ;
                                                    $cl_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $process_info->cl_balance);

                                                    ?>
                                                <tr class="row">
                                                    <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                    <td class="col-md-4" >Cr {{$cl_balance}}</td>
                                                </tr>
                                            @endforeach
                                            <?php $x++; ?>
                                        @endforeach
                                    </table>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <?php
//                                            $total_asset_amount = number_format($total_asset_amount, 2, '.', ',' ) ;
                                            $total_asset_amount  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_asset_amount);

                                            ?>
                                            <th class="col-md-8">Total Assets</th>
                                            <th class="col-md-4"> <span style="margin-left: 15px" >Dr {{$total_asset_amount}}</span></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <?php
                                            $total = $total_liability_amount+$total_income-$total_expense-$total_withdraw;
//                                            $total = number_format($total, 2, '.', ',' ) ;
                                            $total  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total);

                                            ?>
                                            <th class="col-md-8">Total Liability and Owners Equity</th>
                                            <th class="col-md-4"> <span style="margin-left: 15px" >Cr {{$total}}</span></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>



            </div>
        </div>


    </div>

    <!-- /.content-wrapper -->


@endsection
