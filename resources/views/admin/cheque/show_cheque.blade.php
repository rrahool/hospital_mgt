@extends('admin.master')

@section('mainContend')
       <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header text-warning">Check Manager</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

       <div class="row">
           <div class="col-md-12">
               @include('admin.includes.error')
           </div>
       </div>

        <div class="panel panel-info">
            <div class="panel-heading text-dark">Supplier Cheque</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::open(['url'=>'supplier_cheque_report','method'=>'post']) }}
                            <div class="form-group col-lg-3">
                                <label>Start Date</label>
                                <input type="date" class="form-control" placeholder="" name="date1" required/>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>End Date</label>
                                <input type="date" class="form-control" placeholder="" name="date2" required/>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Supplier</label>
                                <select class="form-control" name="supplier_id">
                                    <option value="0"></option>
                                    @foreach($select_supplier as $value)
                                        <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <button type="submit" class="form-control btn btn-warning btn-block" style="margin-top:25px!important;">Search</button>
                            </div>
                        {{ Form::close() }}
                    </div>

                </div>
                <!-- /.row (nested) -->
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading text-warning">
                        Supplier Cheques
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Supplier Company Name</th>
                                    <th>Bank Name</th>
                                    <th>Cheque No</th>
                                    <th>Issue Date</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach($supplier_cheque as $value)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ ucfirst($value->supplier_name) }}<br>{{ $value->company_name }}</td>
                                    <td>{{ $value->bank_name }}</td>
                                    <td>{{ $value->cheque_no }}</td>
                                    <td>{{ date('d-M-Y',$value->issue_date) }}</td>
                                    <td>{{ date('d-M-Y',$value->payment_date) }}</td>
                                    <td>{{ $value->status }}</td>
                                    <td>
                                        <a href="{{ url('supplier_cheque_edit/'.$value->id) }}" class="btn btn-warning text-center">Edit</a>
                                    </td>
                                </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

       <div class="panel panel-info">
           <div class="panel-heading text-dark">Client Cheque</div>
           <div class="panel-body">
               <div class="row">
                   <div class="col-lg-12">
                       {{ Form::open(['url'=>'client_cheque_report','method'=>'post']) }}
                       <div class="form-group col-lg-3">
                           <label>Start Date</label>
                           <input type="date" class="form-control" placeholder="" name="date1" required/>
                       </div>
                       <div class="form-group col-lg-3">
                           <label>End Date</label>
                           <input type="date" class="form-control" placeholder="" name="date2" required/>
                       </div>
                       <div class="form-group col-lg-3">
                           <label>Client</label>
                           <select class="form-control" name="client_id">
                               <option value="0"></option>
                               @foreach($select_client as $value)
                                   <option value="{{ $value->id }}">{{ $value->client_name }}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="form-group col-lg-3">
                           <button type="submit" class="form-control btn btn-warning btn-block" style="margin-top:25px!important;">Search</button>
                       </div>
                       {{ Form::close() }}
                   </div>

               </div>
               <!-- /.row (nested) -->
           </div>
       </div>
        <!-- /.row -->


       <div class="row">
           <div class="col-lg-12">
               <div class="panel panel-warning">
                   <div class="panel-heading text-warning">
                       Client Cheques
                   </div>
                   <!-- /.panel-heading -->
                   <div class="panel-body">
                       <div class="dataTable_wrapper">
                           <table class="table table-bordered table-hover" id="dataTables-example">
                               <thead>
                               <tr>
                                   <th>Serial No.</th>
                                   <th>Client Name</th>
                                   <th>Bank Name</th>
                                   <th>Cheque No</th>
                                   <th>Issue Date</th>
                                   <th>Payment Date</th>
                                   <th>Status</th>
                                   <th>Edit</th>
                               </tr>
                               </thead>
                               <tbody>
                               <?php $i = 1; ?>
                               @foreach($client_cheque as $value)
                                   <tr>
                                       <td>{{ $i++ }}</td>
                                       <td>{{ $value->client_name }}</td>
                                       <td>{{ $value->bank_name }}</td>
                                       <td>{{ $value->cheque_no}}</td>
                                       <td>{{ date('d-M-Y',$value->issue_date) }}</td>
                                       <td>{{ date('d-M-Y',$value->payment_date) }}</td>
                                       <td>{{ $value->status }}</td>
                                       <td><a href="{{ url('client_cheque_edit/'.$value->id) }}" class="btn btn-warning text-center">Edit</a></td>
                                   </tr>
                               @endforeach

                               </tbody>
                           </table>
                       </div>
                       <!-- /.table-responsive -->

                   </div>
                   <!-- /.panel-body -->
               </div>
               <!-- /.panel -->
           </div>
           <!-- /.col-lg-12 -->
       </div>

       <div class="row">
           <div class="col-lg-12">
               <div class="panel panel-warning">
                   <div class="panel-heading text-warning">
                       Official Cheques
                   </div>
                   <!-- /.panel-heading -->
                   <div class="panel-body">
                       <div class="dataTable_wrapper">
                           <table class="table table-bordered table-hover" id="dataTables-example">
                               <thead>
                               <tr>
                                   <td>Serial No.</td>
                                   <td>Expense Type</td>
                                   <td>Bank Name</td>
                                   <td>Cheque No.</td>
                                   <td>Issue date</td>
                                   <td>Payment Date</td>
                                   <td>Status</td>
                                   <td>Edit</td>
                               </tr>
                               </thead>
                               <tbody>
                               <?php $i = 1; ?>
                               @foreach($officialCheque as $value)
                                   <tr>
                                       <td>{{ $i++ }}</td>
                                       <td>{{ $value->payment_type }}</td>
                                       <td>{{ $value->bank_name }}</td>
                                       <td>{{ $value->cheque_no}}</td>
                                       <td>{{ date('d-M-Y',$value->issue_date) }}</td>
                                       <td>{{ date('d-M-Y',$value->payment_date) }}</td>
                                       <td>{{ $value->status }}</td>
                                       <td><a href="{{ url('official_cheque_edit/'.$value->id) }}" class="btn btn-warning text-center">Edit</a></td>
                                   </tr>
                               @endforeach

                               </tbody>
                           </table>
                       </div>
                       <!-- /.table-responsive -->

                   </div>
                   <!-- /.panel-body -->
               </div>
               <!-- /.panel -->
           </div>
           <!-- /.col-lg-12 -->
       </div>



    @stop