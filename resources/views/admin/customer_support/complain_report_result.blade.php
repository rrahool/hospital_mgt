@extends('admin.master')

@section('mainContend')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Date Range Complain Report</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Complain Report</div>
                <div class="panel-body">

                    <div class="row">

                        <div style="padding-left: 10px">
                            <p> Complain Entry History of <b>
                                    <?php
                                    echo $date1." - ".$date2 ;

                                    ?>
                                </b></p>
                        </div>

                        <table class="table table-bordered">

                            <thead>
                            <tr>
                                <td><b>Serial No.</b></td>
                                <td><b>Date</b></td>
                                <td><b>Client Name</b></td>
                                <td><b>Invoice No.</b></td>
                                <td><b>Complain</b></td>
                                <td><b>Creator</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($complain_report as $data) { ?>
                            <tr>
                                <td><?php echo $data->id ?></td>
                                <td><?php echo date('d-M-Y',$data->entry_date) ?></td>
                                <td><?php echo $data->client_name ?></td>
                                <td><?php echo $data->invoice ?></td>
                                <td><?php echo $data->complain ?></td>
                                <td><?php echo ucfirst($data->username) ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>



                </div>

            </div>
        </div>
    </div>
@stop()