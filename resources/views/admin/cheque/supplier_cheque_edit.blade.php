@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header"> Supplier Cheque Edit</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.error')
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Supplier Cheque Edit</div>
        <div class="panel-body">
            {{ Form::open(['url'=>'supplier_cheque_update','method'=>'post']) }}

                <input type="hidden" class="form-control" name="entry_date" value="<?=date('Y-m-d')?>">

                <input type="hidden" class="form-control" name="entry_id" value="{{ $supplier_cheque->id }}">

                <div class="form-group col-lg-6">
                    <label>Supplier Name:</label>
                    <select class="form-control" name="supplier_id">

                        <option>Select Supplier</option>
                        @foreach ($supplier_info as $value)
                            <option value="{{ $value->id }}" <?php echo ($value->id == $supplier_cheque->supplier_id)?'selected="selected"':''?>>{{ $value->supplier_name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>Payment Type :</label>
                    <select class="form-control" name="payment_type" id="payment_type" required>

                        <option value="">Select Payment Type</option>

                        <option value="cash">Cash</option>

                        <option value="cheque" selected="selected">Cheque</option>

                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label>Amount :</label>
                    <input type="text" class="form-control" name="amount" value="<?=$supplier_cheque->amount?>">
                </div>

                <div class="form-group col-lg-6">
                    <label>Bank Name:</label>
                    <input type="text" class="form-control" name="bank_name" value="<?=$supplier_cheque->bank_name?>">
                </div>

                <div class="form-group col-lg-6">
                    <label>Cheque No:</label>
                    <input type="text" class="form-control" name="cheque_no" value="<?=$supplier_cheque->cheque_no?>">
                </div>

                <div class="form-group col-lg-6">
                    <label>Issue Date:</label>
                    <input type="text" class="form-control" name="issue_date" value="<?php echo date('d-m-Y',$supplier_cheque->issue_date)?>">
                </div>

                <div class="col-md-6">
                    <label>Payment Date:</label>
                    <input type="text" class="form-control expenseDateSelector" name="payment_date" value="<?php echo date('d-m-Y',$supplier_cheque->payment_date)?>">
                </div>

                <div class="form-group col-lg-6">
                    <label>Payment Type:</label>
                    <select class="form-control" name="status" id="" required>

                        <option value="">Select Payment Type</option>

                        <option value="pending" <?php echo ($supplier_cheque->status == 'pending')?'selected="selected"':''?>>Pending</option>

                        <option value="bounced" <?php echo ($supplier_cheque->status == 'bounced')?'selected="selected"':''?>>Bounced</option>

                        <option value="approved" <?php echo ($supplier_cheque->status == 'approved')?'selected="selected"':''?>>Approved</option>

                    </select>
                </div>


                <div class="form-group col-md-12">
                    <br>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success purchase-button-edit">Submit</button>
                    </div>
                    <div class="pull-left">
                        <a href="{{ url('cheque_manager') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>  Back</a>
                    </div>

                </div>
            {{ Form::close() }}
        </div>
    </div>
    @stop