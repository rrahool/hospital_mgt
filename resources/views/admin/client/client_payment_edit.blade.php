@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning"> Client Payment Edit </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        @include('admin.includes.error')
    </div>

    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                     Client Payment Edit
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['url'=>'payment_edit','method'=>'post','role'=>'form','id'=>'getValue','name'=>'payment','enctype'=>'multipart/form-data']) !!}
                            <div class="form-group col-lg-6">
                                <label>Date</label>
                                <input type="text" class="form-control" name="entry_date"  value="{{ date('d-M-Y',$payment->entry_date) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Client Name</label>
                                <select class="form-control" name="client_id">
                                    <option value="0">Select Client</option>
                                    @foreach($client as $value)
                                        <option value="{{ $value->id }}">{{ $value->client_name }}</option>
                                        <option value="{{ $value->id }}" <?php echo ($value->id == $payment->client_id)?'selected="selected"':''?>>{{ $value->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Payment Type</label>
                                <select class="form-control" name="payment_type" id="payment_type" required>
                                    <option value="0">Select Payment Type</option>
                                    <option value="cash" <?php echo ($payment->payment_type == 'cash')?'selected="selected"':''?>>Cash</option>
                                    <option value="cheque" <?php echo ($payment->payment_type == 'cheque')?'selected="selected"':''?>>Cheque</option>
                                </select>
                            </div>


                            <div class="form-group col-lg-6">
                                <label>Against</label>
                                <input type="text" class="form-control" placeholder="" name="memo_no" value="{{ $payment->memo_no }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Remarks</label>
                                <input type="text" class="form-control" placeholder="" name="remarks" value="{{ $payment->remarks }}">
                            </div>

                            <div class="form-group col-lg-6" id="1">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="" name="amount" value="{{ $payment->amount }}">
                            </div>

                            <div class="form-group col-lg-6" id="2">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" placeholder="" name="bank_name" value="{{ $payment->bank_name }}">
                            </div>

                            <div class="form-group col-lg-6" id="3">
                                <label>Cheque No</label>
                                <input type="text" class="form-control" placeholder="" name="cheque_no" value="{{ $payment->cheque_no }}">
                            </div>

                            <div class="form-group col-lg-6" id="4">
                                <label>Issue Date</label>
                                <input type="text" class="form-control" name="issue_date"  value="{{ date('d-M-Y',$payment->issue_date) }}">

                            </div>

                            <div class="form-group col-lg-6" id="5">
                                <label>Payment Date</label>
                                <input type="text" class="form-control" name="payment_date"  value="{{ date('d-M-Y',$payment->payment_date) }}">
                            </div>


                            <div class="form-group" style="margin-left:15px;">
                                @if($payment->image == NULL)
                                    <img src="{{ asset('product_image/product_icon.png') }}" height="120px" width="120px">
                                @else
                                    <img src="{{ asset('product_image/cheque/').'/'.$payment->image }}" height="120px" width="120px">

                                @endif
                                <br>
                                <label>File input</label>
                                <input type="file" name="payment_image">
                            </div>

                            <input type="hidden" name="id" value="{{ $payment->id }}">
                            <input type="hidden" name="defaulImage" value="{{ $payment->image }}">


                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-success pull-right col-lg-4" style="margin-right:15px;">Update</button>
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
        $('#getValue').ready(function () {

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
                if(myFormType == 'cash'){
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

            $('#payment_type').ready(function(){
                var val = $('#payment_type').val();
                // showEditForm(val);
                showForm(val);
            });
        });
    </script>
    @stop