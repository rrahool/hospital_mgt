@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Client Cheque</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Client Cheque</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">


                    <tr>
                        <td><b>Serial No.</b></td>
                        <td><b>Client Name</b></td>
                        <td><b>Bank Name</b></td>
                        <td><b>Cheque No.</b></td>
                        <td><b>Issue date</b></td>
                        <td><b>Payment Date</b></td>
                        <td><b>Status</b></td>

                    </tr>



                    <?php $i=1;  foreach($client_cheque as $each) { ?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$each->client_name;?></td>
                        <td><?=$each->bank_name;?></td>
                        <td><?=$each->cheque_no;?></td>
                        <td><?=date('d-m-Y',$each->issue_date)?></td>
                        <td><?=date('d-m-Y',$each->payment_date)?></td>
                        <td><?=$each->status;?></td>


                    </tr>
                    <?php } ?>
                </table>

                <div class="col-md-12">
                    <a href="{{ url('cheque_manager') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>  Back</a>
                </div>
            </div>
        </div>
    </div>

    @stop