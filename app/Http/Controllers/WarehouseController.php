<?php

namespace App\Http\Controllers;

use App\warehouseProductTransfer;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Warning;

class WarehouseController extends Controller
{
    public function __construct(){
//        $this->middleware('auth');
    }

    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    public function getMemoNo() {

        $lastId = DB::table('warehouse_product_transfer')->select('id')->orderby('id', 'desc')->first();

        if ($lastId){
            $num = $lastId->id;
        }else{
            $num = 0;
        }
        ++$num; // add 1;

        $len = strlen($num);
        for($i=$len; $i< 5; ++$i) {
            $num = '0'.$num;
        }
        return $num;
    }


    public function index()
    {

        return view('admin.warehouse.create_warehouse');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'warehouse_name' => 'required',
            'address'      => 'required',
            'owner_name'    => 'required',
            'contact_no'    => 'required',

        ]);

//        $user_id = Auth::user()->id;

        $insert = DB::table('warehouse')->insert([
            'warehouse_name' => $request->warehouse_name,
            'address'  => $request->address,
            'owner_name'      => $request->owner_name,
            'contact_no'         => $request->contact_no,
            'created_at'    => $this->getDate(),
        ]);

        return redirect('add_warehouse')->with('message','Warehouse info saved successful.');
    }


    public function showWareHouseList()
    {
        $all_warehouse = DB::table('warehouse')->get();
        return view('admin.warehouse.warehouse_list',['all_warehouse'=>$all_warehouse]);
    }



    public function editById($id){
        $showById = DB::table('warehouse')->where('id',$id)->first();
        return view('admin.warehouse.showById',['showById'=>$showById]);
    }


    public function update(Request $request)
    {

//        $user_id = Auth::user()->id;\



        $update = DB::table('warehouse')->where('id',$request->id)->update([
            'warehouse_name' => $request->warehouse_name,
            'address'  => $request->address,
            'owner_name'      => $request->owner_name,
            'contact_no'       => $request->contact_no,
            'created_at'    => $this->getDate(),
        ]);

        if ($update){
            return back()->with('message','Warehouse update successfully.');
        }else{
            return back();
        }
    }


    public function destroy($id)
    {
        DB::table('warehouse')->where('id', $id)->delete();

        return redirect('warehouse_list')->with('message','Warehouse delete successfully.');
    }



    public function showWarehouseTransfer(){
        $memo_no = $this->getMemoNo();
        $warehouses = DB::table('warehouse')->get();
        $catagories = DB::table('catagory')->get();

        return view('admin.warehouse.transferProduct', compact('warehouses', 'catagories', 'memo_no'));
    }


    public function getProductsByCatagory(){
        $cat_id = $_GET['cat_id'];

        $products = DB::table('product_info')->where('product_type_id', $cat_id)->get();

        echo "<select name='product_id' id='product_id' ><option>Select Product</option>";
        foreach($products as $data)
        {
            echo "<option value='$data->id'>$data->product_name</option>";
        }
        echo "</select>";


    }



    // getting quantity per carton
    public function getQtPerCarton(){
        $product_id = $_GET['product_id'];

        $product = DB::table('product_info')->select('qt_per_carton')->where('id', $product_id)->first();
        echo $product->qt_per_carton;
    }




    /*
     * transferring products from one warehouse to other
     * */
    public function transferProduct(Request $request){

        $warehouse_from = $request->warehouse_from;
        $warehouse_to = $request->warehouse_to;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $memo_no = $request->memo_no;

        $warehouse_from_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_from)->where('product_id', $product_id)->first();
        $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_to)->where('product_id', $product_id)->first();

        if (empty($warehouse_from_info) ){
            return redirect('transfer_product')->with('expression','Do not transfer this products available products ');
        }else{
            if ($warehouse_from_info->available_qt == 0){
                return redirect('transfer_product')->with('expression','Do not transfer this products available products ');

            }else if($warehouse_from_info->available_qt < $quantity){
                return redirect('transfer_product')->with('expression','Do not transfer this products available products ');
            }else{
                $store_quantity = $warehouse_from_info->product_out + $quantity;
                $available      = $warehouse_from_info->available_qt - $quantity;

                // updating warehouse product status
                $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_id)->where('warehouse_id',$warehouse_from)
                    ->update([
                        'product_out' => $store_quantity,
                        'available_qt'  => $available,
                        'created_at' => $this->getDate(),
                    ]);


                if (empty($warehouse_to_info)){
                    $insert_sql = DB::table('warehouse_product')->insert([
                        'product_id' => $product_id,
                        'warehouse_id' => $warehouse_to,
                        'product_in' => $quantity,
                        'product_out' => 0,
                        'available_qt' => $quantity,
                    ]);
                }else{

                    $store_quantity_to = $warehouse_to_info->product_in + $quantity;
                    $available_to      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_id)->where('warehouse_id',$warehouse_to)
                        ->update([
                            'product_in' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);

                }


                $qt_per_carton = DB::table('product_info')->select('qt_per_carton')->where('id', $product_id)->first()->qt_per_carton;
                /*DB::table('warehouse_product_transfer')->insert([
                    'product_id'=>$product_id,
                    'from_warehouse'=>$warehouse_from,
                    'to_warehouse'=>$warehouse_to,
                    'quantity'=>$quantity,
                    'memo_no'=>$memo_no,
                    'qt_per_carton'=>$qt_per_carton,
                    'entry_date'=>strtotime($request->entry_date),
                ]);*/

                $transferProduct = new warehouseProductTransfer();
                $transferProduct->product_id = $product_id;
                $transferProduct->from_warehouse = $warehouse_from;
                $transferProduct->to_warehouse = $warehouse_to;
                $transferProduct->quantity = $quantity;
                $transferProduct->memo_no = $memo_no;
                $transferProduct->qt_per_carton = $qt_per_carton;
                $transferProduct->entry_date = strtotime($request->entry_date);
                $transferProduct->save();

                \Illuminate\Support\Facades\DB::table('stock_transaction_sl')->insert(['trans_id'=>'transfer_'.$transferProduct->id]);


            }
        }

        return redirect('transfer_product')->with('message','Product Transfer successful');
    }


    public function getAvailableProductsList(){

        $warehouses = DB::table('warehouse_product')->select('warehouse_id')->groupBy('warehouse_id')->get();
        return view('admin.warehouse.warehouseProducts', compact('warehouses'));
    }



    public function showTransferProductForm(Request $request){
        $memo_no = $request->memo;
//        echo $memo_no;

        $info = DB::table('warehouse_product_transfer')
            ->select('warehouse_product_transfer.*', 'product_info.product_name as product_name', 'product_info.product_type_id as cat_id', 'catagory.cname as cat_name')
            ->join('product_info', 'product_info.id','=','warehouse_product_transfer.product_id')
            ->join('catagory', 'catagory.id','=','product_info.product_type_id')
            ->where('warehouse_product_transfer.memo_no', $memo_no)
            ->first();

        $info_arr = array();
        $info_arr['old_transfer_id'] = $info->id;
        $info_arr['memo_no'] = $info->memo_no;
        $info_arr['entry_date'] = date('d/m/y', $info->entry_date);
        $info_arr['cat_id'] = $info->cat_id;
        $info_arr['cat_name'] = $info->cat_name;
        $info_arr['product_id'] = $info->product_id;
        $info_arr['from_warehouse_id'] = $info->from_warehouse;
//        $info_arr['from_warehouse_name'] = DB::table('warehouse')->select('warehouse_name')->where('id', $info->from_warehouse)->first()->warehouse_name;;
        $info_arr['to_warehouse_id'] = $info->to_warehouse;
//        $info_arr['to_warehouse_name'] = DB::table('warehouse')->select('warehouse_name')->where('id', $info->to_warehouse)->first()->warehouse_name;
        $info_arr['product_name'] = $info->product_name;
        $info_arr['quantity'] = $info->quantity;
        $info_arr['qt_per_carton'] = $info->qt_per_carton;
        $info_arr['carton'] = intval($info->quantity/$info->qt_per_carton);
        $info_arr['pieces'] = intval($info->quantity%$info->qt_per_carton);

        $products = DB::table('product_info')->select('id', 'product_name')->where('product_type_id', $info->cat_id)->get();
        // getting other info
        $memo_no = $memo_no;
        $warehouses = DB::table('warehouse')->get();
        $catagories = DB::table('catagory')->get();

        return view('admin.warehouse.editTransferForm', compact('info_arr', 'memo_no','warehouses', 'catagories', 'products'));

    }


    public function showTransferProductInfo(Request $request){

        $old_transfer_id    = $request->old_transfer_id;
        $old_quantity       = $request->old_quantity;
        $old_product_id     = $request->old_product_id;
        $old_from_warehouse = $request->old_from_warehouse;
        $old_to_warehouse   = $request->old_to_warehouse;

        // updating old information


        $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$old_to_warehouse)->where('product_id', $old_product_id)->first();
        if ($warehouse_to_info->available_qt >= $old_quantity){
            $store_quantity_to = $warehouse_to_info->product_in - $old_quantity;
            $available_to      = $warehouse_to_info->available_qt - $old_quantity;
            $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $old_product_id)->where('warehouse_id',$old_to_warehouse)
                ->update([
                    'product_in' => $store_quantity_to,
                    'available_qt'  => $available_to,
                    'created_at' => $this->getDate(),
                ]);
        }else{
            return redirect('transfer_product')->with('message','Warehouse does not have that much quantity of product. Try later... ');
        }

        $warehouse_from_info = DB::table('warehouse_product')->where('warehouse_id',$old_from_warehouse)->where('product_id', $old_product_id)->first();
        $store_quantity = $warehouse_from_info->product_out - $old_quantity;
        $available      = $warehouse_from_info->available_qt + $old_quantity;
        $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $old_product_id)->where('warehouse_id',$old_from_warehouse)
            ->update([
                'product_out' => $store_quantity,
                'available_qt'  => $available,
                'created_at' => $this->getDate(),
            ]);

        // deleting old info
        DB::table('warehouse_product_transfer')->where('id', $old_transfer_id)->delete();

        // creating new info
//        echo $old_transfer_id;
        $warehouse_from = $request->warehouse_from;
        $warehouse_to   = $request->warehouse_to;
        $product_id     = $request->product_id;
        $quantity       = $request->quantity;
        $memo_no        = $request->memo_no;

        $warehouse_from_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_from)->where('product_id', $product_id)->first();
        $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_to)->where('product_id', $product_id)->first();

        if (empty($warehouse_from_info) ){
            return redirect('transfer_product')->with('expression','Do not transfer this products available products ');
        }else{
            if ($warehouse_from_info->available_qt == 0){
                return redirect('transfer_product')->with('expression','Do not transfer this products available products ');

            }else if($warehouse_from_info->available_qt < $quantity){
                return redirect('transfer_product')->with('expression','Do not transfer this products available products ');
            }else{
                $store_quantity = $warehouse_from_info->product_out + $quantity;
                $available      = $warehouse_from_info->available_qt - $quantity;

                // updating warehouse product status
                $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_id)->where('warehouse_id',$warehouse_from)
                    ->update([
                        'product_out' => $store_quantity,
                        'available_qt'  => $available,
                        'created_at' => $this->getDate(),
                    ]);


                if (empty($warehouse_to_info)){
                    $insert_sql = DB::table('warehouse_product')->insert([
                        'product_id' => $product_id,
                        'warehouse_id' => $warehouse_to,
                        'product_in' => $quantity,
                        'product_out' => 0,
                        'available_qt' => $quantity,
                    ]);
                }else{

                    $store_quantity_to = $warehouse_to_info->product_in + $quantity;
                    $available_to      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_id)->where('warehouse_id',$warehouse_to)
                        ->update([
                            'product_in' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);

                }


                $qt_per_carton = DB::table('product_info')->select('qt_per_carton')->where('id', $product_id)->first()->qt_per_carton;
                DB::table('warehouse_product_transfer')->insert([
                    'id'=>$old_transfer_id,
                    'product_id'=>$product_id,
                    'from_warehouse'=>$warehouse_from,
                    'to_warehouse'=>$warehouse_to,
                    'quantity'=>$quantity,
                    'memo_no'=>$memo_no,
                    'qt_per_carton'=>$qt_per_carton,
                    'entry_date'=>strtotime($request->entry_date),
                ]);

            }
        }

        return redirect('transfer_product')->with('message','Product Transfer Updated successfully');


    }

}
