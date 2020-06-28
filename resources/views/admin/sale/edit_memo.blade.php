<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");

$date1 = date('Y-m-d', $memo_info->entry_date);
?>

@extends('layout')

@section('main_content')

    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }

        .form-control {
            padding: 0.0rem !important;

        }

        .table th, .table td{
            padding: 0.2rem !important;
        }
        div.scroll {
            height: 230px;
            overflow: auto;
            text-align:justify;
        }

        .btn {
            padding: 5px 10px;
        }

        .table td {
            padding: 0.1rem;
            vertical-align: top;
            border-top: 0px solid #dee2e6;
        }

        .wd-5{
            width: 5%;
        }
        .wd-10{
            width: 5%;
        }
        .wd-15{
            width: 5%;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">


            {{--<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Sell Product</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>--}}

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><b><span class="level_size_card_title">Edit Sale Entry</span></b></h4>
                            <div class="basic-form">
                                <form action="{{url('edit_memo')}}" method="post" style="margin-top: -25px">

                                    <input type="hidden" name="old_memo_id" value="{{$memo_info->id}}">
                                    <input type="hidden" name="journal_entry_id" value="{{$journal_id}}">
                                    <input type="hidden" name="received_entry_id" value="{{$rc_id}}">

                                    @foreach($entry_info_arr as $key=>$value)
                                        <input type="hidden" name="old_product_id[]" value="{{$entry_info_arr[$key]['product_id']}}">
                                        <input type="hidden" name="old_warehouse_id[]" value="{{$entry_info_arr[$key]['warehouse_id']}}">
                                        <input type="hidden" name="old_quantity[]" value="{{$entry_info_arr[$key]['quantity']}}">
                                        <br>
                                    @endforeach

                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                    <div style="border: 1px solid #CED4DA; padding: 10px; border-radius: 8px; " >
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                    <span class="level_size">Date</span>
                                                    <input class="form-control" type="date" value="<?php echo $date1; ?>" name="entry_date">
                                                </div>
                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                    <span class="level_size">Memo No</span>
                                                    <input class="form-control" placeholder="" type="text" value="{{ $memo_info->memo_no }}" name="memo_no" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="form-row margin_top_minus_10">
                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                    <span class="level_size">Ref No:</span>
                                                    <input class="form-control" type="text" autofocus  value="{{ $memo_info->ref_no }}" name="ref_no" >
                                                </div>
                                                <div class="form-group col-md-6" style="margin-top: -7px">
                                                    <span class="level_size">Client Name</span>
                                                    <?php
                                                        $client_name = \Illuminate\Support\Facades\DB::table('clients')->select('client_name')->where('id', $memo_info->client_id)->first()->client_name;
                                                    ?>
                                                    <input class="form-control input " list="clients" id="client_input" value="{{$client_name}}">
                                                    <datalist id="clients">
                                                        @foreach($client_info as $value)
                                                            <option data-id="{{$value->id}}" value="{{ $value->client_name }}">
                                                        @endforeach
                                                    </datalist>

                                                    <input class="form-control input" type="hidden" id="client_id" value="{{$memo_info->client_id}}" name="client_id">

                                                </div>
                                            </div>


                                            <div class="form-row margin_top_minus_10">
                                                <div class="col-md-12" style="margin-top: -7px">
                                                    <div id="client_info_div" >
                                                        <div class="form-row row"  >
                                                            <div class="form-group col-md-6">
                                                                <span class="level_size">Address</span>
                                                                <input class="form-control client_address" placeholder="" type="text" value="{{$client_address}}"  id="client_address" >
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <span class="level_size">Client Due</span>
                                                                <input class="form-control" placeholder="" type="text" value="{{$due}}" name="client_due">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row margin_top_minus_10">
                                                <div class="col-md-12" style="margin-top: -10px">
                                                    <button type="submit" class="btn btn-dark pull-left" style="margin-top: 10px; ">Submit</button>
                                                    <button type="button" class="btn btn-facebook" data-toggle="modal" style="margin-top: 10px; margin-left: 10px " data-target="#exampleModalCenter">Edit</button>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-md-6">
                                            <input type="hidden" name="column_total" value="{{$memo_info->total_price}}" class="form-control column_total" data-validation="required" >

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
                                                    <input type="text" name="discount_p" class="form-control pdiscount" value="{{ $memo_info->discount_p }}" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="discount" class="form-control discount" value="{{ $memo_info->discount }}">
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3px">
                                                <div class="col-md-2" style="text-align: right">
                                                    <input type="checkbox" class="text-right chk1" name="">
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="level_size">VAT</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat_p" class="form-control pvat" value="{{ $memo_info->vat_p }}" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat" class="form-control vat" value="{{ $memo_info->vat }}">
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3px">
                                                <div class="col-md-2" style="text-align: right">
                                                    <input type="checkbox" class="text-right chk2" name="">
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="level_size">Income Tax.</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="tax_p" class="form-control ptax" value="{{ $memo_info->tax_p }}" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="tax" class="form-control tax"  value="{{ $memo_info->tax }}">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-top: 3px">
                                                <div class="col-md-2" style="text-align: right">
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="level_size">Balance</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <?php
                                                    $amount = str_replace(',','',$memo_info->total_price) - str_replace( ',', '', $memo_info->discount);
                                                    $amount = number_format($amount, 2, '.',',');
                                                    ?>
                                                    <input type="text" name="balance" class="form-control balance" data-validation="required" value="{{$amount}}" readonly>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3px">
                                                <div class="col-md-4">

                                                </div>
                                                <div class="col-md-4">
                                                    <span class="level_size">Received Amount</span>
                                                </div>
                                                <div class="col-md-4">
                                                    @if(!empty($received_info[0]->dr_total))
                                                        <input type="text" name="received" class="form-control received" value="{{$received_info[0]->dr_total}}">
                                                    @else
                                                        <input type="text" name="received" class="form-control received" value="0">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3px; margin-bottom: -5px">
                                                <div class="col-md-4">

                                                </div>
                                                <div class="col-md-4">
                                                    <span class="level_size">Due</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="due" class="form-control due" data-validation="required" readonly value="{{$memo_info->due}}">
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
                                            <td style="width: 20%; text-align: center"><b style=""><span class="level_size_title">Warehouse</span></b></td>
                                            {{--<td style="width: 15%; text-align: center"><b>Product Type</b></td>--}}
                                            <td style="width: 20%; text-align: center"><b><span class="level_size_title">Product Name</span></b></td>
                                            <td style="width: 10%; text-align: center"><b><span class="level_size_title">Rate($)</span></b></td>
                                            <td style="width: 5%; text-align: center"><b><span class="level_size_title">Ctn</span></b></td>
                                            <td style="width: 5%; text-align: center"><b><span class="level_size_title">pcs</span></b></td>
                                            <td style="width: 8%; text-align: center"><b><span class="level_size_title">Total Qt</span></b></td>
                                            <td style="width: 7%; text-align: center"><b><span class="level_size_title">Discount </span><br> Rate</b></td>
                                            <td style="width: 10%; text-align: center"><b><span class="level_size_title">Discount</span> <br> Amount</b></td>
                                            <td style="width: 10%; text-align: center"><b><span class="level_size_title">Total</span></b></td>
                                        </tr>
                                        </thead>
                                    </table>

                                    <div class="scroll">
                                        <table class="table order-list" width="100%">


                                            <tbody id="mytable">
                                            @foreach($entry_info_arr as $key=>$value )
                                                <?php
                                                    $entry = $entry_info_arr[$key];
                                                    $product_type = $entry['product_type_id'];
                                                    $products = \Illuminate\Support\Facades\DB::table('product_info')->where('product_type_id', $product_type)->get();
                                                    $i = $key+1;
                                                ?>
                                            <tr>
                                                @if($i>1)
                                                    <td style="width: 5%"><button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button></td>
                                                @else
                                                    <td style="width: 5%"></td>
                                                @endif
                                                <td style="width: 20%">
                                                    <select  data-row="{{$i}}" name="warehouse[]" class="js-example-basic-single form-control warehouse_{{$i}} warehouse" data-validation="required">
                                                        <option value="">Select</option>
                                                        @foreach($warehouse_info as $value)
                                                            @if($entry['warehouse_id'] == $value->id)
                                                            <option value="{{$value->id}}" selected>{{ $value->warehouse_name }}</option>
                                                            @else
                                                            <option value="{{$value->id}}">{{ $value->warehouse_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>


                                                    <td style="width: 20%; ">
                                                        <?php
                                                            $product = \Illuminate\Support\Facades\DB::table("product_info")
                                                                ->select('product_info.product_name','product_info.product_type_id', 'catagory.cname')
                                                                ->join('catagory', 'catagory.id', '=', 'product_info.product_type_id')
                                                                ->where('product_info.id', $entry['product_id'])
                                                                ->first();
                                                            $product_name = $product->product_name;
                                                            $cat_id = $product->product_type_id;
                                                            $cat_name = $product->cname;
                                                        ?>
                                                        <input type="text" data-row="1" list="products" id="product_input" value="{{$product_name}} ({{$cat_name}})" class="product_input_1 product_input input form-control">
                                                        <datalist id="products">

                                                            <?php

                                                            foreach ($cat_info as $key=>$value){
                                                            $cats = $cat_info[$key];
                                                            foreach ($cats as $key1=>$value){
                                                            $products = $cats[$key1];
                                                            $product_name = $products['p_name'];
                                                            $product_id = $products['p_id'];
                                                            $cat_name = $products['cat_name'];
                                                            $cat_id = $products['cat_id'];
                                                            ?>
                                                                <option data-pid="{{$product_id}}" data-cid="{{$cat_id}}" value="{{ $product_name }} ({{$cat_name}})">
                                                            <?php
                                                            }
                                                            }

                                                            ?>

                                                        </datalist>
                                                            <input type="hidden" id="product_type_1" name="product_type[]" value="{{$entry['product_type_id']}}" class="product_type_1 product_type">
                                                            <input type="hidden" id="product_code_name_1" name="product_code[]" value="{{$entry['product_id']}}" class="product_code_name_1 product_code_name">
{{--                                                            <span class="available_qt_{{$i}}" >{{$entry['available_qt']}}</span>--}}
                                                            <span class="available_qt_{{$i}}"></span>
                                                    </td>




                                                <td style="width: 10%">
                                                    <div data-row="{{$i}}" class="rate_div_{{$i}} rate_div" >
                                                        <input type="text" class="form-control rate_{{$i}} rate" name="product_rate[]"  data-validation="required" value="{{$entry['product_rate']}}">
                                                    </div>
                                                </td>

                                                <td style="width: 5%">
                                                    <input type="text" data-row="{{$i}}"  class="form-control carton_{{$i}} carton" value="{{$entry['carton']}}" name="carton[]"  data-validation="number" >
                                                    <input type="hidden" class="form-control qt_per_carton_{{$i}} qt_per_carton" value="{{$entry['qt_per_carton']}}" name="qt_per_carton[]">

                                                </td>

                                                <td style="width: 5%">
                                                    <input type="text" data-row="{{$i}}" value="{{$entry['pieces']}}" class="form-control piece_{{$i}} piece" name="piece[]" data-validation="number">
                                                </td>
                                                <td style="width: 8%">
                                                    <input type="text" data-row="{{$i}}" value="{{$entry['quantity']}}" class="form-control quantity_{{$i}} quantity" name="quantity[]" readonly data-validation="required">
                                                </td>
                                                <td style="width: 7%">
                                                    <input type="text" data-row="{{$i}}" value="{{$entry['single_discount_rate']}}" class="form-control single_discount_rate_{{$i}} single_discount_rate" name="single_discount_rate[]" >
                                                </td>
                                                <td style="width: 10%">
                                                    <input type="text" data-row="{{$i}}" value="{{$entry['single_discount']}}" readonly class="form-control single_discount_amount_{{$i}} single_discount_amount" name="single_discount_amount[]" >
                                                </td>
                                                <td style="width: 10%">
                                                    <input type="text" name="total[]" value="{{$entry['total']}}" data-row="{{$i}}" class="form-control total_{{$i}} total" readonly data-validation="required">
                                                </td>

                                            </tr>
                                            @endforeach
                                            </tbody>

                                            {{--<tr>
                                                <td colspan="11">
                                                    <div class="row">
                                                        <div class="col-md-10"></div>
                                                        <div class="col-md-2">
                                                            <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                            <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>--}}

                                            {{--<tr>
                                                <td colspan="9"></td>
                                                <td><b>Balance</b></td>
                                                <td><input type="text" name="balance" class="form-control balance" data-validation="required" readonly></td>
                                            </tr>--}}
                                        </table>

                                    </div>

                                        <br/>
                                        <div class="row"  style="margin: -4px" >
                                            <div class="col-md-10" style="margin-top: -10px"></div>
                                            <div class="col-md-2" style="margin-top: -10px">
                                                <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                            </div>
                                        </div>

                                    </div>

                                </form>
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
                                                <input type="submit" name="save" class="btn btn-dark" value="Save">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--MODAL ENDS--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <input class="form-control" placeholder="Supplier Name" type="text" name="supplier_name" required>
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Company Name</label>
                                <input class="form-control" placeholder="Supplier Name" type="text" name="company_name">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Address</label>
                                <input class="form-control" placeholder="Address" type="text" name="address">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Email </label>
                                <input class="form-control" placeholder="Supplier Name" type="email" name="email">
                            </div>

                            <div class="col-md-offset-1 col-md-10 form-group">
                                <label>Contact No </label>
                                <input class="form-control" placeholder="Supplier Name" type="text" name="contact_no" required>
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

        var i = <?php echo $i; ?>;
        function addrow()
        {
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

            console.log('i:: '+i)
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
            cell2.innerHTML='<select name="warehouse[]" data-row="'+i+'" class="js-example-basic-single form-control warehouse_'+i+' warehouse" data-validation="required"><option>Select Warehouse</option><?php foreach ($warehouse_info as $type) {?>  <option value="<?=$type->id ?>"><?=$type->warehouse_name ?></option><?php } ?></select>';
            cell3.innerHTML='<td><input type="text" data-row="'+i+'" list="products" id="product_input" class="product_input_'+i+' product_input input form-control">' +
                '<input type="hidden" id="product_type_'+i+'" name="product_type[]" class="product_type_'+i+' product_type">\n' +
                '<input type="hidden" id="product_code_name_'+i+'" name="product_code[]" class="product_code_name_'+i+' product_code_name">\n' +
                '<span class="available_qt_'+i+'"></span> </td>';
            cell4.innerHTML='<td><div data-row="'+i+'" class="rate_div_'+i+' rate_div" name="rate[]"><input type="text" class="form-control" data-validation="required"> </div></td>';
            cell5.innerHTML='<input type="text" data-row="'+i+'" class="form-control carton_'+i+' carton" name="carton[]" value="0" data-validation="number"> ' +
                '<input type="hidden" name="qt_per_carton[]" class="form-control qt_per_carton_'+i+'">';
            cell6.innerHTML='<input type="text" data-row="'+i+'" class="form-control piece_'+i+' piece" name="piece[]" value="0" data-validation="number">';
            cell7.innerHTML='<input type="text" data-row="'+i+'" class="form-control quantity_'+i+' quantity" name="quantity[]" readonly data-validation="required">';
            cell8.innerHTML='<input type="text" data-row="'+i+'" class="form-control single_discount_rate_'+i+' single_discount_rate" name="single_discount_rate[]" >';
            cell9.innerHTML='<input type="text" data-row="'+i+'" readonly class="form-control single_discount_amount_'+i+' single_discount_amount" name="single_discount_amount[]" >';
            cell10.innerHTML='<input type="text" name="total[]" data-row="'+i+'" class="form-control total_'+i+' total" readonly data-validation="required">';
        }


        $('#client_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#clients [value="' + value + '"]').data('id');
            console.log(c_id);

            $('#client_id').val(c_id)
            getClientInfo(c_id)

        });

        function getClientInfo(client_id) {
            // var client_id = selected_option.options[selected_option.selectedIndex].value;
            console.log(client_id)

            $.ajax({
                //url: 'getUser.php',
                url:'{{url('get_client_info')}}',
                type: 'GET',
                data: 'client_id='+client_id,
                //data:{id:uid}
                dataType: 'html'
            })
                .done(function(data){
                    console.log(data);

                    // $('.client_address').val(data); // load response
                    $('#client_info_div').html(data); // load response
                })
                .fail(function(){
                    $('#client_info_div').html('<div  id="client_info_div">\n' +
                        '<div class="form-row" >\n' +
                        '    <div class="form-group col-md-6">\n' +
                        '        <label>Address</label>\n' +
                        '        <input class="form-control client_address" placeholder="" type="text"  id="client_address" value="" data-validation="required">\n' +
                        '    </div>\n' +
                        '    <div class="form-group col-md-6">\n' +
                        '        <label>Client Due</label>\n' +
                        '        <input class="form-control" placeholder="" type="text" name="client_due">\n' +
                        '    </div>\n' +
                        '    </div>\n' +
                        '</div>');
                });

        }


        $(document).on('keyup','.product_input',function(){
            var row = $(this).data('row');
            var product_input = $('.product_input_'+row).val();

            var product_id = $('#products [value="' + product_input + '"]').data('pid');
            var cat_id = $('#products [value="' + product_input + '"]').data('cid');


            $('.product_type_'+row).val(cat_id)
            $('.product_code_name_'+row).val(product_id)

            bringRate(product_id, row);
            getAvailableQuantity(row)
            bringQuantityPerCarton(row)

        });

        function bringRate(product_id,row){
            // var option2 = $('.product_list_'+row).val();
            var varJ = row;
            var token = $('#token').val();
            $.post('{{url('getRate')}}',{select2:product_id,l:varJ,_token: token},function(data){
                $('.rate_div_'+row).html(data).show();
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
            $.post('{{url('getAvailableQt')}}',{select2:product_code,warehouse_id:warehouse_id,l:varJ,_token: token},function(data){
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
            $.post('{{url('getQuantityPerCarton')}}',{select2:option2,l:varJ,_token: token},function(data){
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
                pbalance = pbalance + vVat;

                vat = (vVat).formatMoney(2, '.', ',');
                $('.vat').val(vat);

            }else if (ppvat<=0 && aavat>0) {

                // console.log("only aavat ::: "+aavat)
                pbalance = pbalance + aavat;

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
                console.log(p)
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
                // var quantity = $('.quantity_'+row).val();

                console.log(qt_per_carton+', '+carton+", "+piece);
                var total = rate * quantity;

                if (single_discount_rate != null || single_discount_rate>0){
                    single_discount_amount = (total * single_discount_rate)/100;
                    $('.single_discount_amount_'+row).val(single_discount_amount);
                }


                if (single_discount_amount != null || single_discount_amount>0){
                    total -= single_discount_amount;
                }
                total = (total).formatMoney(2, '.', ',');
                $('.total_'+row).val(total);
                // calculateDue();

                sum();
                calculateDue();

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

                calculateDue();
            });

            function calculateDue(){
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
            }

            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.piece',function(){
                var row = $(this).data('row');
                // quantity(row);
                totalCalculate(row);
                calculateDue();

                var quantity = parseInt($('.quantity_'+row).val());
                var available_qt = parseInt($('.available_qt_'+row).text());
                console.log(quantity+", "+available_qt)
                if(quantity > available_qt){
                    alert('Sale quantity exeeds available quantity');
                    setAllBlank(row)
                    totalCalculate(row);
                }
            });



            $(document).on('keyup','.carton',function(){
                var row = $(this).data('row');
                // quantity(row);
                totalCalculate(row);
                // console.log('piece keyup')
                calculateDue();
                var quantity = parseInt($('.quantity_'+row).val());
                var available_qt = parseInt($('.available_qt_'+row).text());
                console.log(quantity+", "+available_qt)
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

            $(document).on('change','.product_list', function(){
                var row = $(this).data('row');
                bringRate(row);
                bringQuantityPerCarton(row);
                getAvailableQuantity(row);
            });

            $(document).on('change','.warehouse', function(){
                var row = $(this).data('row');
                getAvailableQuantity(row);
            });

            // $(document).on('change','#newsupplier', function(){
            //     // var row = $(this).data('row');
            //     bringAddress();
            // });

            function bringName(row){
                var option = $('.product_type_'+row).val();
                //console.log(option)
                var token = $('#token').val();
                var varI = row;

                console.log(token)
                console.log(varI)

                $.post('{{url('getProductName')}}', {select:option,j:varI, _token: token}, function(data) {
                    //alert(data);
                    $('.product_code_name_'+row).html(data).hide().show();
                    $('.js-example-basic-single').select2();
                });
            }








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
                    '{{url('getSupplierAddress')}}',
                    {supplier_id : supplierId, _token: token},
                    function (data) {
                        $('#supplier_address').val(data);
                    }

                );
            });

            $('.chk1').change(function(){
                if($(this).is(':checked')) {
                    $(".pvat").removeAttr("disabled");
                    $(".vat").prop("disabled", true);

                    $('.vat').val('0');
                    $('.pvat').val('0');
                    sum();

                } else {
                    $(".vat").removeAttr("disabled");
                    $(".pvat").prop("disabled", true);

                    $('.vat').val('0');
                    $('.pvat').val('0');
                    sum();
                }
                // $(".vat").prop("disabled", !$(this).is(':checked'));
                // $(".pvat").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk2').change(function(){

                if($(this).is(':checked')) {
                    $(".ptax").removeAttr("disabled");
                    $(".tax").prop("disabled", true);

                    $('.ptax').val('0');
                    $('.tax').val('0');
                    sum();

                } else {
                    $(".tax").removeAttr("disabled");
                    $(".ptax").prop("disabled", true);

                    $('.ptax').val('0');
                    $('.tax').val('0');
                    sum();
                }

                // $(".tax").prop("disabled", !$(this).is(':checked'));
                // $(".ptax").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk3').change(function(){

                if($(this).is(':checked')) {
                    $(".pdiscount").removeAttr("disabled");
                    $(".discount").prop("disabled", true);

                    $('.pdiscount').val('0');
                    $('.discount').val('0');

                    sum();
                } else {
                    $(".discount").removeAttr("disabled");
                    $(".pdiscount").prop("disabled", true);

                    $('.pdiscount').val('0');
                    $('.discount').val('0');

                    sum();
                }

            });

            // $(".tax").attr('disabled','disabled');
            // $(".vat").attr('disabled','disabled');
            $(".vat_p").attr('disabled','disabled');
            $(".tax_p").attr('disabled','disabled');
            $(".discount_p").attr('disabled','disabled');
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


    </script>

@stop
