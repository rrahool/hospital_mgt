@extends('layout')

@section('main_content')

    <?php
    $current_date = date('m/d/Y');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Search Ledger Statement</h4>
                            <div class="basic-form">
                                <form>


                                    <div class="form-group">
                                        <span class="level_size">Ledger Account</span>
                                        <select class="form-control js-example-basic-single" id="ledger_id" data-validation="required">
                                            <option value="">-- Select Ledger --</option>
                                            @foreach($ledgers as $led)
                                                <?php
                                                $name = str_replace('_', ' ', $led->name);
                                                $name = preg_replace ( '/[0-9]*$/' , '' , $name);
                                                ?>
                                                <option value="{{$led->id}}">{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker"   class="form-control mydatepicker"  placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                            <input type="text"  id="enddatepicker" required  class="mydatepicker form-control " placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>



                                    <button type="button" onclick="getLedgerStatement()" class="btn btn-primary">Submit</button>
                                    <button type="button" id="clear_btn" class="btn btn-warning" onclick="clearAll()">Clear</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Ledger Statement</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Number</th>
                                        <th>Ledger</th>
                                        <th>Type</th>
                                        {{--<th>Tag</th>--}}
                                        <th>Debit Account</th>
                                        <th>Credit Account</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>


                                    <tbody id="led_statement_table">


                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>



@endsection

@section('js')

    <script>



        function getLedgerStatement(){

            var ledger_id = document.getElementById("ledger_id").value
            var start_date = document.getElementById("startpicker").value
            var end_date = document.getElementById("enddatepicker").value

            if (start_date == ''){
                start_date = 0;
            }else{

                var start_date_arr = start_date.split('/');
                start_date = start_date_arr[2]+'-'+start_date_arr[0]+'-'+start_date_arr[1];
            }

            if (end_date == ''){
                end_date = 0;
            }else{

                var end_date_arr = end_date.split('/');
                end_date = end_date_arr[2]+'-'+end_date_arr[0]+'-'+end_date_arr[1];
            }


            //console.log(ledger_id+", "+start_date+", "+end_date);

            $.ajax({
                type: 'GET',
                url:'get_ledger_statement/'+ledger_id+'/'+start_date+'/'+end_date,
                dataType: 'html'
            })
                .done(function(data){
                    //console.log(data);
                    $('#led_statement_table').html('');
                    $('#led_statement_table').html(data); // load response
                    //$('#modal-loader').hide();		  // hide ajax loader
                })
                .fail(function(){
                    $('#led_statement_table').html('<i class="glyphicon glyphicon-info-sign"></i> Nothing Found...');
                    //$('#modal-loader').hide();
                });

        }


        function clearAll() {

            //document.getElementById('startpicker').innerHTML = ' ';
            //document.getElementById('enddatepicker').innerHTML = ' ';
            $('#startpicker').val(''); // set the value to blank with empty quotes
            $('#enddatepicker').val('');
            //$('#ledger_id').val('-- Select Ledger --');
        }

    </script>


@endsection
