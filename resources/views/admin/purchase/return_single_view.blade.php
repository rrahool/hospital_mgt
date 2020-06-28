@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Purchase Return Memo</h4>
                            </div>


                                <div class="basic-list-group">
                                    <ul class="list-group">
                                        <li class="list-group-item active">Purchase Return Information</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-8" style="font-size: 16px">
                                                    @if($supplier_info->executive_name )
                                                    <b>Executive Name : </b>{{ $supplier_info->executive_name }} <br>
                                                    @endif
                                                    <b>Supplier Name : </b>{{ $supplier_info->supplier_name }} <br>
                                                    @if($supplier_info->address )
                                                        <b>Address : </b>{{ ucfirst($supplier_info->address )}} <br>
                                                    @endif
                                                    @if($supplier_info->email)
                                                        <b>E-mail : </b>{{ $supplier_info->email }} <br>
                                                    @endif
                                                    @if($supplier_info->contact_no)
                                                        <b>Contact : </b>{{ $supplier_info->contact_no }} <br>
                                                    @endif

                                                </div>
                                                <div class="col-md-4" style="font-size: 16px">
                                                    <b>Supplier Memo No : </b>{{ $supplier_info->memo_no }}<br>
                                                    ref : <strong>RP</strong>-{{ $supplier_info->r_id }}
                                                    <br> {{ date('d-M-Y',$supplier_info->entry_date) }} <br>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered zero-configuration">

                                                        <thead>
                                                        <tr>
                                                            <th>SL No.</th>
                                                            <th>Product Description</th>
                                                            <th>Quantity</th>
                                                            <th>Rate</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @if(sizeof($single_purchases_return) > 0)
                                                            <?php $i = 1; ?>
                                                            @foreach($single_purchases_return as $single_purchase)

                                                                <?php

                                                                $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_purchase->product_id)->first();
                                                                $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_purchase->product_type_id)->first();
                                                                ?>
                                                                <tr>
                                                                    <td>{{$i}}</td>
                                                                    <td>{{$product_type_info->cname}}<br>
                                                                        {{ $product_info->product_name }}<br>
                                                                        {{ $product_info->description }}<br>
                                                                    </td>
                                                                    <td>{{$single_purchase->quantity}}</td>
                                                                    <td>{{$single_purchase->product_rate}}</td>
                                                                    <td>{{$single_purchase->total}}</td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td style="color: red">Data not found ....</td>
                                                            </tr>
                                                        @endif
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td>{{$supplier_info->total}}</td>
                                                        </tr>

                                                        <tr>

                                                            <td rowspan="1" colspan="2">

                                                                <?php

                                                                $t = $supplier_info->total;
                                                                $tt = str_replace(",","", $t);

                                                                $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                $n = $f->format($tt);


                                                                ?>


                                                                <center><b><?=ucwords($n)?> Taka Only</b></center>

                                                            </td>

                                                            <td colspan="2"> Total</td>

                                                            <td colspan=""> <?=$supplier_info->total?></td>

                                                        </tr>
                                                        </tfoot>
                                                    </table>

                                                    <br>

                                                    <div style="margin-left: 15px; font-size: 16px">
                                                        <p>
                                                            Kindly acknowledge the receipt and take your necessary action.<br/><br/>
                                                            ------------<br/>
                                                            <?php echo '<b>'.ucfirst($supplier_info->username).'</b>'; ?>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>

                                            <a href="{{url('print_purchase_return_report/'.$id)}}" style="margin-top: 10px" class="btn btn-primary">Print</a>


                                        </li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop
