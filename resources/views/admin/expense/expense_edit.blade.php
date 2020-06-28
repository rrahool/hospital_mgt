@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Expense Edit</h1>
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
                    Expense Edit
                </div>
                <div class="panel-body">

                    <div class="row" id="getReady">

                        {!! Form::open(['url'=>'expense_edit', 'method'=>'post','id'=>'expense','enctype'=>"multipart/form-data"]) !!}

                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="checkImage" value="{{ $expense->image }}">

                        <div class="form-group col-lg-6">
                            <label>Date</label>
                            <input class="form-control" type="text" name="entry_date" value="{{ date('d-M-Y',$expense->entry_date) }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Entry No:</label>
                            <input class="form-control" type="text" name="entry_no" value="{{ $expense->id }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Expense/Payment</label>
                            <select class="form-control" name="exp_pay" id="option_selector" required>
                                <option value="0">Select Expense Options</option>
                                <option value="expense" <?php echo ($expense->exp_pay == 'expense') ? 'selected="selected"':''?>>Expense</option>
                                <option value="payment" <?php echo ($expense->exp_pay == 'payment')?'selected="selected"':''?>>Payment</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Payment Type</label>
                            <select class="form-control" name="payment_type" id="payment_type" required>
                                <option value="0">Select Payment Type</option>
                                <option value="cash" <?php echo ($expense->payment_type == 'cash')?'selected="selected"':''?>>Cash</option>
                                <option value="cheque" <?php echo ($expense->payment_type == 'cheque')?'selected="selected"':''?>>Cheque</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="1">
                            <label>Expense Type</label>
                            <select class="form-control" name="expense_type" id="expense_type">
                                <option value="0">Select Expense Type</option>
                                @foreach($expense_type as $value)
                                    <option value="{{ $value->id }}" <?php echo ($value->id == $expense->expense_type)?'selected="selected"':''?>>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="project">
                            <label>Project</label>
                            <select class="form-control" name="project">
                                <option value="0">Select Project</option>
                                @foreach($project as $value)
                                    <option value="{{ $value->id }}" <?php echo ($value->id == $expense->project)?'selected="selected"':''?>>{{ $value->project_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="2">
                            <label>Amount</label>
                            <input type="text" class="form-control" name="amount" value="{{ $expense->amount }}" required>
                        </div>

                        <div class="form-group col-lg-6" id="3">
                            <label>Company Name</label>
                            <select class="form-control" name="supplier_id">
                                <option value="0">Select Company</option>
                                @foreach($supplier_info as $value)
                                    <option value="{{ $value->id }}" <?php echo ($value->id == $expense->supplier_id)?'selected="selected"':''?>>{{ $value->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6" id="4">
                            <label>Against</label>
                            <input type="text" class="form-control" name="memo_no" value="{{ $expense->memo_no }}">
                        </div>

                        <div class="form-group col-lg-6" id="5">
                            <label>Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" value="{{ $expense->bank_name }}">
                        </div>

                        <div class="form-group col-lg-6" id="6">
                            <label>Cheque No</label>
                            <input type="text" class="form-control" name="cheque_no" value="{{ $expense->cheque_no }}">
                        </div>

                        <div class="form-group col-lg-6" id="7">
                            <label>Issue Date</label>
                            <input type="date" class="form-control" name="issue_date" value="{{ date('d/m/y',$expense->issue_date) }}">
                        </div>

                        <div class="form-group col-lg-6" id="8">
                            <label>Payment Date</label>
                            <input type="date" class="form-control" name="payment_date" value="{{ date('d/m/y',$expense->payment_date) }}">
                        </div>

                        <div class="form-group col-lg-6" id="9">
                            <label>Paid To</label>
                            <input type="text" class="form-control" name="paid_to" value="{{ $expense->paid_to }}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Paid By</label>
                            <select class="form-control" name="paid_by" required>
                                <option value="0">Select User</option>
                                @foreach($users as $value)
                                    <option value="{{ $value->id }}" <?php echo ($value->id == $expense->paid_by)?'selected="selected"':''?>>{{ ucwords($value->username) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Description</label>
                            <input class="form-control" type="text" name="description" value="{{ $expense->description }}" >
                        </div>

                        <div class="form-group col-lg-6" id="10">
                            @if($expense->exp_pay == 'payment')
                                @if(empty($expense_view->image))
                                    <img src="{{ asset('product_image/expense/no-image-available.jpg') }}" height="120px" width="120px">
                                @else
                                    <img src="{{ asset('product_image/expense/'.$expense->image) }}" height="120px" width="120px">
                                @endif
                            @endif
                            <br>
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
            $('#option_selector').change(function(){
                showForm($(this).val());
            });

        });

        function showForm(myFormType){
            if(myFormType == 'expense'){
                $('#1').show();
                $('#3').hide();
                $('#4').hide();
                $('#9').show();
                $('#10').hide();
                $('#project').show();
            }

            else if(myFormType == 'payment'){
                $('#1').hide();
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
            if(myFormType == 'cash'){
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

        $('#option_selector').ready(function(){
            var val = $('#option_selector').val();
            // showEditForm(val);
            showForm(val);
        });

        $('#payment_type').ready(function(){
            var val = $('#payment_type').val();
            showField(val);
        });

    </script>
@stop