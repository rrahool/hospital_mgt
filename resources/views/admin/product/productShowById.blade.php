@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Show Product</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Product Name : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ ucfirst($productById->product_name )}} </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Product Brand : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ ucfirst($productById->brand )}} </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Product Type : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">{{ ucfirst($productById->cname) }} </th>
                                    </tr>

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Description : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ ucwords($productById->description) }} </th>
                                    </tr>

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Cost Price : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">Tk. {{ $productById->cost }} </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Sell Price : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">Tk. {{ $productById->sell }}  </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Min Sell Price : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">Tk. {{ $productById->min_price }}  </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Quantity Per Carton: </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">Tk. {{ $productById->qt_per_carton }}  </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Re Order Level : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">{{ $productById->alert_limit }}  </th>
                                    </tr>
                                    <tr class="row">
                                         <th class="col-md-4"><span style="margin-left: 8px">Creator : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ ucfirst($productById->creator_id) }} </th>
                                    </tr>

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Product Image : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">
                                            @if($productById->product_image == NULL)
                                                <img src="{{ asset('product_image/product_icon.png') }}" height="120px" width="120px">
                                            @else
                                                <img src="{{ asset($productById->product_image )}}" height="120px" width="120px">

                                            @endif

                                        </th>
                                    </tr>

                                </table>
                            </div>



                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
