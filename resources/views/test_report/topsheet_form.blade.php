@extends('layout')

@section('main_content')

    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Patient Report</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    @include('admin.includes.error')
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                    <h4 class="card-title">Get Report</h4>
                                    <div class="basic-form">
                                        <form action="{{url('topsheet')}}" method="post"  onsubmit="return validateForm()" name="myForm" >

                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12 margin_top_minus_10" style="display: block">
                                                    <span class="level_size">Enter Bill No.</span>
                                                    <div class="input-group">
                                                        <input class="form-control input " placeholder="Refferer Name" tabindex="1" list="clients" id="client_input">
                                                        <datalist id="clients" >
                                                            @foreach($bill_info as $value)
                                                                <option data-id="{{$value->id}}" value="{{ $value->memo_no }}" >
                                                            @endforeach
                                                        </datalist>
                                                        <input class="form-control input" type="hidden" id="client_id" name="client_id">
                                                    </div>
                                                </div>

                                                <div class="client_info_div">

                                                </div>

                                            </div>
                                            <button type="submit" class="btn btn-dark" tabindex="2">Get Report</button>
                                        </form>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

@stop

@section('js')

            <script>
                $('#client_input').on('input', function() {

                    var value = $(this).val();
                    var c_id = $('#clients [value="' + value + '"]').data('id');
                    // console.log(c_id);

                    $('#client_id').val(c_id)
                    getClientInfo(c_id)

                });

                function getClientInfo(client_id) {
                    // var client_id = selected_option.options[selected_option.selectedIndex].value;
                     console.log(client_id)

                    $.ajax({
                        //url: 'getUser.php',
                        url:'{{url('get_bill_info')}}',
                        type: 'GET',
                        data: 'client_id='+client_id,
                        //data:{id:uid}
                        dataType: 'html'
                    })
                        .done(function(data){

                            $('#client_info_div').html(data); // load response
                        })
                        .fail(function(){
                            console.log()
                        });

                }


                function validateForm() {
                    var x = document.forms["myForm"]["client_id"].value;
                    if (x == "") {
                        // document.forms["myForm"]["client_id"]
                        document.getElementById("client_input").value = "";
                        alert("Please Select Bill No");
                        return false;
                    }
                }

            </script>
@stop

