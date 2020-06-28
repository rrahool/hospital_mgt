

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

                            @if(empty($income_info))
                                <h4 class="card-title">Create Income Ledger</h4>
                                <div class="basic-form">
                                <form action="{{url('create-new-income')}}" method="post" >

                                    @csrf

                                    <div class="form-group">
                                        <span class="level_size">Income Ledger Name</span>
                                        <input type="text" autofocus  tabindex="1" name="client_name" class="input form-control" placeholder="Income Ledger Name" data-validation="required">
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Catagory</span>
                                            <select id="inputState" tabindex="2" class="input form-control" name="group_id" data-validation="required">
                                                @foreach($sub_groups as $group)
                                                    <option value="{{$group->id}}">{{$group->name}}</option>ion
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Contact No</span>
                                            <input type="text" tabindex="3" name="contact_no" class="input form-control" placeholder="Contact No" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Ledger Code</span>
                                            <input type="text" tabindex="4" name="code" class="input form-control" placeholder="Ledger Code" data-validation="required">
                                        </div>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Address</span>
                                        <input type="text" tabindex="5" name="address" class="input form-control" placeholder="Address">
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-3">
                                            <span class="level_size">Type</span>
                                            <select id="inputState" tabindex="6" class="input form-control" name="dr_cr" data-validation="required">
                                                <option value="C">Cr</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-9">
                                            <span class="level_size">Opening Balance</span>
                                            <input type="text" tabindex="7" name="opening_balance" class="input form-control" placeholder="Opening Balance" data-validation="number" data-validation-allowing="float">
                                            <span class="level_size">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                        </div>
                                    </div>

                                    <div class="form-group margin_top_minus_10">
                                        <div class="form-check">
                                            <input class="form-check-input" tabindex="8" type="checkbox" name="reconciliation" value="1">
                                            <span class="level_size">Reconciliation</span>
                                        </div>
                                        <span class="level_size">Note : If selected the ledger account can be reconciled from Reports > Reconciliation</span>
                                    </div>


                                    <div class="form-group margin_top_minus_10">
                                        <span class="level_size">Notes</span>
                                        <textarea class="input form-control h-150px" tabindex="9" name="notes" rows="3" id="comment"></textarea>
                                    </div>

                                    <button type="submit" tabindex="10" class="btn btn-dark">Create</button>
                                </form>
                            </div>
                            @else
                                <h4 class="card-title">Edit Income Ledger Info</h4>
                                <div class="basic-form">
                                    <form action="{{url('edit-income-info')}}" method="post" >

                                        @csrf

                                        <input type="hidden" name="id" value="{{$income_info->id}}">
                                        <input type="hidden" name="ledger_id" value="{{$ledger_info->id}}">

                                        <div class="form-group">
                                            <span class="level_size">Income Ledger Name</span>
                                            <input type="text" tabindex="1" name="client_name" class="input form-control" value="{{$income_info->name}}" placeholder="Income Ledger Name">
                                        </div>

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-12">
                                                <span class="level_size">Catagory</span>
                                                <select id="inputState" tabindex="2" class="form-control" name="group_id">
                                                    @foreach($sub_groups as $group)
                                                        @if($group->id == $income_info->group_id)
                                                            <option value="{{$group->id}}" selected>{{$group->name}}</option>
                                                        @else
                                                            <option value="{{$group->id}}">{{$group->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Contact No</span>
                                                <input type="text" tabindex="3" name="contact_no" class="input form-control" value="{{$income_info->contact_no}}" placeholder="Contact No">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Ledger Code</span>
                                                <input type="text" tabindex="4" name="code" class="input form-control" value="{{$ledger_info->code}}" placeholder="Ledger Code">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <span class="level_size">Address</span>
                                            <input type="text" tabindex="5" name="address" class="input form-control" value="{{$income_info->address}}" placeholder="Address">
                                        </div>


                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-3">
                                                <span class="level_size">Type</span>
                                                <select id="inputState" tabindex="6" class="input form-control" name="dr_cr">
                                                    <option value="C" selected>Cr</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-9">
                                                <span class="level_size">Opening Balance</span>
                                                <input type="text" tabindex="7" name="opening_balance" class="input form-control" value="{{$ledger_info->op_balance}}" placeholder="Opening Balance" data-validation="number" data-validation-allowing="float">
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
                                            <span class="level_size">Note : If selected the ledger account can be reconciled from Reports > Reconciliation</span>
                                        </div>


                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Notes</span>
                                            <textarea class="input form-control h-150px" tabindex="9" name="notes" rows="3" id="comment">{{$ledger_info->notes}}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary" tabindex="10">Update</button>
                                        <a href="{{url('create-income')}}" tabindex="11" class="btn btn-dark">Create</a>
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
                                <h4 class="card-title">Income Ledgers</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Code</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($incomes as $income)
                                            <?php
                                            $led = \App\Ledger::where('name', $income->income_id)->first();
                                            $group = \App\Group::select('name')->where('id', $income->group_id)->first();
                                            ?>
                                            <tr>
                                                <td>{{$income->name}}</td>
                                                <td>{{$led->code}}</td>
                                                <td>{{$group->name}}</td>
                                                <td>{{$income->address}}</td>
                                                <td><a href="{{url('edit-income/'.$income->id)}}" class="btn btn-primary">Edit</a> <a href="{{url('delete-income/'.$income->income_id)}}" class="btn btn-danger">Delete</a></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Code</th>
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
