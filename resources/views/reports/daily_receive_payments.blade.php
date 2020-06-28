@extends('layout')

@section('main_content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search Receive & payment</h4>
                            <div class="basic-form">
                                <form>
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="input-group">
                                            <input type="text" id="startpicker" required   class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                        </div>
                                    </div>
                                    <button type="button" onclick="getLedgerStatement()" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Receipt Entries</h4>
                            </div>

                            <div class="row">
                                <?php
                                    $rec_pay_total = 0;
                                    $rec_r_total = 0;
                                ?>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Payment</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($receipt_entries as $entry)
                                            <?php
                                                $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'C')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $rec_pay_total += $en->amount;
                                                ?>
                                            <tr class="row">
                                                <td class="col-md-8">{{$name}}</td>
                                                <td class="col-md-4">{{$en->amount}}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Receive</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($receipt_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'D')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                    $name = str_replace('_', ' ', $en->name);
                                                    $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                    $rec_r_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$rec_pay_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$rec_r_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Payment Entries</h4>
                            </div>

                            <div class="row">
                                <?php
                                $p_pay_total = 0;
                                $p_rec_total = 0;
                                ?>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Payment</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($payment_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'C')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $p_pay_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Receive</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($payment_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'D')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $p_rec_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$p_pay_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$p_rec_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Contra Entries</h4>
                            </div>

                            <div class="row">
                                <?php
                                $con_pay_total = 0;
                                $con_rec_total = 0;
                                ?>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Payment</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($contra_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'C')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $con_pay_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Receive</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($contra_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'D')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $con_rec_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$con_pay_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$con_rec_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Journal Entries</h4>
                            </div>

                            <div class="row">
                                <?php
                                $journal_pay_total = 0;
                                $journal_rec_total = 0;
                                ?>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Payment</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($journal_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'C')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $journal_pay_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-title">
                                        <h5>Receive</h5>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Ledger Names</th>
                                            <th class="col-md-4">Amount ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($journal_entries as $entry)
                                            <?php
                                            $s_entry = \App\SingleEntry::where('entry_id', $entry->id)->where('dc', 'D')->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')->get();
                                            ?>
                                            @foreach($s_entry as $en)
                                                <?php
//                                                $name = str_replace('_', ' ', $en->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $en->name));
                                                $journal_rec_total += $en->amount;
                                                ?>
                                                <tr class="row">
                                                    <td class="col-md-8">{{$name}}</td>
                                                    <td class="col-md-4">{{$en->amount}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$journal_pay_total}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-md-8">Total</th>
                                            <th class="col-md-4">{{$journal_rec_total}}</th>
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
