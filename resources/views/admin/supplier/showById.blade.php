@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Show Supplier</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Supplier Name : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ ucwords($showById->supplier_name )}}</th>
                                    </tr>

                                    @if($showById->executive_name)
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Executive Name : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">{{ ucwords($showById->executive_name) }} </th>
                                    </tr>
                                    @endif

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Product Name : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">{{ ucwords($showById->products) }} </th>
                                    </tr>

                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">E-mail :</span> </th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ $showById->email }} </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Contact No : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px"> {{ $showById->contact_no }} </th>
                                    </tr>
                                    <tr class="row">
                                        <th class="col-md-4"><span style="margin-left: 8px">Address : </span></th>
                                        <th class="col-md-8" style="padding-left: 8px">{{ ucwords($showById->address) }} </th>
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
