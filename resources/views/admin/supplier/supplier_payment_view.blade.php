@extends('admin.master')

@section('mainContend')


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning"> Expense view</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-user-secret"></i> Expense view</div>
                <div class="panel-body">



                    <table class="table table-bordered">
                            <?php foreach ($paymen_show as $data) { ?>
                            <?php $span = 2; if( $data->payment_type == 'cheque') { $span = 3; }?>
                            <tr>
                                <td><b><?php echo ($data->exp_pay == 'payment')?'Payment':ucfirst($data->name);  ?></b></td>
                                <td><b><?php echo date('d-M-Y',$data->entry_date) ?></b></td>
                                <td><b>Voucher No.: </b><?php echo "<b>EV ".$data->id."</b>" ?></td>
                            </tr>
                            <tr>
                                <td><b>Paid By:</b><?php echo " ".ucfirst($data->username) ?></td>
                                <td><b>Payment:</b><?php echo " ".ucfirst($data->payment_type) ?></td>
                                <td rowspan="<?php echo $span ?>" class="text-center"><?php echo $data->description ?></td>
                            </tr>
                            <?php if($data->payment_type == 'cheque') { ?>
                            <tr>
                                <td><b>Bank Name:</b><?php echo " ".ucfirst($data->bank_name) ?></td>
                                <td><b>Cheque No.:</b><?php echo " ".ucfirst($data->cheque_no) ?></td>
                            </tr>
                            <?php } ?>
                            <?php
                            $t = $data->amount;
                            $tt = str_replace(",","", $t);
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            $n = $f->format($tt);
                            ?>
                            <tr>
                                <td>
                                    <b>Paid To:</b>
                                    <?php
                                    if($data->paid_to)
                                    {
                                        echo " ".ucfirst($data->paid_to);
                                    }
                                    if($data->supplier_name)
                                    {
                                        $string = $data->supplier_name;
                                        $pos = strpos($string, ';');
                                        if($pos)
                                        {
                                            $name = substr($string, 0, $pos);
                                            echo " ".ucfirst($name);
                                        }
                                        else echo $string;
                                    }
                                    ?>
                                </td>
                                <td colspan=""><b>Amount:</b> <?php echo $data->amount."/=" ?> (<?php echo ucfirst($n)." taka only"?>)</td>
                                <!-- <td></td> -->
                            </tr>
                            <?php } ?>
                        </table>

                        <div class="col-md-12">
                            <div class="pull-left"><u>Received by</u></div>
                            <div class="pull-right"><u>Authorised by</u></div>
                            <div></div>
                            <br><br><br>
                        </div>

                </div>
            </div>
        </div>
    </div>


    @stop
