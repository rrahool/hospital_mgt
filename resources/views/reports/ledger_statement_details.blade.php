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
                                <h4>View {{$type}} Entry</h4>
                            </div>

                            <div class="card-title">
                                <h5>Number {{$my_entry->number}}</h5>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">

                                    <p><b>Vouchar No:</b> </p>
                                    <p><b>Date: </b>{{$my_entry->date}} </p>
                                    @foreach($single_entries as $entry)
                                        <?php

                                        $dr_cr = ($entry->dc == 'D')?"To":'From';
                                        $ledger_name = \App\Ledger::select('name')->where('id', $entry->ledger_id)->first()->name;
                                        $ledger_name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $ledger_name));
                                        ?>
                                        <p><b>{{$dr_cr}}: </b> {{$ledger_name}}</p>
                                    @endforeach
                                    <br>


                                    <table class="table">
                                        <thead>
                                        <tr class="row">
                                            <th class="col-lg-8">Description</th>
                                            <th class="col-lg-4">Amount</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        {{--@foreach($single_entries as $entry)--}}



                                        <tr class="row">
                                            <td class="col-lg-8">{{$single_entries[0]->Remarks}}</td>
                                            <td class="col-lg-4">{{$single_entries[0]->amount}}</td>

                                        </tr>
                                        {{--@endforeach--}}
                                        </tbody>

                                        <thead>
                                        <tr class="row">
                                            <th class="col-lg-8">Total</th>
                                            <th class="col-lg-4">{{$single_entries[0]->amount}}</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    <br>
                                    <p class="col-lg-8">Approved By:   _____________________</p><br><br>
                                    <p class="col-lg-8">Revieved By:   _____________________</p>
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
