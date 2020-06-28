
@extends('layout')

@section('main_content')
    <style>
        .input:focus {
            outline: none !important;
            border:1px solid #648FBE;
            box-shadow: 0 0 10px #719ECE;
        }
    </style>

    <div class="content-body">

        <div class="container-fluid">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Category</h4>
                            <div class="basic-form">
                                <form action="{{url('update_category')}}" method="post" >
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="cname" id="cname" class="input form-control" value="{{ $catValue->category_name }}" data-validation="required">
                                    </div>
                                    {{--<div class="form-group">
                                        <input type="text" name="products" id="products" data-validation="required" class="input form-control" value="{{ $catValue->products }}">
                                    </div>--}}
                                    <input type="hidden" name="id" value="{{ $catValue->id }}" data-validation="required">

                                    <input type="submit" name="save" class="btn btn-dark" value="Update">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
