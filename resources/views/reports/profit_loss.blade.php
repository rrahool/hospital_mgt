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
                                <h4>Profit Loss</h4>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Gross Expenses</th>
                                            <th class="col-md-4">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{-- Direct Expenses --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Direct Expenses</b></td>
                                            <td class="col-md-4"><b>Dr {{$dir_expenses_amount}}</b></td>
                                        </tr>
                                        @foreach($dir_expenses as $d_ex)
                                            <?php
                                            $dir_ex_amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $d_ex->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $d_ex->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Dr {{$dir_ex_amount}}</span></td>
                                            </tr>
                                        @endforeach

                                        {{-- Purchases --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Purchases</b></td>
                                            <td class="col-md-4"><b>Dr {{$purchases_amount}}</b></td>
                                        </tr>
                                        @foreach($purchases as $purchase)
                                            <?php
                                            $purchase_amount = \App\SingleEntry::select('amount')->where('ledger_id', $purchase->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $d_ex->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $d_ex->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Dr {{$purchase_amount}}</span></td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Gross Incomes (Cr)</th>
                                            <th class="col-md-4">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{-- Direct Expenses --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Direct Incomes</b></td>
                                            <td class="col-md-4"><b>Cr {{$dir_income_amount}}</b></td>
                                        </tr>
                                        @foreach($dir_incomes as $d_ex)
                                            <?php
                                            $dir_ex_amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $d_ex->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $d_ex->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Cr {{$dir_ex_amount}}</span></td>
                                            </tr>
                                        @endforeach

                                        {{-- Purchases --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Sales</b></td>
                                            <td class="col-md-4"><b>Cr {{$sales_amount}}</b></td>
                                        </tr>
                                        @foreach($sales as $sale)
                                            <?php
                                            $sale_amount = \App\SingleEntry::select('amount')->where('ledger_id', $sale->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $sale->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $sale->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Cr {{$sale_amount}}</span></td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">

                                        <tr class="row">
                                            <th class="col-md-8">Total Gross Expense</th>
                                            <th class="col-md-4">Dr {{$total_gross_expense}}</th>
                                        </tr>

                                        @if($total_gross_expense < $total_gross_income)
                                            <?php $diff = $total_gross_income - $total_gross_expense; ?>
                                            <tr class="row">
                                                <td class="col-md-8"><b>Gross Profit C/D</b></td>
                                                <td class="col-md-4"><b>{{$diff}}</b></td>
                                            </tr>
                                        @else
                                            <tr class="row">
                                                <td class="col-md-8"><b>Gross Profit C/D</b></td>
                                                <td class="col-md-4"><b>0.00</b></td>
                                            </tr>
                                        @endif

                                        <tr class="row">
                                            <?php $total = ($total_gross_expense > $total_gross_income)?$total_gross_expense:$total_gross_income;  ?>
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$total}}</th>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-lg-6">
                                    <table class="table">
                                        <tr class="row">
                                            <th class="col-md-8">Total Gross Incomes</th>
                                            <th class="col-md-4">Cr {{$total_gross_income}}</th>
                                        </tr>
                                        @if($total_gross_expense > $total_gross_income)
                                            <?php $diff = $total_gross_expense - $total_gross_income; ?>
                                            <tr class="row">
                                                <td class="col-md-8"><b>Gross Loss C/D</b></td>
                                                <td class="col-md-4"><b>{{$diff}}</b></td>
                                            </tr>
                                        @else
                                            <tr class="row">
                                                <td class="col-md-8"><b>Gross Loss C/D</b></td>
                                                <td class="col-md-4"><b>0.00</b></td>
                                            </tr>
                                        @endif

                                        <tr class="row">
                                            <th class="col-md-8">Total </th>
                                            @if($total_gross_expense > $total_gross_income)
                                                <th class="col-md-4">Cr {{$total_gross_expense}}</th>
                                            @else
                                                <th class="col-md-4">Cr {{$total_gross_income}}</th>

                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">

                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Net Expenses (Dr)</th>
                                            <th class="col-md-4">Amount</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        {{-- Direct Expenses --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Indirect Expenses</b></td>
                                            <td class="col-md-4"><b>Dr {{$indir_expenses_amount}}</b></td>
                                        </tr>
                                        @foreach($indir_expenses as $d_ex)
                                            <?php
                                            $dir_ex_amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $d_ex->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $d_ex->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Dr {{$dir_ex_amount}}</span></td>
                                            </tr>
                                        @endforeach


                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Net Incomes (Cr)</th>
                                            <th class="col-md-4">Amount</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        {{-- Direct Expenses --}}
                                        <tr class="row">
                                            <td class="col-md-8"><b>Indirect Incomes</b></td>
                                            <td class="col-md-4"><b>Dr {{$indirect_incomes_amount}}</b></td>
                                        </tr>
                                        @foreach($indirect_incomes as $d_ex)
                                            <?php
                                            $dir_ex_amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
//                                            $name = str_replace('_', ' ', $d_ex->name);
                                            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $d_ex->name));
                                            ?>
                                            <tr class="row">
                                                <td class="col-md-8"><span style="margin-left: 15px">{{$name}}</span></td>
                                                <td class="col-md-4"><span style="margin-left: -15px">Dr {{$dir_ex_amount}}</span></td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">

                                        <tr class="row">
                                            <th class="col-md-8">Total Expense</th>
                                            <th class="col-md-4">Dr {{$indir_expenses_amount}}</th>
                                        </tr>
                                        @if($total_gross_expense > $total_gross_income)
                                            <?php $diff = $total_gross_expense - $total_gross_income;
                                            ?>
                                            <tr class="row">
                                                <th class="col-md-8">Gross Loss B/D</th>
                                                <th class="col-md-4">{{$diff}}</th>
                                            </tr>
                                        @else
                                            <tr class="row">
                                                <th class="col-md-8">Net Profit</th>
                                                <th class="col-md-4">{{$indirect_incomes_amount+$diff}}</th>
                                            </tr>
                                        @endif
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">Dr {{$indirect_incomes_amount+$diff}}</th>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-lg-6">
                                    <table class="table">
                                        <tr class="row">
                                            <th class="col-md-8">Total Incomes</th>
                                            <th class="col-md-4">Dr {{$indirect_incomes_amount}}</th>
                                        </tr>
                                        @if($total_gross_expense > $total_gross_income)
                                            <?php $diff = $total_gross_expense - $total_gross_income;
                                            $net_loss = $diff-$indirect_incomes_amount;
                                            ?>
                                            <tr class="row">
                                                <th class="col-md-8">Net Loss</th>
                                                <th class="col-md-4">{{$net_loss}}</th>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-md-8">Total</th>
                                                <th class="col-md-4">Cr {{$diff}}</th>
                                            </tr>
                                        @else
                                            <tr class="row">
                                                <th class="col-md-8">Gross Profit B/D</th>
                                                <th class="col-md-4">{{$diff}}</th>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-md-8">Total</th>
                                                <th class="col-md-4">Cr {{$diff + $indirect_incomes_amount}}</th>
                                            </tr>
                                        @endif
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
