<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Ledger;
use App\Purchase;
use App\PurchaseReturn;
use App\SingleEntry;
use App\Supplier;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class purchaseController extends Controller
{
    public function __construct(){
//        $this->middleware('auth');
    }

    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    function getSerial() {

        $lastId = DB::table('purchase_main')->select('id')->orderby('id', 'desc')->first();
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

    function getReturnSerial() {

        $lastId = DB::table('purchase_return_main')->select('id')->orderby('id', 'desc')->first();
        if (isset($lastId)){
            $num = $lastId->id;
        }else{
            $num = 1;
        }

        ++$num; // add 1;

        $len = strlen($num);
        for($i=$len; $i< 5; ++$i) {
           $num = '0'.$num;
        }
        return $num;
    }

    public function index(){

        $entry_no = $this->getSerial();

        $supplier = DB::table('supplier_info')->get();
        $category = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->get();

        $cat_info[] = array();
        foreach ($category as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;
            $products = \Illuminate\Support\Facades\DB::table("product_info")
                ->select('id', 'product_name')
                ->where('product_type_id', $cat_id)->get();

            if (sizeof($products)!=0) {
                $cat_info[$cat_id][] = array();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $product_name = $product->product_name;

                    $cat_info[$cat_id][$product_id]['p_id'] = $product_id;
                    $cat_info[$cat_id][$product_id]['p_name'] = $product_name;
                    $cat_info[$cat_id][$product_id]['cat_id'] = $cat_id;
                    $cat_info[$cat_id][$product_id]['cat_name'] = $cat_name;
                    unset($cat_info[$cat_id][0]);
                }
                unset($cat_info[0]);
            }
        }


        return view('admin.purchase.purchase_entry',['cat_info'=>$cat_info,'supplier'=>$supplier,'category'=>$category,'entry_no'=>$entry_no,'warehouses'=>$warehouses]);
    }


    /*
     * getting purchase List
     * */
    public function purchaseList(){

        $purchase_list = DB::table('purchase_main')
            ->join('supplier_info', 'purchase_main.supplier_id', '=', 'supplier_info.id')
            ->select('purchase_main.*','supplier_info.executive_name')
            ->get();


        return view('admin.purchase.purchase_list',['purchase_list'=>$purchase_list]);
    }


    /*
     * getting purchase By Id
     * */
    public function purchaseById($id){

        $purchase_Byid = DB::table('purchase_main')
            ->join('supplier_info','purchase_main.supplier_id', '=', 'supplier_info.id')
            ->join('users', 'purchase_main.creator_id', '=', 'users.id')
            ->where('purchase_main.id',$id)
            ->select('purchase_main.*','purchase_main.id as pid','supplier_info.*','users.username','users.phoneNo')
            ->first();

        $single_purchases = DB::table('purchase_single')->where('purchase_id',$id)->get();

        return view('admin.purchase.show_purchase_id',['showInfo'=>$purchase_Byid])->with(compact( 'id','single_purchases'));
    }

    public function printPurchaseById($id){

        $purchase_Byid = DB::table('purchase_main')
            ->join('supplier_info','purchase_main.supplier_id', '=', 'supplier_info.id')
            ->join('users', 'purchase_main.creator_id', '=', 'users.id')
            ->where('purchase_main.id',$id)
            ->select('purchase_main.*','purchase_main.id as pid','supplier_info.*','users.username','users.phoneNo')
            ->first();

        $single_purchases = DB::table('purchase_single')->where('purchase_id',$id)->get();



        return view('admin.purchase.show_purchase_id_print',['showInfo'=>$purchase_Byid])->with(compact( 'id','single_purchases'));
    }


    //purchase return form
    public function purchaseReturn(){

        $entry_no = $this->getReturnSerial();

        $supplier = DB::table('supplier_info')->get();
        $category = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->get();

        $cat_info[] = array();
        foreach ($category as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;
            $products = \Illuminate\Support\Facades\DB::table("product_info")
                ->select('id', 'product_name')
                ->where('product_type_id', $cat_id)->get();

            if (sizeof($products)!=0) {
                $cat_info[$cat_id][] = array();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $product_name = $product->product_name;

                    $cat_info[$cat_id][$product_id]['p_id'] = $product_id;
                    $cat_info[$cat_id][$product_id]['p_name'] = $product_name;
                    $cat_info[$cat_id][$product_id]['cat_id'] = $cat_id;
                    $cat_info[$cat_id][$product_id]['cat_name'] = $cat_name;
                    unset($cat_info[$cat_id][0]);
                }
                unset($cat_info[0]);
            }
        }

        return view('admin.purchase.purchase_return',['cat_info'=>$cat_info,'warehouses'=>$warehouses, 'supplier'=>$supplier,'category'=>$category,'entry_no'=>$entry_no]);
    }



    /*
     * storing Purchase info
     * */
    public function entryPurchase(Request $request){

        $supplier_led_id  = Ledger::select('ledgers.id as led_id')->join('supplier_info', 'supplier_info.supplier_id', '=', 'ledgers.name')->where('supplier_info.id', $request->supplier_id)->first()->led_id;

        // getting form info
        $entry_date = strtotime($request->entry_date);
        $discount = (isset($request->discount))? $request->discount :0;
        $vat = (isset($request->vat))? $request->vat :0;
        $tax = (isset($request->tax))? $request->tax :0;
        $vat_p = (isset($request->vat_p))? $request->vat_p :0;
        $tax_p = (isset($request->tax_p))? $request->tax_p :0;
        $discount_p = (isset($request->discount_p))? $request->discount_p :0;

        // purchase entry in purchase main table .
        $purchase_main = new Purchase();
        $purchase_main->entry_date = $entry_date;
        $purchase_main->entry_no = $request->entry_no;
        $purchase_main->supplier_id = $request->supplier_id;
        $purchase_main->warehouse_id = $request->warehouse_id;
        $purchase_main->total = $request->column_total;
        $purchase_main->discount = $discount;
        $purchase_main->due = $request->balance;
        $purchase_main->vat = $vat;
        $purchase_main->tax = $tax;
        $purchase_main->vat_p = $vat_p;
        $purchase_main->tax_p = $tax_p;
        $purchase_main->discount_p = $discount_p;
        $purchase_main->memo_no = $request->ref_no;
        $purchase_main->remarks = $request->remarks;
        $purchase_main->creator_id = \Illuminate\Support\Facades\Auth::id();
//        $purchase_main->creator_id = $user_id;
        $purchase_main->created_at = $this->getDate();
        $purchase_id = $purchase_main->id;
        $success = $purchase_main->save();
//        $success = 1;


        if ($success){

            $product_code_names = $request->product_code;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;

            $purchase_id = $purchase_main->id;
//            $purchase_id = 1;


            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'purchase_'.$purchase_id;
            $entry->save();
            $entry_id = $entry->id;


            // saving single transaction in single_entry table
            //saving dr entry (purchase debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 74;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (Acc payable credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = $supplier_led_id;
            $single_entry_cr->amount = str_replace(',', '', $request->column_total);;
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();


            foreach ($product_types as $key=>$value){

                // saving each purchase item
                $product_type = $product_types[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];

                // saving single purchase in purchase_single table
                DB::table('purchase_single')->insert([
                    'purchase_id'=>$purchase_id,
                    'product_type_id'=>$product_type,
                    'entry_date'=>$entry_date,
                    'supplier_id'=>$request->supplier_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);




                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$request->warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count == 0){
                    $insert_sql = DB::table('warehouse_product')->insert([
                        'product_id' => $product_code_name,
                        'warehouse_id' => $request->warehouse_id,
                        'product_in' => $quantity,
                        'product_out' => 0,
                        'available_qt' => $quantity,
                    ]);
                }else{
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$request->warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity_to = $warehouse_to_info->product_in + $quantity;
                    $available_to      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$request->warehouse_id)
                        ->update([
                            'product_in' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);
                }


//                echo $product_type.'/ '.$rate.'/ '.$qt_per_carton.'/ '.$quantity.'/ '.$total;
            }


            DB::table('stock_transaction_sl')->insert(['trans_id'=>'purchase_'.$purchase_id]);


        }


        return redirect('show_purchase_Byid/'.$purchase_id);
//        return redirect('purchase_entry')->with('message','Purchase entry successful');
    }




    /*
     * saving Purchase Return data
     * */
    public function entryPurchaseReturn(Request $request){

        $product_types = $request->product_type;
        $product_code_names = $request->product_code;
        $rates = $request->product_rate;
        $qt_per_cartons = $request->qt_per_carton;
        $quantities = $request->quantity;
        $totals = $request->total;
        /*echo '<pre>';
        print_r($totals);
        echo '</pre>';
        die;*/

        $this->validate($request,[
            'entry_date' => 'required',
            'supplier_id' => 'not_in:0',
            'product_type' => 'not_in:0',
        ]);

        $supplier_led_id  = Ledger::select('ledgers.id as led_id')->join('supplier_info', 'supplier_info.supplier_id', '=', 'ledgers.name')->where('supplier_info.id', $request->supplier_id)->first()->led_id;

        // saving entry in purchase_return_main table
        $purchase_return = new PurchaseReturn();
        $purchase_return->entry_date = strtotime($request->entry_date);
        $purchase_return->supplier_id = $request->supplier_id;
        $purchase_return->warehouse_id = $request->warehouse_id;
        $purchase_return->total = $request->column_total;
        $purchase_return->memo_no = $request->memo_no;
        $purchase_return->ref_no = $request->ref_no;
        $purchase_return->creator_id = \Illuminate\Support\Facades\Auth::id();
        $purchase_return->created_at = $this->getDate();
        $saved = $purchase_return->save();
//        $saved = 1;

        if ($saved) {

            DB::table('stock_transaction_sl')->insert(['trans_id'=>'purchase_return_'.$purchase_return->id]);


            // saving entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'purchase_return_'.$purchase_return->id;
            $entry->save();
            $entry_id = $entry->id;



            //saving cr entry (purchase credit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 74;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'C';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();


            //saving cr entry (Acc payable debit)
            $single_entry_dr = new SingleEntry();
            $single_entry_dr->entry_id = $entry_id;
            $single_entry_dr->ledger_id = $supplier_led_id;
            $single_entry_dr->amount = str_replace(',', '', $request->column_total);
            $single_entry_dr->dc = 'D';
            $single_entry_dr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_dr->save();



            // getting product info
            /*$product_types = $request->product_type;
            $product_code_names = $request->product_code;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;*/


//            $purchase_return_id = 1;
            $purchase_return_id = $purchase_return->id;

            foreach ($product_code_names as $key=>$value) {

                // getting each purchase return item
                $product_type = $product_types[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];


                DB::table('purchase_return_details')->insert([

                    'purchase_return_id'=>$purchase_return_id,
                    'product_type_id'=>$product_type,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);

                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')
                    ->where('warehouse_id',$request->warehouse_id)
                    ->where('product_id', $product_code_name)
                    ->get()
                    ->count();

                if ($warehouse_status_count != 0){

                    $warehouse_to_info = DB::table('warehouse_product')
                        ->where('warehouse_id',$request->warehouse_id)
                        ->where('product_id', $product_code_name)->first();

                    $store_quantity_to = $warehouse_to_info->product_in - $quantity;
                    $available_to      = $warehouse_to_info->available_qt - $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$request->warehouse_id)
                        ->update([
                            'product_in' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);
                }


            }
            return redirect('purchase_return')->with('message','products return successful.');

        }


    }


    /*
     * showing purchase return List
     * */
    public function returnList(){


        $returnList = DB::table('purchase_return_main')
            ->join('supplier_info','purchase_return_main.supplier_id' ,'=', 'supplier_info.id')
            ->select('purchase_return_main.*', 'supplier_info.supplier_name','supplier_info.executive_name')
            ->get();

        return view('admin.purchase.purchase_return_list',['returnList' => $returnList]);
    }



    /*
     * showing purchase return info by id
     * */
    public function returnViewList($id){

        $supplier_info = DB::table('purchase_return_main')
            ->join('supplier_info','purchase_return_main.supplier_id', '=', 'supplier_info.id')
            ->join('users','purchase_return_main.creator_id', '=', 'users.id')
            ->select('purchase_return_main.*','purchase_return_main.id as r_id','supplier_info.*','users.username','users.phoneNo')
            ->where('purchase_return_main.id', $id)
            ->first();

        $single_purchases_return = DB::table('purchase_return_details')->where('purchase_return_id',$id)->get();

        return view('admin.purchase.return_single_view',['id'=>$id, 'supplier_info'=>$supplier_info,'single_purchases_return'=>$single_purchases_return]);
    }

    public function returnViewPrint($id){

        $supplier_info = DB::table('purchase_return_main')
            ->join('supplier_info','purchase_return_main.supplier_id', '=', 'supplier_info.id')
            ->join('users','purchase_return_main.creator_id', '=', 'users.id')
            ->select('purchase_return_main.*','purchase_return_main.id as r_id','supplier_info.*','users.username','users.phoneNo')
            ->where('purchase_return_main.id', $id)
            ->first();


        $single_purchases_return = DB::table('purchase_return_details')->where('purchase_return_id',$id)->get();

        return view('admin.purchase.return_single_view_print',['id'=>$id, 'supplier_info'=>$supplier_info,'single_purchases_return'=>$single_purchases_return]);
    }

    //end purchase return ....


    /*
     * add new Supplier
     * */
    public function addSupplier(Request $request){

        $this->validate($request,[
            'supplier_name' => 'required',
            'contact_no' => 'required',
        ]);

        $next_id = Supplier::max('id') + 1;
        $supplier_name = str_replace(' ','_', $request->supplier_name);
        $supplier_id = $supplier_name.'_'.$next_id;

//        $user_id = Auth::user()->id;

        $supplier = DB::table('supplier_info')->insert([
            'supplier_name' => $request->supplier_name,
            'supplier_id' => $supplier_id,
            'executive_name'  => $request->executive_name,
            'address'       => $request->address,
            'email'         => $request->email,
            'contact_no'    => $request->contact_no,
//            'creator_id'    => $user_id,
            'creator_id'    => \Illuminate\Support\Facades\Auth::id(),
            'created_at'    => $this->getDate(),
        ]);

        if ($supplier){

            $ledger = new Ledger();
            $ledger->group_id = 31;
            $ledger->name = $supplier_id;
//            $ledger->code = $request->code;
            $ledger->op_balance = 0.00;
            $ledger->op_balance_dc = 'D';
            $ledger->type = 0;
//            $ledger->reconciliation = $request->reconciliation;
//            $ledger->notes = $request->notes;
            $ledger->dr_pos = 0;
            $is_saved = $ledger->save();

            return redirect('purchase_entry')->with('message','Supplier add successful.');
        }

    }


    public function getPurchaseMemosInfo(Request $request){
        $memo_no = $request->memo;

        $memo_id = \Illuminate\Support\Facades\DB::table('purchase_main')
            ->select('id')
            ->where('entry_no', $memo_no)
            ->first()
            ->id;
        return redirect('edit_purchase_info/'.$memo_id);
    }

    public function editPurchaseInfoForm($purchase_id){

        $entry_id = DB::table('entries')->select('id')->where('sale_purchase_id', 'purchase_'.$purchase_id)->first()->id;

        $purchase_info = \Illuminate\Support\Facades\DB::table('purchase_main')
            ->where('purchase_main.id', $purchase_id)->first();

        $warehouse_id = $purchase_info->warehouse_id;

        $supplier_name = DB::table('supplier_info')
            ->select('supplier_name')->where('id', $purchase_info->supplier_id)->first()->supplier_name;
        $warehouse_name = DB::table('warehouse')
            ->select('warehouse_name')->where('id', $purchase_info->warehouse_id)->first()->warehouse_name;

        // memo account info
        $purchase_arr = array();
        $purchase_arr['purchase_id'] = $purchase_info->id;
        $purchase_arr['entry_no'] = $purchase_info->entry_no;
        $purchase_arr['entry_date'] = date('Y-m-d', $purchase_info->entry_date);
        $purchase_arr['supplier_id'] = $purchase_info->supplier_id;
        $purchase_arr['supplier_name'] = $supplier_name;
        $purchase_arr['warehouse_id'] = $purchase_info->warehouse_id;
        $purchase_arr['warehouse_name'] = $warehouse_name;
        $purchase_arr['total'] = $purchase_info->total;
        $purchase_arr['discount'] = $purchase_info->discount;
        $purchase_arr['due'] = $purchase_info->due;
        $purchase_arr['vat'] = $purchase_info->vat;
        $purchase_arr['tax'] = $purchase_info->tax;
        $purchase_arr['tax_p'] = $purchase_info->tax_p;
        $purchase_arr['vat_p'] = $purchase_info->vat_p;
        $purchase_arr['discount_p'] = $purchase_info->discount_p;
        $purchase_arr['memo_no'] = $purchase_info->memo_no;
        $purchase_arr['creator_id'] = $purchase_info->creator_id;
        $purchase_arr['remarks'] = $purchase_info->remarks;

        $purchase_entries = \Illuminate\Support\Facades\DB::table('purchase_single')->where('purchase_id', $purchase_id)->get();
        $entry_info_arr = array();

        // getting single wntry info
        foreach ($purchase_entries as $entry){

            $quantity = $entry->quantity;
            $qt_per_carton = $entry->qt_per_carton;

            $carton = intval($quantity/$qt_per_carton);
            $pieces = intval($quantity % $qt_per_carton);

            $available_qt = \Illuminate\Support\Facades\DB::table('warehouse_product')->select('available_qt')
                ->where('warehouse_id', $purchase_info->warehouse_id)
                ->where('product_id', $entry->product_id)
                ->first()->available_qt;

            $product_name = DB::table('product_info')->select('product_name')->where('id', $entry->product_id)->first()->product_name;
            $cat_name = DB::table('catagory')->select('cname')->where('id', $entry->product_type_id)->first()->cname;

            array_push($entry_info_arr,
                array(
                'purchase_id'           =>$purchase_info->id ,
                'entry_id'              =>$entry->id ,
                'product_type_id'       =>$entry->product_type_id,
                'cat_name'              =>$cat_name,
                'available_qt'          =>$available_qt,
                'product_id'            =>$entry->product_id,
                'product_name'          =>$product_name,
                'qt_per_carton'         =>$entry->qt_per_carton,
                'carton'                =>$carton,
                'pieces'                =>$pieces,
                'quantity'              =>$entry->quantity,
                'product_rate'          =>$entry->product_rate,
                'total'                 =>$entry->total,
                ));
                //ss
        }


        /*echo '<pre>';
        print_r($purchase_arr);
        echo '</pre>';*/

        // getting other necessary information to show in form
        $supplier = DB::table('supplier_info')->get();
        $category = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->get();
        $cat_info[] = array();
        foreach ($category as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;
            $products = \Illuminate\Support\Facades\DB::table("product_info")
                ->select('id', 'product_name')
                ->where('product_type_id', $cat_id)->get();

            if (sizeof($products)!=0) {
                $cat_info[$cat_id][] = array();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $product_name = $product->product_name;

                    $cat_info[$cat_id][$product_id]['p_id'] = $product_id;
                    $cat_info[$cat_id][$product_id]['p_name'] = $product_name;
                    $cat_info[$cat_id][$product_id]['cat_id'] = $cat_id;
                    $cat_info[$cat_id][$product_id]['cat_name'] = $cat_name;
                    unset($cat_info[$cat_id][0]);
                }
                unset($cat_info[0]);
            }
        }

        return view('admin.purchase.edit_purchase', compact('warehouse_id', 'purchase_arr', 'entry_info_arr', 'supplier', 'category', 'warehouses', 'cat_info', 'purchase_id', 'entry_id'));
    }



    public function editPurchaseInfo(Request $request){


        $supplier_led_id  = Ledger::select('ledgers.id as led_id')->join('supplier_info', 'supplier_info.supplier_id', '=', 'ledgers.name')->where('supplier_info.id', $request->supplier_id)->first()->led_id;


        // deleting old inputs
        $old_purchase_id = $request->old_memo_id;
        $entry_id = $request->entry_id;
        $old_warehouse_id = $request->old_warehouse_id;
        $old_product_ids = $request->old_product_id;
        $old_quantities = $request->old_quantity;



        DB::table('entries')->where('id', $entry_id)->delete();
        DB::table('single_entry')->where('entry_id', $entry_id)->delete();
        DB::table('purchase_main')->where('id', $old_purchase_id)->delete();
        DB::table('purchase_single')->where('purchase_id', $old_purchase_id)->delete();

        foreach ($old_product_ids as $key=>$value){
            $old_product_id = $old_product_ids[$key];
            $old_quantity = $old_quantities[$key];

            $warhouse_info = DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)->first();

            DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)
                ->update([
                    'product_in'=>$warhouse_info->product_in-$old_quantity,
                    'available_qt'=>$warhouse_info->available_qt-$old_quantity,
                ]);

        }

        // getting form info
        $entry_date = strtotime($request->entry_date);
        $discount = (isset($request->discount))? $request->discount :0;
        $vat = (isset($request->vat))? $request->vat :0;
        $tax = (isset($request->tax))? $request->tax :0;
        $vat_p = (isset($request->vat_p))? $request->vat_p :0;
        $tax_p = (isset($request->tax_p))? $request->tax_p :0;
        $discount_p = (isset($request->discount_p))? $request->discount_p :0;

//        echo $entry_date. ',  '.$discount.', '.$vat.', '.$tax. ', '.$vat_p.', '.$tax_p. ', '.$discount_p;



        // purchase entry in purchase main table .
        $purchase_main = new Purchase();
        $purchase_main->id = $old_purchase_id;
        $purchase_main->entry_date = $entry_date;
        $purchase_main->entry_no = $request->entry_no;
        $purchase_main->supplier_id = $request->supplier_id;
        $purchase_main->warehouse_id = $request->warehouse_id;
        $purchase_main->total = $request->column_total;
        $purchase_main->discount = $discount;
        $purchase_main->due = $request->balance;
        $purchase_main->vat = $vat;
        $purchase_main->tax = $tax;
        $purchase_main->vat_p = $vat_p;
        $purchase_main->tax_p = $tax_p;
        $purchase_main->discount_p = $discount_p;
        $purchase_main->memo_no = $request->ref_no;
        $purchase_main->remarks = $request->remarks;
        $purchase_main->creator_id = \Illuminate\Support\Facades\Auth::id();
//        $purchase_main->creator_id = $user_id;
        $purchase_main->created_at = $this->getDate();
        $purchase_id = $purchase_main->id;
        $success = $purchase_main->save();
//        $success = 1;


        if ($success){

            $product_code_names = $request->product_code;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;

            $purchase_id = $purchase_main->id;
//            $purchase_id = 1;


            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'purchase_'.$purchase_id;
            $entry->save();
            $entry_id = $entry->id;


            // saving single transaction in single_entry table
            //saving dr entry (purchase debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 74;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (Acc payable credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = $supplier_led_id;
            $single_entry_cr->amount = str_replace(',', '', $request->column_total);;
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();


            foreach ($product_types as $key=>$value){

                // saving each purchase item
                $product_type = $product_types[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];

                // saving single purchase in purchase_single table
                DB::table('purchase_single')->insert([
                    'purchase_id'=>$purchase_id,
                    'product_type_id'=>$product_type,
                    'entry_date'=>$entry_date,
                    'supplier_id'=>$request->supplier_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);




                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$request->warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count == 0){
                    $insert_sql = DB::table('warehouse_product')->insert([
                        'product_id' => $product_code_name,
                        'warehouse_id' => $request->warehouse_id,
                        'product_in' => $quantity,
                        'product_out' => 0,
                        'available_qt' => $quantity,
                    ]);
                }else{
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$request->warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity_to = $warehouse_to_info->product_in + $quantity;
                    $available_to      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$request->warehouse_id)
                        ->update([
                            'product_in' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);
                }


//                echo $product_type.'/ '.$rate.'/ '.$qt_per_carton.'/ '.$quantity.'/ '.$total;
            }
        }
        return redirect('show_purchase_Byid/'.$purchase_id);

    }


    public function showPurchaseReturnMemoInfo(Request $request){

        $memo_no = $request->memo;
//        echo $memo_no;

        $return_main_info = DB::table('purchase_return_main')
            ->select('purchase_return_main.*', 'supplier_info.supplier_name')
            ->join('supplier_info', 'supplier_info.id', '=', 'purchase_return_main.supplier_id')
            ->where('memo_no', $memo_no)->first();
        $single_returns = DB::table('purchase_return_details')->where('purchase_return_id', $return_main_info->id)->get();
        $entry_id = DB::table('entries')->select('id')->where('sale_purchase_id', 'purchase_'.$return_main_info->id)->first()->id;

        $info_arr = array();
        $info_arr['entry_date1'] = date('Y-m-d', $return_main_info->entry_date);
        $info_arr['old_id'] = $return_main_info->id;
        $info_arr['supplier_id'] = $return_main_info->supplier_id;
        $info_arr['supplier_name'] = $return_main_info->supplier_name;
        $info_arr['warehouse_id'] = $return_main_info->warehouse_id;
        $info_arr['total'] = str_replace(',', '', $return_main_info->total);
        $info_arr['memo_no'] = $return_main_info->memo_no;
        $info_arr['ref_no'] = $return_main_info->ref_no;
        $info_arr['tax_p'] = $return_main_info->tax_p;
        $info_arr['vat_p'] = $return_main_info->vat_p;


        $entry_info_arr = array();
        foreach ($single_returns as $entry){

            $quantity = $entry->quantity;
            $qt_per_carton = $entry->qt_per_carton;

            $carton = intval($quantity/$qt_per_carton);
            $pieces = intval($quantity % $qt_per_carton);

            $available_qt = \Illuminate\Support\Facades\DB::table('warehouse_product')->select('available_qt')
                ->where('warehouse_id', $return_main_info->warehouse_id)
                ->where('product_id', $entry->product_id)
                ->first()->available_qt;

            $product_name = DB::table('product_info')->select('product_name')->where('id', $entry->product_id)->first()->product_name;
            $cat_name = DB::table('catagory')->select('cname')->where('id', $entry->product_type_id)->first()->cname;

            array_push($entry_info_arr,
                array(
                    'entry_id'              =>$entry->id ,
                    'product_type_id'       =>$entry->product_type_id,
                    'cat_name'              =>$cat_name,
                    'available_qt'          =>$available_qt,
                    'product_id'            =>$entry->product_id,
                    'product_name'          =>$product_name,
                    'qt_per_carton'         =>$entry->qt_per_carton,
                    'carton'                =>$carton,
                    'pieces'                =>$pieces,
                    'quantity'              =>$entry->quantity,
                    'product_rate'          =>$entry->product_rate,
                    'total'                 =>$entry->total,
                ));
            //ss
        }

        // other info
        $supplier = DB::table('supplier_info')->get();
        $category = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->get();
        $cat_info[] = array();
        foreach ($category as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;
            $products = \Illuminate\Support\Facades\DB::table("product_info")
                ->select('id', 'product_name')
                ->where('product_type_id', $cat_id)->get();

            if (sizeof($products)!=0) {
                $cat_info[$cat_id][] = array();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $product_name = $product->product_name;

                    $cat_info[$cat_id][$product_id]['p_id'] = $product_id;
                    $cat_info[$cat_id][$product_id]['p_name'] = $product_name;
                    $cat_info[$cat_id][$product_id]['cat_id'] = $cat_id;
                    $cat_info[$cat_id][$product_id]['cat_name'] = $cat_name;
                    unset($cat_info[$cat_id][0]);
                }
                unset($cat_info[0]);
            }
        }

        return view('admin.purchase.edit_purchase_return_info',compact('info_arr', 'entry_info_arr', 'cat_info','supplier', 'category', 'warehouses'));

    }


    public function editPurchaseReturnInfo(Request $request){

        $old_id = $request->old_pr_id;
        $entry_id = DB::table('entries')->select('id')->where('sale_purchase_id', 'purchase_return_'.$old_id)->first()->id;
        $old_warehouse_id = $request->old_warehouse_id;
        $old_product_ids = $request->old_product_id;
        $old_quantities = $request->old_quantity;

        foreach ($old_product_ids as $key=>$value){
            $old_product_id = $old_product_ids[$key];
            $old_quantity = $old_quantities[$key];

            $warhouse_info = DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)->first();

            DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)
                ->update([
                    'product_out'=>$warhouse_info->product_out-$old_quantity,
                    'available_qt'=>$warhouse_info->available_qt+$old_quantity,
                ]);

        }


        DB::table('purchase_return_main')->where('id', $old_id)->delete();
        DB::table('purchase_return_details')->where('purchase_return_id', $old_id)->delete();
        DB::table('entries')->where('sale_purchase_id', 'purchase_return_'.$old_id)->delete();
        DB::table('single_entry')->where('entry_id', $entry_id)->delete();

        $product_types = $request->product_type;
        $product_code_names = $request->product_code;
        $rates = $request->product_rate;
        $qt_per_cartons = $request->qt_per_carton;
        $quantities = $request->quantity;
        $totals = $request->total;
        /*echo '<pre>';
        print_r($quantities);
        echo '</pre>';
        die;*/

        $this->validate($request,[
            'entry_date' => 'required',
            'ref_no' => 'required',
            'supplier_id' => 'not_in:0',
            'product_type' => 'not_in:0',
        ]);

        $supplier_led_id  = Ledger::select('ledgers.id as led_id')->join('supplier_info', 'supplier_info.supplier_id', '=', 'ledgers.name')->where('supplier_info.id', $request->supplier_id)->first()->led_id;

        // saving entry in purchase_return_main table
        $purchase_return = new PurchaseReturn();
        $purchase_return->id = $old_id;
        $purchase_return->entry_date = strtotime($request->entry_date);
        $purchase_return->supplier_id = $request->supplier_id;
        $purchase_return->warehouse_id = $request->warehouse_id;
        $purchase_return->total = $request->column_total;
        $purchase_return->memo_no = $request->memo_no;
        $purchase_return->ref_no = $request->ref_no;
        $purchase_return->creator_id = \Illuminate\Support\Facades\Auth::id();
        $purchase_return->created_at = $this->getDate();
        $saved = $purchase_return->save();
//        $saved = 1;

        if ($saved) {

            // saving entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'purchase_return_'.$purchase_return->id;
            $entry->save();
            $entry_id = $entry->id;



            //saving cr entry (purchase credit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 74;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'C';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();


            //saving cr entry (Acc payable debit)
            $single_entry_dr = new SingleEntry();
            $single_entry_dr->entry_id = $entry_id;
            $single_entry_dr->ledger_id = $supplier_led_id;
            $single_entry_dr->amount = str_replace(',', '', $request->column_total);
            $single_entry_dr->dc = 'D';
            $single_entry_dr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_dr->save();



            // getting product info
            /*$product_types = $request->product_type;
            $product_code_names = $request->product_code;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;*/


//            $purchase_return_id = 1;
            $purchase_return_id = $purchase_return->id;

            foreach ($product_code_names as $key=>$value) {

                // getting each purchase return item
                $product_type = $product_types[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];


                DB::table('purchase_return_details')->insert([

                    'purchase_return_id'=>$purchase_return_id,
                    'product_type_id'=>$product_type,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);

                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')
                    ->where('warehouse_id',$request->warehouse_id)
                    ->where('product_id', $product_code_name)
                    ->get()
                    ->count();

                if ($warehouse_status_count != 0){

                    $warehouse_to_info = DB::table('warehouse_product')
                        ->where('warehouse_id',$request->warehouse_id)
                        ->where('product_id', $product_code_name)->first();

                    $store_quantity_to = $warehouse_to_info->product_out + $quantity;
                    $available_to      = $warehouse_to_info->available_qt - $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$request->warehouse_id)
                        ->update([
                            'product_out' => $store_quantity_to,
                            'available_qt'  => $available_to,
                            'created_at' => $this->getDate(),
                        ]);
                }


            }
            return redirect('purchase_return')->with('message','products return successful.');

        }
    }



    // class ends
}
