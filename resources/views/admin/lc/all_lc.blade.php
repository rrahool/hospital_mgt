@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Product List</h4>
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
                                        <th>Sl No.</th>
                                        <th>L/C ID</th>
                                        <th>L/C No</th>
                                        <th>Importer Name</th>
                                        <th>Beneficiary</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=1 ; ?>
                                    @foreach($all_lc as $value)
                                        <tr class="gradeU">
                                            <td>{{ $i }}</td>
                                            <td>{{ $value->lc_id }}</td>
                                            <td>{{ $value->lc_no }}</td>
                                            <td>{{ $value->importer_name }}</td>
                                            <td >{{$value->beneficiary }}</td>
                                            <td >
{{--                                                <a href="{{ url('lc_show/'.$value->id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>--}}
                                                <a href="{{ url('lc_edit/'.$value->id) }}" class="btn btn-success text-center"><i class="fa fa-edit"></i></a>
                                                <a href="{{ url('lc_delete/'.$value->id) }}" class="btn btn-danger text-center" onclick="return confirm('Are you sure to delete this?')"><i class="fa fa-trash" ></i></a></td>

                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>L/C ID</th>
                                        <th>L/C No</th>
                                        <th>Importer Name</th>
                                        <th>Beneficiary</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
