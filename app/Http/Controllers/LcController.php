<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LcController extends Controller
{
    //
    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    function getSerial() {

        $lastId = DB::table('lc_info')->select('id')->orderby('id', 'desc')->first();
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

    public function index(){
        $lc_types = DB::table('lc_types')->get();
        $entry_no = $this->getSerial();
        return view('admin.lc.create_lc', compact('lc_types', 'entry_no'));
    }

    /*
     * store Lc Info in table
     * */
    public function storeIcInfo(Request $request){

        $lc_date =strtotime($request->lc_date);
        $scpi_date =strtotime($request->scpi_date);
        $mc_date =strtotime($request->mc_date);

        $saved = DB::table('lc_info')->insert([
            'lc_type'=>$request->lc_type,
            'lc_id'=>$request->lc_id,
            'lc_no'=>$request->lc_no,
            'lc_date'=>$lc_date,
            'bank_name'=>$request->bank_name,
            'importer_name'=>$request->importer_name,
            'beneficiary'=>$request->beneficiary,
            'scpi_no'=>$request->scpi_no,
            'scpi_date'=>$scpi_date,
            'mc_name'=>$request->mc_name,
            'mc_no'=>$request->mc_no,
            'mc_date'=>$mc_date,
            'lc_usd'=>$request->lc_usd,
            'lc_exchange_rate'=>$request->lc_exchange_rate,
            'lc_bdt'=>$request->lc_bdt,
            'remarks'=>$request->remarks,
            'status'=>$request->status,
            'created_at'=>$this->getDate(),

        ]);

        if ($saved){
            return redirect('create_lc')->with('message','L/C information saved successful');
        }else{
            return redirect('create_lc')->with('message','Failed to save L/C information');

        }
    }


    /*
     * getting Lc List
     * */
    public function getLcList(){

        $all_lc = DB::table('lc_info')->get();
        return view('admin.lc.all_lc', compact('all_lc'));

    }


    /*
     * showing edit Lc Form
     * */
    public function editLcForm($id){

        $lc_info = DB::table('lc_info')->where('id', $id)->first();
        $lc_types = DB::table('lc_types')->get();
        $entry_no = $lc_info->lc_id;
        return view('admin.lc.edit_lc', compact('lc_info', 'type', 'lc_types', 'entry_no'));
    }


    /*
     * editing Lc info
     * */
    public function editLc(Request $request){

        $lc_date =strtotime($request->lc_date);
        $scpi_date =strtotime($request->scpi_date);
        $mc_date =strtotime($request->mc_date);


        $saved = DB::table('lc_info')->where('id', $request->id)->update([
            'lc_type'=>$request->lc_type,
            'lc_id'=>$request->lc_id,
            'lc_no'=>$request->lc_no,
            'lc_date'=>$lc_date,
            'bank_name'=>$request->bank_name,
            'importer_name'=>$request->importer_name,
            'beneficiary'=>$request->beneficiary,
            'scpi_no'=>$request->scpi_no,
            'scpi_date'=>$scpi_date,
            'mc_name'=>$request->mc_name,
            'mc_no'=>$request->mc_no,
            'mc_date'=>$mc_date,
            'lc_usd'=>$request->lc_usd,
            'lc_exchange_rate'=>$request->lc_exchange_rate,
            'lc_bdt'=>$request->lc_bdt,
            'remarks'=>$request->remarks,
            'status'=>$request->status,
            'created_at'=>$this->getDate(),
        ]);


        if ($saved){
            return redirect('lc_edit/'.$request->id)->with('message','L/C information updated successful');

        }else{
            return redirect('lc_edit/'.$request->id)->with('message','Failed to update L/C information');
        }


    }


    /*
     * deleting LC row
     * */
    public function deleteLC($id){
        $deleted = DB::table('lc_info')->where('id', $id)->delete();
        if ($deleted){
            return redirect('all_lc/')->with('message','L/C information deleted successful');

        }else{
            return redirect('all_lc/')->with('message','Failed to delete L/C information');
        }
    }

}
