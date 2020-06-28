@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning">Supplier Ledger</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <center><h2><?php echo $name->company_name ?></h2></center>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Purchase</div>
        <div class="panel-body">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td><b>Date</b></td>
                        <td><b>Memo No:</b></td>
                        <td><b>Amount(Inc. Discount, VAT & TAX)</b></td>
                        <td><b>Discount</b></td>
                        <td><b>Vat</b></td>
                        <td><b>Tax</b></td>
                        <td><b>View</b></td>
                    </tr>
                    </thead>
                    <?php
                    $total = 0; $t_dis = 0; $t_vat = 0; $t_tax = 0;
                    foreach($purchase as $value) { ?>
                    <tr>
                        <td><?=date('d-M-Y',$value->entry_date)?></td>
                        <td><?=$value->id?></td>
                        <?php $p = str_replace(",", "", $value->total); $q = str_replace(",", "", $value->discount ); $s = str_replace(",", "", $value->vat ); $t = str_replace(",", "", $value->tax );?>
                        <td><?=$value->total?></td>
                        <td><?=$value->discount?></td>
                        <td><?=$value->vat?></td>
                        <td><?=$value->tax?></td>
                        <td><a href="{{ url('show_purchase_Byid/'.$value->id) }}" type="button" class="btn btn-info">View</a></td>
                    </tr>
                    <?php $total = $total + $p; $t_dis = $t_dis + $q; $t_vat = $t_vat + $s; $t_tax = $t_tax + $t;} ?>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td><b><?php echo number_format($total,2);  ?></b></td>
                        <td><b><?php echo number_format($t_dis,2);  ?></b></td>
                        <td><b><?php echo number_format($t_vat,2);  ?></b></td>
                        <td><b><?php echo number_format($t_tax,2);  ?></b></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">Purchase Return</div>
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
                    foreach($purchase_return as $value2) { ?>
                    <tr>
                        <td><?=date('d-M-Y',$value2->entry_date)?></td>
                        <td><?=$value2->id?></td>
                        <?php $r = str_replace(",", "", $value2->total);?>
                        <td><?=$value2->total?></td>
                        <td><a href="{{ url('return_view/'.$value2->id) }}" type="button" class="btn btn-info">View</a></td>
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
        <div class="panel-heading">Purchase Return</div>
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
                        <td><?=$value2->id?></td>
                        <td><?=$value2->memo_no?></td>
                        <td><?=$value2->payment_type?></td>
                        <td><?=number_format($value2->amount,2)?></td>
                        <td><a href="expense_view.php?id=<?=$value2->id?>" type="button" class="btn btn-default">View</a></td>
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
                        <td>
                            <?php $due = $total - $total2 - $total3; ?>
                            <p><b><?php echo number_format($due,2); ?></b></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @stop