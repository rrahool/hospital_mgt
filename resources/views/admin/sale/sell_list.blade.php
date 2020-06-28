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
                                <h4>Sale List</h4>
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
                                        <th>SL No.</th>
                                        <th>Memo No.</th>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        {{--<th>Company Name</th>--}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=0; ?>
                                    @foreach($sell_list as $value)
                                        <?php $i++; ?>
                                        <tr class="odd gradeX">
                                            <td>{{ $i }}</td>
                                            <td>{{ $value->memo_no }}</td>
                                            <td>{{ date('d-M-Y', $value->entry_date) }}</td>
                                            <td>{{ $value->client_name }}</td>
                                            {{--<td>{{ $value->company_name }}</td>--}}
                                            <td>
                                                <a href="{{ url('sell_view_by/'.$value->id) }}" class="btn btn-primary text-center"><i class="fa fa-eye"></i></a>&nbsp;
                                                <a href="{{ url('customer_copy_bill/'.$value->id) }}" class="btn btn-linkedin text-center">Customer Copy</a>
                                                <a href="{{ url('office_copy_bill/'.$value->id) }}" class="btn btn-skype text-center">Office Copy</a>
                                                <a href="{{ url('edit_memo/'.$value->id) }}" class="btn btn-google text-center">Edit</a>
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


    @stop
