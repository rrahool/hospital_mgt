@extends('layout')

@section('main_content')

    <style media="screen">
        .level-1{
            margin-left: 10px;
        }
        .level-2{
            margin-left: 20px;
        }
        .level-3{
            margin-left: 30px;
        }
        .level-4{
            margin-left: 40px;
        }
        .level-5{
            margin-left: 50px;
        }
        .level-6{
            margin-left: 60px;
        }
        .level-7{
            margin-left: 70px;
        }

        .level-7{
            margin-left: 80px;
        }

        .level-7{
            margin-left: 90px;
        }

        .level-7{
            margin-left: 100px;
        }


    </style>

    <?php


    function minValueInArray($array, $keyToSearch)
    {
        $currentMin = 100;
        foreach ($array as $arr) {
            foreach ($arr as $key => $value) {
                if ($key == $keyToSearch && ($value <= $currentMin)) {
                    $currentMin = $value;
                }
            }
        }
        return $currentMin;
    }



    function nested2ul($data, $i = 0)
    {

        $result = array();

        $i++;
        if (sizeof($data) > 0) {

//            if ($entry['parent_id'] == 0){
            $result[] = '<tr style="background: #7571F9; color: #ffffff">';
            foreach ($data as $entry) {
                //$checked = (in_array($entry['id'],$userItemList)) ? 'checked':'';
                if (isset($entry['children'])) {

                    if ($entry['parent_id'] == 0){
                        $class = 'level-'.$i;

                        $all_balance = \App\Ledger::select('op_balance', 'op_balance_dc')->where('group_id', $entry['id'])->get();
                        $balance = 0;
                        $grp_cl_balance = 0;

                        foreach ($all_balance as $bal){
                            if ($bal->op_balance_dc == 'D'){
                                $balance += $bal->op_balance;
                            }else{
                                $balance -= $bal->op_balance;
                            }
                        }
                        $dr_cr = ($balance>=0)?'Dr':'Cr';
                        $result[] = '<span><td ><span class="'.$class.' ">'.$entry['name'].'</span ></td>   <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td> <td>0.00</td> <td>0.00</td>  <td>0.00</td>  '.getLedger($entry['id'], $i).''.nested2ul($entry['children'], $i);
                        //$i++;
                    }else{

                        $all_balance = \App\Ledger::select('op_balance', 'op_balance_dc')->where('group_id', $entry['id'])->get();
                        $balance = 0;

                        foreach ($all_balance as $bal){
                            if ($bal->op_balance_dc == 'D'){
                                $balance += $bal->op_balance;
                            }else{
                                $balance -= $bal->op_balance;
                            }
                        }
                        $dr_cr = ($balance>=0)?'Dr':'Cr';
                        $class = 'level-'.$i;
                        $result[] = '<td ><span class="'.$class.' ">'.$entry['name'].'</span></td>   <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td>  <td>0.00</td>  <td>0.00</td>  <td>0.00</td> '.getLedger($entry['id'], $i).''.nested2ul($entry['children'], $i);
                        //$i++;
                    }


                    /*$result[] = sprintf(
                        '<td class="has-children-li"><label>%s </td><td>Group</td></label> %s', $entry['name'], nested2ul($entry['children'])
                    );*/
                } else {
                    $class = 'level-'.$i;

                    $all_balance = \App\Ledger::select('op_balance', 'op_balance_dc')->where('group_id', $entry['id'])->get();
                    $balance = 0;
                    foreach ($all_balance as $bal){
                        if ($bal->op_balance_dc == 'D'){
                            $balance += $bal->op_balance;
                        }else{
                            $balance -= $bal->op_balance;
                        }
                    }

                    $dr_cr = ($balance>=0)?'Dr':'Cr';

                    $result[] = '</tr><tr ><td ><span class="'.$class.' ">'.$entry['name'].'</span></td>  <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td> <td>0.00</td> <td>0.00</td> <td>0.00</td>  '.getLedger($entry['id'], $i);

                    /*$result[] = sprintf(
                        '<td class="no-children-li">%s</label></td>', $entry['name']
                    );*/
                }
            }
            $result[] = '</tr>';
        }

        return implode($result);
    }


    function getLedger($id, $i){

        $i++;
        $ledgers = \App\Ledger::select('*')->where('group_id', $id)->get();
        $class = 'level-'.$i;

        $str = '';
        foreach ($ledgers as $led){

            $dr_cr = ($led->op_balance_dc == 'D')?'Dr':'Cr';
            $type='';
            $single_entry = \App\SingleEntry::select('dc', 'amount')->where('ledger_id', $led->id)->get();
            $cl_balance = $led->op_balance;
            $total_dr = 0;
            $total_cr = 0;
            foreach ($single_entry as $entry){


                if($led->dr_pos ==1 ){
                    $type = 'Dr';
                    if ($entry->dc == 'D' ){

                        $cl_balance += $entry->amount;
                        $total_dr += $entry->amount;

                    }elseif ($entry->dc == 'C' ){

                        $cl_balance -= $entry->amount;
                        $total_cr += $entry->amount;
                    }

                }elseif($led->dr_pos ==0){

                    $type = 'Cr';
                    if ($entry->dc == 'D' ){

                        $cl_balance -= $entry->amount;
                        $total_dr += $entry->amount;
                    }elseif ($entry->dc == 'C' ){

                        $total_cr += $entry->amount;
                        $cl_balance += $entry->amount;
                    }

                }
            }

            $total_dr = ($total_dr == 0)?'0.00': $total_dr.'.00';
            $total_cr = ($total_cr == 0)?'0.00': $total_cr.'.00';

            if ($cl_balance<0){
                $cl_balance = str_replace('-', '', $cl_balance);
                $type = ($type == 'Dr' )?'Cr':"Dr";
            }
//            $name = str_replace('_', ' ', $led['name']);
            $name = preg_replace ( '/[0-9]*$/' , '' , str_replace('_', ' ', $led['name']));

            $str .= '</tr><tr><td ><span class="'.$class.' ">'.$name.'</span></td>  <td>Ledger</td>  <td>'.$dr_cr.' '.$led['op_balance'].'</td> <td>Dr '.$total_dr.'</td>  <td>Cr '.$total_cr.'</td> <td>'.$type.' '.$cl_balance.'</td>  </tr>';
        }
        return $str;

    }

    /*

    */
    function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    ?>

    <style media="screen">
        .has-children-li ul li {
            margin-left: 30px;
        }
    </style>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Trial Balance</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Type</th>
                                        <th>O/P Balance ($)</th>
                                        <th>Total Debit ($)</th>
                                        <th>Total Credit ($)</th>
                                        <th>C/L Balance ($)</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php

                                    $groups =  \App\Group::select('*')->get();
                                    $groups = $groups->toArray();

                                    /*echo '<pre>';
                                    print_r($groups);
                                    echo '</pre>';
                                    die();*/


                                    if (!empty($groups)) {
                                        $arr = array();

                                        foreach ($groups as $rows){
                                            $arr[] = $rows;
                                        }

                                        /*echo '<pre>';
                                        print_r($arr);
                                        echo '</pre>';die;*/

                                        $new = array();
                                        foreach ($arr as $a) {
                                            $new[$a['parent_id']][] = $a;
                                        }

                                        $tree = array();
                                        $rootParent = minValueInArray($arr, 'parent_id');
                                        foreach ($arr as $k => $a) {
                                            if ($a['parent_id'] == $rootParent) {
                                                $tree[] = createTree($new, array($arr[$k]));
                                            }
                                        }

                                        $html = '';
                                        foreach ($tree as $t) {
                                            $html .= nested2ul($t);
                                        }
                                        echo $html;
                                    }?>


                                    </tbody>

                                    @if($dr_total_amount == $dr_total_amount)
                                        <th class="text-success">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-success">{{$dr_total_amount}}</th>
                                        <th class="text-success">{{$cr_total_amount}}</th>
                                        <th></th>
                                    @else
                                        <th class="text-danger">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-danger">{{$dr_total_amount}}</th>
                                        <th class="text-danger">{{$cr_total_amount}}</th>
                                        <th></th>
                                    @endif

                                    <tfoot>
                                    <tr>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Type</th>
                                        <th>O/P Balance ($)</th>
                                        <th>Total Debit ($)</th>
                                        <th>Total Credit ($)</th>
                                        <th>C/L Balance ($)</th>
                                    </tr>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- /.content-wrapper -->


@endsection
