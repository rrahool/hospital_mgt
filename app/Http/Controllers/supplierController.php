<?php

namespace App\Http\Controllers;

use App\Ledger;
use App\Supplier;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;


class supplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
//        $this->middleware('auth');
    }

    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    public function index()
    {

        return view('admin.supplier.addSupplier');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'supplier_name' => 'required',
            'products'      => 'required',
            'contact_no'    => 'required',
        ]);

        $next_id = Supplier::max('id') + 1;
        $supplier_name = str_replace(' ','_', $request->supplier_name);
        $supplier_id = $supplier_name.'_'.$next_id;


//        $user_id = Auth::user()->id;

        $insert = DB::table('supplier_info')->insert([
            'supplier_name' => $request->supplier_name,
            'supplier_id' => $supplier_id,
            'executive_name'  => $request->executive_name,
            'products'      => $request->products,
            'address'       => $request->address,
            'email'         => $request->email,
            'contact_no'    => $request->contact_no,
//            'creator_id'    => $user_id,
            'creator_id'    => \Illuminate\Support\Facades\Auth::id(),
            'created_at'    => $this->getDate(),

        ]);

        if ($insert) {

            $ledger = new Ledger();
            $ledger->group_id = 32;
            $ledger->name = $supplier_id;
//            $ledger->code = $request->code;
            $ledger->op_balance = 0.00;
            $ledger->op_balance_dc = 'D';
            $ledger->type = 0;
//            $ledger->reconciliation = $request->reconciliation;
//            $ledger->notes = $request->notes;
            $ledger->dr_pos = 0;
            $is_saved = $ledger->save();
        }

        return redirect('add_supplier')->with('message','Supplier insert successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSupplier()
    {
        $all_supplier = DB::table('supplier_info')->get();
        return view('admin.supplier.supplier_list',['all_supplier'=>$all_supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id)
    {
        $showById = DB::table('supplier_info')->where('id',$id)->first();
        return view('admin.supplier.showById',['showById'=>$showById]);
    }

    public function editById($id){
        $showById = DB::table('supplier_info')->where('id',$id)->first();

        return view('admin.supplier.editSupplier',['showById'=>$showById]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

//        $user_id = Auth::user()->id;



        $update = DB::table('supplier_info')->where('id',$request->id)->update([
            'supplier_name' => $request->supplier_name,
            'executive_name'=> $request->executive_name,
            'products'      => $request->products,
            'address'       => $request->address,
            'email'         => $request->email,
            'contact_no'    => $request->contact_no,
            'creator_id'    => \Illuminate\Support\Facades\Auth::id()
//            'creator_id'    => $user_id,
        ]);

        if ($update){
            return back()->with('message','Supplier update successfully.');
        }
    }

    public function payment(){

        $payment_list = DB::select("SELECT expense.*, supplier_info.supplier_name,supplier_info.executive_name,supplier_info.address FROM supplier_info JOIN expense ON supplier_info.id = expense.supplier_id WHERE expense.exp_pay = 'payment'");

        //return dd($payment_list);

     return view('admin.supplier.supplier_payment',['payment_list'=>$payment_list]);
    }

    public function paymentView($id){

     $paymen_show = DB::select("SELECT expense.*, expense_type.name, users.username,supplier_info.supplier_name FROM expense_type RIGHT JOIN expense ON expense_type.id = expense.expense_type JOIN users ON expense.paid_by = users.id LEFT JOIN supplier_info ON supplier_info.id = expense.supplier_id WHERE expense.id = $id ORDER BY expense.id DESC");

     return view('admin.supplier.supplier_payment_view',['paymen_show'=>$paymen_show]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('supplier_info')->where('id', $id)->delete();

        return redirect('supplier_list')->with('message','Supplier delete successfully.');
    }
}
