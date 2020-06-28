<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create New Expense</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('admin.includes.error')
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Create New Expense
                </div>
                <div class="panel-body">

                    <div class="row" id="getReady">

                        {!! Form::open(['url'=>'create_expense', 'method'=>'post','id'=>'expense','enctype'=>"multipart/form-data"]) !!}

                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                        <div class="form-group col-lg-6">
                            <label>Date</label>
                            <input class="form-control" type="date" name="entry_date" value="{{ $date }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Entry No:</label>
                            <input class="form-control" type="text" name="entry_no" value="{{ $memo_no }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Expense/Payment</label>
                            <select class="form-control" name="exp_pay" id="option_selector" required>
                                <option value="0">Select Expense Options</option>
                                <option value="expense">Expense</option>
                                <option value="payment">Payment</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Payment Type</label>
                            <select class="form-control" name="payment_type" id="payment_type" required>
                                <option value="0">Select Payment Type</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="discount">Discount</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="1">
                            <label>Expense Type</label>
                            <select class="form-control" name="expense_type" id="expense_type">
                                <option value="0">Select Expense Type</option>
                                @foreach($expense_type as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="project">
                            <label>Project</label>
                            <select class="form-control" name="project">
                                <option value="0">Select Project</option>
                                @foreach($project as $value)
                                    <option value="{{ $value->id }}">{{ $value->project_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="2">
                            <label>Amount</label>
                            <input type="text" class="form-control" name="amount" value="" required>
                        </div>

                        <div class="form-group col-lg-6" id="3">
                            <label>Company Name</label>
                            <select class="form-control" name="supplier_id">
                                <option value="0">Select Company</option>
                                @foreach($supplier_info as $value)
                                    <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="4">
                            <label>Against</label>
                            <input type="text" class="form-control" name="memo_no">
                        </div>

                        <div class="form-group col-lg-6" id="5">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank_name">
                        </div>

                        <div class="form-group col-lg-6" id="6">
                            <label>Cheque No</label>
                            <input type="text" class="form-control" name="cheque_no">
                        </div>

                        <div class="form-group col-lg-6" id="7">
                            <label>Issue Date</label>
                            <input type="date" class="form-control" name="issue_date">
                        </div>

                        <div class="form-group col-lg-6" id="8">
                            <label>Payment Date</label>
                            <input type="date" class="form-control" name="payment_date">
                        </div>

                        <div class="form-group col-lg-6" id="9">
                            <label>Paid To</label>
                            <input type="text" class="form-control" name="paid_to">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Paid By</label>
                            <select class="form-control" name="paid_by" required>
                                <option value="0">Select User</option>
                                @foreach($users as $value)
                                <option value="{{ $value->id }}">{{ ucwords($value->username) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Description</label>
                            <input class="form-control" type="text" name="description" value="if any">
                        </div>

                        <div class="form-group col-lg-6" id="10">
                            <label>Image Upload</label>
                            <input type="file" class="" id="" name="image" placeholder="">
                        </div>

                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-success purchase-button-edit pull-right">Submit</button>
                        </div>






                        {{--</form>--}}

                        {!! Form::close() !!}

                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    @stop

@section('js')
    <script type="text/javascript">

        $(function() {
            $('#1').hide();
            $('#3').hide();
            $('#4').hide();
            $('#9').hide();
            $('#10').hide();
            $('#project').hide();
            $('#option_selector').change(function(){
                showForm($(this).val());
            });

        });

        function showForm(myFormType){
            if(myFormType == 'expense'){
                $('#1').show();
                $('#expense_type').attr('required', 'required');
                $('#3').hide();
                $('#4').hide();
                $('#9').show();
                $('#10').hide();
                $('#project').show();
            }

            else if(myFormType == 'payment'){
                $('#1').hide();
                $('#expense_type').removeAttr('required');
                $('#3').show();
                $('#4').show();
                $('#9').hide();
                $('#10').show();
                $('#project').hide();
            }

            else{
                $('#1').hide();
                $('#3').hide();
                $('#4').hide();
                $('#9').hide();
                $('#10').hide();
            }
        }

        $(function() {
            $('#2').hide();
            $('#5').hide();
            $('#6').hide();
            $('#7').hide();
            $('#8').hide();

            $('#payment_type').change(function(){
                showField($(this).val());
            });

        });

        function showField(myFormType){
            if(myFormType == 'cash' || myFormType == 'discount'){
                $('#2').show();
                $('#5').hide();
                $('#6').hide();
                $('#7').hide();
                $('#8').hide();
            }

            else if(myFormType == 'cheque'){
                $('#2').show();
                $('#5').show();
                $('#6').show();
                $('#7').show();
                $('#8').show();
            }

            else {
                $('#2').hide();
                $('#5').hide();
                $('#6').hide();
                $('#7').hide();
                $('#8').hide();
            }

        }

    </script>
    @stop