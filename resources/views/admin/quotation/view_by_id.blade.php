@extends('admin.master')

@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Show Quotation</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel panel-info">
                <div class="panel-heading">Show Quotation</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <b>To,</b><br>

                                @if($quotation_info->client_name)
                                    {{ $quotation_info->client_name }}<br>
                                    @endif

                                @if($quotation_info->company_name)
                                    {{ $quotation_info->company_name }}<br>
                                    @endif

                                @if($quotation_info->address)
                                    {{ $quotation_info->address }}<br>
                                    @endif

                                @if($quotation_info->email)
                                    {{ $quotation_info->email }}<br>
                                    @endif

                                @if($quotation_info->contact_no)
                                    {{ $quotation_info->contact_no }}<br>
                                    @endif

                            </td>
                            <td>
                               <b>Ref : <?php $pname = strtoupper(substr($quotation_info->username,0,3)).date('dmy',$quotation_info->entry_date).'Q'.$quotation_info->q_id; echo $pname?></b><br>
                                Date : {{ date('d-M-Y',$quotation_info->entry_date) }}
                            </td>


                        </tr>

                    </table>
                    <br>

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

                        <?php $i=1;
                        foreach ($product_info as $element) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <?php $des = $element["description"]; $des_new = str_replace( ';' , '</br>', $des) ?>
                            <td><?=$element["cname"].'</br>'.$element["name"].'</br>'.$des_new?></td>
                            <td><?=$element["quantity"]?></td>
                            <td><?=$element["rate"]?></td>
                            <?php $p = $element["rate"]; $q = str_replace(",","", $p); ?>
                            <td><?=number_format($element["quantity"]*$q,2)?></td>
                        </tr>
                        <?php $i++; } ?>

                        <?php
                        if($quotation_info->discount != 0 && $quotation_info->vat != 0 && $quotation_info->tax != 0)
                        {
                            $row_span = 4;
                        }
                        else if($quotation_info->discount != 0 && $quotation_info->vat != 0 || $quotation_info->discount != 0 && $quotation_info->tax != 0 || $quotation_info->tax != 0 && $quotation_info->vat != 0)
                        {
                            $row_span = 3;
                        }
                        else if($quotation_info->discount != 0 || $quotation_info->vat != 0 || $quotation_info->tax != 0)
                        {
                            $row_span = 2;
                        }
                        else $row_span = 1;
                        ?>
                        <tr>
                            <td rowspan="<?=$row_span?>" colspan="2">
                            <?php
                            $t = $quotation_info->due;
                            $tt = str_replace(",","", $t);
                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                            $n = $f->format($tt);

                            //$ntw = new \NTWIndia\NTWIndia();
                            //$n = $ntw->numToWord( $tt );
                            ?>

                            </td>
                            <td colspan="2">Total Amount</td>
                            <td><?=$quotation_info->total?></td>
                        </tr>
                        <tr class="<?php if($quotation_info->discount == 0) echo 'hide'; ?>">
                            <td colspan="2">Discount (-<?=$quotation_info->discount_p ?>%)</td>
                            <td><?=$quotation_info->discount?></td>
                        </tr>
                        <tr class="<?php if($quotation_info->vat == 0) echo 'hide'; ?>">
                            <td colspan="2">Vat (+<?=$quotation_info->vat_p?>%)</td>
                            <td><?=$quotation_info->vat?></td>
                        </tr>
                        <tr class="<?php if($quotation_info->tax == 0) echo 'hide'; ?>">
                            <td colspan="2">Tax (+<?=$quotation_info->tax_p?>%)</td>
                            <td><?=$quotation_info->tax?></td>
                        </tr>
                        <tr>
                            <td rowspan="<?=$row_span?>" colspan="2"><center><b><?=ucwords($n)?> Taka Only</b></center></td>
                            <td colspan="2"><b>Grand Total</b></td>
                            <td><b><?=$quotation_info->due?></b></td>
                        </tr>

                    </table>

                    <br>
                    <div class="<?php if($quotation_info->terms == '') echo 'hide' ?>">
                        <label>Remarks</label><br>
                        <?php $term1 = $quotation_info->terms; $term = str_replace(';','<br>&#8226 ', $term1); ?>
                        <p><?php echo '&#8226 '.$term; ?></p>
                    </div>
                    <div>
                        <p>
                            Thanking you and assuring of our best service at all time.<br/><br/>
                            ------------<br/>
                            <?php echo '<b>'.ucfirst($quotation_info->username).'</b>'; ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop