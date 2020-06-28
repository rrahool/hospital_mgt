<?php

namespace App\Http\Controllers;

use App\Client;
use App\Entry;
use App\Ledger;
use App\memoAccount;
use App\memoReturnAccount;
use App\SingleEntry;
use Illuminate\Http\Request;
use DB;
use Auth;

class sellController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }

    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    public function getCreator(){
        $creator_id = auth::user()->id;
        return $creator_id;
    }

    static function getMemoNo() {

        $lastId = DB::table('memo_account')->select('id')->orderby('id', 'desc')->first();

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

    static function getReturnNo(){

        $lastId = DB::table('return_memo_account')->select('id')->orderby('id', 'desc')->first();

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


    /*
     * creating new Client
     * */
    public function createClient(Request $request){

        $this->validate($request,[
            'client_name' => 'required',
        ]);

        $check = DB::table('client_info')->where('client_name',$request->client_name)->first();
        if ($check){
            return back()->with('expression','This client already existis');
        }else{
            $create = DB::table('client_info')->insert([
                'client_name'  => $request->client_name,
//                'company_name' => $request->company_name,
                'address'      => $request->address,
                'email'        => $request->email,
                'contact_no'   => $request->contact_no,
                'creator_id'   => $this->getCreator(),
                'created_at'   => $this->getDate(),
            ]);

            return back()->with('message','Client add successful.');
        }
    }


    public function index(){

        $term_and_condition = DB::table('settings')->select('terms')->orderby('id', 'desc')->first();
        $memo_no = static::getMemoNo();
        $category = DB::table('catagory')->get();
        $client_info = Client::select('*')->get();
        $warehouse_info = DB::table('warehouse')->get();

        /*$cat_info[] = array();
        foreach ($category as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;*/
            $products = \Illuminate\Support\Facades\DB::table("product_info")
                ->select('id', 'product_name', 'code')
                ->get();


            $cat_id = 1;
            if (sizeof($products)!=0) {
                $cat_info[$cat_id][] = array();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $product_name = $product->product_name;
                    $product_code = $product->code;

                    $cat_info[$cat_id][$product_id]['p_id'] = $product_id;
                    $cat_info[$cat_id][$product_id]['p_name'] = $product_name;
                    $cat_info[$cat_id][$product_id]['p_code'] = $product_code;
                    $cat_info[$cat_id][$product_id]['cat_id'] = $cat_id;
                    $cat_info[$cat_id][$product_id]['cat_name'] = 'N/A';
                    unset($cat_info[$cat_id][0]);
                }
                unset($cat_info[0]);
            }


//        }
/*

        echo '<pre>';
        print_r($cat_info);
        echo '</pre>';
        die();*/

        return view('admin.sale.create_sell',[
            'term_and_condition' => $term_and_condition,
            'category'           => $category,
//            'term_and_condition' => $term_and_condition,
            'client_info'        => $client_info,
            'memo_no'            => $memo_no,
            'warehouse_info'     => $warehouse_info,
            'cat_info'           => $cat_info,
//            'clients'            => $clients,

        ]);
    }

    /*
        * saving Sell Product info in db
        * */
    public function storeSellProduct(Request $request){


        $this->validate($request, [
            'entry_date'    => 'required',
            'client_id'     => 'not_in:0',
            'product_type'  => 'not_in:0',

        ]);


        $client_led_id  = Ledger::select('ledgers.id as led_id')
            ->join('clients', 'clients.client_id', '=', 'ledgers.name')
            ->where('clients.id', $request->client_id)
            ->first()->led_id;
//        echo $client_led_id;
        $discount = ($request->discount > 0)? $request->discount : 0;
        $discount_p = ($request->discount_p > 0)? $request->discount_p : 0;
        $vat = ($request->vat > 0)? $request->vat : 0;
        $vat_p = ($request->vat_p > 0)? $request->vat_p : 0;
        $tax = ($request->tax > 0)? $request->tax : 0;
        $tax_p = ($request->tax_p > 0)? $request->tax_p : 0;
        $received = $request->received;
        $journal_total = str_replace(',', '', $request->column_total);
        if ($received == null || $received<0){
            $received = 0;
        }

        // saving memo info
        $memo = new memoAccount();
        $memo->entry_date       = strtotime($request->entry_date);
        $memo->delivery_date    = strtotime($request->delivery_date);
        $memo->patient_name     = $request->patient_name;
        $memo->gender           = $request->gender;
        $memo->age              = $request->age;
        $memo->contact_no       = $request->contact_no;
        $memo->client_id        = $request->client_id;
        $memo->ref_no           = $request->ref_no;
        $memo->memo_no          = $request->memo_no;
        $memo->total_price      = $request->column_total;
        $memo->received_amount  = $received;
        $memo->vat         = $vat;
        $memo->tax         = $tax;
        $memo->tax_p       = $tax_p;
        $memo->vat_p       = $vat_p;
        $memo->discount    = $discount;
        $memo->discount_p  = $discount_p;
        $memo->due         = $request->due;
        $memo->terms       = $request->terms;
        $memo->creator_id  = \Illuminate\Support\Facades\Auth::id();
//        $memo->creator_id  = $this->getCreator();
        $memo->created_at  = $this->getDate();
        $memo_saved = $memo->save();
//        $memo_saved = 1;

        if ($memo_saved){
            $memo_id = $memo->id;
//            $memo_id = 3;
            \Illuminate\Support\Facades\DB::table('stock_transaction_sl')->insert(['trans_id'=>'sale_'.$memo_id]);

            $product_code_names = $request->product_code;
            $warehouse_ids = 1;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $single_discount_amount = $request->single_discount_amount;
            $single_discount_rates = $request->single_discount_rate;
            $totals = $request->total;
            $due = $request->due;


            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $journal_total);
            $entry->cr_total = str_replace(',', '', $journal_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'sale_journal_'.$memo_id;
            $entry->save();
            $entry_id = $entry->id;


            // saving single transaction in single_entry table
            //saving dr entry (acc receivable debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = $client_led_id;
            $single_entry->amount = str_replace(',', '', $journal_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (revenue credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = 77;
            $single_entry_cr->amount = str_replace(',', '', $journal_total);
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();



            //$rec = str_replace(',', '',$received);

            if ($received > 0){
                // receipt entry
                $rec_entry = new Entry();
                $rec_entry->entrytype_id = 1;
                $rec_entry->date = $this->getDate();
                $rec_entry->dr_total = $received;
                $rec_entry->cr_total = $received;
                $rec_entry->number = $request->ref_no;
                $rec_entry->sale_purchase_id = 'sale_received_'.$memo_id;
//            $entry->narration = $narration;
                $saved = $rec_entry->save();
                $rec_entry_id = $rec_entry->id;


                //cash debit
                $single_rec_entry = new SingleEntry();
                $single_rec_entry->entry_id = $rec_entry_id;
                $single_rec_entry->ledger_id = 37;
                $single_rec_entry->amount = str_replace(',', '', $received);
                $single_rec_entry->dc = 'D';
                $single_rec_entry->transaction_date = $this->getDate();
                //$single_entry->reconciliation_date = "";
                $single_rec_entry->save();

                //account rec credit
                $single_rec_entry_cr = new SingleEntry();
                $single_rec_entry_cr->entry_id = $rec_entry_id;
                $single_rec_entry_cr->ledger_id = $client_led_id;
                $single_rec_entry_cr->amount = str_replace(',', '', $received);
                $single_rec_entry_cr->dc = 'C';
                $single_rec_entry_cr->transaction_date = $this->getDate();
                //$single_entry->reconciliation_date = "";
                $single_rec_entry_cr->save();


            }



            foreach ($product_types as $key=>$value){

                // saving each sale item
                $product_type = $product_types[$key];
                $warehouse_id = 1;
//                $warehouse_id = $warehouse_ids[$key];
                $product_code_name = $product_code_names[$key];
                $rate = 1;
//                $rate = $rates[$key];
//                $qt_per_carton = $qt_per_cartons[$key];
                $qt_per_carton = 1;
                $quantity = $quantities[$key];
                $single_discount = $single_discount_amount[$key];
                $single_discount_rate = $single_discount_rates[$key];
                $total = $totals[$key];

                // saving single sale in memo_entry table
                DB::table('memo_entry')->insert([
                    'memo_id'=>$memo_id,
                    'product_type_id'=>$product_type,
                    'warehouse_id'=>$warehouse_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'single_discount'=>$single_discount,
                    'single_discount_rate'=>$single_discount_rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);

                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count != 0){
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity = $warehouse_to_info->product_out + $quantity;
                    $available      = $warehouse_to_info->available_qt - $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$warehouse_id)
                        ->update([
                            'product_out' => $store_quantity,
                            'available_qt'  => $available,
                            'created_at' => $this->getDate(),
                        ]);
                }

            }
        }
        $id = $memo->id;

//        return redirect('sell_view_by/'.$id);
        return redirect('print_bill_report/'.$id);

//        return back()->with('message','Sale insert successful.');
    }



    /*
     * showing form of editing sale info
     * */
    public function editSaleForm(){
        return view('admin.sale.edit_sell');
    }



    /*
     * getting client info by selecting client
     * */
    public function getClientInfo(){
        $client_id = $_GET['client_id'];

        $client_info = \Illuminate\Support\Facades\DB::table('clients')->select('clients.address', 'ledgers.id', 'ledgers.op_balance', 'ledgers.op_balance_dc')
            ->join('ledgers', 'clients.client_id', '=', 'ledgers.name')
            ->where('clients.id', $client_id)->first();
        $client_address = $client_info->address;
        $led_id = $client_info->id;
        $dc = $client_info->op_balance_dc;
        $op_balance = $client_info->op_balance;
        $dr_amount = SingleEntry::select('amount')->where('dc', 'D')->where('ledger_id', $led_id)->sum('amount');
        $cr_amount = SingleEntry::select('amount')->where('dc', 'C')->where('ledger_id', $led_id)->sum('amount');
//        $due =  $dr_amount - $cr_amount;
        if ($dc == 'D'){
            $due =  $dr_amount - $cr_amount + $op_balance;
        }else if ($dc == 'C'){
            $due =  $dr_amount - $cr_amount - $op_balance;
        }

        $due = str_replace('-', '', $due);
        $due = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $due);

        $output = '
                                    <div id="client_info_div" >
                                               <div class="form-row row"  >
                                               <div class="form-group col-md-6">
                                                    <label>Address</label>
                                                    <input class="form-control client_address" placeholder="" type="text" value="'.$client_address.'"  id="client_address" data-validation="required">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Client Due</label>
                                                    <input class="form-control" value="'.$due.'" placeholder="" type="text" name="client_due">
                                                </div>
                                                </div>
                                            </div>
                                   
        ';

        echo $output;
    }



    /*
     * sold Products List
     * */
    public function sellList(){
        $sell_list = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->select('memo_account.*','clients.client_name')
            ->get();
        return view('admin.sale.sell_list',[
            'sell_list' => $sell_list
        ]);
    }



    public function editSale(Request $request){

        $memo_no = $request->memo;
//        echo $memo_no;
        $memo_id = \Illuminate\Support\Facades\DB::table('memo_account')->select('id')->where('memo_no', $memo_no)->first()->id;
//        echo $memo_id;

        return redirect('edit_memo/'.$memo_id);
//        $this->editMemoForm($memo_id);
    }

    public function editMemoForm($memo_id){


        $memo_info = \Illuminate\Support\Facades\DB::table('memo_account')
            ->where('memo_account.id', $memo_id)->first();

        $journal_info = \Illuminate\Support\Facades\DB::table('entries')
            ->select('entries.id as entry_id','entries.dr_total', 'entries.date', 'entries.sale_purchase_id', 'single_entry.ledger_id','single_entry.dc', 'single_entry.id as single_entry_id')
            ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')
            ->Where('entries.sale_purchase_id', 'sale_journal_'.$memo_id)
//            ->where('single_entry.dc', 'C')
            ->get();

        $received_info = \Illuminate\Support\Facades\DB::table('entries')
            ->select('entries.id as entry_id','entries.dr_total', 'entries.date', 'entries.sale_purchase_id', 'single_entry.ledger_id','single_entry.dc', 'single_entry.id as single_entry_id')
            ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')
            ->Where('entries.sale_purchase_id', 'sale_received_'.$memo_id)
//            ->where('single_entry.dc', 'C')
            ->get();

        $rc_entry = \Illuminate\Support\Facades\DB::table('entries')->select('entries.id')
            ->Where('sale_purchase_id', 'sale_received_'.$memo_id)->first();
        $journal_entry = \Illuminate\Support\Facades\DB::table('entries')
            ->select('entries.id')->Where('entries.sale_purchase_id', 'sale_journal_'.$memo_id)->first();

        $rc_id = (!empty($rc_entry))?$rc_entry->id:0;
        $journal_id = (!empty($journal_entry))?$journal_entry->id:0;


        $memo_entries = \Illuminate\Support\Facades\DB::table('memo_entry')->where('memo_id', $memo_id)->get();
        $entry_info_arr = array();

        foreach ($memo_entries as $entry){

            $quantity = $entry->quantity;
            $qt_per_carton = $entry->qt_per_carton;

            $carton = intval($quantity/$qt_per_carton);
            $pieces = $quantity%$qt_per_carton;

            $available_qt = \Illuminate\Support\Facades\DB::table('warehouse_product')->select('available_qt')
                ->where('warehouse_id', $entry->warehouse_id)
                ->where('product_id', $entry->product_id)
                ->first()->available_qt;

            array_push($entry_info_arr,
                array(
                    'entry_id'              =>$entry->id ,
                    'warehouse_id'          =>$entry->warehouse_id,
                    'product_type_id'       =>$entry->product_type_id,
                    'available_qt'          =>$available_qt,
                    'product_id'            =>$entry->product_id,
                    'qt_per_carton'         =>$entry->qt_per_carton,
                    'carton'                =>$carton, 'pieces'=>$pieces,
                    'quantity'              =>$entry->quantity,
                    'product_rate'          =>$entry->product_rate,
                    'single_discount_rate'  =>$entry->single_discount_rate,
                    'single_discount'       =>$entry->single_discount,
                    'total'                 =>$entry->total
                ));

        }

        $category = DB::table('catagory')->get();
        $client_info = Client::select('*')->get();
        $warehouse_info = DB::table('warehouse')->get();


        $client_info_1 = \Illuminate\Support\Facades\DB::table('clients')->select('clients.address', 'ledgers.id')
            ->join('ledgers', 'clients.client_id', '=', 'ledgers.name')
            ->where('clients.id', $memo_info->client_id)->first();
        $client_address = $client_info_1->address;
        $led_id = $client_info_1->id;
        $dr_amount = SingleEntry::select('amount')->where('dc', 'D')->where('ledger_id', $led_id)->sum('amount');
        $cr_amount = SingleEntry::select('amount')->where('dc', 'C')->where('ledger_id', $led_id)->sum('amount');
        $due = $cr_amount - $dr_amount;
        $due = str_replace('-', '', $due);
        $due = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $due);

        /*echo '<pre>';
        print_r($journal_info);
        echo '//// received';
        print_r($received_info);
        echo '//// memo info';
        print_r($entry_info_arr);
        echo '</pre>';
        die;*/

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



        return view('admin.sale.edit_memo', compact('cat_info','rc_id','journal_id','client_address','due','journal_info', 'received_info', 'entry_info_arr', 'memo_info', 'category', 'client_info', 'warehouse_info'));


    }


    public  function editMemo(Request $request){



        $this->validate($request, [
            'entry_date'    => 'required',
            'client_id'     => 'not_in:0',
            'product_type'  => 'not_in:0',

        ]);

        // deleting old inputs
        $old_memo_id = $request->old_memo_id;
        $journal_entry_id = $request->journal_entry_id;
        $received_entry_id = $request->received_entry_id;

        // deleting old inputs
        \Illuminate\Support\Facades\DB::table('memo_account')->where('id', $old_memo_id)->delete();
        \Illuminate\Support\Facades\DB::table('memo_entry')->where('memo_id', $old_memo_id)->delete();
        \Illuminate\Support\Facades\DB::table('entries')->where('id', $journal_entry_id)->delete();
        \Illuminate\Support\Facades\DB::table('entries')->where('id', $received_entry_id)->delete();
        \Illuminate\Support\Facades\DB::table('single_entry')->where('entry_id', $journal_entry_id)->delete();
        \Illuminate\Support\Facades\DB::table('single_entry')->where('entry_id', $received_entry_id)->delete();

        $old_product_ids = $request->old_product_id;
        $old_warehouse_ids = $request->old_warehouse_id;
        $old_quantities = $request->old_quantity;

        // updating warehouse product status
        foreach ($old_product_ids as $key=>$value){
            $old_product_id = $old_product_ids[$key];
            $old_warehouse_id = $old_warehouse_ids[$key];
            $old_quantity = $old_quantities[$key];

            $warhouse_info = \Illuminate\Support\Facades\DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)->first();

            \Illuminate\Support\Facades\DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)
                ->update([
                    'product_out'=>$warhouse_info->product_out-$old_quantity,
                    'available_qt'=>$warhouse_info->available_qt+$old_quantity,
                ]);

        }



        // creating new sale entry
        $client_led_id  = Ledger::select('ledgers.id as led_id')->
        join('clients', 'clients.client_id', '=', 'ledgers.name')->where('clients.id', $request->client_id)->first()->led_id;
//        echo $client_led_id;
        $discount = ($request->discount > 0)? $request->discount : 0;
        $discount_p = ($request->discount_p > 0)? $request->discount_p : 0;
        $vat = ($request->vat > 0)? $request->vat : 0;
        $vat_p = ($request->vat_p > 0)? $request->vat_p : 0;
        $tax = ($request->tax > 0)? $request->tax : 0;
        $tax_p = ($request->tax_p > 0)? $request->tax_p : 0;
        $received = $request->received;
        $journal_total = str_replace(',', '', $request->column_total);

        if ($received == null || $received<0){
            $received = 0;
        }

        // saving memo info
        $memo = new memoAccount();
        $memo->id          = $old_memo_id;
        $memo->entry_date  = strtotime($request->entry_date);
        $memo->client_id   = $request->client_id;
        $memo->patient_name   = $request->patient_name;
        $memo->ref_no      = $request->ref_no;
        $memo->memo_no     = $request->memo_no;
        $memo->total_price = $request->column_total;
        $memo->received_amount = $received;
        $memo->vat         = $vat;
        $memo->tax         = $tax;
        $memo->tax_p       = $tax_p;
        $memo->vat_p       = $vat_p;
        $memo->discount    = $discount;
        $memo->discount_p  = $discount_p;
        $memo->due         = $request->due;
        $memo->terms       = $request->terms;
        $memo->creator_id  = \Illuminate\Support\Facades\Auth::id();
//        $memo->creator_id  = $this->getCreator();
        $memo->created_at  = $this->getDate();
        $memo_saved = $memo->save();
//        $memo_saved = 1;
//        jjh

        if ($memo_saved){
            $memo_id = $memo->id;
//            $memo_id = 3;

            $product_code_names = $request->product_code;
            $warehouse_ids = $request->warehouse;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $single_discount_amount = $request->single_discount_amount;
            $single_discount_rates = $request->single_discount_rate;
            $totals = $request->total;
            $due = $request->due;


            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $journal_total);
            $entry->cr_total = str_replace(',', '', $journal_total);
            $entry->narration = $request->remarks;
            $entry->number = $request->ref_no;
            $entry->sale_purchase_id = 'sale_journal_'.$memo_id;
            $entry->save();
            $entry_id = $entry->id;


            // saving single transaction in single_entry table
            //saving dr entry (acc receivable debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = $client_led_id;
            $single_entry->amount = str_replace(',', '', $journal_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (revenue credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = 77;
            $single_entry_cr->amount = str_replace(',', '', $journal_total);
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();



            //$rec = str_replace(',', '',$received);

            if ($received > 0){
                // receipt entry
                $rec_entry = new Entry();
                $rec_entry->entrytype_id = 1;
                $rec_entry->date = $this->getDate();
                $rec_entry->dr_total = $received;
                $rec_entry->cr_total = $received;
                $rec_entry->number = $request->ref_no;
                $rec_entry->sale_purchase_id = 'sale_received_'.$memo_id;
//            $entry->narration = $narration;
                $saved = $rec_entry->save();
                $rec_entry_id = $rec_entry->id;


                //cash debit
                $single_rec_entry = new SingleEntry();
                $single_rec_entry->entry_id = $rec_entry_id;
                $single_rec_entry->ledger_id = 37;
                $single_rec_entry->amount = str_replace(',', '', $received);
                $single_rec_entry->dc = 'D';
                $single_rec_entry->transaction_date = $this->getDate();
                //$single_entry->reconciliation_date = "";
                $single_rec_entry->save();

                //account rec credit
                $single_rec_entry_cr = new SingleEntry();
                $single_rec_entry_cr->entry_id = $rec_entry_id;
                $single_rec_entry_cr->ledger_id = $client_led_id;
                $single_rec_entry_cr->amount = str_replace(',', '', $received);
                $single_rec_entry_cr->dc = 'C';
                $single_rec_entry_cr->transaction_date = $this->getDate();
                //$single_entry->reconciliation_date = "";
                $single_rec_entry_cr->save();


            }



            foreach ($product_types as $key=>$value){

                // saving each sale item
                $product_type = $product_types[$key];
                $warehouse_id = $warehouse_ids[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $single_discount = $single_discount_amount[$key];
                $single_discount_rate = $single_discount_rates[$key];
                $total = $totals[$key];

                // saving single sale in memo_entry table
                DB::table('memo_entry')->insert([
                    'memo_id'=>$memo_id,
                    'product_type_id'=>$product_type,
                    'warehouse_id'=>$warehouse_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'single_discount'=>$single_discount,
                    'single_discount_rate'=>$single_discount_rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);

                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count != 0){
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity = $warehouse_to_info->product_out + $quantity;
                    $available      = $warehouse_to_info->available_qt - $quantity;



                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$warehouse_id)
                        ->update([
                            'product_out' => $store_quantity,
                            'available_qt'  => $available,
                            'created_at' => $this->getDate(),
                        ]);
                }




                /*// saving or updating product_status
                $select_query = DB::table('product_status')->where('product_id',$product_code_name)->first();


                $store_out = $select_query->product_out + $quantity;
                $available = $select_query->available - $quantity;

                $update_sql = DB::table('product_status')->where('product_id',$product_code_name)->update([
                    'product_out' => $store_out,
                    'available' => $available,
                ]);*/



            }
        }
//        return back()->with('message','Sale insert successful.');
        return redirect('sell_view_by/'.$memo->id);
//        return redirect('sale_list');
    }


    /*
     * sell Info By product Id
     * */
    public function sellInfoById($id){

        $sell_view = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->join('users','memo_account.creator_id', '=', 'users.id')
            ->select('memo_account.*','memo_account.id as m_id','clients.*','clients.id as client_id','users.username')
            ->where('memo_account.id', $id)
            ->first();

        $single_sale_entries = DB::table('memo_entry')->where('memo_id',$id)->get();

        return view('admin.sale.sell_view_byId',[
            'sell_view'   => $sell_view,
            'single_sale_entries' => $single_sale_entries,
            'id'=>$id
        ]);

    }


    /*
     * showing Bill
     * */
    public function showBill($id){
        $sell_view = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->join('users','memo_account.creator_id', '=', 'users.id')
            ->select('memo_account.*','memo_account.id as m_id','clients.*','clients.id as client_id','users.username')
            ->where('memo_account.id', $id)
            ->first();

        $single_sale_entries = DB::table('memo_entry')->where('memo_id',$id)->get();
        return view('admin.sale.bill',[

            'sell_view'   => $sell_view,
            'single_sale_entries' => $single_sale_entries,
            'id'=>$id
        ]);
    }


    public function showOfficeCopy($id){

        $sell_view = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->join('users','memo_account.creator_id', '=', 'users.id')
            ->select('memo_account.*','memo_account.id as m_id','clients.*','clients.id as client_id','users.username')
            ->where('memo_account.id', $id)
            ->first();

        $single_sale_entries = DB::table('memo_entry')->where('memo_id',$id)->get();
        return view('admin.sale.office_copy',[

            'sell_view'   => $sell_view,
            'single_sale_entries' => $single_sale_entries,
            'id'=>$id
        ]);
    }


    public function printBill($id){
        $sell_view = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->join('users','memo_account.creator_id', '=', 'users.id')
            ->select('memo_account.*','memo_account.id as m_id','clients.*','clients.id as client_id','users.username')
            ->where('memo_account.id', $id)
            ->first();

        $single_sale_entries = DB::table('memo_entry')->where('memo_id',$id)->get();
        return view('admin.sale.bill_print',[

            'sell_view'   => $sell_view,
            'single_sale_entries' => $single_sale_entries,
            'id'=>$id
        ]);
    }



    public function printOfficeBill($id){
        $sell_view = DB::table('memo_account')
            ->join('clients','memo_account.client_id', '=', 'clients.id')
            ->join('users','memo_account.creator_id', '=', 'users.id')
            ->select('memo_account.*','memo_account.id as m_id','clients.*','clients.id as client_id','users.username')
            ->where('memo_account.id', $id)
            ->first();

        $single_sale_entries = DB::table('memo_entry')->where('memo_id',$id)->get();
        return view('admin.sale.office_copy_print',[

            'sell_view'   => $sell_view,
            'single_sale_entries' => $single_sale_entries,
            'id'=>$id
        ]);
    }



    /*
     * sale Return form
     * */
    public function saleReturn(){

        $memo_no = static::getReturnNo();
        $category = DB::table('catagory')->get();
        $client_info = DB::table('clients')->get();
        $warehouse_info = DB::table('warehouse')->get();

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

        return view('admin.sale.sale_return',[
            'memo_no'     =>$memo_no,
            'category'    =>$category,
            'client_info' =>$client_info,
            'cat_info' =>$cat_info,
            'warehouse_info' =>$warehouse_info

        ]);
    }


    /*
     * saving Sale Return info
     * */
    public function storeSaleReturn(Request $request){
        $client_led_id  = Ledger::select('ledgers.id as led_id')->join('clients', 'clients.client_id', '=', 'ledgers.name')->where('clients.id', $request->client_id)->first()->led_id;

        $memo_return = new memoReturnAccount();
        $memo_return->entry_date = strtotime($request->entry_date);
        $memo_return->client_id= $request->client_id;
        $memo_return->ref_no=$request->ref_no;
        $memo_return->memo_no=$request->memo_no;
        $memo_return->total_payable = $request->column_total;
//        $memo_return->creator_id= $this->getCreator();
        $memo_return->creator_id= \Illuminate\Support\Facades\Auth::id();
        $memo_return->created_at= $this->getDate();
        $saved = $memo_return->save();

        if ($saved){
            $memo_return_id = $memo_return->id;

            \Illuminate\Support\Facades\DB::table('stock_transaction_sl')->insert(['trans_id'=>'sale_return_'.$memo_return_id]);

            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
//            $entry->narration = $request->remarks;
            $entry->sale_purchase_id = 'sale_return_'.$memo_return->id;
            $entry->number = $request->ref_no;
            $entry->save();
            $entry_id = $entry->id;

            // saving single transaction in single_entry table
            //saving dr entry (revenue debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 77;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (acc receivable credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = $client_led_id;
            $single_entry_cr->amount = str_replace(',', '', $request->column_total);
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();



            //getting products info
            $product_code_names = $request->product_code;
            $warehouse_ids = $request->warehouse;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;

            foreach ($product_code_names as $key=>$value) {

                // saving each sale item
                $product_type = $product_types[$key];
                $warehouse_id = $warehouse_ids[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];

                // saving single sale in memo_entry table
                DB::table('return_memo_entry')->insert([
                    'return_memo_id'=>$memo_return_id,
                    'product_type_id'=>$product_type,
                    'warehouse_id'=>$warehouse_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);


                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count != 0){
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity = $warehouse_to_info->product_out - $quantity;
                    $available      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$warehouse_id)
                        ->update([
                            'product_out' => $store_quantity,
                            'available_qt'  => $available,
                            'created_at' => $this->getDate(),
                        ]);
                }




                //updating product_status
                /*$product_info = DB::table('product_status')->where('product_id', $product_code_name)->first();

                $store_return = $product_info->product_in;
                $store_quantity = $product_info->product_out - $quantity;
                $available = $product_info->available + $quantity;

                $update = DB::table('product_status')->where('product_id',$product_code_name)->update([
                    'product_in'  => $store_return,
                    'product_out' =>$store_quantity,
                    'available'   =>$available

                ]);*/
            }


        }
        return back()->with('message','sale return successful.');
    }


    /*
     * sale return List
     * */
    public function returnList(){

        $returnList = DB::table('return_memo_account')
            ->join('clients','return_memo_account.client_id', '=', 'clients.id')
            ->select('return_memo_account.*','clients.client_name')
            ->get();

        return view('admin.sale.sale_return_list',['returnList'=>$returnList]);
    }


    /*
     * view Bill by id
     * */
    public function viewBill($id){


        $view_bill = DB::table('return_memo_account')
            ->join('clients','return_memo_account.client_id', '=', 'clients.id')
            ->join('users','return_memo_account.creator_id', '=', 'users.id')
            ->select('return_memo_account.*','clients.*','clients.id as clientId','users.username')
            ->where('return_memo_account.id',$id)
            ->first();


        $entry_info = DB::table('return_memo_entry')->where('return_memo_id',$id)->get();


        return view('admin.sale.view_bill',['view_bill'=>$view_bill,'entry_info'=>$entry_info, 'id'=>$id]);
    }

    /*public function printBill(){

    }*/


    /*
     * print sale Return Bill by id
     * */
    public function printReturnBill($id){


        $view_bill = DB::table('return_memo_account')
            ->join('clients','return_memo_account.client_id', '=', 'clients.id')
            ->join('users','return_memo_account.creator_id', '=', 'users.id')
            ->select('return_memo_account.*','clients.*','clients.id as clientId','users.username')
            ->where('return_memo_account.id',$id)
            ->first();


        $entry_info = DB::table('return_memo_entry')->where('return_memo_id',$id)->get();


        return view('admin.sale.view_bill_print',['view_bill'=>$view_bill,'entry_info'=>$entry_info, 'id'=>$id]);
    }




    /*
     * return Challan
     * */
    public function returnChallan($id){

        $view_bill = DB::table('return_memo_account')
            ->join('clients','return_memo_account.client_id', '=', 'clients.id')
            ->join('users','return_memo_account.creator_id', '=', 'users.id')
            ->select('return_memo_account.*','clients.*','clients.id as clientId','users.username')
            ->where('return_memo_account.id',$id)
            ->first();


        $entry_info = DB::table('return_memo_entry')->where('return_memo_id',$id)->get();

        return view('admin.sale.return_challan',['view_bill'=>$view_bill,'entry_info'=>$entry_info]);

    }


    public function getSaleReturnMemoInfo(Request $request){

        $memo = $request->memo;

        $return_main_info = \Illuminate\Support\Facades\DB::table('return_memo_account')
            ->select('return_memo_account.*', 'clients.client_name')
            ->join('clients', 'clients.id', '=', 'return_memo_account.client_id')
            ->where('return_memo_account.memo_no', $memo)
            ->first();
        $single_returns = \Illuminate\Support\Facades\DB::table('return_memo_entry')
            ->where('return_memo_id', $return_main_info->id)
            ->get();
//        $entry_id = \Illuminate\Support\Facades\DB::table('entries')->select('id')->where('sale_purchase_id', 'purchase_'.$return_main_info->id)->first()->id;

        $info_arr = array();
        $info_arr['entry_date1']    = date('Y-m-d', $return_main_info->entry_date);
        $info_arr['old_id']         = $return_main_info->id;
        $info_arr['client_id']      = $return_main_info->client_id;
        $info_arr['client_name']    = $return_main_info->client_name;
        $info_arr['memo_no']        = $return_main_info->memo_no;
        $info_arr['total_payable']  = $return_main_info->total_payable;
        $info_arr['ref_no']         = $return_main_info->ref_no;
        $info_arr['tax_p']          = $return_main_info->tax_p;
        $info_arr['vat_p']          = $return_main_info->vat_p;


        $entry_info_arr = array();
        foreach ($single_returns as $entry){

            $quantity = $entry->quantity;
            $qt_per_carton = $entry->qt_per_carton;
            $warehouse_id = $entry->warehouse_id;

            $carton = intval($quantity/$qt_per_carton);
            $pieces = intval($quantity % $qt_per_carton);

            $available_qt = \Illuminate\Support\Facades\DB::table('warehouse_product')->select('available_qt')
                ->where('warehouse_id', $warehouse_id)
                ->where('product_id', $entry->product_id)
                ->first()
                ->available_qt;

            $product_name = \Illuminate\Support\Facades\DB::table('product_info')->select('product_name')->where('id', $entry->product_id)->first()->product_name;
            $cat_name = DB::table('catagory')->select('cname')->where('id', $entry->product_type_id)->first()->cname;

            array_push($entry_info_arr,
                array(
                    'entry_id'              =>$entry->id ,
                    'product_type_id'       =>$entry->product_type_id,
                    'warehouse_id'          =>$warehouse_id,
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
        print_r($entry_info_arr);
        echo '</pre>';*/


        // other info
        $memo_no = $memo;
        $category = DB::table('catagory')->get();
        $client_info = DB::table('clients')->get();
        $warehouse_info = DB::table('warehouse')->get();

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


        return view('admin.sale.edit_memo_return_info',compact('info_arr', 'entry_info_arr', 'cat_info', 'memo_no','client_info', 'category', 'warehouse_info'));

    }



    public function editSaleReturnMemoInfo(Request $request){


        $old_id = $request->old_sr_id;
        $old_warehouse_ids = $request->old_warehouse_id;
        $old_product_ids = $request->old_product_id;
        $old_quantities = $request->old_quantity;
//        echo $old_id;

        $entry_id = \Illuminate\Support\Facades\DB::table('entries')->select('id')->where('sale_purchase_id', 'sale_return_'.$old_id)->first()->id;
        \Illuminate\Support\Facades\DB::table('return_memo_account')->where('id', $old_id)->delete();
        \Illuminate\Support\Facades\DB::table('return_memo_entry')->where('return_memo_id', $old_id)->delete();
        \Illuminate\Support\Facades\DB::table('entries')->where('id', $entry_id)->delete();
        \Illuminate\Support\Facades\DB::table('single_entry')->where('entry_id', $entry_id)->delete();

        foreach ($old_product_ids as $key=>$value){
            $old_product_id = $old_product_ids[$key];
            $old_warehouse_id = $old_warehouse_ids[$key];
            $old_quantity = $old_quantities[$key];

            $warhouse_info = \Illuminate\Support\Facades\DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)->first();

            DB::table('warehouse_product')
                ->where('warehouse_id', $old_warehouse_id)
                ->where('product_id', $old_product_id)
                ->update([
                    'product_out'=>$warhouse_info->product_out + $old_quantity,
                    'available_qt'=>$warhouse_info->available_qt - $old_quantity,
                ]);
        }



        /* echo '<pre>';
         print_r($old_quantities);
         echo '</pre>';
         die;*/

        $client_led_id  = Ledger::select('ledgers.id as led_id')->join('clients', 'clients.client_id', '=', 'ledgers.name')->where('clients.id', $request->client_id)->first()->led_id;

        $memo_return = new memoReturnAccount();
        $memo_return->id= $old_id;
        $memo_return->entry_date = strtotime($request->entry_date);
        $memo_return->client_id= $request->client_id;
        $memo_return->ref_no=$request->ref_no;
        $memo_return->memo_no=$request->memo_no;
        $memo_return->total_payable = $request->column_total;
//        $memo_return->creator_id= $this->getCreator();
        $memo_return->creator_id= \Illuminate\Support\Facades\Auth::id();
        $memo_return->created_at= $this->getDate();
        $saved = $memo_return->save();

        if ($saved){
            $memo_return_id = $memo_return->id;

            // saving journal entry
            $entry = new Entry();
            $entry->entrytype_id = 4;
            $entry->date = $this->getDate();
            $entry->dr_total = str_replace(',', '', $request->column_total);
            $entry->cr_total = str_replace(',', '', $request->column_total);
//            $entry->narration = $request->remarks;
            $entry->sale_purchase_id = 'sale_return_'.$old_id;
            $entry->number = $request->ref_no;
            $entry->save();
            $entry_id = $entry->id;

            // saving single transaction in single_entry table
            //saving dr entry (revenue debit)
            $single_entry = new SingleEntry();
            $single_entry->entry_id = $entry_id;
            $single_entry->ledger_id = 77;
            $single_entry->amount = str_replace(',', '', $request->column_total);
            $single_entry->dc = 'D';
            $single_entry->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry->save();

            //saving dr entry (acc receivable credit)
            $single_entry_cr = new SingleEntry();
            $single_entry_cr->entry_id = $entry_id;
            $single_entry_cr->ledger_id = $client_led_id;
            $single_entry_cr->amount = str_replace(',', '', $request->column_total);
            $single_entry_cr->dc = 'C';
            $single_entry_cr->transaction_date = $this->getDate();
            //$single_entry->reconciliation_date = "";
            $single_entry_cr->save();



            //getting products info
            $product_code_names = $request->product_code;
            $warehouse_ids = $request->warehouse;
            $product_types = $request->product_type;
            $rates = $request->product_rate;
            $qt_per_cartons = $request->qt_per_carton;
            $quantities = $request->quantity;
            $totals = $request->total;

            foreach ($product_code_names as $key=>$value) {

                // saving each sale item
                $product_type = $product_types[$key];
                $warehouse_id = $warehouse_ids[$key];
                $product_code_name = $product_code_names[$key];
                $rate = $rates[$key];
                $qt_per_carton = $qt_per_cartons[$key];
                $quantity = $quantities[$key];
                $total = $totals[$key];

                // saving single sale in memo_entry table
                DB::table('return_memo_entry')->insert([
                    'return_memo_id'=>$memo_return_id,
                    'product_type_id'=>$product_type,
                    'warehouse_id'=>$warehouse_id,
                    'product_id'=>$product_code_name,
                    'qt_per_carton'=>$qt_per_carton,
                    'quantity'=>$quantity,
                    'product_rate'=>$rate,
                    'total'=>$total,
                    'created_at'=>$this->getDate(),
                ]);


                // warehouse status change
                $warehouse_status_count = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->get()->count();

                if ($warehouse_status_count != 0){
                    $warehouse_to_info = DB::table('warehouse_product')->where('warehouse_id',$warehouse_id)->where('product_id', $product_code_name)->first();

                    $store_quantity = $warehouse_to_info->product_out - $quantity;
                    $available      = $warehouse_to_info->available_qt + $quantity;

                    $update_warehouse_status = DB::table('warehouse_product')->where('product_id', $product_code_name)->where('warehouse_id',$warehouse_id)
                        ->update([
                            'product_out' => $store_quantity,
                            'available_qt'  => $available,
                            'created_at' => $this->getDate(),
                        ]);
                }
            }
        }
//        return back()->with('message','sale return successful.');

        return redirect('sale_return');

    }


    //end class
}
