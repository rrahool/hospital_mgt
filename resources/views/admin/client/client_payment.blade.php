<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Client Payment</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        @include('admin.includes.error')
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Client Payment
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                                {!! Form::open(['url'=>'client_payment','method'=>'post','role'=>'form','id'=>'getText','enctype'=>'multipart/form-data']) !!}
                                <div class="form-group col-lg-6">
                                    <label>Date</label>
                                    <input type="date" class="form-control" name="entry_date"  placeholder="dd/mm/yyyy" value="<?php echo $date ?>">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Serial Number</label>
                                    <input class="form-control" type="text" name="serial_no" value="{{ $serial_id }}" readonly>
                                    <p class="help-block">Enter serial number</p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Client Name</label>
                                    <select class="form-control" name="client_id" required>
                                        <option value="0">Select Client</option>
                                        @foreach($client as $value)
                                        <option value="{{ $value->id }}">{{ $value->client_name }}</option>
                                            @endforeach
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


                                <div class="form-group col-lg-6">
                                    <label>Against</label>
                                    <input type="text" class="form-control" placeholder="" name="memo_no">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" placeholder="" name="remarks">
                                </div>

                                <div class="form-group col-lg-6" id="1">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" placeholder="" name="amount">
                                </div>

                                <div class="form-group col-lg-6" id="2">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" placeholder="" name="bank_name">
                                </div>

                                <div class="form-group col-lg-6" id="3">
                                    <label>Cheque No</label>
                                    <input type="text" class="form-control" placeholder="" name="cheque_no">
                                </div>

                                <div class="form-group col-lg-6" id="4">
                                    <label>Issue Date</label>
                                    <input type="date" class="form-control" name="issue_date"  placeholder="dd/mm/yyyy" value="<?php echo $date ?>">

                                </div>

                                <div class="form-group col-lg-6" id="5">
                                    <label>Payment Date</label>
                                    <input type="date" class="form-control" name="payment_date"  placeholder="dd/mm/yyyy" value="<?php echo $date ?>">
                                </div>

                            <div class="form-group col-lg-6" style="margin-left:15px;">
                                <label>Image Upload</label>
                                <input type="file" name="payment_image">
                            </div>

                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-success pull-right col-lg-4" style="margin-right:15px;">Save</button>
                            </div>

                            {!! Form::close() !!}
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

@stop

@section('js')
<script>
    $('#getText').ready(function () {

        $(function() {
            $('#1').hide();
            $('#2').hide();
            $('#3').hide();
            $('#4').hide();
            $('#5').hide();
            $('#payment_type').change(function(){
                showForm($(this).val());
            });

        });

        function showForm(myFormType){
            if(myFormType == 'cash' || myFormType == 'discount'){
                $('#1').show();
                $('#2').hide();
                $('#3').hide();
                $('#4').hide();
                $('#5').hide();
            }
            if(myFormType == 'cheque'){
                $('#1').show();
                $('#2').show();
                $('#3').show();
                $('#4').show();
                $('#5').show();
            }
        }

    });


</script>
    @stop