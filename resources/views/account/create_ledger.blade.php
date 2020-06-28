

@extends('layout')

@section('main_content')
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
                            <h4 class="card-title">Create Ledger</h4>
                            <div class="basic-form">
                                <form action="{{url('create-new-ledger')}}" method="post" >

                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Ledger Name</label>
                                            <input type="text" name="ledger_name" class="form-control" placeholder="Ledger Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Ledger Code</label>
                                            <input type="text" name="ledger_code" class="form-control" placeholder="Ledger Code">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Group</label>
                                        <select id="inputState" class="form-control" name="parent_group">
                                            <option selected="selected">Choose...</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>




                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>Type</label>
                                            <select id="inputState" class="form-control" name="dr_cr">
                                                <option selected="selected">Choose...</option>
                                                <option value="D">Dr</option>
                                                <option value="C">Cr</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-9">
                                            <label>Opening Balance</label>
                                            <input type="text" name="amount" class="form-control" placeholder="Opening Balance">
                                            Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="LedgerType" value="1">
                                            <label class="form-check-label">Bank or cash account</label>
                                        </div>
                                        Note : Select if the ledger account is a bank or a cash account.
                                    </div>


                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="reconciliation" value="1">
                                            <label class="form-check-label">Reconciliation</label>
                                        </div>
                                        Note : If selected the ledger account can be reconciled from Reports > Reconciliation
                                    </div>


                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control h-150px" name="notes" rows="3" id="comment"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <a href="{{url('show-accounts')}}" class="btn btn-outline-light">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>


@endsection
