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

    </style>

    <div class="content-body">

        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Purchase New Products</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                @include('admin.includes.error')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Purchase Entry</h4>
                            <div class="basic-form">
                                <form action="{{url('purchase_entry')}}" method="post" >

                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Date</label>
                                                    <input class=" form-control" type="date" value="<?php echo $date; ?>" name="entry_date">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Entry No:</label>
                                                    <input class="form-control" type="text" name="entry_no" value="{{ $entry_no }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Supplier Memo No</label>
                                                    <input class="input form-control" placeholder="" type="text" name="ref_no" data-validation="number">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Supplier Name</label>
                                                    <div class="input-group">
                                                        <select class="input form-control js-example-basic-single" name="supplier_id" id="newsupplier" data-validation="required">
                                                            <option value="">Select Supplier Name</option>
                                                            @foreach($supplier as $value)
                                                                <option value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-btn" style="padding: 2px;">
                                                            <button href="#" data-toggle="modal" data-target="#login-modal" class="btn btn-skype display-3" type="button"> <span class="icon-plus" ></span> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Supplier Name</label>
                                                    <select class="input form-control js-example-basic-single" name="warehouse_id" id="warehouse_id" data-validation="required">
                                                        <option value="">Select Warehouses Name</option>
                                                        @foreach($warehouses as $value)
                                                            <option value="{{ $value->id }}">{{ $value->warehouse_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Remarks</label>
                                                    <input class="input form-control" placeholder="" type="text" name="remarks">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <div class="row" style="margin-top: 10px; ">
                                                <div class="col-md-2" style="text-align: right">
                                                    <input type="checkbox" class="text-right chk3" name="">
                                                </div>
                                                <div class="col-md-2">
                                                    Discount
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="discount_p" class="input form-control pdiscount" value="0" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="discount" class="input form-control discount">
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 10px; ">
                                                <div class="col-md-2" style="text-align: right">
                                                    <input type="checkbox" class="text-right chk1" name="">
                                                </div>
                                                <div class="col-md-2">
                                                    VAT
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat_p" class="input form-control pvat" value="0" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat" class="input form-control vat">
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 10px; ">
                                                <div class="col-md-2" style="text-align: right">
                                                    <input type="checkbox" class="text-right chk2" name="">
                                                </div>
                                                <div class="col-md-2">
                                                    Income Tax.
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="tax_p" class="input form-control ptax" value="0" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="tax" class="input form-control tax">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-md-6" style=" text-align: right">
                                                    {{--<input type="checkbox" class="text-right chk2" name="">--}}
                                                </div>
                                                <div class="col-md-2">
                                                    Balance
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="balance" class="input form-control balance" data-validation="required" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <input class="form-control" placeholder="" type="hidden" id="supplier_address" data-validation="required">


                                    <table class="table order-list">
                                        <tbody id="mytable">
                                        <tr>
                                            <td style="width: 5%; text-align: center"></td>
                                            <td style="width: 20%; text-align: center"><b>Product Type</b></td>
                                            <td style="width: 20%; text-align: center"><b>Name</b></td>
                                            <td style="width: 15%; text-align: center"><b>Rate($)</b></td>
                                            <td style="width: 5%; text-align: center"><b>Carton</b></td>
                                            <td style="width: 10%; text-align: center"><b>piece</b></td>
                                            <td style="width: 10%; text-align: center"><b>Total Quantity</b></td>
                                            <td style="width: 15%; text-align: center"><b>Total</b></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%"></td>
                                            <td style="width: 20%">
                                                <select  data-row="1" name="product_type[]" class="input form-control product_type_1 product_type js-example-basic-single" data-validation="required">
                                                    <option value="">Select Type</option>
                                                    <?php foreach ($category as $type) {?>
                                                    <option value="<?=$type->id ?>"><?=$type->cname ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td style="width: 20%">
                                                <div data-row="1" name="product_code_name[]" class="input product_code_name_1 product_code_name " data-validation="required">
                                                    <select class="form-control" >
                                                        <option>Select Type </option>
                                                    </select>
                                                </div>
                                            </td>

                                            <td style="width: 15%">
                                                <div data-row="1" class="rate_div_1 rate_div" >
                                                    <input type="text" class="input form-control" rate[] data-validation="required">
                                                </div>
                                            </td>

                                            <td style="width: 5%">
                                                <input type="text" data-row="1" value="0" class="input form-control carton_1 carton" name="carton[]" data-validation="number">
                                                <input type="hidden" class="form-control qt_per_carton_1 qt_per_carton" name="qt_per_carton[]">

                                            </td>

                                            <td style="width: 10%">
                                                <input type="text" data-row="1" value="0" class="input form-control piece_1 piece" name="piece[]" data-validation="number">
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" data-row="1" value="" class="input form-control quantity_1 quantity" name="quantity[]" readonly data-validation="required">
                                            </td>
                                            <td style="width: 15%">
                                                <input type="text" name="total[]" data-row="1" class="input form-control total_1 total" readonly data-validation="required">
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="8">
                                                <div class="row">
                                                    <div class="col-md-10"></div>
                                                    <div class="col-md-2">
                                                        <!-- <button type="button" onclick= "removerow()" class="deleterow"><b>- Row</b></button> -->
                                                        <button type="button" class="btn btn-info pull-right" onclick= "addrow()"><b>+ Row </b></button>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td><b>Total</b></td>
                                            <td><input type="text" name="column_total" class="input form-control column_total" required readonly="" data-validation="required"></td>
                                        </tr>
                                        {{--<tr>
                                            <td colspan="4"></td>
                                            <td><input type="checkbox" class="text-right chk3" name=""></td>
                                            <td><b>Discount</b></td>
                                            <td><input type="text" name="discount_p" class="form-control pdiscount" value="0"></td>
                                            <td><input type="text" name="discount" class="form-control discount"></td>
                                        </tr>--}}
                                        {{--<tr>
                                            <td colspan="4"></td>
                                            <td><input type="checkbox" class="text-right chk1" name=""></td>
                                            <td><b>VAT</b></td>
                                            <td><input type="text" name="vat_p" class="form-control pvat" value="0"></td>
                                            <td><input type="text" name="vat" class="form-control vat"></td>
                                        </tr>--}}

                                        {{--<tr>
                                            <td colspan="4"></td>
                                            <td><input type="checkbox" class="text-right chk2" name=""></td>
                                            <td><b>Income Tax.</b></td>
                                            <td><input type="text" name="tax_p" class="form-control ptax" value="0"></td>
                                            <td><input type="text" name="tax" class="form-control tax"></td>
                                        </tr>--}}

                                        {{--<tr>
                                            <td colspan="6"></td>
                                            <td><b>Balance</b></td>
                                            <td><input type="text" name="balance" class="form-control balance" data-validation="required" ></td>
                                        </tr>--}}
                                    </table>
                                    <br/>


                                    <br/>

                                    <button type="submit" class="btn btn-success purchase-button-edit pull-right" style="margin-top: 10px">Submit</button>



                                </form>
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
                            <input class="input form-control" placeholder="Supplier Name" type="text" name="supplier_name" data-validation="required">
                        </div>

                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Company Name</label>
                            <input class="input form-control" placeholder="Supplier Name" type="text" name="company_name" data-validation="required">
                        </div>

                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Address</label>
                            <input class="input form-control" placeholder="Address" type="text" name="address">
                        </div>

                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Email </label>
                            <input class="input form-control" placeholder="Supplier Name" type="email" name="email">
                        </div>

                        <div class="col-md-offset-1 col-md-10 form-group">
                            <label>Contact No </label>
                            <input class="input form-control" placeholder="Supplier Name" type="text" name="contact_no" data-validation="required">
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

            cell1.innerHTML='<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
            cell2.innerHTML='<select name="product_type[]" data-row="'+i+'" class="js-example-basic-single form-control product_type_'+i+' product_type" data-validation="required"><option>Select Type</option><?php foreach ($category as $type) {?>  <option value="<?=$type->id ?>"><?=$type->cname ?></option><?php } ?></select>';
            cell3.innerHTML='<td><div data-row="'+i+'" name="product_code_name_[]" class=" product_code_name_'+i+' product_code_name "><select class="form-control" data-validation="required"><option>Select Name</option></select></div></td>';
            cell4.innerHTML='<td><div data-row="'+i+'" class="input rate_div_'+i+' rate_div" name="rate[]"><input type="text" class="form-control" data-validation="number"> </div></td>';
            cell5.innerHTML='<input type="text" data-row="'+i+'" class="input form-control carton_'+i+' carton" value="0" name="carton[]" data-validation="number"> ' +
                '<input type="hidden" name="qt_per_carton[]" class="input form-control qt_per_carton_'+i+'" data-validation="number">';
            cell6.innerHTML='<input type="text" data-row="'+i+'" class="input form-control piece_'+i+' piece" value="0" name="piece[]" data-validation="number">';
            cell7.innerHTML='<input type="text" data-row="'+i+'" class="input form-control quantity_'+i+' quantity" name="quantity[]" readonly data-validation="number">';
            cell8.innerHTML='<input type="text" name="total[]" data-row="'+i+'" class="form-control total_'+i+' total" readonly data-validation="required" >';
        }

        function sum()
        {
            var sum = 0;
            $('.total').each(function(){
                var ptotal = $(this).val();
                //var rTotal = ptotal.replace(",", "");
                var rTotal = ptotal.replace(/,/g, '');
                var total = parseFloat(rTotal);
                // alert(rTotal);
                sum += total;
            });
            var mtotal = (sum).formatMoney(2, '.', ',');
            $('.column_total').val(mtotal);
            var pbalance = sum;


            // calculate balance after discount
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

                /*if (carton != null || carton<1){

                    var quantity = parseInt(carton*qt_per_carton) + parseInt(piece);
                    console.log(quantity);
                }else {
                    var quantity = piece;
                    console.log(quantity);
                }*/


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
                total = (total).formatMoney(2, '.', ',');
                $('.total_'+row).val(total);
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

            $(document).on('input','.rate',function(){
                var row = $(this).data('row');
                totalCalculate(row);
            });

            $(document).on('keyup','.carton',function(){
                var row = $(this).data('row');
                // quantity(row);
                totalCalculate(row);
                // console.log('piece keyup')
            });

            $(document).on('keyup','.piece',function(){
                var row = $(this).data('row');
                totalCalculate(row);
                quantity(row);
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

                $.post('getProductName', {select:option,j:varI, _token: token}, function(data) {
                    //alert(data);
                    $('.product_code_name_'+row).html(data).hide().show();
                    $('.js-example-basic-single').select2();
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

            function bringQuantityPerCarton(row){
                var option2 = $('.product_list_'+row).val();
                console.log(option2);
                var varJ = row;
                var token = $('#token').val();
                $.post('getQuantityPerCarton',{select2:option2,l:varJ,_token: token},function(data){
                     // $('.qt_per_carton_'+row).html(data).show();
                    $('.qt_per_carton_'+row).val(data);
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
            /*$(".tax").attr('readonly','readonly');
            $(".vat").attr('readonly','readonly');
            $(".discount").attr('readonly','readonly');*/
            /*$(".vat_p").prop('disabled','');
            $(".tax_p").attr('disabled','disabled');
            $(".discount_p").attr('disabled','disabled');*/

        });

    </script>
    @stop
