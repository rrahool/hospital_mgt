<?php

namespace App\Http\Controllers;

use App\SingleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //

    public function showTopsheetForm(){

        $bill_info = DB::table('memo_account')->select('id', 'memo_no')->get();
        return view('test_report.topsheet_form', compact('bill_info'));
    }


    /*
     * getting client info by selecting client
     * */
    public function getBillInfo(){
        $bill_id = $_GET['client_id'];
        echo $bill_id;
        die();
        $bill_info = DB::table('memo_account')
            ->select( 'clients.client_name')
            ->join('clients', 'clients.id', '=', 'memo_account.client_id')
            ->where('memo_account.id', $bill_id)
            ->first();

        $output = '
                                    <div id="client_info_div" >
                                               <div class="form-row row"  >
                                                   <div class="form-group col-md-6">
                                                        <label>Patient Name</label>
                                                        <span>: '.$bill_info->client_name.'</span>
                                                    </div>
                                                </div>
                                            </div>
                                   
        ';

        echo $output;
    }


    public function showTopsheet(Request $request){

        $bill_id = $request->client_id;
        $info = DB::table('memo_account')
            ->select('memo_account.*', 'clients.client_name')
            ->join('clients', 'clients.id', '=', 'memo_account.client_id')
            ->where('memo_account.id', $bill_id)
            ->first();
        return view('test_report.topsheet', compact('info'));
    }
}
