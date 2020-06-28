@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-warning"> Client Payment View</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-user"></i> Client Payment View</div>
                <div class="panel-body">
                    <table class="table table-bordered">

                      <tr>
                          <td><strong>Receipt No : </strong>{{ strtoupper(substr($payment->username,0,3)).date('dmy',$payment->entry_date).'MR'.$payment->id }}</td>
                          <td><strong>Date : </strong>{{ date('d-M-Y',$payment->entry_date) }}</td>
                      </tr>

                        <tr>
                            <td colspan="2"><strong>Recived With</strong> Thanks From<i>&nbsp; {{ ucfirst($payment->client_name) }}</i></td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Against Memo No : </strong> {{ $payment->memo_no }}</td>
                        </tr>

                        @if(!empty($payment->remarks ))
                        <tr>
                            <td colspan="2"><strong>Remarks : </strong> {{ $payment->remarks }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td colspan="2"><strong>Payment Type : </strong> {{ strtoupper($payment->payment_type) }}</td>
                        </tr>

                        @if($payment->payment_type == 'cheque')

                            <tr>
                                <td><strong>Cheque No : </strong> {{ $payment->cheque_no }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bank Name : </strong> {{ $payment->bank_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Issue Date : </strong> {{ $payment->issue_date }}</td>
                            </tr>

                            @endif

                        <?php
                        $t = $payment->amount;
                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                        $n = $f->format($t);
                        ?>

                        <tr>
                            <td><strong>Amount : </strong> <?php echo (number_format($payment->amount,2));?> (<?php echo ucfirst($n); ?>)</td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>
    </div>
    @stop