<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Client;
use App\Entry;
use App\EntryType;
use App\Expense;
use App\Group;
use App\Income;
use App\Ledger;
use App\Liability;
use App\Process;
use App\SingleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class AccountController extends Controller
{
    //


    public function checkAuth(){

    }


    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    /*
     * showing home page
     * */
    public function userHome(){
        if(\Illuminate\Support\Facades\Auth::check()){
            return view('index');
        }else{
            return redirect('/');
        }
    }




    /*
     * showing account info
     * */
    public  function showAccount(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $groups = Group::select('*')->get();
            return view('account.account', compact('groups'));
        }
    }



    public function showRegisterPage(){
        $account_create_menus = DB::table('menus')->where('parent_id', 2)->get();
        $account_report_menus = DB::table('menus')->where('parent_id', 3)->get();
        $stock_entry_menus = DB::table('menus')->where('parent_id', 4)->get();
        $stock_report_menus = DB::table('menus')->where('parent_id', 5)->get();
        return view('auth.register', compact('account_create_menus', 'account_report_menus', 'stock_entry_menus', 'stock_report_menus'));
    }


    public function registerUser(Request $request){

        $user_name = $request->user_name;
        $email = $request->email;
        $contact_no = $request->contact_no;
        $address = $request->address;
        $password = bcrypt($request->password);


        if ($request->user_type == 0){ // if role is user

            $create_account_menus = $request->create_account_menus;
            $account_report_menus = $request->account_report_menus;
            $stock_entry_menus = $request->stock_entry_menus;
            $stock_report_menus = $request->stock_report_menus;

            $c_a_menus = implode (", ", $create_account_menus);
            $c_r_menus = implode (", ", $account_report_menus);
            $s_a_menus = implode (", ", $stock_entry_menus);
            $s_r_menus = implode (", ", $stock_report_menus);


            $success = DB::table('users')->insert([
                'username'=>$user_name,
                'email'=>$email,
                'phoneNo'=>$contact_no,
                'role'=>$request->user_type,
                'address'=>$address,
                'password'=>$password,
                'creator_id'=>Auth::id(),
                'create_account_menus'=>$c_a_menus,
                'account_report_menus'=>$c_r_menus,
                'stock_entry_menus'=>$s_a_menus,
                'stock_report_menus'=>$s_r_menus,
            ]);
        }elseif ($request->user_type == 1){ //if role is admin
            $success = DB::table('users')->insert([
                'username'=>$user_name,
                'email'=>$email,
                'phoneNo'=>$contact_no,
                'address'=>$address,
                'role'=>$request->user_type,
                'password'=>$password,
                'creator_id'=>Auth::id(),
                'create_account_menus'=>'',
                'account_report_menus'=>'',
                'stock_entry_menus'=>'',
                'stock_report_menus'=>'',
                ]);
        }


        if ($success){
            session()->flash('message.level', 'success');
            session()->flash('message.content', 'User Successfully Created ');
            return redirect('register_user');
        }else{
            session()->flash('message.level', 'danger');
            session()->flash('message.content', 'Failed To Create User. Try Again... ');
            return redirect('register_user');
        }
    }


    /*
     * editting Group info
     * */
    public function editGroup($group_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $group = Group::select('*')->where('id', $group_id)->first();
            $groups = Group::select('*')->get();
            return view('account.create_group', compact('groups', 'group'));
        }
    }


    /*
     * editting Group info
     * */
    public function editGroupInfo(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $is_success = Group::where('id', $request->group_id)->update(['parent_id' => $request->parent_group, 'name' => $request->group_name, 'code' => $request->group_code]);
            if ($is_success) {
                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Group Info Edited Successfully ');

                return redirect('edit-group/' . $request->group_id);
            } else {
                session()->flash('message.level', 'failed');
                session()->flash('message.content', 'Failed To Edit Group Info, Try Later');
                return redirect('edit-group/' . $request->group_id);
            }
        }
    }


    /*
     * deleting Group info
     * */
    public function deleteGroup($group_id){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $is_success = Group::where('id', $group_id)->delete();


            if ($is_success) {
                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Group deleted Successfully ');

                return redirect('show-accounts');
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To delete Group, Try Later');
                return redirect('show-accounts');
            }
        }
    }


    /*
     * editting Ledger info
     * */
    public function editLedger($ledger_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $ledger = Ledger::select('*')->where('id', $ledger_id)->first();
            $groups = Group::select('*')->get();
            return view('account.create_ledger', compact('groups', 'ledger'));
        }

    }


    /*
     * editting Ledger info
     * */
    public function editLedgerInfo(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $is_success = Ledger::where('id', $request->leg_id)->update(['group_id' => $request->parent_group, 'name' => $request->ledger_name,
                'code' => $request->ledger_code, 'op_balance' => $request->amount, 'op_balance_dc' => $request->dr_cr, 'type' => $request->LedgerType,
                'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

            $ledger = Ledger::select('*')->where('id', $request->leg_id)->first();
            $groups = Group::select('*')->get();


            if ($is_success) {
                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Ledger Info Edited Successfully ');

                return view('account.create_ledger', compact('groups', 'ledger'));
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Edit Ledger Info, Try Later');
                return view('account.create_ledger', compact('groups', 'ledger'));
            }

        }
    }


    /*
     * deleting Ledger info
     * */
    public function deleteLedger($ledger_id){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            // checking if entry exist
            $entry_exist = SingleEntry::select('id')->where('ledger_id', $ledger_id)->get();
            $entry_exist = $entry_exist->toArray();

            // if entry exist, cant delete
            if (sizeof($entry_exist) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This ledger has an entry. Cannot be deleted.');
                return redirect('show-accounts');
            }

            // getting ledger info and deleteing from ledger table
            $led = Ledger::select('group_id', 'name')->where('id', $ledger_id)->first();
            $is_success = Ledger::where('id', $ledger_id)->delete();


            // deleting from other tables
            if ($is_success) {

                if ($led->group_id == 17) {
                    Bank::where('bank_id', $led->name)->delete();

                } elseif ($led->group_id == 31) {
                    Client::where('client_id', $led->name)->delete();

                } elseif (Group::select('parent_id')->where('id', $led->group_id)->first()->parent_id == 4) {
                    Expense::where('expense_id', $led->name)->delete();

                } elseif (Group::select('parent_id')->where('id', $led->group_id)->first()->parent_id == 3) {
                    Income::where('income_id', $led->name)->delete();

                } elseif (Group::select('parent_id')->where('id', $led->group_id)->first()->parent_id == 2) {
                    Liability::where('ledger_id', $led->name)->delete();

                }

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Ledger deleted Successfully ');

                return redirect('show-accounts');
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To delete Ledger, Try Later');
                return redirect('show-accounts');
            }
        }
    }


    /*
     *
     * creating new group form
     * */
    public function createGroupForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $groups = Group::select('*')->get();
            return view('account.create_group', compact('groups'));
        }
    }


    /*
     * creating new group
     * */
    public function createGroup(Request $request){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $group = new Group();
            $group->name = $request->group_name;
            $group->code = $request->group_code;
            $group->parent_id = $request->parent_group;
            $is_success = $group->save();

            if ($is_success) {
                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Group Created Successfully ');

                return redirect('show-accounts');
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Create Group, Try Later');
                return redirect('show-accounts');
            }

        }
    }



    /*
     * creating new ledger form
     *
     * */
    public function createLedgerForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $groups = Group::select('*')->get();
            return view('account.create_ledger', compact('groups'));
        }
    }


    /*
     *
     * creating new ledger
     * */
    public function createLeder(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $request->LedgerType = ($request->LedgerType == 1) ? 1 : 0;
            $dr_pos = ($request->LedgerType == 1) ? 1 : 0;

            // saving data in ledger table
            $ledger = new Ledger();
            $ledger->name = $request->ledger_name;
            $ledger->code = $request->ledger_code;
            $ledger->group_id = $request->parent_group;
            $ledger->op_balance_dc = $request->dr_cr;
            $ledger->op_balance = $request->amount;
            $ledger->type = $request->LedgerType;
            $ledger->dr_pos = $dr_pos;
            $ledger->reconciliation = $request->reconciliation;
            $ledger->notes = $request->notes;

            if ($request->LedgerType == 1) {
                $ledger->bank_or_cash = 'C';
            }
            $is_success = $ledger->save();

            if ($is_success) {
                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Ledger Created Successfully ');

                return redirect('show-accounts');
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                return redirect('show-accounts');
            }
        }
    }


    public function getEntryNo(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $date = date('d-m-y');
            $date_arr = explode('-', $date);
            $entry_no = $date_arr[2] . '' . $date_arr[1];

            $last_entry_num = DB::table('entries')->select('number')
                ->where('number', 'like', $entry_no . '%')
                ->orderby('number', 'desc')
                ->first();

            if (empty($last_entry_num->number)) {
                $entry_no = $entry_no . '0001';
            } else {
                $entry_no = $last_entry_num->number + 1;
            }


            return $entry_no;
//        return $last_entry_num->number;
        }
    }


    /*
     * Entries works
     *
     * */
    public function newEntries(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $entry_no = $this->getEntryNo();
            /*echo $entry_no;
            die;*/

            $groups = Group::select('*')->get();

            $cash_ledgers = Ledger::select('id', 'name')->where('type', 1)->get();
            $other_ledgers = Ledger::select('id', 'name')->where('type', 0)->get();
            $receivables_id = \App\Group::select('id')->where('name', "Account Recievable")->first()->id;
            $rec_led = \App\Ledger::select('id', 'name')->where('group_id', $receivables_id)->get();


            $entrytypes = EntryType::select('*')->get();
            $journal_ledgers = Ledger::select('id', 'name')->where('type', 0)->get();

            return view('entry.entries', compact('groups', 'journal_ledgers', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led', 'entry_no'));
        }
    }


    /*
     * Entries works
     *
     * */
    public function createEntries(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $transaction_type = $request->trans_type;
            $voucher_no = $request->vou_no;

            $trans_date = explode('/', $request->trans_date);
            $trans_date = $trans_date[2] . '-' . $trans_date[0] . '-' . $trans_date[1];

            $date_summary = $request->date_summary;
            $number = $request->number;

            if ($transaction_type == 2) {
                // if transaction_type is Payment

                $transaction_for = $request->trans_for;
                $trans_mode = $request->trans_mode;
                $payment_to = $request->pay_to;
                $payment_from = $request->pay_from;
                if ($trans_mode == 'Cheque') {
                    $cheque_date = explode('/', $request->cheque_date);
                    $cheque_date = $cheque_date[2] . '-' . $cheque_date[0] . '-' . $cheque_date[1];
                }
                $narration = $request->narration;
                $remarks = $request->remarks;
                $amount = $request->amount;
                $cheque_no = $request->cheque_no;


                // saving data in entry table
                $entry = new Entry();
                $entry->entrytype_id    = $transaction_type;
                $entry->date            = $trans_date;
                $entry->dr_total        = $amount;
                $entry->voucher         = $voucher_no;
                $entry->cr_total        = $amount;
                $entry->narration       = $narration;
                $entry->number          = $number;
                $entry->voucher         = $voucher_no;
                $saved = $entry->save();

                if ($saved) {


                    $entry_id = $entry->id;

                    // after saving data in entry table, saving date for each single entry
                    $single_entry = new SingleEntry();
                    $single_entry->entry_id = $entry_id;
                    $single_entry->ledger_id = $payment_to;
                    $single_entry->amount = $amount;
                    $single_entry->dc = 'D';
                    $single_entry->transaction_for = $transaction_for;
                    $single_entry->transaction_mode = $trans_mode;
                    $single_entry->transaction_date = $trans_date;

                    // trans_mode is 'Cheque'
                    if ($trans_mode == 'Cheque') {
                        $single_entry->bank_name = $request->bank_name;
                        $single_entry->cheque_no = $cheque_no;
                        $single_entry->cheque_date = $cheque_date;
                    }
                    $single_entry->Remarks = $remarks;
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry->save();

                    $single_entry1 = new SingleEntry();
                    $single_entry1->entry_id = $entry_id;
                    $single_entry1->ledger_id = $payment_from;
                    $single_entry1->amount = $amount;
                    $single_entry1->dc = 'C';
                    $single_entry1->transaction_for = $transaction_for;
                    $single_entry1->transaction_mode = $trans_mode;
                    $single_entry1->transaction_date = $trans_date;
                    if ($trans_mode == 'Cheque') {
                        $single_entry1->bank_name = $request->bank_name;
                        $single_entry1->cheque_no = $cheque_no;
                        $single_entry1->cheque_date = $cheque_date;
                    }
                    $single_entry1->Remarks = $remarks;
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry1->save();


                    if ($saved) {
                        session()->flash('message.level', 'success');
                        session()->flash('message.content', 'Entry Saved Successfully ');
                        return redirect('entries');
                    } else {
                        session()->flash('message.level', 'danger');
                        session()->flash('message.content', 'Failed To Save Entry, Try Later');
                        return redirect('entries');
                    }

                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Entry, Try Later');
                    return redirect('entries');
                }


            } else if ($transaction_type == 1) {

                // if transaction_type is Receipt

                $transaction_for = $request->trans_for;
                $trans_mode = $request->trans_mode;
                $receipt_to = $request->receipt_to;
                $receipt_from = $request->receipt_from;
                $cheque_no = $request->cheque_no;
                if ($trans_mode == 'Cheque') {
                    $cheque_date = explode('/', $request->cheque_date);
                    $cheque_date = $cheque_date[2] . '-' . $cheque_date[0] . '-' . $cheque_date[1];
                }
                $narration = $request->narration;
                $remarks = $request->remarks;
                $amount = $request->amount;

                $entry = new Entry();
                $entry->entrytype_id = $transaction_type;
                $entry->date = $trans_date;
                $entry->dr_total = $amount;
                $entry->cr_total = $amount;
                $entry->narration = $narration;
                $entry->number = $number;
                $saved = $entry->save();

                if ($saved) {


                    $entry_id = $entry->id;

                    $single_entry = new SingleEntry();
                    $single_entry->entry_id = $entry_id;
                    $single_entry->ledger_id = $receipt_to;
                    $single_entry->amount = $amount;
                    $single_entry->dc = 'D';
                    $single_entry->transaction_for = $transaction_for;
                    $single_entry->transaction_mode = $trans_mode;
                    $single_entry->transaction_date = $trans_date;
                    if ($trans_mode == 'Cheque') {
                        $single_entry->bank_name = $request->bank_name;
                        $single_entry->cheque_no = $cheque_no;
                        $single_entry->cheque_date = $cheque_date;
                    }
                    $single_entry->Remarks = $remarks;
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry->save();

                    $single_entry1 = new SingleEntry();
                    $single_entry1->entry_id = $entry_id;
                    $single_entry1->ledger_id = $receipt_from;
                    $single_entry1->amount = $amount;
                    $single_entry1->dc = 'C';
                    $single_entry1->transaction_for = $transaction_for;
                    $single_entry1->transaction_mode = $trans_mode;
                    $single_entry1->transaction_date = $trans_date;

                    if ($trans_mode == 'Cheque') {
                        $single_entry1->bank_name = $request->bank_name;
                        $single_entry1->cheque_no = $cheque_no;
                        $single_entry1->cheque_date = $cheque_date;
                    }

                    $single_entry1->Remarks = $remarks;
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry1->save();


                    if ($saved) {
                        session()->flash('message.level', 'success');
                        session()->flash('message.content', 'Ledger Created Successfully ');
                        return redirect('entries');
                    } else {
                        session()->flash('message.level', 'danger');
                        session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                        return redirect('entries');
                    }

                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                    return redirect('entries');
                }


            } else if ($transaction_type == 3) {

                // if transaction_type is Contra

                $transaction_for = $request->trans_for;
                $trans_mode = $request->trans_mode;
                $contra_to = $request->contra_to;
                $contra_from = $request->contra_from;
                if ($trans_mode == 'Cheque') {
                    $cheque_date = explode('/', $request->cheque_date);
                    $cheque_date = $cheque_date[2] . '-' . $cheque_date[0] . '-' . $cheque_date[1];
                }
                $narration = $request->narration;
                $remarks = $request->remarks;
                $amount = $request->amount;
                $cheque_no = $request->cheque_no;

                $entry = new Entry();
                $entry->entrytype_id = $transaction_type;
                $entry->date = $trans_date;
                $entry->dr_total = $amount;
                $entry->cr_total = $amount;
                $entry->narration = $narration;
                $entry->number = $number;
                $saved = $entry->save();

                if ($saved) {


                    $entry_id = $entry->id;

                    $single_entry = new SingleEntry();
                    $single_entry->entry_id = $entry_id;
                    $single_entry->ledger_id = $contra_to;
                    $single_entry->amount = $amount;
                    $single_entry->dc = 'D';
                    $single_entry->transaction_for = $transaction_for;
                    $single_entry->transaction_mode = $trans_mode;
                    $single_entry->transaction_date = $trans_date;
                    if ($trans_mode == 'Cheque') {
                        $single_entry->bank_name = $request->bank_name;
                        $single_entry->cheque_no = $cheque_no;
                        $single_entry->cheque_date = $cheque_date;
                    }
                    $single_entry->Remarks = $remarks;
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry->save();

                    $single_entry1 = new SingleEntry();
                    $single_entry1->entry_id = $entry_id;
                    $single_entry1->ledger_id = $contra_from;
                    $single_entry1->amount = $amount;
                    $single_entry1->dc = 'C';
                    $single_entry1->transaction_for = $transaction_for;
                    $single_entry1->transaction_mode = $trans_mode;
                    $single_entry1->transaction_date = $trans_date;
                    if ($trans_mode == 'Cheque') {
                        $single_entry1->bank_name = $request->bank_name;
                        $single_entry1->cheque_no = $cheque_no;
                        $single_entry1->cheque_date = $cheque_date;
                    }
                    $single_entry1->Remarks = $remarks;
                    $saved = $single_entry1->save();


                    if ($saved) {
                        session()->flash('message.level', 'success');
                        session()->flash('message.content', 'Ledger Created Successfully ');
                        return redirect('entries');
                    } else {
                        session()->flash('message.level', 'danger');
                        session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                        return redirect('entries');
                    }

                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                    return redirect('entries');
                }


            } else if ($transaction_type == 4) {
                // if transaction_type is Journal

                $narration = $request->narration1;

                $dr_accounts = $request->dr_acc;
                $dr_amounts = $request->dr_amount;

                $cr_accounts = $request->cr_acc;
                $cr_amounts = $request->cr_amount;

                $total_dr = $request->dr_total;
                $total_cr = $request->cr_total;

                //saving
                $entry = new Entry();
                $entry->entrytype_id = $transaction_type;
                $entry->date = $trans_date;
                $entry->dr_total = $total_dr;
                $entry->cr_total = $total_cr;
                $entry->narration = $narration;
                $entry->number = $number;
                $saved = $entry->save();

                if ($saved) {


                    $entry_id = $entry->id;

                    for ($i = 0; $i < sizeof($dr_accounts); $i++) {

                        $single_entry = new SingleEntry();
                        $single_entry->entry_id = $entry_id;
                        $single_entry->ledger_id = $dr_accounts[$i];
                        $single_entry->amount = $dr_amounts[$i];
                        $single_entry->dc = 'D';
                        $single_entry->transaction_date = $trans_date;
                        //$single_entry->reconciliation_date = "";
                        $saved = $single_entry->save();

                    }

                    for ($i = 0; $i < sizeof($cr_accounts); $i++) {

                        $single_entry = new SingleEntry();
                        $single_entry->entry_id = $entry_id;
                        $single_entry->ledger_id = $cr_accounts[$i];
                        $single_entry->amount = $cr_amounts[$i];
                        $single_entry->dc = 'C';
                        $single_entry->transaction_date = $trans_date;
                        //$single_entry->reconciliation_date = "";
                        $saved = $single_entry->save();
                    }

                    if ($saved) {
                        session()->flash('message.level', 'success');
                        session()->flash('message.content', 'Ledger Created Successfully ');
                        return redirect('entries');
                    } else {
                        session()->flash('message.level', 'danger');
                        session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                        return redirect('entries');
                    }

                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Create Ledger, Try Later');
                    return redirect('entries');
                }

                /**/


            }
        }
    }


    /*
     *
     * REPORTS
     *
     * */

    public function makeProcess(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            // assets
            $asset_id = Group::select('id')->where('name', 'Assets')->first()->id;

            $asset_groups = Group::select('id')->where('parent_id', $asset_id)->get();
            foreach ($asset_groups as $asset_group) {

                $ledgers = Ledger::select('id')->where('group_id', $asset_group->id)->get();
                foreach ($ledgers as $led) {

                    $dr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->sum('amount');
                    $cr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->sum('amount');
                    $diff = $dr_amount - $cr_amount;
                    //echo $diff.',  ';

                    $is_exist = Process::where('ledger_id', $led->id)->first();
                    if ($is_exist) {

                        Process::where('ledger_id', $led->id)->update(['total_debit' => $dr_amount, 'total_credit' => $cr_amount, 'cl_balance' => $diff, 'date' => date('Y-m-d')]);

                    } else {

                        $process = new Process();
                        $process->ledger_id = $led->id;
                        $process->total_debit = $dr_amount;
                        $process->total_credit = $cr_amount;
                        $process->cl_balance = $diff;
                        $process->date = date('Y-m-d');
                        $process->save();

                    }
                }

            }


            //liabilities
            $liabilty_id = Group::select('id')->where('name', 'Liabilities and Owners Equity')->first()->id;

            // direct Expenses
            $liabilty_groups = Group::select('id')->where('parent_id', $liabilty_id)->get();
            foreach ($liabilty_groups as $liabilty_group) {

                $ledgers = Ledger::select('id')->where('group_id', $liabilty_group->id)->get();
                foreach ($ledgers as $led) {

                    $dr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->sum('amount');
                    $cr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->sum('amount');
                    $diff = $cr_amount - $dr_amount;
                    //echo $diff.',  ';

                    $is_exist = Process::where('ledger_id', $led->id)->first();
                    if ($is_exist) {

                        Process::where('ledger_id', $led->id)->update(['total_debit' => $dr_amount, 'total_credit' => $cr_amount, 'cl_balance' => $diff, 'date' => date('Y-m-d')]);

                    } else {

                        $process = new Process();
                        $process->ledger_id = $led->id;
                        $process->total_debit = $dr_amount;
                        $process->total_credit = $cr_amount;
                        $process->cl_balance = $diff;
                        $process->date = date('Y-m-d');
                        $process->save();

                    }

                }

            }

            //Incomes
            $incomes_id = Group::select('id')->where('name', 'Incomes')->first()->id;

            // direct Expenses
            $income_groups = Group::select('id')->where('parent_id', $incomes_id)->get();
            foreach ($income_groups as $income_group) {

                $ledgers = Ledger::select('id')->where('group_id', $income_group->id)->get();
                foreach ($ledgers as $led) {

                    $dr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->sum('amount');
                    $cr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->sum('amount');
                    $diff = $cr_amount - $dr_amount;
                    //echo $diff.',  ';

                    $is_exist = Process::where('ledger_id', $led->id)->first();
                    if ($is_exist) {

                        Process::where('ledger_id', $led->id)->update(['total_debit' => $dr_amount, 'total_credit' => $cr_amount, 'cl_balance' => $diff, 'date' => date('Y-m-d')]);

                    } else {

                        $process = new Process();
                        $process->ledger_id = $led->id;
                        $process->total_debit = $dr_amount;
                        $process->total_credit = $cr_amount;
                        $process->cl_balance = $diff;
                        $process->date = date('Y-m-d');
                        $process->save();

                    }
                }

            }


            // Expenses
            $expense_id = Group::select('id')->where('name', 'Expenses')->first()->id;

            $expense_groups = Group::select('id')->where('parent_id', $expense_id)->get();
            foreach ($expense_groups as $expense_group) {

                $ledgers = Ledger::select('id')->where('group_id', $expense_group->id)->get();
                foreach ($ledgers as $led) {

                    $dr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'D')->sum('amount');
                    $cr_amount = SingleEntry::select('amount')->where('ledger_id', $led->id)->where('dc', 'C')->sum('amount');
                    $diff = $dr_amount - $cr_amount;
                    //echo $diff.',  ';

                    $is_exist = Process::where('ledger_id', $led->id)->first();
                    if ($is_exist) {

                        Process::where('ledger_id', $led->id)->update(['total_debit' => $dr_amount, 'total_credit' => $cr_amount, 'cl_balance' => $diff, 'date' => date('Y-m-d')]);

                    } else {

                        $process = new Process();
                        $process->ledger_id = $led->id;
                        $process->total_debit = $dr_amount;
                        $process->total_credit = $cr_amount;
                        $process->cl_balance = $diff;
                        $process->date = date('Y-m-d');
                        $process->save();

                    }
                }

            }


        }
    }

    /*
     * Balance Sheet Report
     * */
    public function showBalanceSheet(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $this->makeProcess();

            /* ASSETS */
            $asset_id = Group::select('id')->where('name', 'Assets')->first()->id;
            $assets = Group::where('parent_id', $asset_id)->get();
            $total_asset_amount = 0;
            $asset_amount_arr = array();


            foreach ($assets as $asset) {

                $ledger_amount = Ledger::select('*')->where('group_id', $asset->id)->join('process', 'ledgers.id', '=', 'process.ledger_id')->sum('process.cl_balance');
                $total_asset_amount += $ledger_amount;
                $asset_amount_arr[] = $ledger_amount;

            }

            /* Liabilities and Owners Equity */
            $liability_id = Group::select('id')->where('name', 'Liabilities and Owners Equity')->first()->id;
            $liabilities = Group::where('parent_id', $liability_id)->get();
            $total_liability_amount = 0;
            $liability_amount_arr = array();


            foreach ($liabilities as $liability) {

                $ledger_amount = Ledger::select('*')->where('group_id', $liability->id)->join('process', 'ledgers.id', '=', 'process.ledger_id')->sum('process.cl_balance');
                $total_liability_amount += $ledger_amount;
                //echo $total_asset_amount.', ';
                $liability_amount_arr[] = $ledger_amount;

            }

            /* Incomes */
            $income_id = Group::select('id')->where('name', 'Incomes')->first()->id;
            $incomes = Group::where('parent_id', $income_id)->get();
            $total_income_amount = 0;
            $income_amount_arr = array();


            foreach ($incomes as $income) {

                $ledger_amount = Ledger::select('*')->where('group_id', $income->id)->join('process', 'ledgers.id', '=', 'process.ledger_id')->sum('process.cl_balance');
                $total_income_amount += $ledger_amount;
                //echo $total_asset_amount.', ';
                $income_amount_arr[] = $ledger_amount;

            }


            /* Expenses */
            $expense_id = Group::select('id')->where('name', 'Expenses')->first()->id;
            $expenses = Group::where('parent_id', $expense_id)->get();
            $total_expense_amount = 0;
            $expense_amount_arr = array();


            foreach ($expenses as $expense) {

                $ledger_amount = Ledger::select('*')->where('group_id', $expense->id)->join('process', 'ledgers.id', '=', 'process.ledger_id')->sum('process.cl_balance');
                $total_expense_amount += $ledger_amount;
                //echo $total_asset_amount.', ';
                $expense_amount_arr[] = $ledger_amount;

            }


            /* Withdraw */
            $withdraw_id = Group::select('id')->where('name', 'Withdraw')->first()->id;
            $withdraws = Group::where('parent_id', $withdraw_id)->get();
            $total_withdraw_amount = 0;
            $withdraw_amount_arr = array();


            foreach ($withdraws as $withdraw) {

                $ledger_amount = Ledger::select('*')->where('group_id', $withdraw->id)->join('process', 'ledgers.id', '=', 'process.ledger_id')->sum('process.cl_balance');
                $total_withdraw_amount += $ledger_amount;
                //echo $total_asset_amount.', ';
                $withdraw_amount_arr[] = $ledger_amount;

            }


            return view('reports.balance_sheet', compact('assets', 'total_asset_amount', 'asset_amount_arr', 'liabilities', 'total_liability_amount', 'liability_amount_arr', 'incomes', 'total_income_amount', 'income_amount_arr', 'expenses', 'total_expense_amount', 'expense_amount_arr', 'withdraws', 'total_withdraw_amount', 'withdraw_amount_arr'));

            }
    }


    /*
     * Profit Loss Report
     * */
    public function showProfitLoss(){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $expense_id = Group::select('id')->where('name', 'Expenses')->first()->id;
            $income_id = Group::select('id')->where('name', 'Incomes')->first()->id;

            // direct Expenses
            $dir_expense_id = Group::select('id')->where('name', 'Direct Expenses')->first()->id;
            $dir_expenses = Ledger::where('group_id', $dir_expense_id)->get();
            $dir_expenses_amount = 0;
            foreach ($dir_expenses as $d_ex) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
                $dir_expenses_amount += $amount;
            }


            // Purchases
            $purchase_id = Group::select('id')->where('name', 'Purchases')->first()->id;
            $purchases = Ledger::where('group_id', $purchase_id)->get();
            $purchases_amount = 0;
            foreach ($purchases as $purchase) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $purchase->id)->sum('amount');
                $purchases_amount += $amount;
            }


            //Indirect Expenses
            $indir_expense_id = Group::select('id')->where('name', 'Indirect Expenses')->first()->id;
            $indir_expenses = Ledger::where('group_id', $indir_expense_id)->get();
            $indir_expenses_amount = 0;
            foreach ($indir_expenses as $d_ex) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
                $indir_expenses_amount += $amount;
            }


            // direct income
            $dir_income_id = Group::select('id')->where('name', 'Direct Incomes')->first()->id;
            $dir_incomes = Ledger::where('group_id', $dir_income_id)->get();
            $dir_income_amount = 0;
            foreach ($dir_incomes as $d_ex) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $d_ex->id)->sum('amount');
                $dir_income_amount += $amount;
            }

            // Sales
            $sales_id = Group::select('id')->where('name', 'Sales')->first()->id;
            $sales = Ledger::where('group_id', $sales_id)->get();
            $sales_amount = 0;
            foreach ($sales as $purchase) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $purchase->id)->sum('amount');
                $sales_amount += $amount;
            }


            // Indirect Incomes
            $indirect_incomes_id = Group::select('id')->where('name', 'Indirect Incomes')->first()->id;
            $indirect_incomes = Ledger::where('group_id', $indirect_incomes_id)->get();
            $indirect_incomes_amount = 0;
            foreach ($indirect_incomes as $purchase) {
                $amount = \App\SingleEntry::select('amount')->where('ledger_id', $purchase->id)->sum('amount');
                $indirect_incomes_amount += $amount;
            }


            $total_gross_expense = $dir_expenses_amount + $purchases_amount;
            $total_gross_income = $dir_income_amount + $sales_amount;
            return view('reports.profit_loss',
                compact('expense_id', 'income_id', 'dir_expenses', 'purchases', 'dir_expenses_amount', 'purchases_amount', 'total_gross_expense', 'indir_expenses', 'indir_expenses_amount', 'dir_incomes', 'dir_income_amount', 'sales', 'sales_amount', 'total_gross_income', 'indirect_incomes', 'indirect_incomes_amount'));
        }
    }

    /*
     * Trial Balance Report
     * */
    public function showTrialBalance(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $groups = Group::select('*')->get();
            $dr_total_amount = SingleEntry::select('amount')->where('dc', 'D')->sum('amount');
            $cr_total_amount = SingleEntry::select('amount')->where('dc', 'C')->sum('amount');

            return view('reports.trial_balance', compact('groups', 'dr_total_amount', 'cr_total_amount'));
        }
    }

    /*
     * Ledger Statement Report form
     * */
    public function showLedgerStatement(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $ledgers = Ledger::select('*')->get();
            $title = 'Search Statement';

            return view('reports.ledger_statement', compact('ledgers', 'title'));
        }
    }

    /*
     * Ledger Statement Report
     * */
    public function getLedgerStatement($ledger_id, $start_date, $end_date){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $ledger = Ledger::select('*')->where('id', $ledger_id)->first();
            $dr_cr = ($ledger->dr_pos == 1) ? "Dr" : "Cr";

            $balance = $ledger->op_balance;

            if ($start_date != 0 && $end_date != 0) {

                $date_arr = explode('-', $start_date);
                $day = $date_arr[2] - 1;
                $date = $date_arr[0] . '-' . $date_arr[1] . '-' . $day;

                $single_entries = SingleEntry::select('*')->where('ledger_id', $ledger_id)
                    ->join('entries', 'entries.id', '=', 'single_entry.entry_id')
                    ->whereBetween('date', [$start_date, $end_date])
                    ->get();

                //for calculating the opening balance before start date
                $dr_single_entries = SingleEntry::select('*')->where('ledger_id', $ledger_id)
                    ->join('entries', 'entries.id', '=', 'single_entry.entry_id')
                    ->whereBetween('date', ['1900-01-01', $start_date])
                    ->get();

                foreach ($dr_single_entries as $dr_amount) {

                    if ($dr_cr == 'Dr') {
                        //echo 'ok';
                        if ($dr_amount->dc == 'D') {

                            $balance += $dr_amount->amount;
                        } else if ($dr_cr == 'Cr') {

                            $balance -= $dr_amount->amount;
                        }
                    } else if ($ledger->dr_pos == 0) {
                        //echo 'no';
                        if ($dr_amount->dc == 'C') {

                            $balance += $dr_amount->amount;
                        } else if ($dr_amount->dc == 'D') {

                            $balance -= $dr_amount->amount;
                        }
                    }
                }


            } else {
                $single_entries = SingleEntry::select('*')->where('ledger_id', $ledger_id)->get();
            }


            $output = '
        
            <tr>
                <td colspan="4"><b>Current Opening Balance </b></td>         
                <td></td>
                <td></td>
                
                <td><b>' . $dr_cr . ' ' . $balance . '</b></td>
                <td></td>
            </tr>  
        
        ';


            foreach ($single_entries as $single_entry) {


                $entry = Entry::select('*')->where('id', $single_entry->entry_id)->first();

                $type = EntryType::select('*')->where('id', $entry->entrytype_id)->first()->name;

                $dr_id = SingleEntry::select('ledger_id')->where('entry_id', $single_entry->entry_id)->where('dc', 'D')->first()->ledger_id;
                $cr_id = SingleEntry::select('ledger_id')->where('entry_id', $single_entry->entry_id)->where('dc', 'C')->first()->ledger_id;

                $dr_info = Ledger::select('name', 'code')->where('id', $dr_id)->first();
                $cr_info = Ledger::select('name', 'code')->where('id', $cr_id)->first();


                $dr_name = preg_replace('/[0-9]*$/', '', str_replace('_', ' ', $dr_info->name));
                $cr_name = preg_replace('/[0-9]*$/', '', str_replace('_', ' ', $cr_info->name));

                $output .= '
            
            <tr>
                <td>' . $entry->date . '</td>
                <td>' . $entry->number . '</td>
                <td> Dr [' . $dr_info->code . ']' . $dr_name . ' / Cr [' . $cr_info->code . ']' . $cr_name . '</td>
                <td>' . $type . '</td>
                ';

                if ($single_entry->dc == 'D') {
                    if ($ledger->dr_pos == 1) {
                        $balance += $single_entry->amount;

                    } else if ($ledger->dr_pos == 0) {

                        $balance -= $single_entry->amount;
                    }

                    $output .= '
                <td>Dr ' . $single_entry->amount . '</td>
                <td> - </td>';

                } else if ($single_entry->dc == 'C') {

                    if ($ledger->dr_pos == 1) {
                        $balance -= $single_entry->amount;

                    } else if ($ledger->dr_pos == 0) {

                        $balance += $single_entry->amount;
                    }

                    $output .= '
                <td> - </td>
                <td>Cr ' . $single_entry->amount . '</td>';
                }

                if ($balance < 0) {
                    $dr_cr = ($dr_cr == 'Dr') ? "Cr" : "Dr";
                    $balance = str_replace('-', '', $balance);
                }

                $output .= '
                <td> ' . $dr_cr . ' ' . $balance . '</td>
                <td><a href="' . url('view-details') . '/' . $type . '/' . $entry->id . '" class="text-info">View</a> / <a href="' . url('edit-entry') . '/' . $type . '/' . $entry->id . '" class="text-purple">Edit</a> / <a href="' . url('delete-entry') . '/' . $type . '/' . $entry->id . '" class="text-danger">Delete</a>  </td>
            </tr> 
            
            ';

            }

            $output .= '
        
            <tr>
                <td colspan="4"><b>Current Closing Balance </b></td>         
                <td></td>
                <td></td>
                <td><b>' . $dr_cr . ' ' . $balance . '</b></td>
                <td></td>
            </tr>  
        
        ';

            echo $output;
        }
    }


    /*
     * getting Ledger Statement Details
     * */
    public function getLedgerStatementDetails($type, $entry_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $single_entries = SingleEntry::select('*')->where('entry_id', $entry_id)->get();
            $my_entry = Entry::where('id', $entry_id)->first();

            return view('reports.ledger_statement_details', compact('type', 'single_entries', 'my_entry'));
        }
    }


    /*
     *
     * showing editing entry form
     * */
    public function editEntryForm($type, $entry_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $dr_entry = SingleEntry::where('entry_id', $entry_id)->where('dc', 'D')->first();
            $cr_entry = SingleEntry::where('entry_id', $entry_id)->where('dc', 'C')->first();

            $receivables_id = \App\Group::select('id')->where('name', "Account Recievable")->first()->id;
            $rec_led = \App\Ledger::select('id', 'name')->where('group_id', $receivables_id)->get();
            $cash_ledgers = Ledger::select('id', 'name')->where('type', 1)->get();
            $other_ledgers = Ledger::select('id', 'name')->where('type', 0)->get();

            $entrytypes = EntryType::select('*')->get();
            $entry_info = Entry::select('*')->where('id', $entry_id)->first();
            $single_entry_info = SingleEntry::select('*')->where('entry_id', $entry_id)->first();

            if ($type == 'Receipt') {
                return view('edit_entry.edit_receipt', compact('dr_entry', 'cr_entry', 'entry_id', 'groups', 'single_entry_info', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led', 'entry_info'));

            } elseif ($type == 'Payment') {
                return view('edit_entry.edit_payment', compact('dr_entry', 'cr_entry', 'entry_id', 'groups', 'single_entry_info', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led', 'entry_info'));

            } elseif ($type == 'Contra') {

                return view('edit_entry.edit_contra', compact('dr_entry', 'cr_entry', 'entry_id', 'groups', 'single_entry_info', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led', 'entry_info'));
            } elseif ($type == 'Journal') {

                $dr_entries = SingleEntry::where('entry_id', $entry_id)->where('dc', 'D')->get();
                $cr_entries = SingleEntry::where('entry_id', $entry_id)->where('dc', 'C')->get();

                return view('edit_entry.edit_journal', compact('dr_entry', 'cr_entry', 'dr_entries', 'cr_entries', 'entry_id', 'groups', 'single_entry_info', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led', 'entry_info'));
            }


        }
//        return view('entry.entries', compact('groups','single_entry_info', 'cash_ledgers', 'entrytypes', 'other_ledgers', 'rec_led','entry_info'));
    }



    public function editPaymentEntry(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $date_arr = explode('/', $request->trans_date);
            $request->trans_date = $date_arr[2] . '-' . $date_arr[0] . '-' . $date_arr[1];

            $is_success = Entry::where('id', $request->entry_id)->update(['entrytype_id' => $request->trans_type, 'number' => $request->number, 'date' => $request->trans_date, 'dr_total' => $request->amount, 'cr_total' => $request->amount, 'narration' => $request->narration]);

            if ($is_success) {

                $dr_success = SingleEntry::where('id', $request->dr_entry_id)->update(['ledger_id' => $request->pay_to, 'amount' => $request->amount, 'dc' => 'D', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);
                $cr_success = SingleEntry::where('id', $request->cr_entry_id)->update(['ledger_id' => $request->pay_from, 'amount' => $request->amount, 'dc' => 'C', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);

                if ($dr_success && $cr_success) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Entry Edited Successfully.');
                    return redirect('edit-entry/Payment/' . $request->entry_id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                    return redirect('edit-entry/Payment/' . $request->entry_id);
                }

            } else {

                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                return redirect('edit-entry/Payment/' . $request->entry_id);
            }
        }
    }




    /*
     * editing Receipt Entry
     * */
    public function editReceiptEntry(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $date_arr = explode('/', $request->trans_date);
            $request->trans_date = $date_arr[2] . '-' . $date_arr[0] . '-' . $date_arr[1];

            $is_success = Entry::where('id', $request->entry_id)->update(['entrytype_id' => $request->trans_type, 'number' => $request->number, 'date' => $request->trans_date, 'dr_total' => $request->amount, 'cr_total' => $request->amount, 'narration' => $request->narration]);

            if ($is_success) {

                // updating each single entry data
                $dr_success = SingleEntry::where('id', $request->dr_entry_id)->update(['ledger_id' => $request->receipt_to, 'amount' => $request->amount, 'dc' => 'D', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);
                $cr_success = SingleEntry::where('id', $request->cr_entry_id)->update(['ledger_id' => $request->receipt_from, 'amount' => $request->amount, 'dc' => 'C', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);

                if ($dr_success && $cr_success) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Entry Edited Successfully.');
                    return redirect('edit-entry/Receipt/' . $request->entry_id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                    return redirect('edit-entry/Receipt/' . $request->entry_id);
                }

            } else {

                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                return redirect('edit-entry/Receipt/' . $request->entry_id);
            }
        }
    }




    /*
     * editing Contra Entry
     * */
    public function editContraEntry(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $date_arr = explode('/', $request->trans_date);
            $request->trans_date = $date_arr[2] . '-' . $date_arr[0] . '-' . $date_arr[1];

            $is_success = Entry::where('id', $request->entry_id)->update(['entrytype_id' => $request->trans_type, 'number' => $request->number, 'date' => $request->trans_date, 'dr_total' => $request->amount, 'cr_total' => $request->amount, 'narration' => $request->narration]);

            if ($is_success) {
                // updating each single entry data
                $dr_success = SingleEntry::where('id', $request->dr_entry_id)->update(['ledger_id' => $request->contra_to, 'amount' => $request->amount, 'dc' => 'D', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);
                $cr_success = SingleEntry::where('id', $request->cr_entry_id)->update(['ledger_id' => $request->contra_from, 'amount' => $request->amount, 'dc' => 'C', 'transaction_for' => $request->trans_for, 'transaction_mode' => $request->trans_mode, 'cheque_no' => $request->cheque_no, 'cheque_date' => $request->cheque_date, 'Remarks' => $request->remarks]);

                if ($dr_success && $cr_success) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Entry Edited Successfully.');
                    return redirect('edit-entry/Contra/' . $request->entry_id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                    return redirect('edit-entry/Contra/' . $request->entry_id);
                }

            } else {

                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                return redirect('edit-entry/Contra/' . $request->entry_id);
            }
        }
    }



    /*
     * editing journal entry
     * */
    public function editJournalEntry(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $date_arr = explode('/', $request->trans_date);
            $request->trans_date = $date_arr[2] . '-' . $date_arr[0] . '-' . $date_arr[1];

            $dr_accounts = $request->dr_acc;
            $dr_amounts = $request->dr_amount;

            $cr_accounts = $request->cr_acc;
            $cr_amounts = $request->cr_amount;

            $total_dr = $request->dr_total;
            $total_cr = $request->cr_total;

            // updating entry table info
            $entry_saved = Entry::where('id', $request->entry_id)->update(['date' => $request->trans_date, 'dr_total' => $total_dr, 'cr_total' => $total_cr, 'narration' => $request->narration1, 'number' => $request->number]);
            if ($entry_saved) {

                // deleting single entry table rows
                SingleEntry::where('entry_id', $request->entry_id)->delete();

                // inserting rows into entry table
                for ($i = 0; $i < sizeof($dr_accounts); $i++) {

                    $single_entry = new SingleEntry();
                    $single_entry->entry_id = $request->entry_id;
                    $single_entry->ledger_id = $dr_accounts[$i];
                    $single_entry->amount = $dr_amounts[$i];
                    $single_entry->dc = 'D';
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry->save();

                }

                for ($i = 0; $i < sizeof($cr_accounts); $i++) {

                    $single_entry = new SingleEntry();
                    $single_entry->entry_id = $request->entry_id;
                    $single_entry->ledger_id = $cr_accounts[$i];
                    $single_entry->amount = $cr_amounts[$i];
                    $single_entry->dc = 'C';
                    //$single_entry->reconciliation_date = "";
                    $saved = $single_entry->save();

                }

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Entry Edited Successfully.');
                return redirect('edit-entry/Journal/' . $request->entry_id);
            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Edit Entry, Try Later');
                return redirect('edit-entry/Journal/' . $request->entry_id);
            }
        }
    }



    /*
     *
     * deleting entry
     * */
    public function deleteEntry($type, $entry_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $is_success = Entry::where('id', $entry_id)->delete();
            if ($is_success) {

                $is_success = SingleEntry::where('entry_id', $entry_id)->delete();

                if ($is_success) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Entry Successfully Deleted.');
                    return redirect('ledger-statement');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Delete Entry, Try Later');
                    return redirect('ledger-statement');
                }

            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Delete Entry, Try Later');
                return redirect('ledger-statement');
            }
        }
    }

    /*
     * Ledger Entries Report
     * */
    public function showLedgerEntries(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.ledger_entries');
        }
    }


    /*create bank form*/
    public function showCreateBankForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $banks = Bank::select('*')->get();
            return view('create.bank', compact('banks'));
        }
    }

    /*
     * creating New Bank
     * */
    public function createNewBank(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $next_id = Bank::max('id') + 1;
            $account_name = str_replace(' ', '_', $request->account_name);
            $account_id = $account_name . '_' . $next_id;

            $bank = new Bank();
            $bank->bank_name = $request->bank_name;
            $bank->branch_name = $request->branch_name;
            $bank->account_name = $request->account_name;
            $bank->account_no = $request->account_no;
            $bank->bank_id = $account_id;

            $is_success = $bank->save();

            if ($is_success) {

                $ledger = new Ledger();
                $ledger->group_id = 17;
                $ledger->name = $account_id;
                $ledger->code = $request->bank_code;
                $ledger->op_balance = $request->opening_balance;
                $ledger->op_balance_dc = $request->dr_cr;
                $ledger->type = 1;
                $ledger->bank_or_cash = 'B';
                $ledger->reconciliation = $request->reconciliation;
                $ledger->notes = $request->notes;
                $ledger->dr_pos = 1;
                $is_saved = $ledger->save();

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Bank Details Saved Successfully.');
                    return redirect('create-bank');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Bank Details, Try Later');
                    return redirect('create-bank');
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Bank Details, Try Later');
                return redirect('create-bank    ');
            }
        }
    }


    /*
     * showing bank info for edit
     * */
    public function showEditBankForm($id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $bank_info = Bank::where('id', $id)->first();
            $ledger_info = Ledger::where('name', $bank_info->bank_id)->first();

            $banks = Bank::select('*')->get();

            return view('create.bank', compact('banks', 'bank_info', 'ledger_info'));
        }
    }


    /*
     * editing bank info
     * */
    public function editBankInfo(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $bank_id = $request->bank_id;
            $ledger_id = $request->ledger_id;

            $next_id = $bank_id;
            $account_name = str_replace(' ', '_', $request->account_name);
            $account_id = $account_name . '_' . $next_id;


            $is_success = Bank::where('id', $bank_id)->update(['bank_name' => $request->bank_name, 'branch_name' => $request->branch_name, 'account_name' => $request->account_name, 'account_no' => $request->account_no, 'bank_id' => $account_id]);


            if ($is_success) {

                $is_saved = Ledger::where('id', $ledger_id)->update(['name' => $account_id, 'code' => $request->bank_code, 'op_balance' => $request->opening_balance,
                    'op_balance_dc' => $request->dr_cr, 'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Bank Details Saved Successfully.');
                    return redirect('edit-bank/' . $bank_id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Bank Details, Try Later');
                    return redirect('edit-bank/' . $bank_id);
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Bank Details, Try Later');
                return redirect('edit-bank/' . $bank_id);
            }
        }
    }


    /*
     * deleting bank info
     *
     * */
    public function deleteBank($bank_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = Ledger::where('name', $bank_id)->first();

            $entries = SingleEntry::select('id')->where('ledger_id', $led_id->id)->get();
            $entries_arr = $entries->toArray();

            if (sizeof($entries_arr) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This Bank has one or more entries. It cannot be deleted.');
                return redirect('create-bank');
            } else {
                Ledger::where('name', $bank_id)->delete();
                Bank::where('bank_id', $bank_id)->delete();

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Bank Deleted Successfully.');
                return redirect('create-bank');
            }
        }
    }

    /*create bank form*/
    public function showCreateClientForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $clients = Client::select('*')->get();
            return view('create.client', compact('clients'));
        }
    }



    /*
     * showing Editing Client Form
     * */
    public function showEditClientForm($id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $client_info = Client::where('id', $id)->first();
            $ledger_info = Ledger::where('name', $client_info->client_id)->first();

            $clients = Client::select('*')->get();
            return view('create.client', compact('clients', 'client_info', 'ledger_info'));
        }
    }


    /*
     * creating New Client
     * */
    public function createNewClient(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $next_id = Client::max('id') + 1;
            $client_name = str_replace(' ', '_', $request->client_name);
            $client_id = $client_name . '_' . $next_id;

            $client = new Client();
            $client->client_name = $request->client_name;
            $client->client_id = $client_id;
            $client->email = $request->email;
            $client->designation = $request->designation;
            $client->contact_no = $request->contact_no;
            $client->address = $request->address;
            $is_success = $client->save();

            if ($is_success) {

                $ledger = new Ledger();
                $ledger->group_id = 31;
                $ledger->name = $client_id;
                $ledger->code = $request->code;
                $ledger->op_balance = $request->opening_balance;
                $ledger->op_balance_dc = $request->dr_cr;
                $ledger->type = 0;
                $ledger->reconciliation = $request->reconciliation;
                $ledger->notes = $request->notes;
                $ledger->dr_pos = 1;
                $is_saved = $ledger->save();

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Doctor Details Saved Successfully.');
                    return redirect('create-doctor');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Doctor Details, Try Later');
                    return redirect('create-doctor');
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Doctor Details, Try Later');
                return redirect('create-doctor');
            }
        }
    }


    /*
     * editing client info
     * */
    public function editClientInfo(Request $request){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $id = $request->id;
            $ledger_id = $request->ledger_id;

            $next_id = $id;
            $client_name = str_replace(' ', '_', $request->client_name);
            $client_id = $client_name . '_' . $next_id;


            $is_success = Client::where('id', $id)->update(['client_name' => $request->client_name, 'client_id' => $client_id, 'designation' => $request->designation,
                'contact_no' => $request->contact_no, 'address' => $request->address]);


            if ($is_success) {

                // if saved in client table, save information in ledger table
                $is_saved = Ledger::where('id', $ledger_id)->update(['name' => $client_id, 'code' => $request->code, 'op_balance' => $request->opening_balance,
                    'op_balance_dc' => $request->dr_cr, 'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Doctor Details Saved Successfully.');
                    return redirect('edit-doctor/' . $id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Update Doctor Details, Try Later');
                    return redirect('edit-doctor/' . $id);
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Update Doctor Details, Try Later');
                return redirect('edit-doctor/' . $id);
            }
        }
    }


    /*
    * Deleting Client info
    *
    * */
    public function deleteClient($client_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = Ledger::where('name', $client_id)->first();

            $entries = SingleEntry::select('id')->where('ledger_id', $led_id->id)->get();
            $entries_arr = $entries->toArray();

            if (sizeof($entries_arr) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This Doctor has one or more entries. It cannot be deleted.');
                return redirect('create-doctor');
            } else {
//                Ledger::where('name', $client_id)->delete();
                Client::where('client_id', $client_id)->delete();

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Doctor Deleted Successfully.');
                return redirect('create-doctor');
            }
        }
    }


    /*
     * showing Create Expense Form
     * */
    public function showCreateExpenseForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $sub_groups = Group::where('parent_id', 4)->get();
            $expenses = Expense::select('*')->get();
            return view('create.expense', compact('sub_groups', 'expenses'));
        }
    }



    /*
     * show Edit Expense Form
     * */
    public function showEditExpenseForm($id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $expense_info = Expense::where('id', $id)->first();
            $ledger_info = Ledger::where('name', $expense_info->expense_id)->first();

            $sub_groups = Group::where('parent_id', 4)->get();
            $expenses = Expense::select('*')->get();

            return view('create.expense', compact('sub_groups', 'expenses', 'expense_info', 'ledger_info'));
        }
    }

    /*
     * creating New Expense
     * */
    public function createNewExpense(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $next_id = Expense::max('id') + 1;
            $client_name = str_replace(' ', '_', $request->client_name);
            $client_id = $client_name . '_' . $next_id;

            $client = new Expense();
            $client->name = $request->client_name;
            $client->expense_id = $client_id;
            $client->group_id = $request->group_id;
            $client->contact_no = $request->contact_no;
            $client->address = $request->address;
            $is_success = $client->save();

            if ($is_success) {

                $ledger = new Ledger();
                $ledger->group_id = $request->group_id;
                $ledger->name = $client_id;
                $ledger->code = $request->code;
                $ledger->op_balance = $request->opening_balance;
                $ledger->op_balance_dc = $request->dr_cr;
                $ledger->type = 0;
                $ledger->reconciliation = $request->reconciliation;
                $ledger->notes = $request->notes;
                $ledger->dr_pos = 1;
                $is_saved = $ledger->save();

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Expense Ledger Details Saved Successfully.');
                    return redirect('create-expense');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Expense Ledger Details, Try Later');
                    return redirect('create-expense');
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Expense Ledger Details, Try Later');
                return redirect('create-expense');
            }
        }

    }




    /*
     * editing Expense info
     * */
    public function editExpenseInfo(Request $request){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $id = $request->id;
            $ledger_id = $request->ledger_id;

            $next_id = $id;
            $name = str_replace(' ', '_', $request->client_name);
            $new_id = $name . '_' . $next_id;


            $is_success = Expense::where('id', $id)->update(['name' => $request->client_name, 'expense_id' => $new_id, 'group_id' => $request->group_id,
                'contact_no' => $request->contact_no, 'address' => $request->address]);


            if ($is_success) {

                $is_saved = Ledger::where('id', $ledger_id)->update(['name' => $new_id, 'code' => $request->code, 'op_balance' => $request->opening_balance,
                    'op_balance_dc' => $request->dr_cr, 'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Expense Details Saved Successfully.');
                    return redirect('edit-expense/' . $id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Update Expense Details, Try Later');
                    return redirect('edit-expense/' . $id);
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Update Expense Details, Try Later');
                return redirect('edit-expense/' . $id);
            }
        }
    }



    /*
    * Deleting Expense info
    *
    * */
    public function deleteExpense($expense_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = Ledger::where('name', $expense_id)->first();

            $entries = SingleEntry::select('id')->where('ledger_id', $led_id->id)->get();
            $entries_arr = $entries->toArray();

            if (sizeof($entries_arr) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This Expense Ledger has one or more entries. It cannot be deleted.');
                return redirect('create-expense');
            } else {
                Ledger::where('name', $expense_id)->delete();
                Expense::where('expense_id', $expense_id)->delete();

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Expense Ledger Deleted Successfully.');
                return redirect('create-expense');
            }
        }
    }


    /*
     * showing Create Income Form
     * */
    public function showCreateIncomeForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $sub_groups = Group::where('parent_id', 3)->get();
            $incomes = Income::select('*')->get();
            return view('create.income', compact('sub_groups', 'incomes'));
        }
    }



    /*
     * show Edit Income Form
     * */
    public function showEditIncomeForm($id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $income_info = Income::where('id', $id)->first();
            $ledger_info = Ledger::where('name', $income_info->income_id)->first();

            $sub_groups = Group::where('parent_id', 3)->get();
            $incomes = Income::select('*')->get();
            return view('create.income', compact('sub_groups', 'incomes', 'income_info', 'ledger_info'));
        }
    }


    /*
     * creating New Income
     * */
    public function createNewIncome(Request $request){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $next_id = Income::max('id') + 1;
            $client_name = str_replace(' ', '_', $request->client_name);
            $client_id = $client_name . '_' . $next_id;

            $client = new Income();
            $client->name = $request->client_name;
            $client->income_id = $client_id;
            $client->group_id = $request->group_id;
            $client->contact_no = $request->contact_no;
            $client->address = $request->address;
            $is_success = $client->save();

            if ($is_success) {

                $ledger = new Ledger();
                $ledger->group_id = $request->group_id;
                $ledger->name = $client_id;
                $ledger->code = $request->code;
                $ledger->op_balance = $request->opening_balance;
                $ledger->op_balance_dc = $request->dr_cr;
                $ledger->type = 0;
                $ledger->reconciliation = $request->reconciliation;
                $ledger->notes = $request->notes;
                $ledger->dr_pos = 0;
                $is_saved = $ledger->save();

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Income Ledger Details Saved Successfully.');
                    return redirect('create-income');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Income Ledger Details, Try Later');
                    return redirect('create-income');
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Income Ledger Details, Try Later');
                return redirect('create-income');
            }
        }
    }



    /*
     * editing Expense info
     * */
    public function editIncomeInfo(Request $request){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $id = $request->id;
            $ledger_id = $request->ledger_id;

            $next_id = $id;
            $name = str_replace(' ', '_', $request->client_name);
            $new_id = $name . '_' . $next_id;


            $is_success = Income::where('id', $id)->update(['name' => $request->client_name, 'income_id' => $new_id, 'group_id' => $request->group_id,
                'contact_no' => $request->contact_no, 'address' => $request->address]);


            if ($is_success) {

                $is_saved = Ledger::where('id', $ledger_id)->update(['name' => $new_id, 'code' => $request->code, 'op_balance' => $request->opening_balance,
                    'op_balance_dc' => $request->dr_cr, 'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Income Details Saved Successfully.');
                    return redirect('edit-income/' . $id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Update Income Details, Try Later');
                    return redirect('edit-income/' . $id);
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Update Income Details, Try Later');
                return redirect('edit-income/' . $id);
            }
        }
    }



/*
* Deleting Income info
*
* */
    public function deleteIncome($income_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = Ledger::where('name', $income_id)->first();

            $entries = SingleEntry::select('id')->where('ledger_id', $led_id->id)->get();
            $entries_arr = $entries->toArray();

            if (sizeof($entries_arr) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This Income Ledger has one or more entries. It cannot be deleted.');
                return redirect('create-income');
            } else {
                Ledger::where('name', $income_id)->delete();
                Income::where('income_id', $income_id)->delete();

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Income Ledger Deleted Successfully.');
                return redirect('create-income');
            }
        }
    }

    /*
     * showing Create Liability Form
     * */
    public function showCreateLiabilityForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $sub_groups = Group::where('parent_id', 2)->get();
            $liabilities = Liability::select('*')->get();
            return view('create.liability', compact('sub_groups', 'liabilities'));
        }
    }



    /*
     * showing Edit Liability Form
     * */
    public function showEditLiabilityForm($id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $liability_info = Liability::where('id', $id)->first();
            $ledger_info = Ledger::where('name', $liability_info->ledger_id)->first();

            $sub_groups = Group::where('parent_id', 2)->get();
            $liabilities = Liability::select('*')->get();
            return view('create.liability', compact('sub_groups', 'liabilities', 'liability_info', 'ledger_info'));
        }
    }



    /*
     * creating New Liability
     * */
    public function createNewLiability(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $next_id = Liability::max('id') + 1;
            $client_name = str_replace(' ', '_', $request->client_name);
            $client_id = $client_name . '_' . $next_id;

            $client = new Liability();
            $client->name = $request->client_name;
            $client->ledger_id = $client_id;
            $client->group_id = $request->group_id;
            $client->contact_no = $request->contact_no;
            $client->address = $request->address;
            $is_success = $client->save();

            if ($is_success) {

                $ledger = new Ledger();
                $ledger->group_id = $request->group_id;
                $ledger->name = $client_id;
                $ledger->code = $request->code;
                $ledger->op_balance = $request->opening_balance;
                $ledger->op_balance_dc = $request->dr_cr;
                $ledger->type = 0;
                $ledger->reconciliation = $request->reconciliation;
                $ledger->notes = $request->notes;
                $ledger->dr_pos = 0;
                $is_saved = $ledger->save();

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Ledger Details Saved Successfully.');
                    return redirect('create-liability');
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Save Ledger Details, Try Later');
                    return redirect('create-liability');
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Save Ledger Details, Try Later');
                return redirect('create-liability');
            }
        }
    }


    /*
     * editing Liability info
     * */
    public function editLiabilityInfo(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $id = $request->id;
            $ledger_id = $request->ledger_id;

            $next_id = $id;
            $name = str_replace(' ', '_', $request->client_name);
            $new_id = $name . '_' . $next_id;


            $is_success = Liability::where('id', $id)->update(['name' => $request->client_name, 'ledger_id' => $new_id, 'group_id' => $request->group_id,
                'contact_no' => $request->contact_no, 'address' => $request->address]);


            if ($is_success) {

                $is_saved = Ledger::where('id', $ledger_id)->update(['name' => $new_id, 'code' => $request->code, 'op_balance' => $request->opening_balance,
                    'op_balance_dc' => $request->dr_cr, 'reconciliation' => $request->reconciliation, 'notes' => $request->notes]);

                if ($is_saved) {
                    session()->flash('message.level', 'success');
                    session()->flash('message.content', 'Liability Details Saved Successfully.');
                    return redirect('edit-liability/' . $id);
                } else {
                    session()->flash('message.level', 'danger');
                    session()->flash('message.content', 'Failed To Update Liability Details, Try Later');
                    return redirect('edit-liability/' . $id);
                }


            } else {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'Failed To Update Liability Details, Try Later');
                return redirect('edit-liability/' . $id);
            }
        }
    }

    /*
* Deleting Liability info
*
* */
    public function deleteLiability($liability_id){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = Ledger::where('name', $liability_id)->first();

            $entries = SingleEntry::select('id')->where('ledger_id', $led_id->id)->get();
            $entries_arr = $entries->toArray();

            if (sizeof($entries_arr) > 0) {
                session()->flash('message.level', 'danger');
                session()->flash('message.content', 'This Liability Ledger has one or more entries. It cannot be deleted.');
                return redirect('create-liability');
            } else {
                Ledger::where('name', $liability_id)->delete();
                Liability::where('ledger_id', $liability_id)->delete();

                session()->flash('message.level', 'success');
                session()->flash('message.content', 'Liability Ledger Deleted Successfully.');
                return redirect('create-liability');
            }
        }
    }


    /*
     * daily-receive-payments reports
     * */
    public function showDailyPaymentReceive(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {

            $receipt_entries = Entry::where('date', date('Y-m-d'))->where('entrytype_id', '1')->get();
            $payment_entries = Entry::where('date', date('Y-m-d'))->where('entrytype_id', '2')->get();
            $contra_entries = Entry::where('date', date('Y-m-d'))->where('entrytype_id', '3')->get();
            $journal_entries = Entry::where('date', date('Y-m-d'))->where('entrytype_id', '4')->get();

            $payment_info = array();
            $receive_info = array();

            $payment_groups = array();
            $receive_groups = array();

            /*foreach ($entries as $entry){

                $pay_entries = SingleEntry::where('entry_id', $entry->id)->where('dc', 'D')->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')->orderBy('ledgers.group_id', 'ASC')->get();

                foreach ($pay_entries as $p){
                    $payment_info[] = $p;
                    $payment_groups[] = $p->group_id;
                }

                $rec_entries = SingleEntry::where('entry_id', $entry->id)->where('dc', 'C')->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')->orderBy('ledgers.group_id', 'ASC')->get();
                foreach ($rec_entries as $r){
                    $receive_info[] = $r;
                    $receive_groups[] = $r->group_id;
                }

            }

            $payment_groups = array_unique($payment_groups);
            $receive_groups = array_unique($receive_groups);*/

//        print_r($payment_groups);
            return view('reports.daily_receive_payments', compact('receipt_entries', 'payment_entries', 'contra_entries', 'journal_entries'));
        }
    }


    public function showBalancePaymentReceiveForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.opb_payment_recceive');
        }
    }


    /*
     * showing Balance Payment Receive report
     * */
    public function showBalancePaymentReceive(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];


            $constant_date = '1990-01-01';
            $before_from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));


            $ledgers = DB::table('ledgers')->select('id', 'name', 'op_balance')->where('bank_or_cash', 'B')->orWhere('bank_or_cash', 'C')->get();

            $op_bl_arr = array();
            $payment_arr = array();
            $received_arr = array();
            $cl_bl_arr = array();

            foreach ($ledgers as $ledger) {

                $led_id = $ledger->id;

                // getting opening balance before from date
                $opening_bl = DB::table('single_entry')->select('amount')
                    ->where('ledger_id', $led_id)
                    ->whereBetween('transaction_date', [$constant_date, $before_from_date])
                    ->sum('amount');
                $opening_bl = $opening_bl + str_replace(',', '', $ledger->op_balance);
                $op_bl_arr[$led_id]['name'] = $ledger->name;
                $op_bl_arr[$led_id]['op_bl'] = $opening_bl;


                // getting payment entries
                $payments = DB::table('entries')
                    ->select('entries.id', 'single_entry.amount')
                    ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')
                    ->where('entries.entrytype_id', 2)
                    ->whereBetween('single_entry.transaction_date', [$from_date, $to_date])
                    ->where('single_entry.ledger_id', $led_id)
                    ->where('dc', 'C')
                    ->get();


                // getting received entries
                $received = DB::table('entries')
                    ->select('entries.id', 'single_entry.amount')
                    ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')
                    ->where('entries.entrytype_id', 1)
                    ->whereBetween('single_entry.transaction_date', [$from_date, $to_date])
                    ->where('single_entry.ledger_id', $led_id)
                    ->where('dc', 'D')
                    ->get();


                $payment_arr[$led_id][] = array();
                $received_arr[$led_id][] = array();

                // populating received array
                if (!empty($payments)) {
                    foreach ($payments as $payment) {
                        $payment_dr = DB::table('single_entry')
                            ->select('single_entry.ledger_id', 'ledgers.name')->where('dc', 'D')
                            ->where('entry_id', $payment->id)
                            ->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')
                            ->first();
                        $amount = str_replace(',', '', $payment->amount);

                        $is_empty = empty($payment_arr[$led_id][$payment_dr->ledger_id]['amount']);
                        if ($is_empty) {
                            $payment_arr[$led_id][$payment_dr->ledger_id]['id'] = $payment->id;
                            $payment_arr[$led_id][$payment_dr->ledger_id]['amount'] = $amount;
                            $payment_arr[$led_id][$payment_dr->ledger_id]['ledger'] = $payment_dr->name;
                        } else {
                            $payment_arr[$led_id][$payment_dr->ledger_id]['amount'] += $amount;
                        }

                    }
                    unset($payment_arr[$led_id][0]);
                }


                //// populating received array
                if (!empty($received)) {
                    foreach ($received as $receive) {
                        $receive_cr = DB::table('single_entry')
                            ->select('single_entry.ledger_id', 'ledgers.name')->where('dc', 'C')
                            ->where('entry_id', $receive->id)
                            ->join('ledgers', 'ledgers.id', '=', 'single_entry.ledger_id')
                            ->first();
                        $amount = str_replace(',', '', $receive->amount);

                        $is_empty = empty($received_arr[$led_id][$receive_cr->ledger_id]['amount']);
                        if ($is_empty) {
                            $received_arr[$led_id][$receive_cr->ledger_id]['id'] = $payment->id;
                            $received_arr[$led_id][$receive_cr->ledger_id]['amount'] = $amount;
                            $received_arr[$led_id][$receive_cr->ledger_id]['ledger'] = $receive_cr->name;
                        } else {
                            $received_arr[$led_id][$receive_cr->ledger_id]['amount'] += $amount;
                        }

                    }
                    unset($received_arr[$led_id][0]);
                }


                // getting sum of payments till date
                $payment_bl = DB::table('single_entry')->select('amount')
                    ->join('entries', 'entries.id', '=', 'single_entry.entry_id')
                    ->where('single_entry.ledger_id', $led_id)
                    ->where('entries.entrytype_id', 2)
                    ->whereBetween('single_entry.transaction_date', [$from_date, $to_date])
                    ->sum('amount');


                // getting sum of received till date
                $received_bl = DB::table('single_entry')->select('amount')
                    ->join('entries', 'entries.id', '=', 'single_entry.entry_id')
                    ->where('single_entry.ledger_id', $led_id)
                    ->where('entries.entrytype_id', 1)
                    ->whereBetween('single_entry.transaction_date', [$from_date, $to_date])
                    ->sum('amount');

                $closing_bl = str_replace(',', '', $ledger->op_balance) + $received_bl - $payment_bl;
                $cl_bl_arr[$led_id]['name'] = $ledger->name;
                $cl_bl_arr[$led_id]['cl_bl'] = $closing_bl;

            }


            return view('reports.receive_payment_report_details', compact('payment_arr', 'received_arr', 'op_bl_arr', 'cl_bl_arr', 'from_date', 'to_date', 'constant_date', 'before_from_date'));
        }
    }


    /*
     * Receipt Payment Report by selecting option
     * */
    public function showSelectedReceiptPaymentReportForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $bank_cash_leds = Ledger::where('type', 1)->get();
            return view('reports.receipt_payment_selected', compact('bank_cash_leds'));
        }
    }

    public  function selectedReceiptPaymentReport(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $led_id = $request->led_id;

            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];


            $constant_date = '1990-01-01';
            $before_from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));

            // getting opening balance
            $led_info = \App\Ledger::where('id', $led_id)->first();
            $led_dr_amount = \App\SingleEntry::selectRaw('sum(amount) as dr')
                ->where('ledger_id', $led_id)
                ->where('dc', 'D')
                ->whereBetween('transaction_date', [$constant_date, $before_from_date])
                ->first();

            $led_cr_amount = \App\SingleEntry::selectRaw('sum(amount) as cr')
                ->where('ledger_id', $led_id)
                ->where('dc', 'C')
                ->whereBetween('transaction_date', [$constant_date, $before_from_date])
                ->first();

            $opening_balance = $led_info->op_balance + $led_dr_amount->dr - $led_cr_amount->cr;

            // getting entries id
            $entry_ids = SingleEntry::select('entry_id')
                ->where('ledger_id', $led_id)
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->groupBy('entry_id')
                ->get();


            return view('reports.receipt_payment_selected_details', compact('led_info', 'opening_balance', 'entry_ids', 'from_date', 'to_date'));
        }
    }



    /*
     * showing receipt payment details
     * */
    public function showAllReceiptPaymentDetailsForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.all_receipt_payment');
        }
    }

    public function allReceiptPaymentDetails(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];


            $constant_date = '1990-01-01';
            $before_from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));


            // getting ledger ids
            $bank_cash_leds = SingleEntry::select('single_entry.ledger_id as led_id')
                ->whereBetween('transaction_date', [$from_date, $to_date])
                ->join('ledgers', 'single_entry.ledger_id', '=', 'ledgers.id')
                ->where('ledgers.group_id', 17)
                ->where('ledgers.type', 1)
                ->groupBy('single_entry.ledger_id')
                ->get();

            // getting entries id

            $assets = Ledger::select('id')->where('type', 1)->get();
            $assets_arr = array();
            foreach ($assets as $a) {
                $assets_arr[] = $a->id;
            }
            $assets_str = implode(',', $assets_arr);
            /*echo $assets_str;
            die();*/

            $rec_entries = DB::select("Select distinct entry_id, ledger_id  from single_entry where (transaction_date between '$from_date' and '$to_date') and dc = 'D' and ledger_id in ($assets_str)  ");
            $pay_entries = DB::select("Select distinct entry_id ,ledger_id from single_entry where (transaction_date between '$from_date' and '$to_date') and dc = 'C' and ledger_id in ($assets_str)  ");


            // for journal
            $non_cash_ledgers = Ledger::select('id')->where('type', 0)->get();
            $non_cash_ledgers_arr = array();
            foreach ($non_cash_ledgers as $a) {
                $non_cash_ledgers_arr[] = $a->id;
            }

            $non_cash_ledgers_str = implode(',', $non_cash_ledgers_arr);
            $non_cash_entries = DB::select("Select distinct single_entry.entry_id from single_entry join entries on single_entry.entry_id = entries.id where entries.entrytype_id = '4' and (single_entry.transaction_date between '$from_date' and '$to_date') and single_entry.ledger_id in ($non_cash_ledgers_str)  ");

            return view('reports.all_receipt_payment_details', compact('from_date', 'to_date', 'constant_date', 'before_from_date', 'bank_cash_leds', 'rec_entries', 'pay_entries', 'non_cash_entries'));
        }
    }


    /*
     * search income statement by date
     * */
    public function showIncomeStatementForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.income_statement_form');
        }
    }


    /*
     * showing income Statement Report
     * */
    public function incomeStatementReport(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];

            // for expense
            $leds = Group::select('ledgers.id as led_id')->where('parent_id', 4)->join('ledgers', 'ledgers.group_id', '=', 'groups.id')->get();
            $ex_assets_arr = array();
            foreach ($leds as $a) {
                $ex_assets_arr[] = $a->led_id;
            }

            $ex_assets_str = implode(',', $ex_assets_arr);

            $ex_led_ids = DB::select("Select distinct ledger_id from single_entry where transaction_date between '$from_date' and '$to_date' and ledger_id in ($ex_assets_str)  ");


            // for Income
            $inc_leds = Group::select('ledgers.id as led_id')->where('parent_id', 3)->join('ledgers', 'ledgers.group_id', '=', 'groups.id')->get();
            $inc_assets_arr = array();
            foreach ($inc_leds as $a) {
                $inc_assets_arr[] = $a->led_id;
            }

            $inc_assets_str = implode(',', $inc_assets_arr);
            $inc_led_ids = DB::select("Select distinct ledger_id from single_entry where transaction_date between '$from_date' and '$to_date' and ledger_id in ($inc_assets_str)  ");


            return view('reports.income_statement_report', compact('ex_led_ids', 'inc_led_ids', 'from_date', 'to_date'));
        }
    }



    /*
     * showing Transaction Listing
     *
     * */
    public function showTransactionListingForm(){
    if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.transaction_list_form', compact(''));
        }
    }


    /*
     * showing Transaction List
     * */
    public function showTransactionListing(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];

            $leds = Ledger::select('id')->where('type', 1)->get();
            $leds_arr = array();
            foreach ($leds as $a) {
                $leds_arr[] = $a->id;
            }
            $leds_str = implode(',', $leds_arr);

            $dr_entry_infos = DB::select("Select distinct entry_id, ledger_id from single_entry join entries on single_entry.entry_id = entries.id where single_entry.transaction_date between '$from_date' and '$to_date' and single_entry.ledger_id in ($leds_str) and single_entry.dc = 'D' and (entries.entrytype_id = 1 or entries.entrytype_id = 2 ) ");
            $cr_entry_infos = DB::select("Select distinct entry_id, ledger_id from single_entry join entries on single_entry.entry_id = entries.id where single_entry.transaction_date between '$from_date' and '$to_date' and single_entry.ledger_id in ($leds_str) and single_entry.dc = 'C' and (entries.entrytype_id = 1 or entries.entrytype_id = 2 )");


            $contra_entries = Entry::select('entries.id as entry_id', 'single_entry.ledger_id as ledger_id')->where('entrytype_id', 3)->whereBetween('date', [$from_date, $to_date])
                ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')->where('single_entry.dc', 'D')->get();

            $journal_entries = Entry::select('entries.id as entry_id', 'single_entry.ledger_id as ledger_id')->where('entrytype_id', 4)->whereBetween('date', [$from_date, $to_date])
                ->join('single_entry', 'single_entry.entry_id', '=', 'entries.id')->where('single_entry.dc', 'D')->get();


            /*echo '<pre>';
            print_r($contra_entries);
            echo '</pre>';
            die();*/

            return view('reports.transaction_list_report', compact('from_date', 'to_date', 'dr_entry_infos', 'cr_entry_infos', 'journal_entries', 'contra_entries'));
        }
    }



    /*
     * searching trial balance by date
     * */
    public function showTrialBalanceForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            return view('reports.trial_balance_form');
        }
    }



    public function showTrialBalanceReport(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];

            $constant_date = '1990-01-01';
            $before_from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));

            $leds = Ledger::select('*')->get();

            return view('reports.trial_balance_report', compact('from_date', 'to_date', 'constant_date', 'before_from_date', 'leds'));
        }
    }


    /*
     * showing cash book
     * */
    public function showCashBookForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $ledgers = Ledger::select('*')->where('bank_or_cash', 'C')->get();
            $title = 'Cash Book';
            return view('reports.ledger_statement', compact('ledgers', 'title'));
        }

    }


    /*
     * Notes To The Accounts
     * */
    public function showNotesToAccForm(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $groups = Group::where('parent_id', 0)->get();
            return view('reports.notes_to_acc_form', compact('groups'));
        }
    }


    public function showHeadNames(){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $parent_id = $_GET['parentID'];
            $sub_groups = Group::where('parent_id', $parent_id)->get();

            $output = '
            <select class="form-control" id="head_id" name="group_id" data-validation="required">
                ';
            foreach ($sub_groups as $sub_group) {
                $output .= '
                        <option value="' . $sub_group->id . '">' . $sub_group->name . '</option>    
                    ';
            }
            $output .= '    
            </select>  
        ';

            echo $output;
        }
    }

    public function showNotesToAccReport(Request $request){
        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect('/');
        }else {
            $group_id = $request->group_id;

            $from_date_arr = explode('/', $request->from_date);
            $from_date = $from_date_arr[2] . '-' . $from_date_arr[0] . '-' . $from_date_arr[1];

            $to_date_arr = explode('/', $request->to_date);
            $to_date = $to_date_arr[2] . '-' . $to_date_arr[0] . '-' . $to_date_arr[1];

            $constant_date = '1990-01-01';
            $before_from_date = date('Y-m-d', strtotime($from_date . ' -1 day'));


            $leds = Ledger::select('*')->where('group_id', $group_id)->get();

            /*        echo $group_id;
                    echo '<pre>';
                    print_r($leds);
                    echo '</pre>';
                    die();*/

            return view('reports.notes_to_acc_report', compact('from_date', 'to_date', 'constant_date', 'before_from_date', 'leds'));
        }
    }

}
