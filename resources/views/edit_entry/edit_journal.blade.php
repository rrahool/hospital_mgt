

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
                            <h4 class="card-title">Edit Journal Entry</h4>
                            <div class="basic-form">
                                <form action="{{url('edit-journal-entry')}}" method="post" >

                                    @csrf

                                    <input type="hidden" name="entry_id" value="{{$entry_id}}">

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


                                    <div id="journal_div" >

                                        <div class="form-row">
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

                                                    <?php
                                                        $dr_total = 0;
                                                        $cr_total = 0;
                                                    ?>
                                                    @foreach($dr_entries as $entry)
                                                        <?php $dr_total+=$entry->amount; ?>
                                                    <tr>
                                                        <td>
                                                            <select id="inputState" class="form-control" name="dr_acc[]">
                                                                @foreach($other_ledgers as $c)
                                                                    <?php
                                                                    $name = str_replace('_', ' ', $c->name);
                                                                    ?>
                                                                    @if($entry->ledger_id ==$c->id )
                                                                    <option value="{{$c->id}}" selected>{{$name}}</option>
                                                                        @else
                                                                    <option value="{{$c->id}}">{{$name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="dr_amount[]" class="form-control dr_amount" value="{{$entry->amount}}" placeholder="Amount"  onkeyup="dr_sum()">
                                                        </td>
                                                        <td>
                                                            <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete">
                                                        </td>
                                                    </tr>
                                                    @endforeach

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
                                                        <td colspan="2"><input type="text" name="dr_total" value="{{$dr_total}}" class="dr_total form-control" id="dr_total"></td>
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

                                                    @foreach($cr_entries as $entry)
                                                        <?php $cr_total+=$entry->amount; ?>
                                                    <tr>
                                                        <td>
                                                            <select id="inputState" class="form-control" name="cr_acc[]">
                                                                @foreach($other_ledgers as $c)
                                                                    <?php
                                                                    $name = str_replace('_', ' ', $c->name);
                                                                    ?>
                                                                        @if($entry->ledger_id ==$c->id )
                                                                            <option value="{{$c->id}}" selected>{{$name}}</option>
                                                                        @else
                                                                            <option value="{{$c->id}}">{{$name}}</option>
                                                                        @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="cr_amount[]" class="form-control cr_amount" value="{{$entry->amount}}" placeholder="Amount"  onkeyup="cr_sum()">
                                                        </td>
                                                        <td>
                                                            <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete">
                                                        </td>
                                                    </tr>
                                                    @endforeach
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
                                                        <td colspan="2"><input type="text"  name="cr_total" value="{{$cr_total}}" class="cr_total form-control" id="cr_total"></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="form-group  margin_top_minus_10">
                                            <span class="level_size">Narration</span>
                                            <textarea class="form-control h-150px" name="narration1" rows="2" placeholder="Narration"></textarea>
                                        </div>

                                        <div style="display: none" id="err">
                                            <p class="alert alert-danger" id="err_msg"></p>
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
