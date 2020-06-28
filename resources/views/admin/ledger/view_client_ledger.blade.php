@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Client Ledger</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <center><h2><?php  echo $client_info->company_name; ?></h2></center>
            <center><p><?php echo $client_info->address ?></p></center>
        </div>
    </div>


    <div class="panel panel-info">
        <div class="panel-heading">Invoice</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td><b>Date</b></td>
                        <td><b>Memo No:</b></td>
                        <td><b>Total(Exc. Discount, VAT & TAX)</b></td>
                        <td><b>Discount</b></td>
                        <td><b>Vat</b></td>
                        <td><b>Tax</b></td>
                        <td><b>Due</b></td>
                        <td><b>View</b></td>
                    </tr>
                    </thead>
                    <?php
                    $total = 0;	$t_dis = 0; $t_vat = 0; $t_tax = 0; $t_due = 0;
                    foreach($invoice_info as $value) { ?>
                    <tr>
                        <td><?=date('d-M-Y',$value->entry_date)?></td>
                        <td><?=$value->id?></td>
                        <?php $p = str_replace(",", "", $value->total_price); $q = str_replace(",", "", $value->discount ); $r = str_replace(",", "", $value->due ); $s = str_replace(",", "", $value->vat ); $t = str_replace(",", "", $value->tax );?>
                        <td><?=$value->total_price?></td>
                        <td><?=$value->discount?></td>
                        <td><?=$value->vat?></td>
                        <td><?=$value->tax?></td>
                        <td><?=$value->due?></td>
                        <td><a href="{{ url('show_bill/'.$value->id) }}" class="btn btn-info text-center">View</a></td>
                    </tr>
                    <?php $total = $total + $p; $t_dis = $t_dis + $q; $t_vat = $t_vat + $s; $t_tax = $t_tax + $t; $t_due = $t_due + $r; } ?>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td><b><?php echo number_format($total,2);  ?></b></td>
                        <td><b><?php echo number_format($t_dis,2);  ?></b></td>
                        <td><b><?php echo number_format($t_vat,2);  ?></b></td>
                        <td><b><?php echo number_format($t_tax,2);  ?></b></td>
                        <td><b><?php echo number_format($t_due,2);  ?></b></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Return Invoice</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td><b>Date</b></td>
                        <td><b>Memo No:</b></td>
                        <td><b>Amount</b></td>
                        <td><b>View</b></td>
                    </tr>
                    </thead>
                    <?php
                    $total3 = 0;
                    foreach($return_invoice as $value) { ?>
                    <tr>
                        <td><?=date('d-M-Y',$value->entry_date)?></td>
                        <td><?=$value->id?></td>
                        <?php $r = str_replace(",", "", $value->total_payable);?>
                        <td><?=$value->total_payable?></td>
                        <td><a href="{{ url('view_bill/'.$value->id) }}" class="btn btn-info text-center">View</a></td>
                    </tr>
                    <?php $total3 = $total3 + $r; } ?>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td><b><?php echo number_format($total3,2);  ?></b></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Payments</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td><b>Date</b></td>
                        <td><b>Payment No.</b></td>
                        <td><b>Against Bill No.</b></td>
                        <td><b>Method</b></td>
                        <td><b>Amount</b></td>
                        <td><b>View</b></td>
                    </tr>
                    </thead>
                    <?php
                    $total2 = 0;
                    foreach($payments as $value2) { ?>
                    <tr>
                        <td><?=date('d-M-Y',$value2->entry_date)?></td>
                        <td><?=$value2->id ?></td>
                        <td><?=$value2->memo_no ?></td>
                        <td><?=$value2->payment_type ?></td>
                        <td><?=number_format($value2->amount,2)?></td>
                        <td><a href="{{ url('payment_view/'.$value2->id) }}" class="btn btn-info text-center">View</a></td>
                    </tr>
                    <?php $total2 = $total2 + $value2->amount; } ?>
                    <tr>
                        <td colspan="4"><b>Total Paid</b></td>
                        <td><?php echo number_format($total2,2);  ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-danger">
        <div class="panel-heading">Due</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <td><b>Due</b></td>
                        <td><?php $due = $t_due - $total2 - $total3; ?>
                            <p><b><?php echo number_format($due,2); ?></b></p></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    @stop