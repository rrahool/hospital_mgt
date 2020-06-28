@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Purchase Memo</h4>
                            </div>
                            @if($showInfo)

                            <div class="basic-list-group">
                                <ul class="list-group">
                                    <li class="list-group-item active">Purchase Information</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-8" style="font-size: 16px">

                                                Supplier Name : {{ $showInfo->supplier_name }}<br>
                                                @if($showInfo->executive_name)
                                                    Executive Name : {{ $showInfo->executive_name }}<br>
                                                @endif
                                                @if($showInfo->address)
                                                    Address : {{ $showInfo->address }}<br>
                                                @endif
                                                @if($showInfo->email)
                                                    E-mail : {{ $showInfo->email}}<br>
                                                @endif
                                                @if($showInfo->remarks != null)
                                                    Remarks : {{ $showInfo->remarks }} <br>
                                                @endif


                                            </div>

                                            <div class="col-md-4" style="font-size: 16px">
                                                @if($showInfo->contact_no)
                                                    Contact : {{ $showInfo->contact_no }}<br>
                                                @endif

                                                @if($showInfo->memo_no)
                                                    Supplier Memo No : {{ $showInfo->memo_no }} <br>
                                                @endif

                                                Ref : <strong>P-{{ $showInfo->pid }}</strong> <br>
                                                Date : {{ date('d-M-Y',$showInfo->entry_date) }}<br>
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
                                                    @if(sizeof($single_purchases) > 0)
                                                        <?php $i = 1; ?>
                                                    @foreach($single_purchases as $single_purchase)

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
                                                        <td>{{$showInfo->total}}</td>
                                                    </tr>

                                                    <?php
                                                    if($showInfo->discount != 0 && $showInfo->vat != 0 && $showInfo->tax != 0)
                                                    {
                                                        $row_span = 4;
                                                    }
                                                    else if($showInfo->discount != 0 && $showInfo->vat != 0 || $showInfo->discount != 0 && $showInfo->tax != 0 || $showInfo->tax != 0 && $showInfo->vat != 0)
                                                    {
                                                        $row_span = 3;
                                                    }
                                                    else if($showInfo->discount != 0 || $showInfo->vat != 0 || $showInfo->tax != 0)
                                                    {
                                                        $row_span = 2;
                                                    }
                                                    else $row_span = 1;
                                                    ?>

                                                    @if($showInfo->discount != 0)
                                                        <tr>
                                                           <td colspan="3"></td>
                                                            <td >Discount (-{{$showInfo->discount_p}}%)</td>
                                                            <td class="lower_parts_class">{{$showInfo->discount}} </td>
                                                        </tr>
                                                    @endif

                                                    @if($showInfo->vat != 0)
                                                        <tr>
                                                           <td colspan="3"></td>
                                                            <td >VAT (+{{$showInfo->vat_p}}%)</td>
                                                            <td class="lower_parts_class"><b>{{$showInfo->vat}} </td>
                                                        </tr>
                                                    @endif

                                                    @if($showInfo->tax != 0)
                                                        <tr>
                                                           <td colspan="3"></td>
                                                            <td >TAX (+{{$showInfo->tax_p}}%)</td>
                                                            <td class="lower_parts_class">{{$showInfo->tax}}</td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td rowspan="<?=$row_span?>" colspan="3">
                                                        <?php
                                                        $due = 0;
                                                        $due += str_replace(",","", $showInfo->total);
                                                        $due -= str_replace(",","", $showInfo->discount);
                                                        $due += str_replace(",","", $showInfo->vat);
                                                        $due += str_replace(",","", $showInfo->tax);

                                                        //$t = $ac['due'];
                                                        $t = $due;
                                                        $tt = str_replace(",","", $t);


                                                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                            $n = $f->format($tt);
                                                        ?>
                                                            <center><b><?=ucfirst($n)?> Taka Only</b></center>
                                                        </td>

                                                        <td ><b>Grand Total</b></td>
                                                        <td class="lower_parts_class"><b><?=number_format($due, 2, '.', ',');//$ac['due']?></b></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>

                                                <br>

                                                <div style="margin-left: 15px; font-size: 16px">
                                                    <p>
                                                        Kindly acknowledge the receipt and take your necessary action.<br/><br/>
                                                        ------------<br/>
                                                        <?php echo '<b>'.ucfirst($showInfo->username).'</b>'; ?>
                                                    </p>
                                                </div>


                                            </div>
                                        </div>

                                        <a href="{{url('print_purchase_report/'.$id)}}" style="margin-top: 10px" class="btn btn-primary">Print</a>
                                        <a href="{{url('purchase_entry')}}" style="margin-top: 10px" class="btn btn-primary">Purchase Again</a>

                                    </li>
                                </ul>
                            </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @stop
