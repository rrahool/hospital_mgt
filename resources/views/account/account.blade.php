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
//                        $balance  = number_format($balance, 2, '.', ',' ) ;
                        $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $balance);
                        $result[] = '<span><td><span class="'.$class.'  " >'.$entry['name'].'</span ></td>   <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td>  <td>0.00</td>  <td></td> '.getLedger($entry['id'], $i).''.nested2ul($entry['children'], $i);
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
//                        $balance  = number_format($balance, 2, '.', ',' ) ;
                        $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $balance);
                        $result[] = '<td><span class="'.$class.' ">'.$entry['name'].'</span></td>   <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td>  <td>0.00</td>  <td></td> '.getLedger($entry['id'], $i).''.nested2ul($entry['children'], $i);
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
//                    $balance  = number_format($balance, 2, '.', ',' ) ;
                    $balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $balance);
                    $result[] = '</tr><tr ><td ><span class="'.$class.' ">'.$entry['name'].'</span></td>  <td>Group</td>  <td>'.$dr_cr.' '.$balance.'</td>  <td>0.00</td>  <td><a href="'.url('edit-group').'/'.$entry['id'].'" class="btn btn-primary">Edit</a> <a href="'.url('delete-group').'/'.$entry['id'].'" class="btn btn-danger">Delete</a></td>'.getLedger($entry['id'], $i);

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
            $cl_balance = 0;
            foreach ($single_entry as $entry){


                if($led->dr_pos ==1 ){
                    $type = 'Dr';
                    if ($entry->dc == 'D' ){

                        $cl_balance += $entry->amount;
                    }elseif ($entry->dc == 'C' ){

                        $cl_balance -= $entry->amount;
                    }

                }elseif($led->dr_pos ==0){
                    $type = 'Cr';
                    if ($entry->dc == 'D' ){

                        $cl_balance -= $entry->amount;
                    }elseif ($entry->dc == 'C' ){

                        $cl_balance += $entry->amount;
                    }

                }
            }

            $led_name = str_replace('_', ' ', $led['name']);
            $led_name = preg_replace ( '/[0-9]*$/' , '' , $led_name);
//            $op_balance  = number_format($led['op_balance'], 2, '.', ',' ) ;
            $op_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $led['op_balance']);
//            $cl_balance  = number_format($cl_balance, 2, '.', ',' ) ;
            $cl_balance  = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $cl_balance);
            if($cl_balance < 0){
                $cl_balance = str_replace('-', '', $cl_balance);
                $type = ($type == 'Dr')?"Cr":"Dr";
            }

            $str .= '</tr><tr><td ><span class="'.$class.' ">'.$led_name.'</span></td>  <td>Ledger</td>  <td>'.$dr_cr.' '.$op_balance.'</td>  <td>'.$type.' '.$cl_balance.'</td>  <td><a href="#" class="btn btn-primary">Edit</a> <a href="'.url('delete-ledger').'/'.$led['id'].'" class="btn btn-danger">Delete</a></td></tr>';
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

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li ><a href="{{url('/create-group')}}" class="btn btn-primary" style="margin-right: 10px; color: #ffffff;">Add Group</a></li>
                    <li ><a href="{{url('/create-ledger')}}" class="btn btn-primary" style="color: #ffffff;">Add Ledger</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Chart Of Accounts</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Type</th>
                                        <th>O/P Balance ($)</th>
                                        <th>C/L Balance ($)</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php
                                    $groups =  \App\Group::select('*')->get();
                                    $groups = $groups->toArray();

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
                                    <tfoot>
                                    <tr>
                                    <tr>
                                        <th>Account Name</th>
                                        <th>Type</th>
                                        <th>O/P Balance ($)</th>
                                        <th>C/L Balance ($)</th>
                                        <th>Actions</th>
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
