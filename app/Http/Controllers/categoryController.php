<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        //$this->middleware('auth');
    }

    public function getDate(){
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d H:i:s");
        return $date;
    }

    public function index()
    {
        $all_categories = DB::table('test_category')->orderBy('id','asc')->get();
        return view('admin.category.category',['all_categories'=>$all_categories]);
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

//        $user = Auth::user()->id;

        $this->validate($request,[
            'category_name'  => 'required',
//            'product' => 'required',
        ]);

        $store = DB::table('test_category')->insert([
            'category_name'      => $request->category_name,
//            'products'   => $request->product,
//            'creator_id' => $user,
            'creator_id' => \Illuminate\Support\Facades\Auth::id(),
            'created_at' => $this->getDate(),
        ]);

        if ($store){
            return redirect('test_category')->with('message','Category insert successful.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catValue = DB::table('test_category')->where('id',$id)->first();

        return view('admin.category.editCategory',['catValue' => $catValue]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $update = DB::table('test_category')->where('id',$request->id)
            ->update([
                'category_name'      => $request->cname,
//                'products'   => $request->products,
                'created_at' => $this->getDate(),
            ]);

        if($update){
            return redirect('test_category')->with('message','Category update successfully.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('test_category')->where('id', $id)->delete();
        if ($delete){
            return redirect('test_category')->with('message','Category delete successfully.');
        }
    }
}
