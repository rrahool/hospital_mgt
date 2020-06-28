<?php
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
?>

@extends('admin.master')

@section('mainContend')
    {{--Modal panel--}}
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            {!! Form::open(['url'=>'add_client','method'=>'post']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Client Information</strong></h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Client Name</label>
                            <input class="form-control" placeholder="Client Name" type="text" name="client_name" required>
                        </div>

                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Company Name</label>
                            <input class="form-control" placeholder="Company Name" type="text" name="company_name">
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
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div>
            <br><br>
        </div>
    </div>

    <div class="row">
        @include('admin.includes.error')
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Quotation Entry
                </div>
                <div class="panel-body">

                    <div class="row">
                        {!! Form::open(['url'=>'quotation_input', 'method'=>'post']) !!}
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                        <div class="form-group col-lg-6">
                            <label>Date</label>
                            <input class="form-control" type="date" value="{{ $date }}" name="entry_date">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Entry No:</label>
                            <input class="form-control" type="text" value="{{ $entry_no }}" readonly>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Client Name</label>
                            <div class="input-group">
                                <select class="form-control" name="client_id" id="newsupplier" required>
                                    <option value="0">Select Client</option>
                                    @foreach($client_info as $value)
                                        <option value="{{ $value->id }}">{{ ucwords($value->client_name )}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-btn">
                                    <button href="#" data-toggle="modal" data-target="#login-modal" class="btn btn-warning" type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Address</label>
                            <input class="form-control" placeholder="" type="text" id="client_address">
                        </div>

                        <table class="table order-list">
                            <tbody id="mytable">
                            <tr>
                                <td></td>
                                <td><b>Product Type</b></td>
                                <td><b>Name</b></td>
                                <td><b>Rate($)</b></td>
                                <td><b>Quantity</b></td>
                                <td><b>Total</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="col-md-4">
                                    <select data-row="1" name="product_type" class="form-control product_type_1 product_type" required>
                                        <option value="0">Select Type</option>
                                        @foreach($category as $value)
                                            <option value="{{$value->id}}">{{ $value->cname }}</option>
                                            @endforeach
                                    </select>
                                </td>

                                <td class="col-md-3">
                                    <div data-row="1" name="product_code_name" class="product_code_name_1 product_code_name">
                                        <select class="form-control">
                                            <option>Select Type </option>
                                        </select>
                                    </div>
                                </td>

                                <td class="col-md-2">
                                    <div data-row="1" class="rate_div_1 rate_div" name="rate_1">
                                        <input type="text" class="form-control">
                                    </div>
                                </td>

                                <td class="col-md-1">
                                    <input type="text" data-row="1" value="" class="form-control quantity_1 quantity" name="quantity[]">
                                </td>
                                <td>
                                    <input type="text" name="total_1" data-row="1" class="form-control total_1 total">
                                </td>
                            </tr>
                            </tbody>
                            <tr>
                                <td colspan="4"></td>
                                <td><b>Total</b></td>
                                <td><input type="text" name="column_total" class="form-control column_total"></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><input type="checkbox" class="text-right chk3" name=""></td>
                                <td><b>Discount</b></td>
                                <td><input type="text" name="discount_p" class="form-control pdiscount" value="0"></td>
                                <td><input type="text" name="discount" class="form-control discount"></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><input type="checkbox" class="text-right chk1" name=""></td>
                                <td><b>VAT</b></td>
                                <td><input type="text" name="vat_p" class="form-control pvat" value="0"></td>
                                <td><input type="text" name="vat" class="form-control vat"></td>
                            </tr>

                            <tr>
                                <td colspan="2"></td>
                                <td><input type="checkbox" class="text-right chk2" name=""></td>
                                <td><b>Income Tax.</b></td>
                                <td><input type="text" name="tax_p" class="form-control ptax" value="0"></td>
                                <td><input type="text" name="tax" class="form-control tax"></td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td><b>Balance</b></td>
                                <td><input type="text" name="balance" class="form-control balance"></td>
                            </tr>
                        </table>
                        <br/>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info" onclick= "addrow()"><b>+ Row </b></button>
                            <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                        </div>
                        <br><br>
                        <div class="col-md-12">
                            <label>Terms and Conditions</label>
                            <textarea class="form-control" name="terms">{{ $term_and_condition->terms }}</textarea>
                        </div>
                        <br><br>

                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-success purchase-button-edit pull-right">Submit</button>
                        </div>

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
        var i=1;
        function addrow()
        {
            i++;
            var table = document.getElementById("mytable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            cell1.innerHTML='<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
            cell2.innerHTML='<select name="product_type_'+i+'" data-row="'+i+'" class="form-control product_type_'+i+' product_type"><option value="0">Select Type</option><?php foreach ($category as $value){ ?><option value="<?php echo $value->id ?>"><?php echo $value->cname ?></option><?php } ?></select>';

            cell3.innerHTML='<td><div data-row="'+i+'" name="product_code_name_'+i+'" class="product_code_name_'+i+' product_code_name"><select class="form-control"><option value="0">Select Name</option></select> </div></td>';
            cell4.innerHTML='<td><div data-row="'+i+'" class="rate_div_'+i+' rate_div" name="rate_'+i+'"><input type="text" class="form-control"></div></td>';
            cell5.innerHTML='<input type="text" data-row="'+i+'" class="form-control quantity_'+i+' quantity" name="quantity[]">';
            cell6.innerHTML='<input type="text" name="total" data-row="'+i+'" class="form-control total_'+i+' total">';
        }

        // function removerow()
        // {
        //     i--;
        //     if(i<1){
        //     i++;
        //     return false;
        // }
        // document.getElementById("mytable").deleteRow(-1);
        // }

        function deleteRow(rowNum)
        {
            var i = rowNum.parentNode.parentNode.rowIndex;
            document.getElementById("mytable").deleteRow(i);
        }
    </script>

    </div>
    </div>



    <script type="text/javascript">

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
                var quantity = $('.quantity_'+row).val();
                var total = rate * quantity;
                total = (total).formatMoney(2, '.', ',');
                $('.total_'+row).val(total);
                sum();

            }

            function sum()
            {
                var sum = 0;
                $('.total').each(function(){
                    var ptotal = $(this).val();
                    var total = parseFloat(ptotal.replace(",", ""));
                    sum += total;
                });
                var mtotal = (sum).formatMoney(2, '.', ',');
                $('.column_total').val(mtotal);

                var pvat = $('.pvat').val();
                var ppvat = parseFloat(pvat.replace(",", ""));
                var vvat = (sum * ppvat) / 100 ;
                var vat = (vvat).formatMoney(2, '.', ',');
                $('.vat').val(vat);

                var ptax = $('.ptax').val();
                var pptax = parseFloat(ptax.replace(",", ""));
                var vtax = (sum * pptax) / 100 ;
                var tax = (vtax).formatMoney(2, '.', ',');
                $('.tax').val(tax);

                var pdiscount = $('.pdiscount').val();
                var discount = $('.discount').val();
                var adiscount = parseFloat(discount.replace(",", ""));
                var ppdiscount = parseFloat(pdiscount.replace(",", ""));
                var vdiscount = (ppdiscount > 0) ? (sum * ppdiscount) / 100 : adiscount ;
                discount = (vdiscount).formatMoney(2, '.', ',');
                $('.discount').val(discount);

                var pbalance = sum + vvat + vtax - vdiscount ;
                var balance = (pbalance).formatMoney(2, '.', ',');
                $('.balance').val(balance);
            }

            $(document).on('click','.deleterow',function(){
                sum();
            })

            $(document).on('keyup','.discount',function(){
                sum();
            })

            $(document).on('keyup','.total',function(){
                sum();
            })

            $(document).on('input','.pdiscount', function(){
                sum();
            });

            $(document).on('input','.pvat', function(){
                sum();
            });

            $(document).on('input','.ptax', function(){
                sum();
            });

            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.quantity',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                quantity(row);
            });

            $(document).on('change','.product_type', function(){
                var row = $(this).data('row');
                bringName(row);
            });

            $(document).on('change','.product_list', function(){
                var row = $(this).data('row');
                bringRate(row);
            });

            $(document).on('change','#newclient', function(){
                // var row = $(this).data('row');
                bringAddress();
            });

            function bringName(row){
                var option = $('.product_type_'+row).val();
                var token = $('#token').val();
                var varI = row;

                $.post('getProductName', {select:option,j:varI, _token: token}, function(data) {
                    //alert(data);
                    $('.product_code_name_'+row).html(data).hide().show();
                });
            }

            function bringRate(row){
                var option2 = $('.product_list_'+row).val();
                var varJ = row;
                var token = $('#token').val();
                $.post('getRate',{select2:option2,l:varJ,_token: token},function(data){
                    $('.rate_div_'+row).html(data).show();
                });
            }

            $('#newsupplier').change(function () {
                var clientId = $(this).val();
                var token = $('#token').val();
                $.post(
                    'getClientAddress',
                    {client_id : clientId, _token: token},
                    function (data) {
                        $('#client_address').val(data);
                    }

                );
            });

            function quantity(row){
                var ids= $('.product_list_'+row).val();
                var quantities= $('.quantity_'+row).val();
                var token = $('#token').val();
                $.post('<?php echo url('getQuantityReturn'); ?>',{quantity:quantities,id:ids, _token: token},function(data){
                    $('.quantity_'+row).html(data).show();
                    if(data == "false"){
                        alert('Quantity not available');
                        $('.quantity_'+row).val("");
                    }

                });
            }



            $('.chk1').change(function(){
                $(".vat").prop("disabled", !$(this).is(':checked'));
                $(".pvat").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk2').change(function(){
                $(".tax").prop("disabled", !$(this).is(':checked'));
                $(".ptax").prop("disabled", !$(this).is(':checked'));
            });

            $('.chk3').change(function(){
                $(".discount").prop("disabled", !$(this).is(':checked'));
                $(".pdiscount").prop("disabled", !$(this).is(':checked'));
            });

            onload = function (){
                document.forms[0].tax.disabled = true;
                document.forms[0].discount.disabled = true;
                document.forms[0].vat.disabled = true;
                document.forms[0].tax_p.disabled = true;
                document.forms[0].vat_p.disabled = true;
                document.forms[0].discount_p.disabled = true;
            }
        });

    </script>
    @stop