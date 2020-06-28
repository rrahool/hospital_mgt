@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Show Test Memo</h4>
                            </div>


                                <div class="basic-list-group">
                                    <ul class="list-group">
                                        <li class="list-group-item active">Show Test Memo</li>
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
                                                        <b style="font-size: 18px;">Refferer: </b>{{ $sell_view->client_name }}
                                                        <br>
                                                    @endif

                                                    @if($sell_view->address)
                                                        <b>Address:</b> {{ $sell_view->address }}<br>
                                                    @endif

                                                    @if($sell_view->contact_no)
                                                        <b>Mob No:</b> {{ $sell_view->contact_no }}
                                                    @endif
                                                </div>

                                                <div class="col-md-6" style="font-size: 16px">
                                                    <b>Ref No. </b><?php $pname = strtoupper(substr($sell_view->username,0,3)).date('dmy',$sell_view->entry_date).'C'.$sell_view->m_id; echo $pname?> <br>
                                                    <b>Date : </b> <?=date('d-M-Y',$sell_view->entry_date)?><br>
                                                    <b>Delivery Date : </b> <?=date('d-M-Y',$sell_view->delivery_date)?>
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

                                                        <tbody>
                                                        @if(sizeof($single_sale_entries) > 0)
                                                            <?php $i = 1; ?>
                                                            @foreach($single_sale_entries as $single_sale_entry)

                                                                <?php

                                                                $product_info = \Illuminate\Support\Facades\DB::table('product_info')->where('id', $single_sale_entry->product_id)->first();
                                                                $product_type_info = \Illuminate\Support\Facades\DB::table('catagory')->where('id', $single_sale_entry->product_type_id)->first();
                                                                ?>
                                                                <tr>
                                                                    <td>{{$i}}</td>
                                                                    <td>
                                                                        {{ $product_info->product_name }}<br>
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
                                                        </thead>
                                                    </table>

                                                    <br>
                                                    <div class="text-right" style=" margin-right: 15px">
                                                        <br/><br/>
                                                        ------------<br/>
                                                        <?php echo '<b >'.ucfirst($sell_view->username).'</b>'; ?>
                                                    </div>
                                                    <div class="text-center">
                                                        <p>
                                                            <small>Thanking you and assuring of our best service at all time.</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <a href="{{ url('print_bill_report/'.$id) }}" target="_blank" class="btn btn-linkedin text-center" style="margin-right: 5px">Print Customer Copy</a>
                                                <a href="{{ url('print_office_copy_report/'.$id) }}" target="_blank" class="btn btn-skype text-center" style="margin-right: 5px">Print Office Copy</a>
                                                <a href="{{ url('edit_memo/'.$id) }}" class="btn btn-google text-center" style="margin-right: 5px">Edit</a>
                                                <a href="{{ url('create_sell') }}" class="btn btn-primary text-center" >Create Sale</a>
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
