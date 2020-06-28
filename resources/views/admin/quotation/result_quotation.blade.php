@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Merge Quotation Bill</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-green">
                <div class="panel-heading">
                    Merge Quotation Bill
                </div>
                <div class="panel-body">
                    <ul>
                        <?php

                        $discount = 0; $vat = 0; $tax = 0; $total = 0;

                        foreach($quotation_result as $ac) {

                        ?>
                        <p><label>Ref:<?php $pname = strtoupper(substr($ac->username,0,3)).date('dmy',$ac->entry_date).'QB'.$memo_no; echo $pname?></label>
                            <label>Bill</label>
                            <label>Date: <?=date('d-M-Y',$ac->entry_date)?></label></p>
                        <li>To,</li>
                        <?php $name = $ac->client_name; $show_name = str_replace(';', '<br>', $name) ?>
                        <li><?=$show_name?> </li>
                    <!-- <li><?php //echo $ac['company_name']?> </li> -->
                        <?php if($ac->address) { ?> <li><?=$ac->address?> </li> <?php } ?>
                        <?php if($ac->email) { ?> <li>Email: <?=$ac->email?></li> <?php } ?>
                        <?php if($ac->contact_no) { ?> <li>Contact No: <?=$ac->contact_no?></li> <?php } ?>
                        <li><strong>Ref. Quotation No: <?=$ac->ref_no?></strong></li>
                    </ul>




                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td><b>SL No.</b></td>
                            <td><b>Product Description</b></td>
                            <td><b>Quantity</b></td>
                            <td><b>Rate</b></td>
                            <td><b>Total</b></td>
                        </tr>
                        </thead>
                        <?php
                        $i=1;
                        foreach ($product_info as $element) {?>
                        <tr>
                            <td><?=$i?></td>

                            <td><?=$element['type'].'<br>'.$element['name'].'<br>'.$element['description']?></td>
                            <td><?=$element['quantity']?></td>
                            <td><?=$element['rate']?></td>
                            <?php $p = $element['rate']; $q = str_replace(",","", $p); ?>
                            <td><?=number_format($element['quantity']*$q,2)?></td>
                        </tr>

                        <?php
                        $i++;

                        }

                        $discount += str_replace(',','',$ac->discount);
                        $vat += str_replace(',','',$ac->vat);
                        $tax += str_replace(',','',$ac->tax);
                        //var_dump($aq);die;
                        $total += str_replace(',','',$ac->total_price);


                        $grand_total = ($total-$discount+$vat+$tax);
                        ?>
                        <?php

                        if($discount != 0 && $vat != 0 && $tax != 0)
                        {
                            $row_span = 4;
                        }
                        else if($discount != 0 && $vat != 0 || $discount != 0 && $tax != 0 || $tax != 0 && $vat != 0)
                        {
                            $row_span = 3;
                        }
                        else if($discount != 0 || $vat != 0 || $tax != 0)
                        {
                            $row_span = 2;
                        }
                        else $row_span = 1;
                        ?>
                        <tr>
                            <td rowspan="<?=$row_span?>" colspan="2">
                            <?php
                            $t = $grand_total; $tt = str_replace(",","", $t);
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            $n = $f->format($tt);
                            // $n = $t;
                            ?>
                            <!-- <p class="balance_words"><b>Total: <?php //echo ucfirst($n)?> Taka Only</b></p>						 -->
                                <center><b><?=ucwords($n)?> Taka Only</b></center>
                            </td>
                            <td colspan="2" class="lower_parts_text_class">Total Amount</td>
                            <td class="lower_parts_class"><?=number_format($total,2)?></td>
                        </tr>
                        <tr class="<?php if($discount == 0) echo 'hide'; ?>">
                            <td colspan="2" class="lower_parts_text_class">Discount</td>
                            <td class="lower_parts_class"><?=number_format($discount,2)?></td>
                        </tr>
                        <tr class="<?php if($vat == 0) echo 'hide'; ?>">
                            <td colspan="2" class="lower_parts_text_class">Vat</td>
                            <td class="lower_parts_class"><?=number_format($vat,2)?></td>
                        </tr>
                        <tr class="<?php if($tax == 0) echo 'hide'; ?>">
                            <td colspan="2" class="lower_parts_text_class">Tax</td>
                            <td class="lower_parts_class"><?=number_format($tax,2)?></td>
                        </tr>

                        <?php //if($ac['vat'] != 0) {
                        //echo "<tr><td colspan=\"2\" class=\"lower_parts_text_class\"> <b>Vat</b></td><td class=\"lower_parts_class\"><b>$ac[vat]</b></td></tr>";
                        //}
                        ?>
                        <?php //if($ac['tax'] != 0) {
                        //echo "<tr><td colspan=\"2\" class=\"lower_parts_text_class\"> <b>Tax</b></td><td class=\"lower_parts_class\"><b>$ac[tax]</b></td></tr>";
                        //}
                        ?>
                        <tr>
                            <td colspan="4" class="lower_parts_text_class"><b>Grand Total</b></td>
                            <td class="lower_parts_class"><b><?=number_format($grand_total,2)?></b></td>
                        </tr>

                        <?php } ?>

                    </table>

                    <div class="terms <?php if($ac->terms == '') echo 'hide' ?>">
                        <label>Remarks</label><br>
                        <?php $term1 = $ac->terms; $term = str_replace(';','<br>&#8226 ', $term1); ?>
                        <p><?php echo '&#8226 '.$term; ?></p>
                    </div>
                    <div class="terms">
                        <p>
                            Thanking you and assuring of our best service at all time.<br><br/>
                            ------------<br/>
                            <?php echo '<b>'.ucfirst($ac->username).'</b>'; ?>
                        </p>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @stop