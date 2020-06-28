@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning"> Show Client</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-user"></i> Show Client</div>
                <div class="panel-body">
                    <table class="table table-bordered">

                        @if(!is_null($showById))
                        <tr>
                            <th class="">Supplier Name : </th>
                            <th style="padding-left: 8px"> {{ ucfirst($showById->client_name) }} </th>
                        </tr>
                        <tr>
                            <th class="col-md-2">Company Name : </th>
                            <th style="padding-left: 8px">{{ ucfirst($showById->company_name) }} </th>
                        </tr>

                        <tr>
                            <th class="col-md-2">E-mail : </th>
                            <th style="padding-left: 8px"> {{ $showById->email }} </th>
                        </tr>
                        <tr>
                            <th class="col-md-2">Contact No : </th>
                            <th style="padding-left: 8px"> {{ $showById->contact_no }} </th>
                        </tr>
                        <tr>
                            <th class="col-md-2">Address : </th>
                            <th style="padding-left: 8px">{{ ucwords($showById->address) }} </th>
                        </tr>

                        <tr>
                            <th class="col-md-2">Provide By : </th>
                            <th style="padding-left: 8px">{{ ucfirst($showById->username) }} </th>
                        </tr>
                            @else
                            <i style="color: red">Null value here, Null is users id...</i>
                            @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    @stop