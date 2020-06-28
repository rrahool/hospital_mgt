

@extends('layout')

@section('main_content')
    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

    </style>

    <?php
        $current_date = date('m/d/Y');
    ?>
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
                            <h4 class="card-title">Create Entry</h4>
                            <div class="basic-form">
                                <form action="{{url('create-new-entry')}}" method="post" name = "myForm" onsubmit="return validateForm()">

                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6" >
                                            <span class="level_size">Entry Number</span>
                                            <input type="text" name="number" style="" value="{{$entry_no}}" readonly class="input form-control" placeholder="Entry Number" data-validation="required">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Voucher No</span>
                                            <input type="text" name="vou_no" tabindex="1" class="input form-control" placeholder="Voucher No" autofocus >
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10" >
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Transaction Type</span>
                                            <select class="form-control js-example-basic-single" tabindex="2" name="trans_type" id="trans_type" onChange="getTransactionType(this);" data-validation="required">
                                                <option value="">-- Select Transaction Type --</option>
                                                @foreach($entrytypes as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Transaction Date</span>
                                            <div class="input-group">
                                                <input type="text" name="trans_date" tabindex="3" onchange="getDate(this.value)"  class="form-control mydatepicker" placeholder="mm/dd/yyyy" data-validation="required" > <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Month</span>
                                            <input type="text" name="date_summary" readonly tabindex="4" id="month" class="form-control" placeholder="Month">
                                        </div>
                                    </div>


                                    <div id="pay_rec_div">

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Transaction For</span>
                                                <select class="form-control" tabindex="5" name="trans_for" data-validation="required" >
                                                    <option value="Official">Official</option>
                                                    <option value="Personal ">Personal</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Transaction Mode</span>
                                                <select class="form-control" tabindex="6" name="trans_mode" onChange="getTransactionMode(this);" data-validation="required">
                                                    <option value="">-- Select Mode --</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Cheque">Cheque</option>
                                                </select>
                                            </div>
                                        </div>


                                        {{-- for payment --}}
                                        <div id="payment_div" style="display: none">
                                            <div class="form-row margin_top_minus_10" >
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Payment To</span>
                                                    <select class="form-control js-example-basic-single" tabindex="7" name="pay_to" style="width: 100%">
                                                        @foreach($other_ledgers as $payable)
                                                            <?php
                                                                $name = str_replace('_', ' ', $payable->name);
                                                                $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$payable->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Payment From</span>
                                                    <select class="form-control js-example-basic-single" tabindex="8" name="pay_from" style="width: 100%">
                                                        @foreach($cash_ledgers as $led)
                                                            <?php
                                                                $name = str_replace('_', ' ', $led->name);
                                                                $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$led->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- for Receipt --}}
                                        <div id="receipt_div" style="display: none">
                                            <div class="form-row margin_top_minus_10" >
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Receipt To</span>
                                                    <select class="form-control js-example-basic-single" tabindex="9" name="receipt_to"  style="width: 100%">
                                                        @foreach($cash_ledgers as $led)
                                                            <?php
                                                            $name = str_replace('_', ' ', $led->name);
                                                            $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$led->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Receipt From</span>
                                                    <select class="form-control js-example-basic-single" tabindex="10" name="receipt_from" style="width: 100%">
                                                        @foreach($other_ledgers as $c)
                                                            <?php
                                                            $name = str_replace('_', ' ', $c->name);
                                                            $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$c->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- for Contra --}}
                                        <div id="contra_div" style="display: none">
                                            <div class="form-row margin_top_minus_10" >
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">To</span>
                                                    <select class="form-control js-example-basic-single" tabindex="11" name="contra_to" style="width: 100%">
                                                        @foreach($cash_ledgers as $led)
                                                            <?php
                                                            $name = str_replace('_', ' ', $led->name);
                                                            $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$led->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">From</span>
                                                    <select class="form-control js-example-basic-single" tabindex="12" name="contra_from" style="width: 100%">
                                                        @foreach($cash_ledgers as $led)
                                                            <?php
                                                            $name = str_replace('_', ' ', $led->name);
                                                            $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                            ?>
                                                            <option value="{{$led->id}}">{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="cheque_div" style="display: none">
                                            <div class="form-group">
                                                <span class="level_size">Bank Name</span>
                                                <input type="text" name="bank_name" class="input form-control" tabindex="13" placeholder="Bank Name" data-validation="required">
                                            </div>

                                            <div class="form-row margin_top_minus_10">

                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Cheque No</span>
                                                    <input type="text" name="cheque_no" tabindex="14" class="input form-control" placeholder="Cheque No" data-validation="required">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Cheque Date</span>
                                                    <div class="input-group">
                                                        <input type="text" name="cheque_date" tabindex="15" onchange="getDate(this.value)" value="{{$current_date}}" class="form-control mydatepicker" data-validation="required" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Amount</span>
                                            <input type="text" name="amount" class="input form-control input_amount" tabindex="16" placeholder="Amount" data-validation="number" data-validation-allowing="float">
                                            <span id="input_amount_in_words"></span>
                                        </div>


                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Narration</span>
                                                <textarea class="input form-control h-150px" name="narration" rows="2" tabindex="17" id="narration" placeholder="Narration"></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Remarks</span>
                                                <textarea class="input form-control h-150px" name="remarks" rows="2" tabindex="18" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>

                                    </div>



                                    {{--  Journal div  --}}
                                    <div id="journal_div"  style="display: none">

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <table id="myTable" class=" table dr-order-list">
                                                    <h3 style="margin-left: 0px">Debit</h3>
                                                    <thead>
                                                    <tr>
                                                        <td>Select A/C Head</td>
                                                        <td>Debit Amount</td>
                                                        <td></td>
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                        <tr>
                                                        <td style="width: 245px">

                                                            <select id="js-example-basic-single-a" class=" form-control " tabindex="19" name="dr_acc[]" style="width: 100%">
                                                                @foreach($journal_ledgers as $c)
                                                                    <?php
                                                                    $name = str_replace('_', ' ', $c->name);
                                                                    $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                                    ?>
                                                                    <option value="{{$c->id}}">{{$name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="dr_amount[]" tabindex="20" class="input form-control dr_amount" placeholder="Amount"  onkeyup="dr_sum()" data-validation="number" data-validation-allowing="float">
                                                        </td>
                                                        <td>
                                                            <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete">
                                                        </td>
                                                        </tr>
                                                    </tbody>

                                                    <tfoot>

                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td colspan="" style="text-align: left;">
                                                            <input type="button" class="btn btn-primary " id="addrow_dr" value="Add Row" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="">Total</label></td>
                                                        <td colspan="2"><input type="text" name="dr_total" class="dr_total form-control" id="dr_total" data-validation="required" readonly>
                                                            <span id="dr_in_word"></span></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <table id="myTable" class=" table  cr-order-list">
                                                    <h3 style="margin-left: 0px">Credit</h3>
                                                    <thead>
                                                    <tr>
                                                        <td>Select A/C Head</td>
                                                        <td>Credit Amount</td>
                                                        <td></td>
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    <tr>
                                                        <td style="width: 245px">
                                                            <select id="inputState" tabindex="21" class="form-control js-example-basic-single" name="cr_acc[]" style="width: 100%">
                                                                @foreach($journal_ledgers as $c)
                                                                    <?php
                                                                    $name = str_replace('_', ' ', $c->name);
                                                                    $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                                    ?>
                                                                    <option value="{{$c->id}}">{{$name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="cr_amount[]" tabindex="22" class="input form-control cr_amount" placeholder="Amount"  onkeyup="cr_sum()" data-validation="number" data-validation-allowing="float">
                                                        </td>
                                                        <td>
                                                            <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete">
                                                        </td>
                                                    </tr>
                                                    </tbody>


                                                    <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td colspan="" style="text-align: left;">
                                                            <input type="button" class="btn btn btn-primary " id="addrow_cr" value="Add Row" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="">Total</label></td>
                                                        <td colspan="2"><input type="text"  name="cr_total" class="input cr_total form-control" id="cr_total" data-validation="required" readonly>
                                                            <span id="cr_in_word"></span>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="form-group " style="margin-top: -20px">
                                            <span class="level_size">Narration</span>
                                            <textarea class="input form-control h-150px" name="narration1" rows="2" placeholder="Narration"></textarea>
                                        </div>

                                        <div style="display: none" id="err">
                                            <p class="alert alert-danger" id="err_msg"></p>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-dark">Create</button>
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

@section('js')

    <script>



        /* Checking Transaction Type */
        function getTransactionType(selected_option) {
            var value = selected_option.options[selected_option.selectedIndex].text;
            //console.log(value);

            if (value == 'Payment'){
                document.getElementById('pay_rec_div').style.display = 'block';
                document.getElementById('payment_div').style.display = 'block';
                document.getElementById('receipt_div').style.display = 'none';
                document.getElementById('journal_div').style.display = 'none';
                document.getElementById('contra_div').style.display = 'none';


            } else if(value == 'Receipt'){
                document.getElementById('pay_rec_div').style.display = 'block';
                document.getElementById('receipt_div').style.display = 'block';
                document.getElementById('payment_div').style.display = 'none';
                document.getElementById('journal_div').style.display = 'none';
                document.getElementById('contra_div').style.display = 'none';

            }else if(value == 'Contra'){//contra_div

                document.getElementById('pay_rec_div').style.display = 'block';
                document.getElementById('receipt_div').style.display = 'none';
                document.getElementById('payment_div').style.display = 'none';
                document.getElementById('journal_div').style.display = 'none';
                document.getElementById('contra_div').style.display = 'block';

            }else if(value == 'Journal'){
                document.getElementById('pay_rec_div').style.display = 'none';
                document.getElementById('journal_div').style.display = 'block';
            }

            $('.js-example-basic-single').select2();
        }


        /*  Checking Transaction Mode */
        function getTransactionMode(selected_option) {
            var value = selected_option.options[selected_option.selectedIndex].text;
            console.log(value);

            if (value == 'Cheque'){
                document.getElementById('cheque_div').style.display = 'block';

            }else if(value == 'Cash'){
                document.getElementById('cheque_div').style.display = 'none';

            }
        }


        /* validating total debit and credit amount of journal */
        function validateForm() {

            var e = document.getElementById("trans_type");
            var trans_type = e.options[e.selectedIndex].value;

            if (trans_type == 4){

                var dr_total = document.getElementById('dr_total').value;
                var cr_total = document.getElementById('cr_total').value;

                if (dr_total == cr_total){
                    document.getElementById("err").style.display = "none";
                    return true;
                } else{
                    var msg = "Debit and Credit amount should be equal";
                    document.getElementById("err").style.display = "block";
                    document.getElementById('err_msg').innerHTML = msg;
                    return false;
                }

            } else{
                document.getElementById("err").style.display = "none";
                return true;
            }

        }


        /* getting date as a string  */
        function getDate(value) {
            // console.log(value);

            var strArray = value.split("/");

            var month = '';
            if (strArray[0] == 1){
                month = 'JAN';
            } else if (strArray[0] == 2){
                month = 'FEB';
            } else if (strArray[0] == 3){
                month = 'MAR';
            }else if (strArray[0] == 4){
                month = 'APR';
            } else if (strArray[0] == 5){
                month = 'MAY';
            } else if (strArray[0] == 6){
                month = 'JUN';
            } else if (strArray[0] == 7){
                month = 'JUL';
            } else if (strArray[0] == 8){
                month = 'AUG';
            } else if (strArray[0] == 9){
                month = 'SEP';
            } else if (strArray[0] == 10){
                month = 'OCT';
            } else if (strArray[0] == 11){
                month = 'NOV';
            } else if (strArray[0] == 12){
                month = 'DEC';
            }

            document.getElementById('month').value = month+'-'+strArray[2];

        }


        $(document).on('keyup','.input_amount',function(){
            var amount = $('.input_amount').val();
            var in_word = convertNumberToWords(amount);


            // document.getElementById("rcv_in_words").innerHTML = in_word+" Taka";
            if (in_word != ""){
                document.getElementById("input_amount_in_words").innerHTML = "(In Words: "+in_word+" Taka)";
            } else {
                document.getElementById("input_amount_in_words").innerHTML = "";

            }
        });


        $( '.mydatepicker').datepicker({
            format:'mm/dd/yyyy',
        }).on('changeDate', function(ev){
            $('.mydatepicker').datepicker('hide');
        }).datepicker("setDate",'now');


        //input_amount_in_words

       /* $(document).ready(function(){

            // Initialize select2
            $("#trans_type").select2();
        });*/

    </script>



@endsection
