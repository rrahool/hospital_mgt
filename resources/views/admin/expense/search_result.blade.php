@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Expense Search Result</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Expense Search Result
                </div>
                <div class="panel-body">
                    <div class="row">

                            <div>
                                <p> Expense History of <b>
                                        <?php
                                        if ($date1!= "" && $date2!= "") { echo date('d-m-Y',$date1)." - ".date('d-m-Y',$date2)." | "; }

                                        if ($expense_type){
                                            echo $expense_type->name." | ";
                                        }

                                        if ($project){
                                            echo $project->project_name;
                                        }

                                        ?>
                                    </b></p>
                            </div>


                            <div id="printThisExpenseArea">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Entry No.</b></td>
                                        <td><b>Date</b></td>
                                        <td><b>Expense Type</b></td>
                                        <td><b>Project Type</b></td>
                                        <td><b>Payment Method</b></td>
                                        <td><b>Amount</b></td>
                                    </tr>
                                    <?php  $total_amount = 0; foreach($expense_search as $each) { ?>
                                    <tr>
                                        <td><?=$each->id;?></td>
                                        <td><?=date('d-M-Y',$each->entry_date);?></td>
                                        <td><?php if($each->name ==''){echo 'Payment';}else {echo $each->name;}?></td>
                                        <td><?=$each->project_name;?></td>
                                        <td><?=$each->payment_type;?></td>
                                        <td><?=number_format($each->amount,2);?></td>
                                        <?php $total_amount = $total_amount+$each->amount?>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <label>Total:</label><?php echo ' '.number_format($total_amount,2).' /='; ?>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop