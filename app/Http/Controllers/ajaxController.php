<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientDue;
use App\SingleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ajaxController extends Controller
{
    public function productName(Request $request){

        $k = $request->get('j');
        $select = $request->get('select');


        $sql = "SELECT DISTINCT product_name,id FROM product_info WHERE product_type_id = '".$select."' ORDER BY product_name ASC";
        $model = DB::select($sql);

        echo "<select name='product_code[]' data-row='$k' class='js-example-basic-single form-control input_edit6 product_list_$k product_list'><option>Select Product</option>";
        foreach($model as $data)
        {
            echo "<option value='$data->id'>$data->product_name</option>";
        }
        echo "</select>";


    }

    public function productRate(Request $request){

        $product_id = $request->select2;
        $date = DB::table('product_info')->select('sell')->where('id',$product_id )->first();
        echo $date->sell;

        /*$k = $request->get('l');
        $select2 = $request->get('select2');*/

        /*$data = DB::table('product_info')->select('sell')->where('id',$request->select2 )->first();
        echo $data['sell']."";*/

        /*if (sizeof($model)>0){
            foreach ($model as $data)
            {
                echo "<input type='text' name='product_rate[]' data-row='$k' class='input form-control rate_$k rate' value='".preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $data->sell)."' /> <input type='hidden' name='min_rate[]' data-row='$k' class='form-control min_rate_$k min_rate' value='".preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $data->min_price)."' />";
                // echo "<input type='text' name='product_rate[]' data-row='$k' class='rate_$k rate' value='$data[sale]'/>";
            }
        }else{
            echo "<input type='text' name='product_rate[]' data-row='$k' class='input form-control rate_$k rate' value='".preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", 0)."' /> <input type='hidden' name='min_rate[]' data-row='$k' class='form-control min_rate_$k min_rate' value='".preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", 0)."' />";

        }*/
    }


    public function quantityPerCarton(Request $request){

        $k = $request->get('l');
        $select2 = $request->get('select2');

        $model = DB::select("SELECT qt_per_carton from product_info where id = '".$select2."'");


        foreach ($model as $data)
        {
            echo $data->qt_per_carton;
//            echo "<input type='text' name='qt_per_carton[]' data-row='$k' class='form-control qt_per_carton_$k qt_per_carton' value='$data->qt_per_carton' />";
            // echo "<input type='text' name='product_rate[]' data-row='$k' class='rate_$k rate' value='$data[sale]'/>";
        }
    }


    public function getAvailableQuantity(Request $request){

        $k = $request->get('l');
        $product_id = $request->get('select2');
        $warehouse_id = $request->get('warehouse_id');

//        $model = DB::select("SELECT available_qt from warehouse_product where warehouse_id = '".$warehouse_id."' and  product_id = '".$product_id."'");
        $info = DB::table('warehouse_product')->select('available_qt')->where('warehouse_id', $warehouse_id)->where('product_id', $product_id)->first();

        if (!empty($info)){
            $available_qt = $info->available_qt;
            echo "$available_qt</span>";
        }else{
            echo "0";

        }

        /*foreach ($model as $data)
        {
            echo $data->available;
//            echo "<input type='text' name='qt_per_carton[]' data-row='$k' class='form-control qt_per_carton_$k qt_per_carton' value='$data->qt_per_carton' />";
            // echo "<input type='text' name='product_rate[]' data-row='$k' class='rate_$k rate' value='$data[sale]'/>";
        }*/
    }


    public function address(Request $request){

        $supplierId = $request->get('supplier_id');

     $sql = DB::select("SELECT * from supplier_info where id = '".$supplierId."'");

       foreach ($sql as $data)
      {
           //echo '<label for="" class="col-sm-2 control-label">Address</label><div class="col-sm-4"><input type="text" class="form-control" id="" placeholder="" value="'.$data->address.'" readonly></div>';
            echo $data->address;
            // echo "<input type='text' name='product_rate[]' data-row='$k' class='rate_$k rate' value='$data[sale]'/>";
       }
    }

    public function clientAddress(Request $request){

        $clientId = $request->get('client_id');

        $sql = DB::select("SELECT * from client_info where id = '".$clientId."'");

        foreach ($sql as $data)
        {
            //echo '<label for="" class="col-sm-2 control-label">Address</label><div class="col-sm-4"><input type="text" class="form-control" id="" placeholder="" value="'.$data->address.'" readonly></div>';
            echo $data->address;
            // echo "<input type='text' name='product_rate[]' data-row='$k' class='rate_$k rate' value='$data[sale]'/>";
        }

    }

    public function quantityReturn(Request $request){

        $product_id = $request->get('id');
        $quantity   = $request->get('quantity');

        $getProduct = DB::table('product_status')->where('product_id', $product_id)->first();

        if($quantity > $getProduct->available)
        {
            echo "false";
        }
        else echo "true";

    }

    public function clientDue(Request $request){

        $id = $request->get('client_id');

        $sql = DB::select("SELECT SUM(replace(amount, ',', '')) as amount FROM client_payments where client_id='".$id."'");


        foreach ($sql as $data)
        {
            $client_payments =  $data->amount;

        }

        $due_sql = DB::select("SELECT sum(replace(due, ',', '')) as due from memo_account where client_id='".$id."'");

        foreach ($due_sql as $data)
        {
            $due =  $data->due;

        }

        $return_sql = DB::select("SELECT sum(replace(total_payable, ',', '')) as total_payable from return_memo_account where client_id='".$id."'");

        foreach ($return_sql as $data)
        {
            $return = $data->total_payable;

        }


        $paid = $client_payments + $return;
        //echo $paid.' ';

        $final_due = $due - $paid;
//        // echo $final_due.' ';
        return $final_due;

    }


    function getAllSuppliers(){

        $suppliers = DB::table('supplier_info')->select('id', 'supplier_name')->get();

        $output = '<datalist id="parties">';
            foreach ($suppliers as $supplier){
                $output .= "<option data-id='$supplier->id' value='$supplier->supplier_name'>";
            }
        $output .= '</datalist>';
        echo $output;
    }


    function getAllClients(){

        $clients = DB::table('clients')->select('id', 'client_name')->get();

        $output = '<datalist id="parties">';
        foreach ($clients as $client){
            $output .= "<option data-id='$client->id' value='$client->client_name'>";
        }
        $output .= '</datalist>';
        echo $output;
    }


    function getAllWarehouses(){

        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();

        $output = '<datalist id="parties">';
        foreach ($warehouses as $warehouse){
            $output .= "<option data-id='$warehouse->id' value='$warehouse->warehouse_name'>";
        }
        $output .= '</datalist>';
        echo $output;
    }


    public function getMemosByDate(){

        $from_date = strtotime($_GET['from_date']);
        $to_date = strtotime($_GET['to_date']);

        $memos = DB::table('memo_account')
            ->select('memo_no')
            ->whereBetween('entry_date', [$from_date, $to_date])->get();

        $output = ' <datalist id="memos">';
        foreach ($memos as $memo){
            $output .= "<option data-id='$memo->memo_no' value='$memo->memo_no'>";
        }
        $output .='</datalist>';

        echo $output;
    }



    public function getPurchaseMemosByDate(){

        $from_date = strtotime($_GET['from_date']);
        $to_date = strtotime($_GET['to_date']);


        $memos = DB::table('purchase_main')
            ->select('entry_no')
            ->whereBetween('entry_date', [$from_date, $to_date])
            ->get();

        $output = ' <datalist id="memos">';
        foreach ($memos as $memo){
            $output .= "<option data-id='$memo->entry_no' value='$memo->entry_no'>";
        }
        $output .='</datalist>';

        echo $output;
    }

    public function getTransferMemosByDate(){
        $from_date = strtotime($_GET['from_date']);
        $to_date = strtotime($_GET['to_date']);
        $memos = DB::table('warehouse_product_transfer')
            ->select('memo_no')
            ->whereBetween('entry_date', [$from_date, $to_date])
            ->get();

        $output = ' <datalist id="memos">';
        foreach ($memos as $memo){
            $output .= "<option data-id='$memo->memo_no' value='$memo->memo_no'>";
        }
        $output .='</datalist>';

        echo $output;
    }


    public function getPurchaseReturnMemosByDate(){
        $from_date = strtotime($_GET['from_date']);
        $to_date = strtotime($_GET['to_date']);
        $memos = DB::table('purchase_return_main')
            ->select('memo_no')
            ->whereBetween('entry_date', [$from_date, $to_date])
            ->get();

        $output = ' <datalist id="memos">';
        foreach ($memos as $memo){
            $output .= "<option data-id='$memo->memo_no' value='$memo->memo_no'>";
        }
        $output .='</datalist>';

        echo $output;
    }

    public function getSaleReturnMemosByDate(){
        $from_date = strtotime($_GET['from_date']);
        $to_date = strtotime($_GET['to_date']);

        $memos = DB::table('return_memo_account')
            ->select('memo_no')
            ->whereBetween('entry_date', [$from_date, $to_date])
            ->get();

        $output = ' <datalist id="memos">';
        foreach ($memos as $memo){
            $output .= "<option data-id='$memo->memo_no' value='$memo->memo_no'>";
        }
        $output .='</datalist>';

        echo $output;
    }

}
