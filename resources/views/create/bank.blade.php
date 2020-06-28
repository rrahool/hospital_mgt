

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
                            @if(empty($bank_info))
                            <h4 class="card-title">Create Bank Ledger</h4>
                            <div class="basic-form">

                                <form action="{{url('create-new-bank')}}" method="post" >

                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank Name</span>
                                            <input type="text" name="bank_name" tabindex="1" autofocus  data-validation="required" class="input form-control" placeholder="Bank Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Branch Name</span>
                                            <input type="text" name="branch_name" tabindex="2" class="input form-control" placeholder="Branch Name" data-validation="required">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Account Name</span>
                                            <input type="text" name="account_name" tabindex="3" class="input form-control" placeholder="Account Name" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Account No.</span>
                                            <input type="text" name="account_no" tabindex="4" class=" input form-control" placeholder="Account No." data-validation="required" >
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Ledger Code</span>
                                        <input type="text" name="bank_code" tabindex="5" class="input form-control" placeholder="Ledger Code" data-validation="required">
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Type</span>
                                            <select id="inputState" tabindex="6" class="form-control" name="dr_cr" data-validation="required">
                                                <option value="" selected="selected">Choose...</option>
                                                <option value="D">Dr</option>
                                                <option value="C">Cr</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-9 ">
                                            <span class="level_size">Opening Balance</span>
                                            <input type="text" name="opening_balance" tabindex="7" class="input form-control" placeholder="Opening Balance" data-validation="number" data-validation-allowing="float">
                                            <span class="level_size">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" tabindex="8" name="reconciliation" value="1">
                                            <span class="level_size">Reconciliation</span>
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Notes</span>
                                        <textarea class="input form-control h-150px" tabindex="9" name="notes" rows="3" id="comment"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-dark" tabindex="10">Create</button>
                                </form>

                            </div>
                            @else
                                <h4 class="card-title">Edit Bank Ledger Info</h4>

                                <form action="{{url('edit-bank-info')}}" method="post" >

                                    @csrf

                                    <input type="hidden" name="bank_id" value="{{$bank_info->id}}">
                                    <input type="hidden" name="ledger_id" value="{{$ledger_info->id}}">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Bank Name</span>
                                            <input type="text" name="bank_name" tabindex="1" class="form-control" value="{{$bank_info->bank_name}}" data-validation="required" placeholder="Bank Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Branch Name</span>
                                            <input type="text" name="branch_name" tabindex="2" class="form-control" value="{{$bank_info->branch_name}}" data-validation="required" placeholder="Branch Name">
                                        </div>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Account Name</span>
                                            <input type="text" name="account_name" tabindex="3" class="form-control" value="{{$bank_info->account_name}}" data-validation="required" placeholder="Account Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Account No.</span>
                                            <input type="text" name="account_no" tabindex="4" class="form-control" value="{{$bank_info->account_no}}" data-validation="required" placeholder="Account No.">
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Ledger Code</span>
                                        <input type="text" name="bank_code" tabindex="5" class="form-control" value="{{$ledger_info->code}}" data-validation="required" placeholder="Ledger Code">
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Type</span>
                                            <select id="inputState" tabindex="6" class="form-control" name="dr_cr" data-validation="required">
                                                <option value="">Choose...</option>
                                                @if($ledger_info->op_balance_dc == 'D')
                                                    <option value="D" selected="selected">Dr</option>
                                                    <option value="C">Cr</option>
                                                @else
                                                    <option value="D" >Dr</option>
                                                    <option value="C" selected="selected">Cr</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-9">
                                            <span class="level_size">Opening Balance</span>
                                            <input type="text" name="opening_balance" tabindex="7" class="form-control" value="{{$ledger_info->op_balance}}" data-validation="number" data-validation-allowing="float" placeholder="Opening Balance">
                                            <span class="level_size">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
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


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Notes</span>
                                        <textarea class="form-control h-150px" tabindex="9" name="notes" rows="3" id="comment" >{{$ledger_info->notes}}</textarea>
                                    </div>

                                    <button type="submit" tabindex="10" class="btn btn-primary">Update</button>
                                    <a href="{{url('create-bank')}}" tabindex="11" class="btn btn-dark">Create Bank</a>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bank Ledgers</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Acc Name</th>
                                            <th>Acc No.</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($banks as $bank)
                                        <tr>
                                            <td>{{$bank->bank_name}}</td>
                                            <td>{{$bank->account_name}}</td>
                                            <td>{{$bank->account_no}}</td>
                                            <td><a href="{{url('edit-bank/'.$bank->id)}}" class="btn btn-primary">Edit</a> <a href="{{url('delete-bank/'.$bank->bank_id)}}" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Acc Name</th>
                                            <th>Acc No.</th>
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


