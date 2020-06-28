@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Sale History</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Return Bill Lists</h4>
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
                                        <th>Memo No.</th>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($returnList as $value)
                                        <tr class="odd gradeX">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ date('d-M-Y',$value->entry_date) }}</td>
                                            <td>{{ $value->client_name }}</td>
                                            <td>
                                                <a href="{{ url('view_bill/'.$value->id) }}" class="btn btn-success text-center">View Bill</a>
                                                <a href="{{ url('return_challan/'.$value->id) }}" class="btn btn-success text-center">View MRR</a>
                                            </td>
                                        </tr>

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


    @endsection
