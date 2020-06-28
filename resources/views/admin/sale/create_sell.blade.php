<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('layout')

@section('main_content')

    <style>



        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

        div.scroll {
            height: 230px;
            overflow: auto;
            text-align:justify;
        }

        .form-control {
            padding: 0.0rem !important;

        }

        .table th, .table td{
            padding: 0.1rem !important;
        }

        .btn {
            padding: 5px 10px;
        }

        .table td {
            padding: 0.1rem;
            vertical-align: top;
            border-top: 0px solid #dee2e6;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">


            <div class="row">
               {{-- <div class="col-lg-12">
                    <h3 class="page-header">Sell Product</h3>
                </div>--}}
                <!-- /.col-lg-12 -->
            </div>

            <?php
/*            echo '<pre>';
            print_r($clients);
            echo '</pre>';
            */?>

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" ><b><span class="level_size_card_title">Test Memo Entry</span></b></h4>
                            <div class="basic-form">
                                <form action="{{url('create_sell')}}" method="post" onsubmit="return validateForm()" name="my_form" >

                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" >

                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; " >
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12" style="margin-top: -7px">
                                                        <span class="level_size">Patient Name</span>
                                                        <input class="form-control" type="text" tabindex="1" name="patient_name">
                                                    </div>
                                                </div>

                                                <div class="form-row margin_top_minus_10">
                                                    <div class="form-group col-md-6" style="margin-top: -7px">
                                                        <span class="level_size">Sex</span>
                                                        <select class="input form-control js-example-basic-single" autofocus tabindex="2" name="gender" data-validation="required">
                                                            <option value="">Select Sex</option>
                                                            <option value="Male" >Male</option>
                                                            <option value="Femail" >Female</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6" style="margin-top: -7px">
                                                        <span class="level_size">Age</span>
                                                        <input class="form-control" placeholder="" tabindex="3" type="text" name="age" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="form-row margin_top_minus_10">

                                                    <div class="form-group col-md-6" style="margin-top: -7px; ">
                                                        <span class="level_size">Contact No</span>
                                                        <input class="form-control" placeholder="" tabindex="4" type="text"  name="contact_no" data-validation="required">
                                                    </div>

                                                    <div class="form-group col-md-6" style="margin-top: -7px">
                                                        <span class="level_size">Date</span>
                                                        <input class="form-control" type="date" tabindex="5" value="<?php echo $date; ?>" name="entry_date">
                                                    </div>

                                                    <div class="form-group col-md-6" style="margin-top: -7px; display: none">
                                                        <span class="level_size">Memo No</span>
                                                        <input class="form-control" placeholder="" tabindex="6" type="text" value="{{ $memo_no }}" name="memo_no" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="form-row margin_top_minus_10">
                                                    <div class="form-group col-md-6" style="margin-top: -7px; display: none">
                                                        <span class="level_size">Ref No:</span>
                                                        <input class="form-control input " autofocus placeholder="Reference No"  tabindex="7" type="text" value="0" id="ref_no" name="ref_no" >
                                                    </div>

                                                    <div class="form-group col-md-6" style="margin-top: -7px">
                                                        <span class="level_size">Delivery Date:</span>
                                                        <input class="form-control" type="date" tabindex="8" value="<?php echo $date; ?>" name="delivery_date">                                                    </div>

                                                    <div class="form-group col-md-6" style="margin-top: -7px">
                                                        <span class="level_size">Refferer Name</span>
                                                        <div class="input-group">
                                                             <input class="form-control input " placeholder="Refferer Name" tabindex="9" list="clients" id="client_input" data-validation="required">
                                                            <datalist id="clients">
                                                                @foreach($client_info as $value)
                                                                    <option data-id="{{$value->id}}" value="{{ $value->client_name }}">
                                                                @endforeach
                                                            </datalist>

                                                            <input class="form-control input" type="hidden" id="client_id" name="client_id">


                                                            {{--<div class="input-group-btn">
                                                                <button href="#" data-toggle="modal" data-target="#login-modal" class="btn btn-warning" type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row margin_top_minus_10" style="display: none">
                                                    <div class="col-md-12">
                                                        <div id="client_info_div" >
                                                            <div class="form-row row"  >
                                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                                    <span class="level_size">Address</span>
                                                                    <input class="input form-control client_address"  tabindex="5" placeholder="Address" type="text"  id="client_address" >
                                                                </div>
                                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                                    <span class="level_size">Client Due</span>
                                                                    <input class="input form-control" placeholder="Client Due" tabindex="6" type="text" name="client_due">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row margin_top_minus_10">
                                                    <div class="col-md-10" style="margin-top: -7px">
                                                        <button type="submit" class="btn btn-dark pull-left" tabindex="100" style="margin-top: 10px; ">Submit</button>

                                                        <button type="reset" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Clear</button>

                                                        <button type="button" class="btn btn-facebook" data-toggle="modal" style="margin-top: 10px; margin-left: 10px " data-target="#exampleModalCenter">Edit</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                            <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                            <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                                    </div>
                                                </div>
                                            </div>                                                     


                                            <div class="col-md-6" >
                                                <input type="hidden" name="column_total" class="form-control column_total" data-validation="required" >

                                                <div class="row" style="margin-top: -5px; ">
                                                    <div class="col-md-2" style="text-align: right">
                                                    </div>
                                                    <div class="col-md-2">
                                                    </div>
                                                    <div class="col-md-4" style="text-align: center">
                                                        <span class="level_size" >Rate</span>                                                    </div>
                                                    <div class="col-md-4" style="text-align: center">
                                                        <span class="level_size">Amount</span>
                                                    </div>
                                                </div>

                                                <div class="row" >
                                                    <div class="col-md-2" style="text-align: right">
                                                        <input type="checkbox" class="text-right chk3" name="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="level_size">Discount</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="discount_p" class="input input form-control pdiscount" value="0" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="discount" tabindex="91" class="input input form-control discount" >
                                                    </div>
                                                </div>


                                                <div class="row" style="margin-top: 3px">
                                                    <div class="col-md-2" style="text-align: right;">
                                                        <input type="checkbox" class="text-right chk1" name="" style="display: none;">                                                </div>
                                                    <div class="col-md-2">
                                                        <span class="level_size">Advance</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="vat_p" class="input form-control pvat" value="0" readonly style="display: none;">                                                </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="vat" tabindex="92" class="input form-control vat" >
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 3px; display: none">
                                                    <div class="col-md-2" style="text-align: right">
                                                        <input type="checkbox" class="text-right chk2" name="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="level_size">Income Tax.</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="tax_p" class="input form-control ptax" value="0" readonly>                                                </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="tax" tabindex="93" class="input form-control tax"  >
                                                    </div>
                                                </div>


                                                <div class="row" style="margin-top: 3px">
                                                    <div class="col-md-4">

                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="level_size"><h5>Balance</h5></span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="balance" class="input form-control balance" data-validation="required" readonly>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 3px; display: none">
                                                    <div class="col-md-4">

                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="level_size">Received Amount</span>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="received" tabindex="94" class="input form-control received" >
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 3px; margin-bottom: -5px; display: none">
                                                    <div class="col-md-4">

                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="level_size">Due</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" name="due" class="input form-control due" data-validation="required" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

{{--                                    <h4 class="card-title" style="margin-top: 20px; margin-bottom: 10px">Products To Sale</h4>--}}
                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; margin-top: 10px" >

                                    <table class="table order-list" style="margin-top: 0px; margin-bottom: 0px">


                                        <thead>
                                        <tr>
                                            <td style="width: 5%"></td>
                                            <td style="display:none; width: 15%; text-align: center"><b style=""><span class="level_size_title">Warehouse</span></b></td>
                                            {{--<td style="width: 15%; text-align: center"><b>Product Type</b></td>--}}
                                            <td style="width: 15%; text-align: center"><b><span class="level_size_title">Test Name</span></b></td>
                                            <td style="display:none; width: 10%; text-align: center"><b><span class="level_size_title">Rate($)</span></b></td>
                                            <td style="display:none; width: 10%; text-align: center"><b><span class="level_size_title">Ctn</span></b></td>
                                            <td style="display:none; width: 10%; text-align: center"><b><span class="level_size_title">pcs</span></b></td>
                                            <td style="display:none; width: 10%; text-align: center"><b><span class="level_size_title">Total Qt</span></b></td>
                                            <td style="display:none; width: 5%; text-align: center"><b><span class="level_size_title">Discount Rate</span></b></td>
                                            <td style="display:none; width: 10%; text-align: center"><b><span class="level_size_title">Discount Amount</span></b></td>
                                            <td style="width: 10%; text-align: center"><b><span class="level_size_title">Amount</span></b></td>
                                        </tr>
                                        </thead>
                                    </table>

                                    <div class="scroll">
                                        <table class="table order-list">

                                            <tbody id="mytable">
                                            <tr>
                                            <td style="width: 5%"></td>
                                            <td style="display:none; width: 15%">
                                                <select  data-row="1" tabindex="7" name="warehouse[]" class="js-example-basic-single input form-control warehouse_1 warehouse" data-validation="required">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouse_info as $value)
                                                        <option value="{{$value->id}}">{{ $value->warehouse_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>


                                                <td style="width: 15%">

                                                    <input type="text" data-row="1" tabindex="10" placeholder="Test Name"  list="products" id="product_input" class="product_input_1 product_input input form-control">
                                                    <datalist id="products">

                                                        <?php

                                                            foreach ($cat_info as $key=>$value){
                                                                $cats = $cat_info[$key];
                                                                foreach ($cats as $key1=>$value){
                                                                    $products = $cats[$key1];
                                                                    $product_name = $products['p_name'];
                                                                    $product_id = $products['p_id'];
                                                                    $product_code = $products['p_code'];
                                                                    $cat_name = $products['cat_name'];
                                                                    $cat_id = $products['cat_id'];
                                                                    ?>
                                                                        <option data-pid="{{$product_id}}" data-cid="{{$cat_id}}" value="({{$product_code}}) {{ $product_name }} ">
                                                                    <?php
                                                                }
                                                            }

                                                        ?>

                                                    </datalist>
                                                    <input type="hidden" id="product_type_1" tabindex="9" name="product_type[]" class="product_type_1 product_type">
                                                    <input type="hidden" id="product_code_name_1" name="product_code[]" class="product_code_name_1 product_code_name">
                                                    <span class="available_qt_1"></span>
                                                </td>


                                            <td style="display:none; width: 10%">
                                                <div data-row="1" class="rate_div_1 rate_div" >
                                                    <input type="text" tabindex="10" placeholder="Rate" class="form-control input" data-validation="required">
                                                </div>
                                            </td>

                                            <td style="display:none; width: 10%">
                                                <input type="text" data-row="1" tabindex="11" placeholder="Carton" class="form-control carton_1 carton input" value="0" name="carton[]" data-validation="number" >
                                                <input type="hidden" class="form-control qt_per_carton_1 qt_per_carton" name="qt_per_carton[]">

                                            </td>

                                            <td style="display:none; width: 10%">
                                                <input type="text" data-row="1" value="1" tabindex="12" placeholder="Pieces" class="form-control piece_1 piece input" name="piece[]" data-validation="number">
                                            </td>
                                            <td style="display:none; width: 10%">
                                                <input type="text" data-row="1" value="1" tabindex="13"  placeholder="Total Quantity" class="form-control quantity_1 quantity input" name="quantity[]" readonly data-validation="required">
                                            </td>
                                            <td style="display:none; width: 5%">
                                                <input type="text" data-row="1" value="" tabindex="14" placeholder="" class="input form-control single_discount_rate_1 single_discount_rate" name="single_discount_rate[]" >
                                            </td>
                                            <td style="display:none; width: 10%">
                                                <input type="text" data-row="1" value="" tabindex="15" placeholder="Discount Amount" readonly class="input form-control single_discount_amount_1 single_discount_amount" name="single_discount_amount[]" >
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" name="total[]" data-row="1" class="form-control total_1 total" placeholder="Total" readonly data-validation="required">
                                            </td>

                                        </tr>

                                            </tbody>


                                    </table>
                                    </div>

                                        <br/>
                                        <div class="row" style="margin: -2px">
                                            <div class="col-md-10" style="margin-top: -10px"></div>
                                            <div class="col-md-2" style="margin-top: -10px">
                                                <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--MODAL STARTS--}}
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Get Memo Info</h5>
                        </div>
                        <div class="modal-body">
                            <div class="basic-form">
                                <form action="{{url('edit_sale')}}" method="post" >
                                    @csrf
                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-4">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" tabindex="1" name="from_date" required class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" tabindex="2" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <span class="level_size">Select Memo</span>
                                            <div class="input-group">
                                                <input class="form-control input "  tabindex="3" list="memos" id="memo_input">
                                                <div id="memo_datalist">

                                                </div>
                                                <input class="form-control input" type="hidden" id="memo" name="memo" >
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" name="save" class="btn btn-dark" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--MODAL ENDS--}}

        </div>
    </div>



    {{--Modal panel--}}
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">

            <form action="add_supplier1" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Supplier Information</strong></h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Supplier Name</label>
                                <input class="form-control input" placeholder="Supplier Name" type="text" name="supplier_name" required>
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Company Name</label>
                                <input class="form-control input" placeholder="Supplier Name" type="text" name="company_name">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Address</label>
                                <input class="form-control input" placeholder="Address" type="text" name="address">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Email </label>
                                <input class="form-control input" placeholder="Supplier Name" type="email" name="email">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Contact No </label>
                                <input class="form-control input" placeholder="Supplier Name" type="text" name="contact_no" required>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>



@stop


@section('js')

    <script>

        document.onkeyup=function(e){
            var e = e || window.event; // for IE to cover IEs window event-object
            if(e.altKey && e.which == 65) {
                // alert('Keyboard shortcut working!');
                addrow()
                // return false;
            }
        }


        var i=1;
        function addrow()
        {

            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });


            i++;
            var table = document.getElementById("mytable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);
            var cell9 = row.insertCell(8);
            var cell10 = row.insertCell(9);



            // var cell11 = row.insertCell(10);

            cell1.innerHTML='<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
            cell2.innerHTML='<td ><select name="warehouse[]" data-row="'+i+'" class="js-example-basic-single input form-control warehouse_'+i+' warehouse" data-validation="required"><option>Select Warehouse</option><?php foreach ($warehouse_info as $type) {?>  <option value="<?=$type->id ?>"><?=$type->warehouse_name ?></option><?php } ?></select></td>';
            cell3.innerHTML='<td><input type="text" data-row="'+i+'" list="products" id="product_input" placeholder="Product Name" class="product_input_'+i+' product_input input form-control">' +
                '<input type="hidden" id="product_type_'+i+'" name="product_type[]" class="product_type_'+i+' product_type">\n' +
                '<input type="hidden" id="product_code_name_'+i+'" name="product_code[]" class="product_code_name_'+i+' product_code_name">\n' +
                '<span class="available_qt_'+i+'"></span> </td>';
            cell4.innerHTML='<td><div data-row="'+i+'" class="input rate_div_'+i+' rate_div" name="rate[]"><input type="text" value="0" class="form-control" placeholder="Rate" data-validation="required"> </div></td>';
            cell5.innerHTML='<input type="text" data-row="'+i+'" placeholder="Carton" class=" input form-control carton_'+i+' carton" name="carton[]" value="0" data-validation="number"> ' +
                '<input type="hidden" name="qt_per_carton[]" class="form-control qt_per_carton_'+i+'">';
            cell6.innerHTML='<input type="text" data-row="'+i+'" placeholder="Pieces" class="input form-control piece_'+i+' piece"  name="piece[]" value="1" data-validation="number">';
            cell7.innerHTML='<input type="text" data-row="'+i+'" placeholder="Quantity" class="input form-control quantity_'+i+' quantity" value="1" name="quantity[]" readonly data-validation="required">';
            cell8.innerHTML='<input type="text" data-row="'+i+'" class="input form-control single_discount_rate_'+i+' single_discount_rate" name="single_discount_rate[]" >';
            cell9.innerHTML='<input type="text" data-row="'+i+'" placeholder="Discount Amount" readonly class="input form-control single_discount_amount_'+i+' single_discount_amount" name="single_discount_amount[]" >';
            cell10.innerHTML='<input type="text" name="total[]" placeholder="Total" data-row="'+i+'" class="form-control total_'+i+' total" readonly data-validation="required">';

            cell2.style.display = 'none';
            cell4.style.display = 'none';
            cell5.style.display = 'none';
            cell6.style.display = 'none';
            cell7.style.display = 'none';
            cell8.style.display = 'none';
            cell9.style.display = 'none';

        }


        function getClientInfo(client_id) {
            // var client_id = selected_option.options[selected_option.selectedIndex].value;
            console.log(client_id)

            $.ajax({
                //url: 'getUser.php',
                url:'get_client_info',
                type: 'GET',
                data: 'client_id='+client_id,
                //data:{id:uid}
                dataType: 'html'
            })
                .done(function(data){
                    // console.log(data);

                    $('#client_info_div').html(data); // load response
                })
                .fail(function(){
                    $('#client_info_div').html('<div  id="client_info_div">\n' +
                        '                                        <div class="form-row" >\n' +
                        '                                            <div class="form-group col-md-6">\n' +
                        '                                                <label>Address</label>\n' +
                        '                                                <input class="form-control client_address" placeholder="" type="text"  id="client_address" value="" data-validation="required">\n' +
                        '                                            </div>\n' +
                        '                                            <div class="form-group col-md-6">\n' +
                        '                                                <label>Client Due</label>\n' +
                        '                                                <input class="form-control" placeholder="" type="text" name="client_due">\n' +
                        '                                            </div>\n' +
                        '                                        </div>\n' +
                        '                                    </div>');
                });

        }


        $('#client_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#clients [value="' + value + '"]').data('id');
            console.log(c_id);

            $('#client_id').val(c_id)
            getClientInfo(c_id)

        });

        $(document).on('keyup','.product_input',function(){
            var row = $(this).data('row');
            var product_input = $('.product_input_'+row).val();

            var product_id = $('#products [value="' + product_input + '"]').data('pid');
            var cat_id = $('#products [value="' + product_input + '"]').data('cid');


            $('.product_type_'+row).val(cat_id)
            $('.product_code_name_'+row).val(product_id)
            // console.log(product_id)

             bringRate(product_id, row);
            // getAvailableQuantity(row)
            // bringQuantityPerCarton(row)

        });

        function bringRate(product_id, row){
            // var option2 = $('.product_list_'+row).val();
             var varJ = row;
             console.log(varJ)
            var token = $('#token').val();
            $.post('{{url('getRate')}}',{select2:product_id,l:varJ,_token: token},function(data){
                // $('.rate_div_'+row).html(data).show();
                $('.total_' + row).val(data);
                $('.rate_div_' + row).val(data);
                console.log(data)
                sum()
            });
        }


        function getAvailableQuantity(row) {

            // console.log('sj')

            var product_code = $('.product_code_name_'+row).val();
            var warehouse_id = $('.warehouse_'+row).val();
/*

            if (warehouse_id == '' && product_code != ''){
                alert('select Warehouse')

            }if (warehouse_id != '' && product_code == ''){
                alert('select Product')

            } else {
*/

                console.log("product_code_name:: "+ product_code+", warehouse_id:: "+warehouse_id)
                var varJ = row;
                var token = $('#token').val();
                $(".available_qt_"+row).prop("hidden", false);
                $.post('getAvailableQt',{select2:product_code,warehouse_id:warehouse_id,l:varJ,_token: token},function(data){
                    $('.available_qt_'+row).html(data).show();

                    setTimeout(function(){ hideAvailableQt(row) }, 3000);

                    if (data<=0){
                        $(".carton_"+row).prop("readonly", true);
                        $(".piece_"+row).prop("readonly", true);
                    }else{
                        $(".carton_"+row).prop("readonly", false);
                        $(".piece_"+row).prop("readonly", false);
                    }
                });
            // }

        }

        function hideAvailableQt(row) {
            $(".available_qt_"+row).prop("hidden", true);
        }

        function bringQuantityPerCarton(row){
            var option2 = $('.product_code_name_'+row).val();
            console.log(option2);
            var varJ = row;
            var token = $('#token').val();
            $.post('getQuantityPerCarton',{select2:option2,l:varJ,_token: token},function(data){
                // $('.qt_per_carton_'+row).html(data).show();
                $('.qt_per_carton_'+row).val(data);
            });
        }


        function sum()
        {
            var sum = 0;
            $('.total').each(function(){
                var ptotal = $(this).val();
                //var rTotal = ptotal.replace(",", "");
                var rTotal = ptotal.replace(/,/g, '');
                var total = parseFloat(rTotal);
                sum += total;
            });
            var mtotal = (sum).formatMoney(2, '.', ',');
            // alert(rTotal);
            // console.log('mtotal: '+mtotal)
            $('.column_total').val(mtotal);
            var pbalance = sum;


            // getting discount
            var pdiscount = $('.pdiscount').val();
            var discount = $('.discount').val();
            var adiscount = parseFloat(discount.replace(",", ""));
            var ppdiscount = parseFloat(pdiscount.replace(",", ""));

            if (ppdiscount>0) {

                // console.log("ppdiscount:: "+ppdiscount+", adiscount ::: "+adiscount)
                var vdiscount =  (sum * ppdiscount) / 100;
                pbalance = pbalance - vdiscount ;

                discount = (vdiscount).formatMoney(2, '.', ',');
                $('.discount').val(discount);

            }else if (ppdiscount<=0 && adiscount>0) {

                // console.log("only adiscount ::: "+adiscount)
                pbalance = pbalance - adiscount ;
            }



            // getting vat
            var pvat = $('.pvat').val();
            var avat = $('.vat').val();
            var aavat = parseFloat(avat.replace(",", ""));
            var ppvat = parseFloat(pvat.replace(",", ""));


            if (ppvat>0) {

                // console.log("ppvat:: "+ppvat+",aavat ::: "+aavat)
                var vVat =  (sum * ppvat) / 100;
                pbalance = pbalance - vVat;

                vat = (vVat).formatMoney(2, '.', ',');
                $('.vat').val(vat);

            }else if (ppvat<=0 && aavat>0) {

                // console.log("only aavat ::: "+aavat)
                pbalance = pbalance - aavat;

            }


            // getting tax
            var atax = $('.tax').val();
            var ptax = $('.ptax').val();
            var aatax = parseFloat(atax.replace(",", ""));
            var pptax = parseFloat(ptax.replace(",", ""));
            console.log("pptax:: "+pptax+",aatax ::: "+aatax)
            // var tax = (vtax).formatMoney(2, '.', ',');

            if (pptax>0) {

                // console.log("pptax:: "+pptax+",aatax ::: "+aatax)
                var vTax =  (sum * pptax) / 100;
                pbalance = pbalance + vTax;

                tax = (vTax).formatMoney(2, '.', ',');
                $('.tax').val(tax);

            }else if (pptax<=0 && aatax>0) {

                // console.log("only aatax ::: "+aatax)
                pbalance = pbalance + aatax;

            }


            var balance = (pbalance).formatMoney(2, '.', ',');
            $('.balance').val(balance);
            $('.due').val(balance);
        }


        function deleteRow(rowNum)
        {
            var i = rowNum.parentNode.parentNode.rowIndex;
            document.getElementById("mytable").deleteRow(i);
            sum();
        }

        //get product type ......

        $(document).ready(function(){

            Number.prototype.formatMoney = function(c, d, t){
                var n = this,
                    c = isNaN(c = Math.abs(c)) ? 2 : c,
                    d = d == undefined ? "." : d,
                    t = t == undefined ? "," : t,
                    s = n < 0 ? "-" : "",
                    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                    j = (j = i.length) > 3 ? j % 3 : 0;
                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
            };

            function totalCalculate(row)
            {
                var p = $('.rate_'+row).val();
                var rate = parseFloat(p.replace(",", ""));
                var qt_per_carton = $('.qt_per_carton_'+row).val();
                var carton = $('.carton_'+row).val();
                var piece = $('.piece_'+row).val();
                var single_discount_rate = $('.single_discount_rate_'+row).val();
                var single_discount_amount = $('.single_discount_amount_'+row).val();

                // console.log('piece: '+piece)
                // console.log('carton: '+carton)


                if (carton > 0 && piece>0){
                    var quantity = parseInt(carton*qt_per_carton) + parseInt(piece);
                }else if ((carton == 0 || carton == 0) && piece>0){
                    var quantity = piece;
                }else if ((piece == 0 || piece == 0) && carton>0){
                    var quantity = parseInt(carton*qt_per_carton);
                }


                $('.quantity_'+row).val(quantity);


                    var total = rate * quantity;

                    if (single_discount_rate != null || single_discount_rate > 0) {
                        single_discount_amount = (total * single_discount_rate) / 100;
                        $('.single_discount_amount_' + row).val(single_discount_amount);
                    }


                    if (single_discount_amount != null || single_discount_amount > 0) {
                        total -= single_discount_amount;
                    }
                    total = (total).formatMoney(2, '.', ',');
                    $('.total_' + row).val(total);

                    sum();

            }




            function setAllBlank(row){
                $('.total_'+row).val('0.00');
                $('.piece_'+row).val('0');
                $('.carton_'+row).val('0');
                $('.quantity_'+row).val('0');

            }


            $(document).on('click','.deleterow',function(){
                sum();
            })

            $(document).on('input','.discount',function(){
                sum();
            })

            $(document).on('keyup','.total',function(){
                sum();
            })

            $(document).on('input','.pdiscount', function(){
                sum();
                //console.log('ok')
            });

            $(document).on('input','.pvat', function(){
                sum();
            });

            $(document).on('input','.vat', function(){
                sum();
            });

            $(document).on('input','.ptax', function(){
                sum();
            });

            $(document).on('input','.tax', function(){
                sum();
            });

            $(document).on('input','.received', function(){
                // sum();

                var total = $('.balance').val();
                var received = $('.received').val();

                var total = parseFloat(total.replace(",", ""));
                var received = parseFloat(received.replace(",", ""));

                if (received>total){
                    alert("Invalid Amount")
                } else{
                    var due = total - received;
                    due = (due).formatMoney(2, '.', ',');
                    $('.due').val(due)
                }


            });

            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.piece',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                var quantity = parseInt($('.quantity_'+row).val());
                var available_qt = parseInt($('.available_qt_'+row).text());
                // console.log(quantity+", "+available_qt)
                if(quantity > available_qt){
                    alert('Sale quantity exeeds available quantity');
                    setAllBlank(row)
                    totalCalculate(row);
                }
            });

            $(document).on('keyup','.carton',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                // console.log('piece keyup')

                var quantity = parseInt($('.quantity_'+row).val());
                var available_qt = parseInt($('.available_qt_'+row).text());
                // console.log(quantity+", "+available_qt)
                if(quantity > available_qt){
                    alert('Sale quantity exeeds available quantity');
                    setAllBlank(row)
                    totalCalculate(row);
                }
            });

            $(document).on('keyup','.single_discount_rate',function(){
                var row = $(this).data('row');
                // quantity(row);
                totalCalculate(row);
            });

            $(document).on('keyup','.single_discount_amount',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });


            $(document).on('change','.product_type', function(){
                var row = $(this).data('row');
                //console.log(row)
                setAllBlank(row);
                $('.rate_'+row).val('0');
                bringName(row);
                totalCalculate(row);
            });


            $(document).on('change','.product_code_name', function(){
                var row = $(this).data('row');
                setAllBlank(row);
                totalCalculate(row);

            });


            $(document).on('change','.rate', function(){
                var row = $(this).data('row');

                var rate = $('.rate_'+row).val();
                var min_rate = $('.min_rate_'+row).val();

                if (rate<min_rate){
                    alert("Min Rate Of This Product is "+min_rate);
                    $('.rate_'+row).val(min_rate)
                }

            });

            $(document).on('change','.product_list', function(){
                var row = $(this).data('row');
                bringRate(row);
                // bringQuantityPerCarton(row);
                // getAvailableQuantity(row);
            });

            $(document).on('change','.warehouse', function(){
                var row = $(this).data('row');
                // getAvailableQuantity(row);

            });

            // $(document).on('change','#newsupplier', function(){
            //     // var row = $(this).data('row');
            //     bringAddress();
            // });

            /*function bringName(row){
                var option = $('.product_type_'+row).val();
                //console.log(option)
                var token = $('#token').val();
                var varI = row;

                console.log(token)
                console.log(varI)

                $.post('getProductName', {select:option,j:varI, _token: token}, function(data) {
                    //alert(data);
                    $('.product_code_name_'+row).html(data).hide().show();
                    $('.js-example-basic-single').select2();
                });
            }*/






            // function quantity(row){
            //     var ids= $('.product_list_'+row).val();
            //     var quantities= $('.quantity_'+row).val();
            //     var token = $('#token').val();
            //     $.post('getQuantity',{quantity:quantities,id:ids, _token: token},function(data){
            //         $('.quantity_'+row).html(data).show();
            //         if(data == "false"){
            //             alert('Quantity not available');
            //             $('.quantity_'+row).val("");
            //         }
            //     });
            // }

            // function bringAddress(){
            //     var option3 = $('#newsupplier').val();
            //     var token = $('token').va();
            //     alert(option3);
            //     // console.log(option3);
            //     $.post('getSupplierAddress',{select3:option3, _token: token},function(data){
            //         $('#supplier_address').html(data).show();
            //     });
            // }

            $('#newsupplier').change(function () {
                var supplierId = $(this).val();
                var token = $('#token').val();
                $.post(
                    'getSupplierAddress',
                    {supplier_id : supplierId, _token: token},
                    function (data) {
                        $('#supplier_address').val(data);
                    }

                );
            });

            $('.chk1').change(function(){
                if($(this).is(':checked')) {
                    $(".pvat").removeAttr("readonly");
                    $(".vat").prop("readonly", true);

                    $('.vat').val('0');
                    $('.pvat').val('0');
                    sum();

                } else {
                    $(".vat").removeAttr("readonly");
                    $(".pvat").prop("readonly", true);

                    $('.vat').val('0');
                    $('.pvat').val('0');
                    sum();
                }
                // $(".vat").prop("disabled", !$(this).is(':checked'));
                // $(".pvat").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk2').change(function(){

                if($(this).is(':checked')) {
                    $(".ptax").removeAttr("readonly");
                    $(".tax").prop("readonly", true);

                    $('.ptax').val('0');
                    $('.tax').val('0');
                    sum();

                } else {
                    $(".tax").removeAttr("readonly");
                    $(".ptax").prop("readonly", true);

                    $('.ptax').val('0');
                    $('.tax').val('0');
                    sum();
                }

                // $(".tax").prop("disabled", !$(this).is(':checked'));
                // $(".ptax").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk3').change(function(){

                if($(this).is(':checked')) {
                    $(".pdiscount").removeAttr("readonly");
                    $(".discount").prop("readonly", true);

                    $('.pdiscount').val('0');
                    $('.discount').val('0');

                    sum();
                } else {
                    $(".discount").removeAttr("readonly");
                    $(".pdiscount").prop("readonly", true);

                    $('.pdiscount').val('0');
                    $('.discount').val('0');

                    sum();
                }

            });

            // $(".tax").attr('disabled','disabled');
            // $(".vat").attr('disabled','disabled');
            /*$(".vat_p").attr('disabled','disabled');
            $(".tax_p").attr('disabled','disabled');
            $(".discount_p").attr('disabled','disabled');*/
            // $(".discount").attr('disabled','disabled');

        });


        $("#startpicker").on("change",function (){
            var from_date = document.getElementById('startpicker').value
            var to_date = document.getElementById('enddatepicker').value
            console.log(from_date)
            console.log(to_date)

            getMemoByDate(from_date, to_date);

        });

        $("#enddatepicker").on("change",function (){
            var from_date = document.getElementById('startpicker').value
            var to_date = document.getElementById('enddatepicker').value
            console.log(from_date)
            console.log(to_date)
        });

        function getMemoByDate(from_date, to_date) {

            $.ajax({
                url: '{{url('get_memos_by_date')}}',
                type: 'GET',
                data: 'from_date='+from_date+'&to_date='+to_date,
                /*data:{
                    from_date:from_date,
                    to_date:to_date
                },*/
                dataType: 'html'
            })
                .done(function (data) {
                    console.log(data);

                    // $('.client_address').val(data); // load response
                    $('#memo_datalist').html(data); // load response
                });
        }

        $('#memo_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#memos [value="' + value + '"]').data('id');
            $('#memo').val(c_id)
        });


        function validateForm() {
            var x = document.forms["my_form"]["client_id"].value;
            var y = document.forms["my_form"]["warehouse"].value;
            if (x == "") {
                // document.forms["myForm"]["client_id"]
                document.getElementById("client_input").value = "";
                alert("Please Select Refferer");
                return false;
            }
        }

    </script>

@stop
