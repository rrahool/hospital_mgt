

@extends('layout')

@section('main_content')
    <div class="content-body">

        <div class="container-fluid">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

                <?php

                $entry_info = \App\Entry::select('*')->where('id', $entry_id)->first();

                $date_arr = explode('-', $entry_info->date);
                $date = $date_arr[1].'/'.$date_arr[2].'/'.$date_arr[0];

                $date_str = '';
                if ($date_arr[1] == 1){
                    $date_str = 'JAN-'.$date_arr[0];
                } else if ($date_arr[1] == 2){
                    $date_str = 'FEB-'.$date_arr[0];
                } else if ($date_arr[1] == 3){
                    $date_str = 'MAR-'.$date_arr[0];
                }else if ($date_arr[1] == 4){
                    $date_str = 'APR-'.$date_arr[0];
                } else if ($date_arr[1] == 5){
                    $date_str = 'MAY-'.$date_arr[0];
                } else if ($date_arr[1] == 6){
                    $date_str = 'JUN-'.$date_arr[0];
                } else if ($date_arr[1] == 7){
                    $date_str = 'JUL-'.$date_arr[0];
                } else if ($date_arr[1] == 8){
                    $date_str = 'AUG-'.$date_arr[0];
                } else if ($date_arr[1] == 9){
                    $date_str = 'SEP-'.$date_arr[0];
                } else if ($date_arr[1] == 10){
                    $date_str = 'OCT-'.$date_arr[0];
                } else if ($date_arr[1] == 11){
                    $date_str = 'NOV-'.$date_arr[0];
                } else if ($date_arr[1] == 12){
                    $date_str = 'DEC-'.$date_arr[0];
                }

                ?>

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Payment Entry</h4>
                            <div class="basic-form">
                                <form action="{{url('edit-payment-entry')}}" method="post" >

                                    @csrf

                                    <input type="hidden" name="entry_id" value="{{$entry_id}}">
                                    <input type="hidden" name="dr_entry_id" value="{{$dr_entry->id}}">
                                    <input type="hidden" name="cr_entry_id" value="{{$cr_entry->id}}">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Entry Number</span>
                                            <input type="text" name="number" class="form-control" value="{{$entry_info->number}}" placeholder="Entry Number">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Vouchar No</span>
                                            <input type="text" name="vou_no" class="form-control" placeholder="Vouchar No">
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-12">
                                            <span class="level_size">Transaction Type</span>
                                            <select class="form-control" name="trans_type" id="trans_type" onChange="getTransactionType(this);">
                                                <option value="Payment">-- Select Type --</option>
                                                @foreach($entrytypes as $type)
                                                    @if($entry_info->entrytype_id == $type->id)
                                                        <option value="{{$type->id}}" selected>{{$type->name}}</option>
                                                    @else
                                                        {{--<option value="{{$type->id}}">{{$type->name}}</option>--}}
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Transaction Date</span>
                                            <div class="input-group">
                                                <input type="text" name="trans_date" value="{{$date}}" onchange="getDate(this.value)" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Month</span>
                                            <input type="text" name="date_summary" value="{{$date_str}}" id="month" class="form-control" placeholder="Month">
                                        </div>
                                    </div>


                                    <div id="pay_rec_div">

                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Transaction For</span>
                                                <select class="form-control" name="trans_for" >
                                                    @if($dr_entry->transaction_for == "Official")
                                                        <option value="Official" selected>Official</option>
                                                        <option value="Personal ">Personal</option>
                                                    @elseif($dr_entry->transaction_for == "Personal")
                                                        <option value="Official" >Official</option>
                                                        <option value="Personal" selected>Personal</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Transaction Mode</span>
                                                <select class="form-control" name="trans_mode" onChange="getTransactionMode(this);" >
                                                    <option value="">-- Select Mode --</option>
                                                    @if($dr_entry->transaction_mode == "Cash")
                                                        <option value="Cash" selected>Cash</option>
                                                        <option value="Cheque">Cheque</option>
                                                    @elseif($dr_entry->transaction_mode == "Cheque")
                                                        <option value="Cash">Cash</option>
                                                        <option value="Cheque" selected>Cheque</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div id="payment_div" >
                                            <div class="form-row margin_top_minus_10" >
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Payment To</span>
                                                    <select class="form-control" name="pay_to" >
                                                        @foreach($other_ledgers as $payable)
                                                            <?php
                                                            $led_name = str_replace('_', ' ', $payable->name);
                                                            ?>
                                                            @if($payable->id == $dr_entry->ledger_id)
                                                                <option value="{{$payable->id}}" selected>{{$led_name}}</option>
                                                            @else
                                                                <option value="{{$payable->id}}">{{$led_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <span class="level_size">Payment From</span>
                                                    <select class="form-control" name="pay_from">
                                                        @foreach($cash_ledgers as $led)
                                                            <?php
                                                            $led_name = str_replace('_', ' ', $led->name);
                                                            ?>
                                                            @if($led->id == $cr_entry->ledger_id)
                                                                <option value="{{$led->id}}" selected>{{$led_name}}</option>
                                                            @else
                                                                <option value="{{$led->id}}">{{$led_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        @if($dr_entry->transaction_mode == "Cheque")
                                            <div id="cheque_div1" >
                                                <div class="form-group margin_top_minus_10">
                                                    <span class="level_size">Bank Name</span>
                                                    <input type="text" name="bank_name" value="{{$dr_entry->cheque_no}}" class="form-control" placeholder="Bank Name">
                                                </div>

                                                <div class="form-row margin_top_minus_10">

                                                    <div class="form-group col-md-6">
                                                        <span class="level_size">Cheque No</span>
                                                        <input type="text" name="cheque_no" value="{{$dr_entry->cheque_no}}"  class="form-control" placeholder="Cheque No">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <span class="level_size">Cheque Date</span>
                                                        <div class="input-group">
                                                            <input type="text" name="cheque_date" value="{{$dr_entry->cheque_date}}"  onchange="getDate(this.value)" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                            <div id="cheque_div" style="display: none;">
                                                <div class="form-group margin_top_minus_10">
                                                    <span class="level_size">Bank Name</span>
                                                    <input type="text" name="bank_name" value="{{$dr_entry->bank_name}}" class="form-control" placeholder="Bank Name">
                                                </div>

                                                <div class="form-row margin_top_minus_10">

                                                    <div class="form-group col-md-6">
                                                        <span class="level_size">Cheque No</span>
                                                        <input type="text" name="cheque_no" value="{{$dr_entry->cheque_no}}"  class="form-control" placeholder="Cheque No">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <span class="level_size">Cheque Date</span>
                                                        <div class="input-group">
                                                            <input type="text" name="cheque_date" value="{{$dr_entry->cheque_date}}"  onchange="getDate(this.value)" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif

                                        <div class="form-group margin_top_minus_10">
                                            <span class="level_size">Amount</span>
                                            <input type="text" name="amount" value="{{$entry_info->dr_total}}" class="form-control" placeholder="Amount">
                                        </div>


                                        <div class="form-row margin_top_minus_10">
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Narration</span>
                                                <textarea class="form-control h-150px" name="narration" rows="2" id="narration" placeholder="Narration">{{$entry_info->narration}}</textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span class="level_size">Remarks</span>
                                                <textarea class="form-control h-150px" name="remarks" rows="2" placeholder="Remarks">{{$dr_entry->Remarks}}</textarea>
                                            </div>
                                        </div>

                                    </div>



                                    <button type="submit" class="btn btn-dark">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>


    <script>



        function getTransactionMode(selected_option) {
            var value = selected_option.options[selected_option.selectedIndex].text;
            console.log(value);

            if (value == 'Cheque'){
                document.getElementById('cheque_div').style.display = 'block';

            }else if(value == 'Cash'){
                document.getElementById('cheque_div').style.display = 'none';
                document.getElementById('cheque_div1').style.display = 'none';

            }
        }

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



    </script>

@endsection
