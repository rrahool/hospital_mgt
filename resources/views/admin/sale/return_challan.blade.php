@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Show Challan</h4>
                            </div>


                            <div class="basic-list-group">
                                <ul class="list-group">
                                    <li class="list-group-item active">Show Challan</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6" style="font-size: 16px">

                                                <h4>To,</h4>
                                                @if($view_bill->client_name)
                                                    <b>{{ $view_bill->client_name }}</b><br>
                                                @endif

                                                @if($view_bill->address)
                                                    {{ $view_bill->address }}<br>
                                                @endif

                                                @if($view_bill->contact_no)
                                                    {{ $view_bill->contact_no }}
                                                @endif
                                            </div>

                                            <div class="col-md-6" style="font-size: 16px">
                                                <h4>Return Invoice</h4>
                                                <b>Ref No. </b><?php $pname = strtoupper(substr($view_bill->username,0,3)).date('dmy',$view_bill->entry_date).'C'; echo $pname?> <br>
                                                <b>Date : </b> <?=date('d-M-Y',$view_bill->entry_date)?>
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

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(sizeof($entry_info) > 0)
                                                        <?php $i = 1; $total_quantity = 0;?>
                                                        @foreach($entry_info as $single_sale_entry)

                                                            <?php

                                                            $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_sale_entry->product_id)->first();
                                                            $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_sale_entry->product_type_id)->first();
                                                            $total_quantity += $single_sale_entry->quantity;
                                                            ?>
                                                            <tr>
                                                                <td>{{$i}}</td>
                                                                <td>{{$product_type_info->cname}}<br>
                                                                    {{ $product_info->product_name }}<br>
                                                                    {{ $product_info->description }}<br>
                                                                </td>
                                                                <td>{{$single_sale_entry->quantity}}</td>

                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td style="color: red">Data not found ....</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>

                                                    <tr>
                                                        <td colspan="2" class="">
                                                            <b>Total Quantity</b>
                                                        </td>
                                                        <td class="lower_parts_class"><b>{{$total_quantity}}</b></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>



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
