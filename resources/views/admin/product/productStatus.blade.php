@extends('layout')

@section('main_content')

    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Product Status</h4>
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
                                        <th>Product Category</th>
                                        <th>Product Name</th>
                                        <th>Purchase</th>
                                        <th>Sale</th>
                                        <th>Purchase Return</th>
                                        <th>Sale Return</th>
                                        <th>Product Available</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info_arr as $key => $value)
                                        <?php
                                        $infos = $info_arr[$key];
                                        ?>

                                        @foreach($infos as  $info)
                                        <tr class="odd gradeX">
                                            <td>{{ $info['cat_name'] }}</td>
                                            <td>{{ $info['product_name'] }}</td>
                                            <td>{{ $info['purchase'] }}</td>
                                            <td>{{ $info['sale'] }}</td>
                                            <td>{{ $info['p_return'] }}</td>
                                            <td>{{ $info['s_return'] }}</td>
                                            <td class="center">{{ $info['available_qt'] }}</td>
                                        </tr>
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
    @endsection
