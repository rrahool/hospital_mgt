@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">WareHouse Product List</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>WareHouse Product List</h4>
                            </div>


                            @if(session()->has('message.level'))
                                <div class="alert alert-{{ session('message.level') }}">
                                    {!! session('message.content') !!}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Warehouse</th>
                                        <th>Product</th>
                                        {{--<th>Company Name</th>--}}
                                        <th>Available Quantity</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=1; ?>
                                    @foreach($warehouses as $warehouse)
                                        <?php
                                            $warehouse_name = \Illuminate\Support\Facades\DB::table('warehouse')->where('id', $warehouse->warehouse_id)->first()->warehouse_name;
                                            $product_names = \Illuminate\Support\Facades\DB::table('warehouse_product')->select('product_info.product_name', 'warehouse_product.available_qt')->join('product_info', 'product_info.id', '=', 'warehouse_product.product_id')->where('warehouse_product.warehouse_id', $warehouse->warehouse_id)->get();
                                        ?>

                                        @foreach($product_names as $product_name)
                                            <tr class="odd gradeX">
                                                <td>{{$i}}</td>
                                                <td>{{ $warehouse_name }}</td>
                                                <td>{{$product_name->product_name}}</td>
                                                <td>{{$product_name->available_qt}}</td>
                                            </tr>
                                            <?php $i++;?>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
