<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockReports extends Controller
{
    //

    /*
     * closing Stock Report
     * */



    /*
     * item Details Report
     * */
    public function itemDetailsReport(){
        $catagories = DB::table('catagory')->get();
        return view('admin.stock_reports.item_details', compact('catagories'));
    }


    public function itemStockForm(){

        $products = DB::table('product_info')->select('id', 'product_name')->get();
        return view('admin.stock_reports.item_stock_form', compact('products'));
    }

    public function itemStockReport(Request $request){

        $date = $request->to_date;
        $product_id = $request->item_id;
        $from_date = strtotime('1990-01-01');
        $to_date = strtotime($date);


        $product_info = DB::table('product_info')->select('product_name', 'qt_per_carton', 'sell')->where('id', $product_id)->first();
        $product_name = $product_info->product_name;
        $qt_per_carton = $product_info->qt_per_carton;
        $sell_price = $product_info->sell;

        $warehouses = DB::table('warehouse')->get();
        $info_array = array();

        foreach ($warehouses as $warehouse){

            $info_array[$warehouse->id] = array();

            $closing_qt = 0;
            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.' and purchase_main.warehouse_id = '.$warehouse->id.'  ');

            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.' and purchase_return_main.warehouse_id = '.$warehouse->id.'   ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry join memo_account on memo_account.id = memo_entry.memo_id
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.' and memo_entry.warehouse_id = '.$warehouse->id.'  ');

            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.' and return_memo_entry.warehouse_id = '.$warehouse->id.'  ');

            $in_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as in_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.to_warehouse = '.$warehouse->id.' 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');

            $out_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.from_warehouse = '.$warehouse->id.' 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');


            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt + $in_qt[0]->in_qt - $out_qt[0]->out_qt ;

            $carton = intval($closing_qt / $qt_per_carton);
            $pieces = intval($closing_qt % $qt_per_carton);


            $info_array[$warehouse->id]['warehouse_name'] = $warehouse->warehouse_name;
            $info_array[$warehouse->id]['qt_per_carton'] = $qt_per_carton;
            $info_array[$warehouse->id]['carton'] = $carton;
            $info_array[$warehouse->id]['pieces'] = $pieces;
            $info_array[$warehouse->id]['closing_qt'] = $closing_qt;
            $info_array[$warehouse->id]['amount'] = $closing_qt * $sell_price;
//            echo $closing_qt.' ///  ';
        }

        /*echo '<pre>';
        print_r($info_array);
        echo '</pre>';*/


        return view('admin.stock_reports.item_stock_report', compact('info_array', 'product_name', 'date'));
    }



    public function catagoryWiseItemStockForm(){

        $cats = DB::table('catagory')->select('id', 'cname')->get();
        return view('admin.stock_reports.catagory_wise_item_stock_form', compact('cats'));
    }



    public function catagoryWiseItemStockReport(Request $request){

        $cat_id = $request->cat_id;
        $date = $request->to_date;
        $from_date = strtotime('1990-01-01');
        $to_date = strtotime($date);

        $products = DB::table('product_info')
            ->select('id', 'product_name', 'qt_per_carton', 'sell')
            ->where('product_type_id', $cat_id)->get();

        $cat_name = DB::table('catagory')->select('cname')->where('id', $cat_id)->first()->cname;

        $info_array = array();

        foreach ($products as $product){
            $product_id = $product->id;
            $product_name = $product->product_name;
            $qt_per_carton = $product->qt_per_carton;
            $sell_price = $product->sell;

            $info_array[$product_id] = array();
            $closing_qt = 0;

            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.'  ');

            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.'    ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry join memo_account on memo_account.id = memo_entry.memo_id
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.'   ');

            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.'   ');

            $in_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as in_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');

            $out_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');


            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt + $in_qt[0]->in_qt - $out_qt[0]->out_qt ;
            $carton = intval($closing_qt / $qt_per_carton);
            $pieces = intval($closing_qt % $qt_per_carton);


//            $info_array[$warehouse->id]['warehouse_name'] = $warehouse->warehouse_name;
            $info_array[$product_id]['product_id'] = $product_id;
            $info_array[$product_id]['product_name'] = $product_name;
            $info_array[$product_id]['qt_per_carton'] = $qt_per_carton;
            $info_array[$product_id]['carton'] = $carton;
            $info_array[$product_id]['pieces'] = $pieces;
            $info_array[$product_id]['closing_qt'] = $closing_qt;
            $info_array[$product_id]['amount'] = $closing_qt * $sell_price;
        }



        /*echo '<pre>';
        print_r($info_array);
        echo '</pre>';*/
        return view('admin.stock_reports.catagory_wise_item_stock_report', compact('info_array', 'cat_name', 'date'));
    }




    public function closingStockStoreWiseForm(){

        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        $cats = DB::table('catagory')->select('id', 'cname')->get();
        return view('admin.stock_reports.closing_stock_store_wise_form', compact('cats', 'warehouses'));
    }


    public function closingStockStoreWiseReport(Request $request){

        $date = $request->to_date;
        $cat_id = $request->cat_id;
        $warehouse_id = $request->warehouse_id;
        $from_date = strtotime('1990-01-01');
        $to_date = strtotime($date);

        $products = DB::table('product_info')
            ->select('id', 'product_name', 'qt_per_carton', 'sell')
            ->where('product_type_id', $cat_id)->get();

        $cat_name = DB::table('catagory')->select('cname')->where('id', $cat_id)->first()->cname;
        $warehouse_name = DB::table('warehouse')->select('warehouse_name')->where('id', $warehouse_id)->first()->warehouse_name;

        $info_array = array();

        foreach ($products as $product){
            $product_id = $product->id;
            $product_name = $product->product_name;
            $qt_per_carton = $product->qt_per_carton;
            $sell_price = $product->sell;

            $info_array[$product_id] = array();
            $closing_qt = 0;

            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.' and purchase_main.warehouse_id = '.$warehouse_id.'  ');

            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.' and purchase_return_main.warehouse_id = '.$warehouse_id.'   ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry join memo_account on memo_account.id = memo_entry.memo_id
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.' and memo_entry.warehouse_id = '.$warehouse_id.'  ');

            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.' and return_memo_entry.warehouse_id = '.$warehouse_id.'  ');

            $in_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as in_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.to_warehouse = '.$warehouse_id.' 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');

            $out_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.from_warehouse = '.$warehouse_id.' 
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');


            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt + $in_qt[0]->in_qt - $out_qt[0]->out_qt ;
            $carton = intval($closing_qt / $qt_per_carton);
            $pieces = intval($closing_qt % $qt_per_carton);


//            $info_array[$warehouse->id]['warehouse_name'] = $warehouse->warehouse_name;
            $info_array[$product_id]['product_id'] = $product_id;
            $info_array[$product_id]['product_name'] = $product_name;
            $info_array[$product_id]['qt_per_carton'] = $qt_per_carton;
            $info_array[$product_id]['carton'] = $carton;
            $info_array[$product_id]['pieces'] = $pieces;
            $info_array[$product_id]['closing_qt'] = $closing_qt;
            $info_array[$product_id]['amount'] = $closing_qt * $sell_price;
        }

        /*echo '<pre>';
        print_r($info_array);
        echo '</pre>';*/
        return view('admin.stock_reports.closing_stock_store_wise_report', compact('info_array', 'warehouse_name', 'cat_name', 'date'));
    }




    /*
     * warehouse Wise Stock Report
     * */
    public function warehouseWiseStockReport(){

        $product_ids = DB::table('warehouse_product')->select('product_id')->groupBy('product_id')->get();
        return view('admin.stock_reports.warehouse_wise_stock', compact('product_ids'));
    }


    /*
     * lc Info Form
     * */
    public function lcInfoForm(){
        $lc_infos = DB::table('lc_info')->select('id', 'lc_no')->get();
        return view('admin.stock_reports.lc_info_form', compact('lc_infos'));
    }


    /*
     * lc Info Report
     * */
    public function lcInfoReport(Request $request){

        $lc_id = $request->lc_id;
        $lc_info = DB::table('lc_info')->where('id', $lc_id)->first();
        return view('admin.stock_reports.lc_info_report', compact('lc_info'));
    }



    /*
     * party Wise Sales Form
     * */
    public function partyWiseSalesForm(){

        $clients = DB::table('clients')->select('client_name', 'id')->get();
        return view('admin.stock_reports.party_wise_sales_form', compact('clients'));
    }



    /*
     * party Wise Sales Report
     * */
    public function partyWiseSalesReport(Request $request){

        $client_id = $request->client_id;
        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $client_name = DB::table('clients')->select('client_name')->where('id', $client_id)->first()->client_name;
        $sale_info_dates = DB::table('memo_account')->select('entry_date')->where('client_id', $client_id)->whereBetween('entry_date', [$from_date, $to_date])->orderBy('entry_date')->get();
        $dates_arr = array();
        foreach ($sale_info_dates as $date){
            $dates_arr[] = $date->entry_date;
        }

        $dates_arr = array_unique($dates_arr);

        return view('admin.stock_reports.party_wise_sales_report', compact('dates_arr', 'client_id', 'client_name', 'from_date', 'to_date'));
    }



    /*
     * party Wise Summerized Sales Form
     * */
    public function partyWiseSummerizedSalesForm(){

        $clients = DB::table('clients')->select('client_name', 'id')->get();
        return view('admin.stock_reports.party_wise_summerized_sales_form', compact('clients'));
    }



    /*
     * party Wise Summerized Sales Report
     * */
    public function partyWiseSummerizedSalesReport(Request $request){

        $client_id = $request->party_id;
        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);


        $client_name = DB::table('clients')->select('client_name')->where('id', $client_id)->first()->client_name;
        //$sale_info_dates = DB::table('memo_account')->select('entry_date')->where('client_id', $client_id)->whereBetween('entry_date', [$from_date, $to_date])->orderBy('entry_date')->get();
        $catagories = DB::table('catagory')->select('catagory.id')
            ->join('memo_entry', 'memo_entry.product_type_id', '=', 'catagory.id')
            ->join('memo_account','memo_account.id', '=', 'memo_entry.memo_id')
            ->where('memo_account.client_id', $client_id)
            ->groupBy('id')
            ->get();
        return view('admin.stock_reports.party_wise_summerized_sales_report', compact('catagories', 'client_name','client_id',  'from_date', 'to_date'));
    }



    /*
     * party Wise Summerized Statement Form
     * */
    public function partyWiseSummerizedStatementForm(){

        return view('admin.stock_reports.party_wise_summerized_statement_form');
    }



    /*
     * party Wise Summerized Statement Report
     * */
    public function partyWiseSummerizedStatementReport(Request $request){

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $client_ids = DB::table('memo_account')->select('client_id')->whereBetween('entry_date', [$from_date, $to_date])->groupBy('client_id')->get();

        return view('admin.stock_reports.party_wise_summerized_statement_report', compact('client_ids', 'from_date', 'to_date'));
    }



    /*
     * sale Statement Form
     * */
    public function saleStatementForm(){
        return view('admin.stock_reports.sale_statement_form');
    }



    /*
     * sale Statement Report
     * */
    public function saleStatementReport(Request $request){

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $entry_dates = DB::table('memo_account')->select('entry_date')->whereBetween('entry_date', [$from_date, $to_date])->groupBy('entry_date')->get();

        return view('admin.stock_reports.sale_statement_report', compact('entry_dates', 'from_date', 'to_date'));
    }




    /*
     * sale Purchase Statement Form
     * */
    public function salePurchaseStatementForm(){
        return view('admin.stock_reports.sale_purchase_statement_form');

    }


    /*
     * sale Purchase Statement Report
     * */
    public function salePurchaseStatementReport(Request $request){


        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $sale_or_purchase = $request->sale_or_purchase;

        if ($sale_or_purchase == 's'){
            $entry_dates = DB::table('memo_account')->select('entry_date')->whereBetween('entry_date', [$from_date, $to_date])->groupBy('entry_date')->get();
            return view('admin.stock_reports.sale_purchase_statement_report', compact('sale_or_purchase','entry_dates', 'from_date', 'to_date'));

        }else if ($sale_or_purchase == 'p'){
            $entry_dates = DB::table('purchase_main')->select('entry_date')->whereBetween('entry_date', [$from_date, $to_date])->groupBy('entry_date')->get();
            return view('admin.stock_reports.sale_purchase_statement_report_p', compact('sale_or_purchase','entry_dates', 'from_date', 'to_date'));

        }
    }


    /*
     * store Wise Item Register Form
     * */
    public function ItemRegisterForm(){

//        $catagories = DB::table('catagory')->select('id', 'cname')->get();
        $products = DB::table('product_info')->select('id', 'product_name')->get();
        return view('admin.stock_reports.item_register_form', compact('products'));
    }


    /*
     * store Wise Item Register Report
     * */
    public function ItemRegisterReport(Request $request){
        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $product_id = $request->product_id;

        $constant_date = strtotime('1990-01-01');
        $before_from_date = strtotime(date( 'Y-m-d', strtotime( $request->from_date . ' -1 day' ) ));

        $warehouses = DB::table('warehouse')->get();
        $info_array = array();

        foreach ($warehouses as $warehouse){

            $purchases = DB::table('purchase_single')
                ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
                ->select('purchase_main.id', 'purchase_single.quantity', 'purchase_main.supplier_id', 'purchase_main.warehouse_id', 'purchase_main.entry_date', 'purchase_main.entry_no', 'purchase_single.qt_per_carton')
                ->whereBetween('purchase_single.entry_date', [$from_date, $to_date])
                ->where('purchase_single.product_id', $product_id)
                ->where('purchase_main.warehouse_id', $warehouse->id)
                ->get();

            $purchase_returns = DB::table('purchase_return_main')
                ->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
                ->select('purchase_return_main.id', 'purchase_return_details.quantity', 'purchase_return_main.supplier_id', 'purchase_return_main.warehouse_id', 'purchase_return_main.entry_date', 'purchase_return_main.memo_no', 'purchase_return_details.qt_per_carton')
                ->whereBetween('purchase_return_main.entry_date', [$from_date, $to_date])
                ->where('purchase_return_details.product_id', $product_id)
                ->where('purchase_return_main.warehouse_id', $warehouse->id)
                ->get();

            $sales = DB::table('memo_entry')
                ->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
                ->select('memo_account.id', 'memo_entry.quantity', 'memo_account.client_id', 'memo_entry.warehouse_id', 'memo_account.entry_date', 'memo_account.memo_no', 'memo_entry.qt_per_carton')
                ->whereBetween('memo_account.entry_date', [$from_date, $to_date])
                ->where('memo_entry.product_id', $product_id)
                ->where('memo_entry.warehouse_id', $warehouse->id)
                ->get();

            $sale_returns = DB::table('return_memo_account')
                ->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
                ->select('return_memo_account.id', 'return_memo_account.client_id', 'return_memo_account.entry_date', 'return_memo_account.memo_no', 'return_memo_account.ref_no', 'return_memo_entry.quantity', 'return_memo_entry.qt_per_carton', 'return_memo_entry.warehouse_id')
                ->whereBetween('return_memo_account.entry_date', [$from_date, $to_date])
                ->where('return_memo_entry.product_id', $product_id)
                ->where('return_memo_entry.warehouse_id', $warehouse->id)
                ->get();

            $product_ins = DB::table('warehouse_product_transfer')
                ->select('warehouse_product_transfer.id', 'warehouse_product_transfer.quantity', 'warehouse_product_transfer.from_warehouse', 'warehouse_product_transfer.to_warehouse', 'warehouse_product_transfer.entry_date', 'warehouse_product_transfer.memo_no', 'warehouse_product_transfer.qt_per_carton')
                ->where('warehouse_product_transfer.product_id', $product_id)
                ->where('warehouse_product_transfer.to_warehouse', $warehouse->id)
                ->whereBetween('entry_date', [$from_date, $to_date])->get();

            $product_outs = DB::table('warehouse_product_transfer')
                ->select('warehouse_product_transfer.id', 'warehouse_product_transfer.quantity', 'warehouse_product_transfer.from_warehouse', 'warehouse_product_transfer.to_warehouse', 'warehouse_product_transfer.entry_date', 'warehouse_product_transfer.memo_no', 'warehouse_product_transfer.qt_per_carton')
                ->where('warehouse_product_transfer.product_id', $product_id)
                ->where('warehouse_product_transfer.from_warehouse', $warehouse->id)
                ->whereBetween('entry_date', [$from_date, $to_date])->get();


            $info_array[$warehouse->id] = array();

            foreach ($purchases as  $k => $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'purchase_'.$purchase->id)->first()->id;
                array_push($info_array[$warehouse->id], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->supplier_id,
                    'warehouse_id'=>$purchase->warehouse_id,
                    'entry_date'=>$purchase->entry_date,
                    'flag'=>'purchase',
                    'memo'=>$purchase->entry_no,
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }

            foreach ($purchase_returns as  $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'purchase_return_'.$purchase->id)->first()->id;

                array_push($info_array[$purchase->warehouse_id], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->supplier_id,
                    'warehouse_id'=>$purchase->warehouse_id,
                    'entry_date'=>$purchase->entry_date,
                    'flag'=>'purchase_return',
                    'memo'=>$purchase->memo_no,
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }

            foreach ($sales as  $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'sale_'.$purchase->id)->first()->id;

                array_push($info_array[$purchase->warehouse_id], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->client_id,
                    'warehouse_id'=>$purchase->warehouse_id,
                    'entry_date'=>$purchase->entry_date,
                    'memo'=>$purchase->memo_no,
                    'flag'=>'sale',
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }

            foreach ($sale_returns as  $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'sale_return_'.$purchase->id)->first()->id;
                array_push($info_array[$purchase->warehouse_id], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->client_id,
                    'warehouse_id'=>$purchase->warehouse_id,
                    'entry_date'=>$purchase->entry_date,
                    'memo'=>$purchase->memo_no,
                    'ref_no'=>$purchase->ref_no,
                    'flag'=>'sale_return',
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }

            foreach ($product_ins as  $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'transfer_'.$purchase->id)->first()->id;
                array_push($info_array[$purchase->to_warehouse], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->from_warehouse,
                    'warehouse_id'=>$purchase->to_warehouse,
                    'entry_date'=>$purchase->entry_date,
                    'flag'=>'in',
                    'memo'=>$purchase->memo_no,
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }
            foreach ($product_outs as  $purchase){
                $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'transfer_'.$purchase->id)->first()->id;
                array_push($info_array[$purchase->from_warehouse], array(
                    'trans_id'=>$t_id,
                    'quantity'=>$purchase->quantity,
                    'id'=>$purchase->to_warehouse,
                    'warehouse_id'=>$purchase->from_warehouse,
                    'entry_date'=>$purchase->entry_date,
                    'flag'=>'out',
                    'memo'=>$purchase->memo_no,
                    'qt_per_carton'=>$purchase->qt_per_carton,
                ));
            }

        }

        $info_array_new = array();
        foreach ($info_array as $key=>$value){
            $arr = $value;
            usort($arr, function ($item1, $item2) {
                return $item1['trans_id'] <=> $item2['trans_id'];
            });

            $info_array_new[$key] = array();
            $info_array_new[$key] = $arr;
            /*echo '<pre>';
            print_r($arr);
            echo '</pre>';*/
        }

        /*echo '<pre>';
        print_r($info_array_new);
        echo '</pre>';
        die();*/

        return view('admin.stock_reports.item_register_report', compact('info_array_new', 'product_id', 'from_date', 'to_date', 'constant_date', 'before_from_date'));
    }


    /*
     * store Wise Item Report  aa
     * */
    public function storeWiseItemRegisterReport1(Request $request){

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $warehouse_id = $request->warehouse_id;
        $product_id = $request->product_id;

        $constant_date = strtotime('1990-01-01');
        $before_from_date = strtotime(date( 'Y-m-d', strtotime( $request->from_date . ' -1 day' ) ));

        $info_array = array();
        $products = DB::table('product_info')->get();
        $op_qt = 0;
        foreach ($products  as  $product) {
            $cat_name = \Illuminate\Support\Facades\DB::table('catagory')->select('cname')->where('id',$product->product_type_id)->first()->cname;

            $purchase_qt = DB::table('purchase_single')
                ->select('purchase_single.quantity')
                ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
                ->whereBetween('purchase_single.entry_date', [$from_date, $to_date])
                ->where('purchase_single.product_id', $product->id)
                ->where('purchase_main.warehouse_id', $warehouse_id)
                ->sum('quantity');


            $purchase_return_qt = DB::table('purchase_return_main')
                ->select('purchase_return_details.quantity')
                ->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
                ->whereBetween('purchase_return_main.entry_date', [$from_date, $to_date])
                ->where('purchase_return_details.product_id', $product->id)
                ->where('purchase_return_main.warehouse_id', $warehouse_id)
                ->sum('quantity');

            $sale_qt = DB::table('memo_entry')
                ->select('memo_entry.quantity')
                ->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
                ->whereBetween('memo_account.entry_date', [$from_date, $to_date])
                ->where('memo_entry.product_id', $product->id)
                ->where('memo_entry.warehouse_id', $warehouse_id)
                ->sum('quantity');

            $sale_return_qt = DB::table('return_memo_account')
                ->select('return_memo_entry.quantity')
                ->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
                ->whereBetween('return_memo_account.entry_date', [$from_date, $to_date])
                ->where('return_memo_entry.product_id', $product->id)
                ->where('return_memo_entry.warehouse_id', $warehouse_id)
                ->sum('quantity');


            // date problem
            $product_in_qt = DB::table('warehouse_product_transfer')->select('quantity')
                ->where('product_id', $product->id)
                ->where('to_warehouse', $warehouse_id)
                ->whereBetween('entry_date', [$from_date, $to_date])
                ->sum('quantity');


            // date problem
            $product_out_qt = DB::table('warehouse_product_transfer')
                ->select('quantity')
                ->where('product_id', $product->id)
                ->where('from_warehouse', $warehouse_id)
                ->whereBetween('entry_date', [$from_date, $to_date])
                ->sum('quantity');

//            echo '---- in: '.$product_in_qt.', out:'.$product_out_qt.' /////  '.$from_date.', '.$to_date;


            if ($purchase_qt==0 && $purchase_return_qt==0 && $sale_qt==0 && $sale_return_qt==0 && $product_in_qt==0 && $product_out_qt==0){

            }else{
                array_push($info_array, array(
                    'productid'=>$product->id,
                    'cat_name'=>$cat_name,
                    'product_name'=>$product->product_name,
                    'qt_per_carton'=>$product->qt_per_carton,
                    'purchase_qt'=>$purchase_qt,
                    'purchase_return_qt'=>$purchase_return_qt,
                    'sale_qt'=>$sale_qt,
                    'sale_return_qt'=>$sale_return_qt,
                    'product_in_qt'=>$product_in_qt,
                    'product_out_qt'=>$product_out_qt,

                ));
            }


            // getting opening balance
            $op_purchase_qt = DB::table('purchase_single')->select('purchase_single.quantity')
                ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
                ->whereBetween('purchase_single.entry_date', [$constant_date, $before_from_date])
                ->where('purchase_single.product_id', $product->id)
                ->where('purchase_main.warehouse_id', $warehouse_id)
                ->sum('purchase_single.quantity');

            $op_purchase_return_qt = DB::table('purchase_return_main')->select('quantity')->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
                ->whereBetween('purchase_return_main.entry_date', [$constant_date, $before_from_date])
                ->where('purchase_return_details.product_id', $product->id)
                ->where('purchase_return_main.warehouse_id', $warehouse_id)
                ->sum('quantity');

            $op_sales_qt = DB::table('memo_entry')->select('quantity')->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
                ->whereBetween('memo_account.entry_date', [$constant_date, $before_from_date])
                ->where('memo_entry.product_id', $product->id)
                ->where('memo_entry.warehouse_id', $warehouse_id)
                ->sum('quantity');
            $op_sale_return_qt = DB::table('return_memo_account')->select('quantity')->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
                ->whereBetween('return_memo_account.entry_date', [$constant_date, $before_from_date])
                ->where('return_memo_entry.product_id', $product->id)
                ->where('return_memo_entry.warehouse_id', $warehouse_id)
                ->sum('quantity');

            $op_product_in_qt = DB::table('warehouse_product_transfer')->select('quantity')
                ->where('warehouse_product_transfer.product_id', $product->id)
                ->where('warehouse_product_transfer.to_warehouse', $warehouse_id)
                ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');

            $op_product_out_qt = DB::table('warehouse_product_transfer')->select('quantity')
                ->where('warehouse_product_transfer.product_id', $product->id)
                ->where('warehouse_product_transfer.from_warehouse', $warehouse_id)
                ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');

            $op_qt += $op_purchase_qt - $op_purchase_return_qt - $op_sales_qt + $op_sale_return_qt + $op_product_in_qt - $op_product_out_qt;


//            echo $purchase_qt.', '.$purchase_return_qt.', '.$sale_qt.', '.$sale_return_qt.', '.$product_in_qt.', '.$product_out_qt.'\n       \n';
        }
        /*
                echo '<pre>';
                print_r($info_array);
                echo '</pre>';
                die;*/

        return view('admin.stock_reports.store_wise_item_report', compact('info_array','op_qt', 'from_date', 'to_date', 'warehouse_id', 'constant_date', 'before_from_date'));
    }



    /*
     * store Wise Item Form
     * */
    public function storeWiseItemRegisterForm(){

        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        $products = DB::table('product_info')->select('id', 'product_name')->get();
        return view('admin.stock_reports.store_wise_item_register_form', compact('warehouses', 'products'));
    }

    public function storeWiseItemRegisterReport(Request $request)
    {

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $warehouse_id = $request->warehouse_id;
        $product_id = $request->product_id;

        $product_info = DB::table('product_info')
            ->select('product_info.product_name', 'product_info.sell', 'product_info.qt_per_carton', 'catagory.cname')
            ->join('catagory', 'product_info.product_type_id','=', 'catagory.id')
            ->where('product_info.id', $product_id)
            ->first();
        $product_name = $product_info->product_name;
        $qt_per_carton = $product_info->qt_per_carton;

        $constant_date = strtotime('1990-01-01');
        $before_from_date = strtotime(date('Y-m-d', strtotime($request->from_date . ' -1 day')));

        $info_array = array();

        $purchases = DB::table('purchase_single')
            ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
            ->join('supplier_info', 'supplier_info.id', '=', 'purchase_main.supplier_id')
            ->select('supplier_info.supplier_name','purchase_main.id', 'purchase_single.quantity', 'purchase_main.supplier_id', 'purchase_main.warehouse_id', 'purchase_main.entry_date', 'purchase_main.entry_no', 'purchase_single.qt_per_carton')
            ->whereBetween('purchase_single.entry_date', [$from_date, $to_date])
            ->where('purchase_single.product_id', $product_id)
            ->where('purchase_main.warehouse_id', $warehouse_id)
            ->get();

        $purchase_returns = DB::table('purchase_return_main')
            ->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
            ->join('supplier_info', 'supplier_info.id', '=', 'purchase_return_main.supplier_id')
            ->select('supplier_info.supplier_name', 'purchase_return_main.id', 'purchase_return_details.quantity', 'purchase_return_main.supplier_id', 'purchase_return_main.warehouse_id', 'purchase_return_main.entry_date', 'purchase_return_main.memo_no', 'purchase_return_details.qt_per_carton')
            ->whereBetween('purchase_return_main.entry_date', [$from_date, $to_date])
            ->where('purchase_return_details.product_id', $product_id)
            ->where('purchase_return_main.warehouse_id', $warehouse_id)
            ->get();

        $sales = DB::table('memo_entry')
            ->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
            ->join('clients', 'clients.id', '=', 'memo_account.client_id')
            ->select('clients.client_name', 'memo_account.id', 'memo_entry.quantity', 'memo_account.client_id', 'memo_entry.warehouse_id', 'memo_account.entry_date', 'memo_account.memo_no', 'memo_entry.qt_per_carton')
            ->whereBetween('memo_account.entry_date', [$from_date, $to_date])
            ->where('memo_entry.product_id', $product_id)
            ->where('memo_entry.warehouse_id', $warehouse_id)
            ->get();

        $sale_returns = DB::table('return_memo_account')
            ->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
            ->join('clients', 'clients.id', '=', 'return_memo_account.client_id')
            ->select('clients.client_name', 'return_memo_account.id', 'return_memo_account.client_id', 'return_memo_account.entry_date', 'return_memo_account.memo_no', 'return_memo_account.ref_no', 'return_memo_entry.quantity', 'return_memo_entry.qt_per_carton', 'return_memo_entry.warehouse_id')
            ->whereBetween('return_memo_account.entry_date', [$from_date, $to_date])
            ->where('return_memo_entry.product_id', $product_id)
            ->where('return_memo_entry.warehouse_id', $warehouse_id)
            ->get();

        $product_ins = DB::table('warehouse_product_transfer')
            ->join('warehouse', 'warehouse.id', '=', 'warehouse_product_transfer.from_warehouse')
            ->select('warehouse.warehouse_name', 'warehouse_product_transfer.id', 'warehouse_product_transfer.quantity', 'warehouse_product_transfer.from_warehouse', 'warehouse_product_transfer.to_warehouse', 'warehouse_product_transfer.entry_date', 'warehouse_product_transfer.memo_no', 'warehouse_product_transfer.qt_per_carton')
            ->where('warehouse_product_transfer.product_id', $product_id)
            ->where('warehouse_product_transfer.to_warehouse', $warehouse_id)
            ->whereBetween('entry_date', [$from_date, $to_date])->get();

        $product_outs = DB::table('warehouse_product_transfer')
            ->join('warehouse', 'warehouse.id', '=', 'warehouse_product_transfer.to_warehouse')
            ->select('warehouse.warehouse_name', 'warehouse_product_transfer.id', 'warehouse_product_transfer.quantity', 'warehouse_product_transfer.from_warehouse', 'warehouse_product_transfer.to_warehouse', 'warehouse_product_transfer.entry_date', 'warehouse_product_transfer.memo_no', 'warehouse_product_transfer.qt_per_carton')
            ->where('warehouse_product_transfer.product_id', $product_id)
            ->where('warehouse_product_transfer.from_warehouse', $warehouse_id)
            ->whereBetween('entry_date', [$from_date, $to_date])->get();


        foreach ($purchases as  $k => $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'purchase_'.$purchase->id)->first()->id;
            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->supplier_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->entry_no,
                'p'=>$purchase->quantity,
                'p_r'=>0,
                's'=>0,
                's_r'=>0,
                'in'=>0,
                'out'=>0,
            ));
        }

        foreach ($purchase_returns as  $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'purchase_return_'.$purchase->id)->first()->id;

            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->supplier_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->memo_no,
                'p'=>0,
                'p_r'=>$purchase->quantity,
                's'=>0,
                's_r'=>0,
                'in'=>0,
                'out'=>0,
            ));
        }

        foreach ($sales as  $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'sale_'.$purchase->id)->first()->id;

            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->client_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->memo_no,
                'p'=>0,
                'p_r'=>0,
                's'=>$purchase->quantity,
                's_r'=>0,
                'in'=>0,
                'out'=>0,
            ));
        }

        foreach ($sale_returns as  $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'sale_return_'.$purchase->id)->first()->id;
            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->client_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->memo_no,
                'p'=>0,
                'p_r'=>0,
                's'=>0,
                's_r'=>$purchase->quantity,
                'in'=>0,
                'out'=>0,
            ));
        }

        foreach ($product_ins as  $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'transfer_'.$purchase->id)->first()->id;
            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->warehouse_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->memo_no,
                'p'=>0,
                'p_r'=>0,
                's'=>0,
                's_r'=>0,
                'in'=>$purchase->quantity,
                'out'=>0,
            ));
        }

        foreach ($product_outs as  $purchase){
            $t_id = DB::table('stock_transaction_sl')->select('id')->where('trans_id', 'transfer_'.$purchase->id)->first()->id;
            array_push($info_array, array(
                'trans_id'=>$t_id,
                'date'=>date('d/m/y', $purchase->entry_date),
                'party'=>$purchase->warehouse_name,
                'c_qt'=>intval($purchase->quantity/$purchase->qt_per_carton),
                'memo'=>$purchase->memo_no,
                'p'=>0,
                'p_r'=>0,
                's'=>0,
                's_r'=>0,
                'in'=>0,
                'out'=>$purchase->quantity,
            ));
        }

        usort($info_array, function ($item1, $item2) {
            return $item1['trans_id'] <=> $item2['trans_id'];
        });



       /* echo '<pre>';
        print_r($info_array);
        echo '</pre>';
        die();*/


        // GETTING OPENNING BALANCE
        $op_qt = 0;
        // getting opening balance
        $op_purchase_qt = DB::table('purchase_single')->select('purchase_single.quantity')
            ->join('purchase_main', 'purchase_main.id', '=', 'purchase_single.purchase_id')
            ->whereBetween('purchase_single.entry_date', [$constant_date, $before_from_date])
            ->where('purchase_single.product_id', $product_id)
            ->where('purchase_main.warehouse_id', $warehouse_id)
            ->sum('purchase_single.quantity');

        $op_purchase_return_qt = DB::table('purchase_return_main')->select('quantity')->join('purchase_return_details', 'purchase_return_main.id', '=', 'purchase_return_details.purchase_return_id')
            ->whereBetween('purchase_return_main.entry_date', [$constant_date, $before_from_date])
            ->where('purchase_return_details.product_id', $product_id)
            ->where('purchase_return_main.warehouse_id', $warehouse_id)
            ->sum('quantity');

        $op_sales_qt = DB::table('memo_entry')->select('quantity')->join('memo_account', 'memo_account.id', '=', 'memo_entry.memo_id')
            ->whereBetween('memo_account.entry_date', [$constant_date, $before_from_date])
            ->where('memo_entry.product_id', $product_id)
            ->where('memo_entry.warehouse_id', $warehouse_id)
            ->sum('quantity');
        $op_sale_return_qt = DB::table('return_memo_account')->select('quantity')->join('return_memo_entry', 'return_memo_account.id', '=', 'return_memo_entry.return_memo_id')
            ->whereBetween('return_memo_account.entry_date', [$constant_date, $before_from_date])
            ->where('return_memo_entry.product_id', $product_id)
            ->where('return_memo_entry.warehouse_id', $warehouse_id)
            ->sum('quantity');

        $op_product_in_qt = DB::table('warehouse_product_transfer')->select('quantity')
            ->where('warehouse_product_transfer.product_id', $product_id)
            ->where('warehouse_product_transfer.to_warehouse', $warehouse_id)
            ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');

        $op_product_out_qt = DB::table('warehouse_product_transfer')->select('quantity')
            ->where('warehouse_product_transfer.product_id', $product_id)
            ->where('warehouse_product_transfer.from_warehouse', $warehouse_id)
            ->whereBetween('entry_date', [$constant_date, $before_from_date])->sum('quantity');

        $op_qt += $op_purchase_qt - $op_purchase_return_qt - $op_sales_qt + $op_sale_return_qt + $op_product_in_qt - $op_product_out_qt;



        /*echo '<pre>';
        print_r($info_array);
        echo '</pre>';*/

        return view('admin.stock_reports.store_wise_item_register_report', compact('info_array','qt_per_carton', 'op_qt', 'from_date', 'to_date', 'warehouse_id', 'constant_date', 'before_from_date', 'product_name'));


    }






    /*
     * store Wise Closing Stock Form
     * */
    public function storeWiseClosingStockForm(){

        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        return view('admin.stock_reports.store_wise_closing_stock_form', compact('warehouses'));
    }


    /*
     * store Wise Closing Stock Report
     * */
    public function storeWiseClosingStockReport(Request $request){

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $warehouse_id = $request->warehouse_id;
        $type = $request->type;



        if ($type == 'p'){
            return redirect('storewise_stock_purchase/'.$from_date.'/'.$to_date.'/'.$warehouse_id);
        }elseif ($type == 'p_r'){
            return redirect('storewise_stock_purchase_return/'.$from_date.'/'.$to_date.'/'.$warehouse_id);

        }elseif ($type == 's'){
            return redirect('storewise_stock_sale/'.$from_date.'/'.$to_date.'/'.$warehouse_id);

        }elseif ($type == 's_r'){
            return redirect('storewise_stock_sale_return/'.$from_date.'/'.$to_date.'/'.$warehouse_id);

        }elseif ($type == 'in'){
            return redirect('storewise_stock_in/'.$from_date.'/'.$to_date.'/'.$warehouse_id);

        }elseif ($type == 'out'){
            return redirect('storewise_stock_out/'.$from_date.'/'.$to_date.'/'.$warehouse_id);

        }

        //return view('admin.stock_reports.store_wise_closing_stock_report', compact(''));
    }


    /*
     * store wise Stock Purchase
     * */
    public function storewiseStockPurchase($from_date, $to_date, $warehouse_id){
        $report_type = 'PURCHASE';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();

        foreach ($cats as $cat){

            $cat_id = $cat->id;
            if ($warehouse_id == 'all'){
                $entries = DB::select('select * from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id 
                    where purchase_single.product_type_id = '.$cat_id.' and (purchase_single.entry_date between '.$from_date.' AND '.$to_date.') 
                     ');
            }else{
                $entries = DB::select('select * from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id 
                    where purchase_single.product_type_id = '.$cat_id.' and (purchase_single.entry_date between '.$from_date.' AND '.$to_date.') 
                    and purchase_main.warehouse_id = '.$warehouse_id.' ');

            }



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                    foreach ($entries as $entry){
                            $product = DB::table('product_info')
                                ->where('id',$entry->product_id)->first();
                            $product_name = $product->product_name;
                            $qt_per_carton = $product->qt_per_carton;
                            $carton = intval($entry->quantity / $entry->qt_per_carton);
                            $pieces = intval($entry->quantity % $entry->qt_per_carton);

                            $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                            if ($is_empty){
                                $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                                $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                                $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                                $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                                $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                                $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                            }else{
                                $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                                $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                                $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                            }
                    }
                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type', 'search_by_zero'));


    }


    /*
     * store wise Stock Purchase Return
     * */
    public function storewiseStockPurchaseReturn($from_date, $to_date, $warehouse_id){
        $report_type = 'PURCHASE RETURN';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();
        if ($warehouse_id == 'all'){

            $where_clause = '';
        }else{

            $where_clause = 'and purchase_return_main.warehouse_id = '.$warehouse_id;
        }

        foreach ($cats as $cat){

            $cat_id = $cat->id;

                $entries = DB::select('select * from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id 
                    where purchase_return_details.product_type_id = '.$cat_id.' and (purchase_return_main.entry_date between '.$from_date.' AND '.$to_date.') '.$where_clause.'
                     ');



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                    foreach ($entries as $entry){

                            $product = DB::table('product_info')
                                ->where('id',$entry->product_id)->first();
                            $product_name = $product->product_name;
                            $qt_per_carton = $product->qt_per_carton;
                            $carton = intval($entry->quantity / $entry->qt_per_carton);
                            $pieces = intval($entry->quantity % $entry->qt_per_carton);

                            $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                            if ($is_empty){
                                $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                                $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                                $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                                $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                                $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                                $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                            }else{
                                $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                                $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                                $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                            }
                    }

                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type'));


    }


    /*
     * store wise Stock Sale
     * */
    public function storewiseStockSale($from_date, $to_date, $warehouse_id){
        $report_type = 'SALE';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();
        if ($warehouse_id == 'all'){

            $where_clause = '';
        }else{

            $where_clause = 'and memo_entry.warehouse_id = '.$warehouse_id;
        }

        foreach ($cats as $cat){

            $cat_id = $cat->id;

            $entries = DB::select('select * from memo_entry join memo_account on memo_account.id = memo_entry.memo_id 
                    where memo_entry.product_type_id = '.$cat_id.' and (memo_account.entry_date between '.$from_date.' AND '.$to_date.') '.$where_clause.'
                     ');



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                foreach ($entries as $entry){

                    $product = DB::table('product_info')
                        ->where('id',$entry->product_id)->first();
                    $product_name = $product->product_name;
                    $qt_per_carton = $product->qt_per_carton;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);

                    $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                    if ($is_empty){
                        $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                        $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                    }else{
                        $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                    }


                }
                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type'));

    }



    /*
     * store wise Stock Sale Return
     * */
    public function storewiseStockSaleReturn($from_date, $to_date, $warehouse_id){
        $report_type = 'SALE RETURN';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();
        if ($warehouse_id == 'all'){

            $where_clause = '';
        }else{

            $where_clause = 'and return_memo_entry.warehouse_id = '.$warehouse_id;
        }

        foreach ($cats as $cat){

            $cat_id = $cat->id;

            $entries = DB::select('select * from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id 
                    where return_memo_entry.product_type_id = '.$cat_id.' and (return_memo_account.entry_date between '.$from_date.' AND '.$to_date.') '.$where_clause.'
                     ');



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                foreach ($entries as $entry){

                    $product = DB::table('product_info')
                        ->where('id',$entry->product_id)->first();
                    $product_name = $product->product_name;
                    $qt_per_carton = $product->qt_per_carton;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);

                    $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                    if ($is_empty){
                        $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                        $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                    }else{
                        $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                    }


                }
                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type'));

    }


    /*
     * store wise Stock In report
     * */
    public function storewiseStockIn($from_date, $to_date, $warehouse_id){
        $report_type = 'PRODUCT IN';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();
        if ($warehouse_id == 'all'){

            $where_clause = '';
        }else{

            $where_clause = 'and warehouse_product_transfer.to_warehouse = '.$warehouse_id;
        }

        foreach ($cats as $cat){

            $cat_id = $cat->id;

            $entries = DB::select('select * from warehouse_product_transfer join product_info on product_info.id = warehouse_product_transfer.product_id 
                    where product_info.product_type_id = '.$cat_id.' and (warehouse_product_transfer.entry_date between '.$from_date.' AND '.$to_date.') '.$where_clause.'
                     ');



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                foreach ($entries as $entry){

                    $product = DB::table('product_info')
                        ->where('id',$entry->product_id)->first();
                    $product_name = $product->product_name;
                    $qt_per_carton = $product->qt_per_carton;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);

                    $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                    if ($is_empty){
                        $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                        $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                    }else{
                        $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                    }


                }
                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type'));

    }



    /*
     * storewise Stock Out report
     * */
    public function storewiseStockOut($from_date, $to_date, $warehouse_id){
        $report_type = 'PRODUCT OUT';

        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();
        if ($warehouse_id == 'all'){

            $where_clause = '';
        }else{

            $where_clause = 'and warehouse_product_transfer.from_warehouse = '.$warehouse_id;
        }

        foreach ($cats as $cat){

            $cat_id = $cat->id;

            $entries = DB::select('select * from warehouse_product_transfer join product_info on product_info.id = warehouse_product_transfer.product_id 
                    where product_info.product_type_id = '.$cat_id.' and (warehouse_product_transfer.entry_date between '.$from_date.' AND '.$to_date.') '.$where_clause.'
                     ');



            if (sizeof($entries) != 0){
                $info_arr[$cat_id][] = array();

                foreach ($entries as $entry){

                    $product = DB::table('product_info')
                        ->where('id',$entry->product_id)->first();
                    $product_name = $product->product_name;
                    $qt_per_carton = $product->qt_per_carton;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);

                    $is_empty = empty($info_arr[$cat_id][$entry->product_id]['product_id']);


                    if ($is_empty){
                        $info_arr[$cat_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$cat_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$cat_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] = $entry->quantity;
                        $info_arr[$cat_id][$entry->product_id]['qt_per_carton'] = $qt_per_carton;
                    }else{
                        $info_arr[$cat_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$cat_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$cat_id][$entry->product_id]['quantity'] += $entry->quantity;
                    }


                }
                unset($info_arr[$cat_id][0]);

            }

        }
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
        return view('admin.stock_reports.store_wise_closing_stock_report', compact('warehouse_id','info_arr', 'from_date', 'to_date', 'report_type'));

    }



    public function summarizedSaleItemForm(){
        $cats = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        return view('admin.stock_reports.summarized_sale_items_form', compact('cats', 'warehouses'));
    }


    public function summarizedSaleItemReport(Request $request){
        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $cat_id = $request->cat_id;
        $warehouse_id = $request->warehouse_id;
        return redirect('summarized_items_sale/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

    }


    /*
     * summarized Items Form
     * */
    public function summarizedItemsForm(){

        $cats = DB::table('catagory')->get();
        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        return view('admin.stock_reports.summarized_items_form', compact('cats', 'warehouses'));
    }


    /*
     * summarized Items Report
     * */
    public function summarizedItemsReport(Request $request){

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $cat_id = $request->cat_id;
        $warehouse_id = $request->warehouse_id;
        $type = $request->type;

        if ($type == 'p'){
            return redirect('summarized_items_purchase/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);
        }elseif ($type == 'p_r'){
            return redirect('summarized_items_purchase_return/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

        }elseif ($type == 's'){
            return redirect('summarized_items_sale/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

        }elseif ($type == 's_r'){
            return redirect('summarized_items_sale_return/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

        }elseif ($type == 'in'){
            return redirect('summarized_items_in/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

        }elseif ($type == 'out'){
            return redirect('summarized_items_out/'.$from_date.'/'.$to_date.'/'.$cat_id.'/'.$warehouse_id);

        }


    }


    /*
     * summarized Items Purchase report
     * */
    public function summarizedItemsPurchase($from_date, $to_date, $cat_id, $warehouse_id){

        $report_type = 'PURCHASE';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }




        $entries = DB::select('select purchase_single.product_id, purchase_single.quantity, purchase_single.qt_per_carton, purchase_main.warehouse_id  
            from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id 
            where purchase_main.warehouse_id in ('.$warehouse_id.') and (purchase_single.entry_date between '.$from_date.' AND '.$to_date.') 
            AND (purchase_single.product_type_id = '.$cat_id.')  order by purchase_main.warehouse_id ');

        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();


            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);


                    /*$exist = array_key_exists('product_id', $info_arr[$w_id][$entry->product_id]);
                    echo $exist;*/

                    $is_empty = empty($info_arr[$w_id][$entry->product_id]['product_id']);
                    //echo $exist;
                    //print_r($info_arr[$w_id][$entry->product_id]);

                    if ($is_empty){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
                unset($info_arr[$w_id][0]);
            }

        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/


    }


    /*
     * summarized Items Purchase Return
     * */
    public function summarizedItemsPurchaseReturn($from_date, $to_date, $cat_id, $warehouse_id){
        $report_type = 'PURCHASE RETURN';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }




        $entries = DB::select('select purchase_return_details.product_id, purchase_return_details.quantity, purchase_return_details.qt_per_carton, purchase_return_main.warehouse_id  
             from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id 
            where purchase_return_main.warehouse_id in ('.$warehouse_id.') and (purchase_return_main.entry_date between '.$from_date.' AND '.$to_date.') 
            AND (purchase_return_details.product_type_id = '.$cat_id.')  order by purchase_return_main.warehouse_id ');

        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();


            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);


                    $exist = empty($info_arr[$w_id][$entry->product_id]['product_id']);
//                    echo $exist;

                    if ($exist){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
            }
            unset($info_arr[$w_id][0]);
        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/

    }



    /*
     * summarized Items Sale
     * */
    public function summarizedItemsSale($from_date, $to_date, $cat_id, $warehouse_id){
        $report_type = 'SALE';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }


        $entries = DB::select('select memo_entry.product_id, memo_entry.quantity, memo_entry.qt_per_carton, memo_entry.warehouse_id
            from memo_entry join memo_account on memo_account.id = memo_entry.memo_id
            where memo_entry.warehouse_id in ('.$warehouse_id.') and (memo_account.entry_date between '.$from_date.' AND '.$to_date.')
            AND (memo_entry.product_type_id = '.$cat_id.')  order by memo_entry.warehouse_id ');

        /*echo '<pre>';
        print_r($entries);
        echo '</pre>';
        die();*/

        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();


            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);


                    /*$exist = array_key_exists('product_id', $info_arr[$w_id][$entry->product_id]);
                    echo $exist;*/

                    $exist = empty($info_arr[$w_id][$entry->product_id]['product_id']);
//                    echo $exist;
                    //print_r($info_arr[$w_id][$entry->product_id]);

                    if ($exist){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
                unset($info_arr[$w_id][0]);
            }

        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
    }



    /*
     * summarized Items Sale Return
     * */
    public function summarizedItemsSaleReturn($from_date, $to_date, $cat_id, $warehouse_id){
        $report_type = 'SALE RETURN';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }


        $entries = DB::select('select return_memo_entry.product_id, return_memo_entry.quantity, return_memo_entry.qt_per_carton, 
            return_memo_entry.warehouse_id  
            from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id 
            where return_memo_entry.warehouse_id in ('.$warehouse_id.') and (return_memo_account.entry_date between '.$from_date.' AND '.$to_date.') 
            AND (return_memo_entry.product_type_id = '.$cat_id.')  order by return_memo_entry   .warehouse_id ');

        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();


            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);


                    /*$exist = array_key_exists('product_id', $info_arr[$w_id][$entry->product_id]);
                    echo $exist;*/

                    $exist = empty($info_arr[$w_id][$entry->product_id]['product_id']);
                    echo $exist;
                    //print_r($info_arr[$w_id][$entry->product_id]);

                    if ($exist){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
                unset($info_arr[$w_id][0]);
            }

        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
    }



    /*
     * summarized Items In
     * */
    public function summarizedItemsIn($from_date, $to_date, $cat_id, $warehouse_id){
        $report_type = 'PRODUCT IN';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }

        $entries = DB::select('select warehouse_product_transfer.product_id, warehouse_product_transfer.quantity, 
            warehouse_product_transfer.qt_per_carton, warehouse_product_transfer.to_warehouse  as warehouse_id 
            from warehouse_product_transfer where warehouse_product_transfer.to_warehouse in ('.$warehouse_id.') and 
            (warehouse_product_transfer.entry_date >= '.$from_date.' AND warehouse_product_transfer.entry_date <='.$to_date.') 
             order by warehouse_product_transfer.to_warehouse ');

        /*echo $warehouse_id;
        echo '<pre>';
        print_r($entries);
        echo '</pre>';
        die;*/


        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();

            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);

                    $exist = empty($info_arr[$w_id][$entry->product_id]['product_id']);

                    if ($exist){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
                unset($info_arr[$w_id][0]);
            }

        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
    }



    /*
     * summarized Items Out
     * */
    public function summarizedItemsOut($from_date, $to_date, $cat_id, $warehouse_id){
        $report_type = 'Product Out';

        $warehouse_id_arr = array();
        if ($warehouse_id == 'all'){

            $warehouses = DB::table('warehouse')->select('id')->get();
            foreach ($warehouses as $warehouse){
                $warehouse_id_arr[] = $warehouse->id;
            }
            $warehouse_id = implode(',',$warehouse_id_arr);
        }else{
            $warehouse_id_arr[] = $warehouse_id;
        }

        $entries = DB::select('select warehouse_product_transfer.product_id, warehouse_product_transfer.quantity, 
            warehouse_product_transfer.qt_per_carton, warehouse_product_transfer.from_warehouse  as warehouse_id 
            from warehouse_product_transfer where warehouse_product_transfer.from_warehouse in ('.$warehouse_id.') and 
            (warehouse_product_transfer.entry_date between '.$from_date.' AND '.$to_date.') 
             order by warehouse_product_transfer.from_warehouse ');

        $info_arr = array();


        foreach ($warehouse_id_arr as $w_id){

            $info_arr[$w_id][] = array();

            foreach ($entries as $entry){
                //$info_arr[$w_id][$entry->product_id] = array();

                if ($w_id == $entry->warehouse_id) {
                    $product_name = DB::table('product_info')->select('product_name')
                        ->where('id',$entry->product_id)->first()->product_name;
                    $carton = intval($entry->quantity / $entry->qt_per_carton);
                    $pieces = intval($entry->quantity % $entry->qt_per_carton);


                    /*$exist = array_key_exists('product_id', $info_arr[$w_id][$entry->product_id]);
                    echo $exist;*/

                    $exist = empty($info_arr[$w_id][$entry->product_id]['product_id']);
//                    echo $exist;
                    //print_r($info_arr[$w_id][$entry->product_id]);

                    if ($exist){

//                        echo 'empty//  ';
                        $info_arr[$w_id][$entry->product_id]['product_id'] = $entry->product_id;
                        $info_arr[$w_id][$entry->product_id]['product_name'] = $product_name;
                        $info_arr[$w_id][$entry->product_id]['carton'] = $carton;
                        $info_arr[$w_id][$entry->product_id]['qt_per_carton'] = $entry->qt_per_carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] = $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] = $entry->quantity;

                    }else{
//                        echo 'exist   ///  ';
                        $info_arr[$w_id][$entry->product_id]['carton'] += $carton;
                        $info_arr[$w_id][$entry->product_id]['pieces'] += $pieces;
                        $info_arr[$w_id][$entry->product_id]['quantity'] += $entry->quantity;

                    }
                }
                unset($info_arr[$w_id][0]);
            }

        }
        return view('admin.stock_reports.summarized_items_report', compact('info_arr', 'cat_id', 'from_date', 'to_date', 'warehouse_id', 'report_type'));
        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/
    }





    /*
     *store Wise Closing Stock Value Form
     *
     * */
    public function storeWiseClosingStockValueForm(){
        return view('admin.stock_reports.store_wise_closing_stock_value_form');

    }

    public function storeWiseClosingStockValueReport(Request $request){



        $is_zero = ($_POST['submit'] == 'with_zero') ? 0 : 1;

        $from_date = strtotime('1990-01-01');
        $to_date = strtotime($request->date);
        $cats = DB::table('catagory')->select('id')->get();
        $info_arr = array();

        foreach ($cats as $cat){

            $cat_id = $cat->id;
            $info_arr[$cat_id][] = array();

            $products = DB::table('product_info')->select( 'id','product_name', 'qt_per_carton', 'sell')->where('product_type_id', $cat_id)->get();


            foreach ($products as $product){

                $product_id = $product->id;
                $closing_qt = 0;

                $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.'   ');


                $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.'   ');

                $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry join memo_account on memo_account.id = memo_entry.memo_id  
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.'   ');

                $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id  
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.'   ');


//            echo $product_id;
//            echo 'id: '.$product_id.',  '.$purchase_qt[0]->purchase_qt.', '.$purchase_rt_qt[0]->purchase_rt_qt .',,, '.$sale_qt[0]->sale_qt.', '.$sale_rt_qt[0]->sale_rt_qt.'             //       ';


            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt ;
                if ($is_zero == 0){
                    /*if ($product->qt_per_carton != 0){
                        $carton = intval($closing_qt / $product->qt_per_carton);
                        $pieces = intval($closing_qt % $product->qt_per_carton);
                    }else{
                        $carton = 0;
                        $pieces = $closing_qt;
                    }*/
                    $carton = 0;
                    $rate = $product->sell;


                    if ($closing_qt > 0){
                        $carton = intval($closing_qt / $product->qt_per_carton);
                        $pieces = intval($closing_qt % $product->qt_per_carton);
                        $amount = $closing_qt * $rate;
                    }else{
                        $carton = 0;
                        $pieces = $closing_qt;
                        $amount = 0 * $rate;
                    }

                        $info_arr[$cat_id][$product_id]['product_id'] = $product_id;
                        $info_arr[$cat_id][$product_id]['product_name'] = $product->product_name;
                        $info_arr[$cat_id][$product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$product_id]['quantity'] = $closing_qt;
                        $info_arr[$cat_id][$product_id]['qt_per_carton'] = $product->qt_per_carton;
                        $info_arr[$cat_id][$product_id]['rate'] = $rate;
                        $info_arr[$cat_id][$product_id]['amount'] = $amount;


                }elseif ($is_zero > 0){
                    if ($closing_qt > 0){
                        $carton = intval($closing_qt / $product->qt_per_carton);
                        $pieces = intval($closing_qt % $product->qt_per_carton);
                    }else{
                        $carton = 0;
                        $pieces = $closing_qt;
                    }
                    $rate = $product->sell;
                    $amount = $closing_qt * $rate;

                    if ($closing_qt > 0){

                        $info_arr[$cat_id][$product_id]['product_id'] = $product_id;
                        $info_arr[$cat_id][$product_id]['product_name'] = $product->product_name;
                        $info_arr[$cat_id][$product_id]['carton'] = $carton;
                        $info_arr[$cat_id][$product_id]['pieces'] = $pieces;
                        $info_arr[$cat_id][$product_id]['quantity'] = $closing_qt;
                        $info_arr[$cat_id][$product_id]['qt_per_carton'] = $product->qt_per_carton;
                        $info_arr[$cat_id][$product_id]['rate'] = $rate;
                        $info_arr[$cat_id][$product_id]['amount'] = $amount;
                    }
                }



//            echo '  $ cl_qt : '.$closing_qt.', '.$carton.', '.$pieces.', '.$amount.'       ..............       ';
            }
            unset($info_arr[$cat_id][0]);

        }

        /*echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/


        return view('admin.stock_reports.store_wise_closing_stock_value_report', compact('info_arr', 'to_date'));

    }


    public function salePurchaseReturnPartyWiseForm(){
        return view('admin.stock_reports.sale_purchase_return_party_wise_form');
    }

    public function salePurchaseReturnPartyWiseReport(Request $request){

        $type = $request->type;
        $to_d = $request->to_date;
        $from_d = $request->from_date;

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);
        $arr_info = array();

        if ($type == 'p'){
            $heading = "BUY";
            $suppliers = DB::table('supplier_info')->select('id', 'supplier_name')->get();

            foreach ($suppliers as $supplier){

                $supplier_id = $supplier->id;
                $supplier_name = $supplier->supplier_name;
                $total_amount = 0;

                $amounts = DB::select(' Select purchase_main.total from purchase_main 
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_main.supplier_id = '.$supplier_id.'  ');

                foreach ($amounts as $amount){
                    $am = str_replace(',', '',$amount->total);
                    $total_amount += $am;
                }

                if ($total_amount>0){
                    $arr_info[$supplier_id] = array();
                    $arr_info[$supplier_id]['name'] = $supplier_name;
                    $arr_info[$supplier_id]['amount'] = $total_amount;
                }

            }

        }



        if ($type == 'p_r'){
            $heading = "BUY RETURN";
            $suppliers = DB::table('supplier_info')->select('id', 'supplier_name')->get();

            foreach ($suppliers as $supplier){

                $supplier_id = $supplier->id;
                $supplier_name = $supplier->supplier_name;
                $total_amount = 0;

                $amounts = DB::select(' Select purchase_return_main.total from purchase_return_main 
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_main.supplier_id = '.$supplier_id.'  ');

                foreach ($amounts as $amount){
                    $am = str_replace(',', '',$amount->total);
                    $total_amount += $am;
                }

                if ($total_amount>0){
                    $arr_info[$supplier_id] = array();
                    $arr_info[$supplier_id]['name'] = $supplier_name;
                    $arr_info[$supplier_id]['amount'] = $total_amount;
                }

            }

        }


        if ($type == 's'){
            $heading = "SALE";
            $clients = DB::table('clients')->select('id', 'client_name')->get();

            foreach ($clients as $client){

                $client_id = $client->id;
                $client_name = $client->client_name;
                $total_amount = 0;

                $amounts = DB::select(' Select memo_account.total_price from memo_account 
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_account.client_id = '.$client_id.'  ');

                foreach ($amounts as $amount){
                    $am = str_replace(',', '',$amount->total_price);
                    $total_amount += $am;
                }

                if ($total_amount>0){
                    $arr_info[$client_id] = array();
                    $arr_info[$client_id]['name'] = $client_name;
                    $arr_info[$client_id]['amount'] = $total_amount;
                }

            }

        }

        if ($type == 's_r'){
            $heading = "SALE RETURN";
            $clients = DB::table('clients')->select('id', 'client_name')->get();

            foreach ($clients as $client){

                $client_id = $client->id;
                $client_name = $client->client_name;
                $total_amount = 0;

                $amounts = DB::select(' Select return_memo_account.total_payable from return_memo_account 
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_account.client_id = '.$client_id.'  ');

                foreach ($amounts as $amount){
                    $am = str_replace(',', '',$amount->total_payable);
                    $total_amount += $am;
                }

                if ($total_amount>0){
                    $arr_info[$client_id] = array();
                    $arr_info[$client_id]['name'] = $client_name;
                    $arr_info[$client_id]['amount'] = $total_amount;
                }

            }

        }

        /*echo '<pre>';
          print_r($arr_info);
          echo '</pre>';*/
        return view('admin.stock_reports.sale_purchase_return_party_wise_report', compact('arr_info', 'heading', 'to_d', 'from_d'));
    }


    public function salePurchaseReturnSummarizedForm(){
        return view('admin.stock_reports.sale_purchase_return_summarzied_form');
    }

    public function salePurchaseReturnSummarizedReport(Request $request){

        $type = $request->type;
        $party_id = $request->party_id;
        $to_d = $request->to_date;
        $from_d = $request->from_date;

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $catagories = DB::table('catagory')->select('id', 'cname')->get();

        // if type SALE selected
        if ($type == 's'){
            $heading = 'SALE';
            $party_name = DB::table('clients')->select('client_name')->where('id', $party_id)->first()->client_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();

                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry 
                            join memo_account on memo_account.id = memo_entry.memo_id  
                            where (memo_account.entry_date between '.$from_date.' and '.$to_date.') 
                            and memo_entry.product_id = '.$product_id.' and memo_account.client_id = '.$party_id.'  ');

                        if ($sale_qt[0]->sale_qt != null){
                            $rate_per_carton = $qt_per_carton * $rate;
                            $carton_qt = intval($sale_qt[0]->sale_qt / $qt_per_carton);
                            $pieces = intval($sale_qt[0]->sale_qt % $qt_per_carton);
                            $carton_rate = $carton_qt * $rate_per_carton;
                            $amount = $sale_qt[0]->sale_qt * $rate;

                            $arr_info[$cat_name][$product_id] = array();

                            $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                            $arr_info[$cat_name][$product_id]['rate'] = $rate;
                            $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                            $arr_info[$cat_name][$product_id]['sale_qt'] = $sale_qt[0]->sale_qt;
                            $arr_info[$cat_name][$product_id]['carton_qt'] = intval($carton_qt);
                            $arr_info[$cat_name][$product_id]['pieces'] = $pieces;
                            $arr_info[$cat_name][$product_id]['carton_amount'] = $carton_rate;
                            $arr_info[$cat_name][$product_id]['amount'] = $amount;
                        }
                    }
                }
            }
            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/
            return view('admin.stock_reports.sale_purchase_return_summarized_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));

        }


        //SALE RETURN
        if ($type == 's_r'){
            $heading = 'SALE RETURN';
            $party_name = DB::table('clients')->select('client_name')->where('id', $party_id)->first()->client_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;


                        $sale_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry 
                            join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id   
                            where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') 
                            and return_memo_entry.product_id = '.$product_id.' and return_memo_account.client_id = '.$party_id.'  ');

                        if ($sale_qt[0]->sale_rt_qt != null) {
                            $rate_per_carton = $qt_per_carton * $rate;
                            $carton_qt = intval($sale_qt[0]->sale_rt_qt / $qt_per_carton);
                            $pieces = intval($sale_qt[0]->sale_rt_qt % $qt_per_carton);
                            $carton_rate = $carton_qt * $rate_per_carton;
                            $amount = $sale_qt[0]->sale_rt_qt * $rate;

                            $arr_info[$cat_name][$product_id] = array();

                            $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                            $arr_info[$cat_name][$product_id]['rate'] = $rate;
                            $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                            $arr_info[$cat_name][$product_id]['sale_qt'] = $sale_qt[0]->sale_rt_qt;
                            $arr_info[$cat_name][$product_id]['carton_qt'] = intval($carton_qt);
                            $arr_info[$cat_name][$product_id]['pieces'] = $pieces;
                            $arr_info[$cat_name][$product_id]['carton_amount'] = $carton_rate;
                            $arr_info[$cat_name][$product_id]['amount'] = $amount;
                        }

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.sale_purchase_return_summarized_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));
        }



        //PURCHASE
        if ($type == 'p'){
            $heading = 'PURCHASE';
            $party_name = DB::table('supplier_info')->select('supplier_name')->where('id', $party_id)->first()->supplier_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single 
                        join purchase_main on purchase_main.id = purchase_single.purchase_id  
                        where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') 
                        and purchase_single.product_id = '.$product_id.' and purchase_main.supplier_id = '.$party_id.'   ');

                        if ($purchase_qt[0]->purchase_qt != null) {
                            $rate_per_carton = $qt_per_carton * $rate;
                            $carton_qt = intval($purchase_qt[0]->purchase_qt / $qt_per_carton);
                            $pieces = intval($purchase_qt[0]->purchase_qt % $qt_per_carton);
                            $carton_rate = $carton_qt * $rate_per_carton;
                            $amount = $purchase_qt[0]->purchase_qt * $rate;

                            $arr_info[$cat_name][$product_id] = array();

                            $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                            $arr_info[$cat_name][$product_id]['rate'] = $rate;
                            $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                            $arr_info[$cat_name][$product_id]['sale_qt'] = $purchase_qt[0]->purchase_qt;
                            $arr_info[$cat_name][$product_id]['carton_qt'] = $carton_qt;
                            $arr_info[$cat_name][$product_id]['pieces'] = $pieces;
                            $arr_info[$cat_name][$product_id]['carton_amount'] = $carton_rate;
                            $arr_info[$cat_name][$product_id]['amount'] = $amount;
                        }

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/
            return view('admin.stock_reports.sale_purchase_return_summarized_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));
        }



        //PURCHASE RETURN
        if ($type == 'p_r'){
            $heading = 'PURCHASE RETURN';
            $party_name = DB::table('supplier_info')->select('supplier_name')->where('id', $party_id)->first()->supplier_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt 
                        from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                        where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') 
                        and purchase_return_details.product_id = '.$product_id.' and purchase_return_main.supplier_id = '.$party_id.'  ');


                        if ($purchase_rt_qt[0]->purchase_rt_qt != null) {
                            $rate_per_carton = $qt_per_carton * $rate;
                            $carton_qt = intval($purchase_rt_qt[0]->purchase_rt_qt / $qt_per_carton);
                            $pieces = intval($purchase_rt_qt[0]->purchase_rt_qt % $qt_per_carton);
                            $carton_rate = $carton_qt * $rate_per_carton;
                            $amount = $purchase_rt_qt[0]->purchase_rt_qt * $rate;

                            $arr_info[$cat_name][$product_id] = array();
                            $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                            $arr_info[$cat_name][$product_id]['rate'] = $rate;
                            $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                            $arr_info[$cat_name][$product_id]['sale_qt'] = $purchase_rt_qt[0]->purchase_rt_qt;
                            $arr_info[$cat_name][$product_id]['carton_qt'] = $carton_qt;
                            $arr_info[$cat_name][$product_id]['pieces'] = $pieces;
                            $arr_info[$cat_name][$product_id]['carton_amount'] = $carton_rate;
                            $arr_info[$cat_name][$product_id]['amount'] = $amount;
                        }

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.sale_purchase_return_summarized_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }
    }



    public function salePurchaseReturnTransferForm(){
        return view('admin.stock_reports.summarized_sale_purchase_return_form');

    }

    public function salePurchaseReturnTransferReport(Request $request){

        $type = $request->type;
        $party_id = $request->party_id;
        $to_d = $request->to_date;
        $from_d = $request->from_date;
        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);


        $catagories = DB::table('catagory')->select('id', 'cname')->get();

//        echo $type.', '.$party_id.', '.$from_date.', '.$to_date;

        // if type SALE selected
        if ($type == 's'){
            $heading = 'PARTY WISE SALES STATEMENT - DETAILS';
            $party_name = DB::table('clients')->select('client_name')->where('id', $party_id)->first()->client_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry 
                            join memo_account on memo_account.id = memo_entry.memo_id  
                            where (memo_account.entry_date between '.$from_date.' and '.$to_date.') 
                            and memo_entry.product_id = '.$product_id.' and memo_account.client_id = '.$party_id.'  ');

                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $sale_qt[0]->sale_qt;

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));

        }


        //SALE RETURN
        if ($type == 's_r'){
            $heading = 'PARTY WISE SALES RETURN STATEMENT - DETAILS';
            $party_name = DB::table('clients')->select('client_name')->where('id', $party_id)->first()->client_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;


                        $sale_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry 
                            join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id   
                            where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') 
                            and return_memo_entry.product_id = '.$product_id.' and return_memo_account.client_id = '.$party_id.'  ');

                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $sale_qt[0]->sale_rt_qt;

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }


        //PURCHASE
        if ($type == 'p'){
            $heading = 'PARTY WISE PURCHASE STATEMENT - DETAILS ';
            $party_name = DB::table('supplier_info')->select('supplier_name')->where('id', $party_id)->first()->supplier_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single 
                        join purchase_main on purchase_main.id = purchase_single.purchase_id  
                        where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') 
                        and purchase_single.product_id = '.$product_id.' and purchase_main.supplier_id = '.$party_id.'   ');


                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $purchase_qt[0]->purchase_qt;

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }

        //PURCHASE RETURN
        if ($type == 'p_r'){
            $heading = 'PARTY WISE PURCHASE RETURN STATEMENT - DETAILS';
            $party_name = DB::table('supplier_info')->select('supplier_name')->where('id', $party_id)->first()->supplier_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt 
                        from purchase_return_details join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                        where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') 
                        and purchase_return_details.product_id = '.$product_id.' and purchase_return_main.supplier_id = '.$party_id.'  ');

                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $purchase_rt_qt[0]->purchase_rt_qt;

                    }
                }
            }

            /*echo '<pre>';
            print_r($arr_info);
            echo '</pre>';*/

            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }


        //TRANSFER IN
        if ($type == 'in'){
            $heading = ' PARTY WISE TRANSFER IN STATEMENT - DETAILS ';
            $party_name = DB::table('warehouse')->select('warehouse_name')->where('id', $party_id)->first()->warehouse_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $in_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as in_qt from warehouse_product_transfer 
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') 
                        and warehouse_product_transfer.product_id = '.$product_id.'  and warehouse_product_transfer.to_warehouse = '.$party_id.'   ');

                        /*$out_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.')
                        and warehouse_product_transfer.product_id = '.$product_id.'    ');*/

                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $in_qt[0]->in_qt;

                    }
                }
            }
            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }


        //TRANSFER OUT
        if ($type == 'out'){
            $heading = 'PARTY WISE TRANSFER OUT STATEMENT - DETAILS';
            $party_name = DB::table('warehouse')->select('warehouse_name')->where('id', $party_id)->first()->warehouse_name;
            $arr_info = array();

            foreach ($catagories as $catagory){

                $cat_id = $catagory->id;
                $cat_name = $catagory->cname;
                $products = DB::table('product_info')->select('id', 'product_name', 'sell', 'qt_per_carton')->where('product_type_id', $cat_id)->get();


                if (sizeof($products)>0){ // if the category has product
                    $arr_info[$cat_name] = array();

                    foreach ($products as $product){
                        $product_id = $product->id;
                        $product_name = $product->product_name;
                        $rate = $product->sell;
                        $qt_per_carton = $product->qt_per_carton;

                        $out_qt = DB::select('   Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer
                        where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.')
                        and warehouse_product_transfer.product_id = '.$product_id.'  and warehouse_product_transfer.from_warehouse = '.$party_id.'  ');

                        $arr_info[$cat_name][$product_id] = array();

                        $arr_info[$cat_name][$product_id]['product_name'] = $product_name;
                        $arr_info[$cat_name][$product_id]['rate'] = $rate;
                        $arr_info[$cat_name][$product_id]['qt_per_carton'] = $qt_per_carton;
                        $arr_info[$cat_name][$product_id]['sale_qt'] = $out_qt[0]->out_qt;

                    }
                }
            }
            return view('admin.stock_reports.summarized_sale_purchase_return_report', compact('arr_info', 'party_name', 'from_d', 'to_d','heading'));



        }
    }



    public function closingStockAndValueForm(){
        return view('admin.stock_reports.closing_stock_and_value_form');
    }


    public function closingStockAndValueReport(Request $request){

        $date = $request->from_date;
        $from_date = $constant_date = strtotime('1990-01-01');
        $to_date = strtotime($date);

        $products = DB::table('product_info')->get();
        $info_arr = array();

        foreach ($products as $product){
            $product_id = $product->id;
            $product_name = $product->product_name;
            $product_rate = $product->sell;
            $qt_per_carton = $product->qt_per_carton;

            $closing_qt = 0;
            $info_arr[$product_id] = array();

            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single 
                join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.'   ');


            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details 
                join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.'   ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry 
                join memo_account on memo_account.id = memo_entry.memo_id  
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.'   ');

            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry 
                join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id  
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.'   ');

            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt ;


            if ($closing_qt > 0){
                $carton = intval($closing_qt / $product->qt_per_carton);
                $pieces = intval($closing_qt % $product->qt_per_carton);
                $amount = $closing_qt * $product_rate;
            }else{
                $carton = 0;
                $pieces = $closing_qt;
                $amount = 0 * $product_rate;
            }

            $info_arr[$product_id]['product_id'] = $product_id;
            $info_arr[$product_id]['product_name'] = $product->product_name;
            $info_arr[$product_id]['carton'] = $carton;
            $info_arr[$product_id]['pieces'] = $pieces;
            $info_arr[$product_id]['qt_per_carton'] = $product->qt_per_carton;
            $info_arr[$product_id]['closing_qt'] = $closing_qt;
            $info_arr[$product_id]['rate'] = $product_rate;
            $info_arr[$product_id]['amount'] = $amount;
        }
/*
        echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/

        return view('admin.stock_reports.closing_stock_and_value_report', compact('info_arr', 'date'));
    }


    public function closingStockForm(){

        $catagories = DB::table('catagory')->select('id', 'cname')->get();
        return view('admin.stock_reports.closing_stock_form', compact('catagories'));
    }

    public function closingStockReport(Request $request){

        $cat_id = $request->catagory_id;
        $date = $request->to_date;
        $from_date = $constant_date = strtotime('1990-01-01');
        $to_date = strtotime($date);

        $cat_name = DB::table('catagory')->select('cname')->where('id', $cat_id)->first()->cname;
        $products = DB::table('product_info')->where('product_type_id', $cat_id)->get();
        $info_arr = array();

        foreach ($products as $product){
            $product_id = $product->id;
            $product_name = $product->product_name;
            $product_rate = $product->sell;
            $qt_per_carton = $product->qt_per_carton;

            $closing_qt = 0;
            $info_arr[$product_id] = array();

            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single 
                join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.'   ');


            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details 
                join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.'   ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry 
                join memo_account on memo_account.id = memo_entry.memo_id  
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.'   ');

            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry 
                join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id  
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.'   ');

            $closing_qt += $purchase_qt[0]->purchase_qt - $purchase_rt_qt[0]->purchase_rt_qt - $sale_qt[0]->sale_qt + $sale_rt_qt[0]->sale_rt_qt ;


            if ($closing_qt > 0){
                $carton = intval($closing_qt / $product->qt_per_carton);
                $pieces = intval($closing_qt % $product->qt_per_carton);
                $amount = $closing_qt * $product_rate;
            }else{
                $carton = 0;
                $pieces = $closing_qt;
                $amount = 0 * $product_rate;
            }

            $info_arr[$product_id]['product_id'] = $product_id;
            $info_arr[$product_id]['product_name'] = $product->product_name;
            $info_arr[$product_id]['carton'] = $carton;
            $info_arr[$product_id]['pieces'] = $pieces;
            $info_arr[$product_id]['qt_per_carton'] = $product->qt_per_carton;
            $info_arr[$product_id]['closing_qt'] = $closing_qt;
            $info_arr[$product_id]['rate'] = $product_rate;
            $info_arr[$product_id]['amount'] = $amount;
        }


        return view('admin.stock_reports.closing_stock', compact('info_arr', 'date', 'cat_name'));
    }


    public function StoreWiseClosingStockWithRateForm(){

        $warehouses = DB::table('warehouse')->select('id', 'warehouse_name')->get();
        $catagories = DB::table('catagory')->select('id', 'cname')->get();
        return view('admin.stock_reports.storewise_closing_stock_with_rate_form', compact('catagories', 'warehouses'));
    }

    public function StoreWiseClosingStockWithRateReport(Request $request){

        $cat_id = $request->catagory_id;
        $warehouse_id = $request->warehouse_id;
        $date = $request->to_date;
        $from_date = $constant_date = strtotime('1990-01-01');
        $to_date = strtotime($date);

        $cat_name = DB::table('catagory')->select('cname')->where('id', $cat_id)->first()->cname;
        $warehouse_name = DB::table('warehouse')->select('warehouse_name')->where('id', $warehouse_id)->first()->warehouse_name;
        $products = DB::table('product_info')->where('product_type_id', $cat_id)->get();
        $info_arr = array();


        foreach ($products as $product){
            $product_id = $product->id;
            $product_name = $product->product_name;
            $product_rate = $product->sell;
            $qt_per_carton = $product->qt_per_carton;

            $closing_qt = 0;
            $info_arr[$product_id] = array();

            $purchase_qt = DB::select(' Select sum(purchase_single.quantity) as purchase_qt from purchase_single 
                join purchase_main on purchase_main.id = purchase_single.purchase_id  
                where (purchase_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_single.product_id = '.$product_id.' 
                and purchase_main.warehouse_id = '.$warehouse_id.'  ');


            $purchase_rt_qt = DB::select(' Select sum(purchase_return_details.quantity) as purchase_rt_qt from purchase_return_details 
                join purchase_return_main on purchase_return_main.id = purchase_return_details.purchase_return_id  
                where (purchase_return_main.entry_date between '.$from_date.' and '.$to_date.') and purchase_return_details.product_id = '.$product_id.'  and purchase_return_main.warehouse_id = '.$warehouse_id.'  ');

            $sale_qt = DB::select(' Select sum(memo_entry.quantity) as sale_qt from memo_entry 
                join memo_account on memo_account.id = memo_entry.memo_id  
                where (memo_account.entry_date between '.$from_date.' and '.$to_date.') and memo_entry.product_id = '.$product_id.'  and memo_entry.warehouse_id = '.$warehouse_id.'  ');



            $sale_rt_qt = DB::select(' Select sum(return_memo_entry.quantity) as sale_rt_qt from return_memo_entry 
                join return_memo_account on return_memo_account.id = return_memo_entry.return_memo_id  
                where (return_memo_account.entry_date between '.$from_date.' and '.$to_date.') and return_memo_entry.product_id = '.$product_id.' and return_memo_entry.warehouse_id = '.$warehouse_id.'   ');



            $in_qt = DB::select(' Select sum(warehouse_product_transfer.quantity) as in_qt from warehouse_product_transfer 
                where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') and warehouse_product_transfer.product_id = '.$product_id.' and warehouse_product_transfer.to_warehouse = '.$warehouse_id.'  ');


            $out_qt = DB::select(' Select sum(warehouse_product_transfer.quantity) as out_qt from warehouse_product_transfer 
                where (warehouse_product_transfer.entry_date between '.$from_date.' and '.$to_date.') and warehouse_product_transfer.product_id = '.$product_id.' 
                and warehouse_product_transfer.from_warehouse = '.$warehouse_id.'  ');

            $closing_qt += $purchase_qt[0]->purchase_qt - $sale_qt[0]->sale_qt - $out_qt[0]->out_qt - $purchase_rt_qt[0]->purchase_rt_qt  + $sale_rt_qt[0]->sale_rt_qt+ $in_qt[0]->in_qt  ;


            if ($closing_qt > 0){
                $carton = intval($closing_qt / $product->qt_per_carton);
                $pieces = intval($closing_qt % $product->qt_per_carton);
                $amount = $closing_qt * $product_rate;
            }else{
                $carton = 0;
                $pieces = $closing_qt;
                $amount = 0 * $product_rate;
            }

            $info_arr[$product_id]['product_id'] = $product_id;
            $info_arr[$product_id]['product_name'] = $product->product_name;
            $info_arr[$product_id]['carton'] = $carton;
            $info_arr[$product_id]['pieces'] = $pieces;
            $info_arr[$product_id]['qt_per_carton'] = $product->qt_per_carton;
            $info_arr[$product_id]['closing_qt'] = $closing_qt;
            $info_arr[$product_id]['rate'] = $product_rate;
            $info_arr[$product_id]['amount'] = $amount;
        }

        return view('admin.stock_reports.storewise_closing_stock_with_rate_report',  compact('info_arr', 'date', 'cat_name', 'warehouse_name'));
    }


}
