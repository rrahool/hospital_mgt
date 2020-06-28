@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Sales Memo</h4>
                            </div>


                            <div class="basic-list-group">
                                <ul class="list-group">
                                    <li class="list-group-item active">Sales Information</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6" style="font-size: 16px">

                                                @if($sell_view->patient_name)
                                                    <tr style="border: none">
                                                        <td style="text-align: left; border: none"><b>Patient Name: </b></td>
                                                        <td style="border: none">{{ $sell_view->patient_name}}<br></td>
                                                    </tr>
                                                @endif
                                                @if($sell_view->client_name)
                                                    <h4>{{ $sell_view->client_name }}</h4>
                                                @endif

                                                @if($sell_view->address)
                                                    {{ $sell_view->address }}<br>
                                                @endif

                                                @if($sell_view->contact_no)
                                                    {{ $sell_view->contact_no }}
                                                @endif
                                            </div>

                                            <div class="col-md-6" style="font-size: 16px">
{{--                                                <h4>CHALLAN</h4>--}}
                                                <b>Memo No:</b>{{$sell_view->memo_no }}<br>
                                                <b>Ref No:</b>{{$sell_view->ref_no }}<br>
                                                <b>Date : </b> <?=date('d-M-Y',$sell_view->entry_date)?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered zero-configuration">

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
                                                    @if(sizeof($single_sale_entries) > 0)
                                                        <?php $i = 1; $total_quantity = 0;?>
                                                        @foreach($single_sale_entries as $single_sale_entry)

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
                                                                <td>{{$single_sale_entry->product_rate}}</td>
                                                                <td>{{$single_sale_entry->total}}</td>
                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td style="color: red">Data not found ....</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                    <?php
                                                    if($sell_view->discount != 0 && $sell_view->vat != 0 && $sell_view->tax != 0)
                                                    {
                                                        $row_span = 4;
                                                    }
                                                    else if($sell_view->discount != 0 && $sell_view->vat != 0 || $sell_view->discount != 0 && $sell_view->tax != 0 || $sell_view->tax != 0 && $sell_view->vat != 0)
                                                    {
                                                        $row_span = 3;
                                                    }
                                                    else if($sell_view->discount != 0 || $sell_view->vat != 0 || $sell_view->tax != 0)
                                                    {
                                                        $row_span = 2;
                                                    }
                                                    else $row_span = 1;
                                                    ?>
                                                    <tr>
                                                        <td rowspan="<?=$row_span?>" colspan="2">

                                                        </td>
                                                        <td colspan="2" class="lower_parts_text_class">Total Amount</td>
                                                        <td class="lower_parts_class"><?=$sell_view->total_price?></td>
                                                    </tr>
                                                    @if($sell_view->discount != 0)
                                                    <tr >
                                                        <td colspan="2" class="lower_parts_text_class">Discount (-<?=$sell_view->discount_p?>%)</td>
                                                        <td class="lower_parts_class"><?=$sell_view->discount?></td>
                                                    </tr>
                                                    @endif
                                                    @if($sell_view->vat != 0)
                                                    <tr >
                                                        <td colspan="2" class="lower_parts_text_class">Vat (+<?=$sell_view->vat_p?>%)</td>
                                                        <td class="lower_parts_class"><?=$sell_view->vat?></td>
                                                    </tr>
                                                    @endif
                                                    @if($sell_view->tax != 0)
                                                    <tr >
                                                        <td colspan="2" class="lower_parts_text_class">Tax (+<?=$sell_view->tax_p ?>%)</td>
                                                        <td class="lower_parts_class"><?=$sell_view->tax ?></td>
                                                    </tr>
                                                    @endif

                                                    <?php
                                                    $paid_info = \Illuminate\Support\Facades\DB::table('entries')->select('dr_total')->where('sale_purchase_id', 'sale_received_'.$id)->first();
                                                    ?>

                                                    @if(!empty($paid_info))
                                                        <tr >
                                                            <td colspan="2"></td>
                                                            <td colspan="2" class="lower_parts_text_class">Paid Amount</td>
                                                            <td class="lower_parts_class"><?=$paid_info->dr_total?></td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td colspan="2" class="">
                                                        <?php
                                                        $t = $sell_view->due;
                                                        $tt = str_replace(",","", $t);
//                                                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
//                                                        $n = $f->format($tt);

                                                        //$ntw = new \NTWIndia\NTWIndia();
                                                        //$n = $ntw->numToWord( $tt );
                                                        ?>
                                                        <!-- <p class="balance_words"><b>Total: <?php //echo ucfirst($n)?> Taka Only</b></p>						 -->
                                                            <b class="text-left"><?=ucwords($n)?> Taka Only</b>
                                                        </td>
                                                        <td colspan="2" class="lower_parts_text_class"><b>Grand Total</b></td>
                                                        <td class="lower_parts_class"><b><?=$sell_view->due ?></b></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>



                                        <div style="margin-top: 10px">
                                            <a href="{{url('print_bill_report/'.$id)}}"  target="_blank" class="btn btn-primary">Print</a>
                                            <a href="{{ url('print_office_copy_report/'.$id) }}" target="_blank" class="btn btn-primary text-center" >Print Office Copy</a>
                                            <a href="{{ url('edit_memo/'.$id) }}" class="btn btn-primary text-center">Edit</a>
                                            <a href="{{ url('create_sell') }}" class="btn btn-primary text-center">Create Sale</a>
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
