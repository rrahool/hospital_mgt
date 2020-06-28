

@extends('layout')

@section('main_content')

    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

    </style>

    <div class="content-body">

        <div class="container-fluid">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(empty($client_info))

                            <h4 class="card-title">Create Doctor</h4>
                            <div class="basic-form">
                                <form action="{{url('create-new-client')}}" method="post" >

                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Doctor Name</span>
                                            <input type="text" name="client_name" autofocus  tabindex="1" class="input form-control" placeholder="Doctor Name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Designation</span>
                                            <input type="text" name="designation" tabindex="2" class="input form-control" placeholder="Designation" >
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Contact No</span>
                                            <input type="text" name="contact_no" tabindex="3" class="input form-control" placeholder="Contact No" data-validation="required">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <span class="level_size">Email Address</span>
                                            <input type="text" name="email" tabindex="4"  class="input form-control" placeholder="Email Address" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="code" tabindex="4" value="0" class="input form-control" placeholder="Ledger Code" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <input type="text" name="address" tabindex="5" class="input form-control" placeholder="Address" >
                                    </div>


                                    <div class="form-row margin_top_minus_10 " style="display: none">
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Type</span>
                                            <select id="inputState" tabindex="6" class="form-control" name="dr_cr" data-validation="required">
                                                <option selected="selected" value="">Choose...</option>
                                                <option value="D" selected>Dr</option>
                                                <option value="C">Cr</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-9">
                                            <span class="level_size">Opening Balance</span>
                                            <input type="text" tabindex="7" value="0" name="opening_balance" class="input form-control" placeholder="Opening Balance" data-validation="number" data-validation-allowing="float">
                                            <span class="level_size">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10" style="display: none">
                                        <div class="form-check">
                                            <input class="form-check-input" tabindex="8" type="checkbox" name="reconciliation" value="1">
                                            <span class="level_size">Reconciliation</span>
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10" style="display: none">
                                        <span class="level_size">Notes</span>
                                        <textarea class="input form-control h-150px" tabindex="9" name="notes" rows="3" id="comment"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-dark">Create</button>
                                </form>
                            </div>

                            @else
                                <h4 class="card-title">Edit Doctor List Info</h4>
                                <div class="basic-form">
                                    <form action="{{url('edit-client-info')}}" method="post" >

                                        @csrf

                                        <input type="hidden" name="id" value="{{$client_info->id}}">
                                        <input type="hidden" name="ledger_id" value="{{$ledger_info->id}}">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Doctor Name</span>
                                                <input type="text" name="client_name" tabindex="1" class="input form-control" value="{{$client_info->client_name}}" data-validation="required" placeholder="Doctor Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Designation</span>
                                                <input type="text" name="designation" tabindex="2" class="input form-control" value="{{$client_info->designation}}" data-validation="required" placeholder="Designation">
                                            </div>
                                        </div>

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Contact No</span>
                                                <input type="text" name="contact_no" tabindex="3" class="input form-control" value="{{$client_info->contact_no}}" data-validation="required" placeholder="Contact No">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Email Address</span>
                                                <input type="text" name="email" tabindex="3" class="input form-control" value="{{$client_info->email}}" data-validation="required" placeholder="Contact No">
                                            </div>
                                            <div class="form-group col-md-6" style="display: none">
                                                <span class="level_size">Ledger Code</span>
                                                <input type="text" name="code" tabindex="4" class="input form-control" value="{{$ledger_info->code}}" data-validation="required" placeholder="Ledger Code">
                                            </div>
                                        </div>


                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Address</span>
                                            <input type="text" name="address" tabindex="5" class="input form-control" value="{{$client_info->address}}" data-validation="required" placeholder="Address">
                                        </div>


                                        <div class="form-row  margin_top_minus_10" style="display: none">
                                            <div class="form-group col-md-3">
                                                <span class="level_size">Type</span>
                                                <select id="inputState" tabindex="6" class="form-control" name="dr_cr" data-validation="required">
                                                    <option value="">Choose...</option>
                                                    @if($ledger_info->op_balance_dc == 'D')
                                                        <option value="D" selected="selected">Dr</option>
                                                        <option value="C">Cr</option>
                                                    @else
                                                        <option value="D">Dr</option>
                                                        <option value="C" selected="selected">Cr</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-9" style="display: none">
                                                <span class="level_size">Opening Balance</span>
                                                <input type="text" name="opening_balance" tabindex="7 class="input form-control" value="{{$ledger_info->op_balance}}" data-validation="number" data-validation-allowing="float" placeholder="Opening Balance">
                                                <span class="level_size">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                            </div>
                                        </div>

                                        <div class="form-group margin_top_minus_10" style="display: none">
                                            <div class="form-check">
                                                @if($ledger_info->reconciliation == 1)
                                                    <input class="form-check-input" tabindex="8" type="checkbox" name="reconciliation" value="1" checked>
                                                    <span class="level_size">Reconciliation</span>
                                                @else
                                                    <input class="form-check-input" tabindex="8" type="checkbox" name="reconciliation" value="1">
                                                    <span class="level_size">Reconciliation</span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group margin_top_minus_10" style="display: none">
                                            <span class="level_size">Notes</span>
                                            <textarea class="input form-control h-150px" tabindex="9" name="notes" rows="3" id="comment">{{$ledger_info->notes}}</textarea>
                                        </div>

                                        <button type="submit" tabindex="10" class="btn btn-primary">Update</button>
                                        <a href="{{url('create-doctor')}}" tabindex="11" class="btn btn-dark">Create</a>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <h4 class="card-title">Doctors List</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Email</th>
                                            <th>Contact No.</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($clients as $client)
                                            <?php
                                                $led = \App\Ledger::where('name', $client->client_id)->first();
                                            ?>
                                            <tr>
                                                <td>{{$client->client_name}}</td>
                                                <td>{{$client->email}}</td>
                                                <td>{{$client->contact_no}}</td>
                                                <td>{{$client->address}}</td>
                                                <td><a href="{{url('edit-doctor/'.$client->id)}}" class="btn btn-primary">Edit</a> <a href="{{url('delete-client/'.$client->client_id)}}" class="btn btn-danger">Delete</a></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Code</th>
                                            <th>Contact No.</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
        <!-- #/ container -->
    </div>


@endsection
