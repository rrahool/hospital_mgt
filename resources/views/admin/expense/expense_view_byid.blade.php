@extends('admin.master')

@section('mainContend')
    <div class="col-lg-12">
        <h1 class="page-header">Expense View</h1>
    </div>


    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">Expense View</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                    @foreach($expense_view_byid as $expense_view)
                        <?php $span = 2; if( $expense_view->payment_type == 'cheque') { $span = 3; }?>
                        <tr>
                            <td><b><?php echo ($expense_view->exp_pay == 'payment')?'Payment':ucfirst($expense_view->name);  ?></b></td>
                            <td><b><?php echo date('d-M-Y',$expense_view->entry_date) ?></b></td>
                            <td><b>Voucher No.: </b><?php echo "<b>EV ".$expense_view->id."</b>" ?></td>
                        </tr>
                        <tr>
                            <td><b>Paid By:</b><?php echo " ".ucfirst($expense_view->username) ?></td>
                            <td><b>Payment:</b><?php echo " ".ucfirst($expense_view->payment_type) ?></td>
                            <td rowspan="<?php echo $span ?>" class="text-center"><?php echo $expense_view->description ?></td>
                        </tr>
                        <?php if($expense_view->payment_type == 'cheque') { ?>
                        <tr>
                            <td><b>Bank Name:</b><?php echo " ".ucfirst($expense_view->bank_name) ?></td>
                            <td><b>Cheque No.:</b><?php echo " ".ucfirst($expense_view->cheque_no) ?></td>
                        </tr>
                        <?php } ?>
                        <?php
                        $t = $expense_view->amount; $tt = str_replace(",","", $t);
                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                        $n = $f->format($tt);

                        //$ntw = new \NTWIndia\NTWIndia();
                        //$n = $ntw->numToWord( $tt );
                        ?>
                        <tr>
                            <td>
                                <b>Paid To:</b>
                                <?php
                                if($expense_view->paid_to)
                                {
                                    echo " ".ucfirst($expense_view->paid_to);
                                }
                                if($expense_view->supplier_name)
                                {
                                    $string = $expense_view->supplier_name;
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
                            <td colspan=""><b>Amount:</b> <?php echo number_format($expense_view->amount,2,'.',',')."/=" ?> (<?php echo ucfirst($n)." taka only"?>)</td>
                            <!-- <td></td> -->
                        </tr>

                        @endforeach

                    </table>
                    <div class="col-md-offset-1 col-md-10">
                        <div class="pull-left">
                            Received by
                        </div>
                        <div class="pull-right">
                            Authorised by
                        </div>
                    </div>
                    <br><br><br>
                    <div class="col-md-offset-1 col-md-10">
                        @if($expense->exp_pay == 'payment')
                        @if(empty($expense_view->image))
                            <img src="{{ asset('product_image/expense/no-image-available.jpg') }}" height="280px" width="280px">
                        @else
                            <img src="{{ asset('product_image/expense/'.$expense_view->image) }}" height="280px" width="280px">
                        @endif
                            @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
    @stop