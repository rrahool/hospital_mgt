@extends('admin.master')

@section('mainContend')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Invoice Report</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Invoice Report</div>
                <div class="panel-body">

                    <div class="row">
                        <div>
                            <p> Purchase  History of <b>
                                    <?php
                                    echo $date1." - ".$date2 ;

                                    ?>
                                </b></p>
                        </div>



                        <table class="table table-bordered">
                            <tr>
                            <tr>
                                <td><b>Serial No.</b></td>
                                <td><b>Entry No.</b></td>

                                <td><b>Entry Date</b></td>

                                <td><b>Client Name</b></td>
                                <td><b>Amount</b></td>
                                <td><b>Vat</b></td>
                                <td><b>Tax</b></td>

                                <td><b>View</b></td>



                            </tr>
                            <?php $i=1; $total_amount = 0; $total_vat = 0; $total_tax = 0;  foreach($report as $each) { ?>
                            <tr>
                                <td><?=$i++;?></td>
                                <td><?=$each->id;?></td>
                                <td><?=date('d-M-Y',$each->entry_date);?></td>
                                <td><?php echo $each->client_name;?></td>
                                <td><?=$each->due;?></td>
                                <td><?=$each->vat;?></td>
                                <td><?=$each->tax;?></td>
                                <td>
                                    <a href="{{ url('show_bill/'.$each->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>&nbsp;
                                </td>
                                <?php $total_amount = $total_amount+str_replace(',', "", $each->due)?>
                                <?php $total_vat = $total_vat+str_replace(',', "", $each->vat)?>
                                <?php $total_tax = $total_tax+str_replace(',', "", $each->tax)?>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4"><b>Total</b></td>
                                <td><b><?php echo ' '.number_format($total_amount,2); ?></b></td>
                                <td><b><?php echo ' '.number_format($total_vat,2); ?></b></td>
                                <td><b><?php echo ' '.number_format($total_tax,2); ?></b></td>
                                <td></td></tr>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()