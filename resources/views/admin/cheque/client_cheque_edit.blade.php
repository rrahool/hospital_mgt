@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header"> Client Cheque Edit</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.error')
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Client Cheque Edit</div>
        <div class="panel-body">
            {{ Form::open(['url'=>'client_cheque_update','method'=>'post']) }}

            <input type="hidden" class="form-control" name="entry_date" value="<?=date('Y-m-d')?>">

            <input type="hidden" class="form-control" name="entry_id" value="{{ $client_payment->id }}">

            <div class="form-group col-lg-6">
                <label>Clinet Name:</label>
                <select class="form-control" name="client_id">

                    <option>Select Clinet</option>
                    @foreach ($select_client as $value)
                        <option value="{{ $value->id }}" <?php echo ($value->id == $client_payment->client_id)?'selected="selected"':''?>>{{ $value->client_name }}</option>
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
                <input type="text" class="form-control" name="amount" value="<?=$client_payment->amount?>">
            </div>

            <div class="form-group col-lg-6">
                <label>Bank Name:</label>
                <input type="text" class="form-control" name="bank_name" value="<?=$client_payment->bank_name?>">
            </div>

            <div class="form-group col-lg-6">
                <label>Cheque No:</label>
                <input type="text" class="form-control" name="cheque_no" value="<?=$client_payment->cheque_no?>">
            </div>

            <div class="form-group col-lg-6">
                <label>Issue Date:</label>
                <input type="text" class="form-control" name="issue_date" value="<?php echo date('d-m-Y',$client_payment->issue_date)?>">
            </div>

            <div class="col-md-6">
                <label>Payment Date:</label>
                <input type="text" class="form-control expenseDateSelector" name="payment_date" value="<?php echo date('d-m-Y',$client_payment->payment_date)?>">
            </div>

            <div class="form-group col-lg-6">
                <label>Payment Type:</label>
                <select class="form-control" name="status" id="" required>

                    <option value="">Select Payment Type</option>

                    <option value="pending" <?php echo ($client_payment->status == 'pending')?'selected="selected"':''?>>Pending</option>

                    <option value="bounced" <?php echo ($client_payment->status == 'bounced')?'selected="selected"':''?>>Bounced</option>

                    <option value="approved" <?php echo ($client_payment->status == 'approved')?'selected="selected"':''?>>Approved</option>

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