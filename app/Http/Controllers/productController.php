<?php

namespace App\Http\Controllers;

use App\Client;
use App\Ledger;
use Illuminate\Http\Request;
use DB;
use Auth;

class productController extends Controller
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
//        $cat_all = DB::table('catagory')->get();
        $tests = \Illuminate\Support\Facades\DB::table('product_info')->get();
        $cat_all = \Illuminate\Support\Facades\DB::table('test_category')->select('id', 'category_name')->get();
        return view('admin.product.product',['cat_all'=>$cat_all, 'tests'=>$tests]);
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

    public function editTest($id){

        $info= \Illuminate\Support\Facades\DB::table('product_info')->where('id', $id)->first();
        $cat_all = DB::table('catagory')->get();
        $tests = \Illuminate\Support\Facades\DB::table('product_info')->get();
        return view('admin.product.product',['cat_all'=>$cat_all, 'tests'=>$tests, 'info'=>$info]);
    }

    public function editProduct1(Request $request){
        \Illuminate\Support\Facades\DB::table('product_info')->where('id', $request->id)
            ->update([
                'product_name'=>$request->product_name,
                'sell'=>$request->sale,
                'description'=>$request->description,

            ]);
        $cat_all = DB::table('catagory')->get();
        $tests = \Illuminate\Support\Facades\DB::table('product_info')->get();
        return view('admin.product.product',['cat_all'=>$cat_all, 'tests'=>$tests]);
    }


    public function deleteTest($id){
        \Illuminate\Support\Facades\DB::table('product_info')->where('id', $id)->delete();

        $cat_all = DB::table('catagory')->get();
        $tests = \Illuminate\Support\Facades\DB::table('product_info')->get();
        return view('admin.product.product',['cat_all'=>$cat_all, 'tests'=>$tests]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if ($request->file('product_image')){

              $this->validate($request, [
                  'product_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:3048',
                  'cat_id'       => 'required|not_in:0',
                  'product_name' => 'required',
                  'cost'         => 'required',
                  'sale'         => 'required',
                  'alert_limit'  => 'required',
              ]);


            // saving image
          $target = "product_image/"; //target name

          /* getting images and setting names for them */
          $image = $request->file('product_image');
          $six_digit_random_number = mt_rand(100000, 999999);
          $image_title = str_replace(' ', '_', $request->product_name);
          $image_title .= '_'.$six_digit_random_number.'.'.$image->getClientOriginalExtension();

          //method for saving the image into directory
          $this->saveImageToDir($image, $target, $image_title);

              //$user = Auth::user()->id;

              $insert = DB::table('product_info')->insert([
              'product_type_id'  => $request->cat_id,
              'product_name'     => $request->product_name,
              'brand'            => $request->brand,
              'cost'             => $request->cost,
              'sell'             => $request->sale,
              'min_price'        => $request->min_price,
              'unit'             => $request->unit,
              'qt_per_carton'    => $request->qt_per_carton,
              'product_image'    => $request->product_image,
              'description'      => $request->description,
              'alert_limit'      => $request->alert_limit,
              'product_image'    => $target.''.$image_title,
//              'creator_id'       => $user,
              'creator_id'       => \Illuminate\Support\Facades\Auth::id(),
              'created_at'       => $this->getDate(),
              ]);


             if ($insert){
              return redirect('add_product')->with('message','Product insert successfully.');
             }

          }else{

          $this->validate($request, [
              'cat_id'       => 'required|not_in:0',
              'product_name' => 'required',
              'code' => 'required',
              'range' => 'required',
              'unit' => 'required',
              'cost'         => 'required',
              'sale'         => 'required',
              'alert_limit'  => 'required',
          ]);

          //$user = Auth::user()->id;

          $insert = DB::table('product_info')->insert([
              'product_type_id'  => $request->cat_id,
              'product_name'     => $request->product_name,
              'cost'             => $request->cost,
              'code'             => $request->code,
              'normal_range'     => $request->range,
              'unit'             => $request->range_unit,
              'sell'             => $request->sale,
              'min_price'        => $request->min_price,
              'qt_per_carton'    => $request->qt_per_carton,
              'product_image'    => $request->product_image,
              'description'      => $request->description,
              'alert_limit'      => $request->alert_limit,
              'creator_id'       => \Illuminate\Support\Facades\Auth::id(),
//              'creator_id'       => $user,
              'created_at'       => $this->getDate(),
          ]);


          if ($insert){
              return redirect('add_test')->with('message','Test Info insert successfully.');
          }
      }

      }



    /*
     * method for saving the image into directory
     *
     * */

    public function saveImageToDir($image, $target, $imageName){

        $tmpName = $image->getPathname();
        $imageType = $image->getClientOriginalExtension();

        /* new file name */
        $path = $target.$imageName;

        /* read binary data from image file */
        $imgString = file_get_contents($tmpName);

        /* create image from string */
        $image = imagecreatefromstring($imgString);

        /* Save image */
        switch (strtolower($imageType)) {
            case 'jpeg':
                imagejpeg($image, $path, 100);
                break;
            case 'jpg':
                imagejpeg($image, $path, 100);
                break;
            case 'png':
                imagepng($image, $path, 0);
                break;
            case 'gif':
                imagegif($image, $path);
                break;
            default:
                exit;
                break;
        }
    }






    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productList()
    {
        $productList = DB::table('product_info')
            ->join('catagory', 'product_info.product_type_id', '=', 'catagory.id')
            ->select('product_info.*','product_info.id as p_id', 'catagory.cname')
            ->get();

        return view('admin.product.productList',['productList'=>$productList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cat_all = DB::table('catagory')->get();

        $productById = DB::table('product_info')
            ->join('catagory', 'product_info.product_type_id', '=', 'catagory.id')
            ->select('product_info.*','product_info.id as p_id','catagory.id as cat_id','catagory.cname')
            ->where('product_info.id', $id)
            ->first();

        return view('admin.product.editProduct',['productById'=>$productById,'cat_all'=>$cat_all]);
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
//        $user = Auth::user()->id;


       if ($request->file('product_image')){

           $this->validate($request, [
               'product_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:3048',
               'cat_id'       => 'required|not_in:0',
               'product_name' => 'required',
               'cost'         => 'required',
               'sale'         => 'required',

           ]);

           if(file_exists(public_path('product_image/'.$request->default_image))){

               unlink(public_path('product_image/'.$request->default_image));

           }

           $getimageName = time() . '.' . $request->product_image->getClientOriginalExtension();
           $request->product_image->move(public_path('product_image'), $getimageName);

           $insert = DB::table('product_info')
               ->where('id',$request->id)
               ->update([
                   'product_type_id'  => $request->cat_id,
                   'product_name'     => $request->product_name,
                   'brand'            => $request->brand,
                   'cost'             => $request->cost,
                   'sale'             => $request->sell,
                   'product_image'    => $request->product_image,
                   'description'      => $request->description,
                   'product_image'    => $getimageName,
//                   'creator_id'       => $user,
                   'creator_id'       => \Illuminate\Support\Facades\Auth::id(),
                   'created_at'       => $this->getDate(),
               ]);


           if($insert){
               session()->flash('message.level', 'success');
               session()->flash('message.content','Product update successfully.');
               return redirect('product_edit/'.$request->id);
           }else{
               session()->flash('message.level', 'danger');
               session()->flash('message.content','Failed To update Product, Try Later');
               return redirect('product_edit/'.$request->id);
           }
           /*if ($insert){
               return back()->with('message','Product update successfully.');
           }*/
       }else{


           $this->validate($request, [
               'cat_id'       => 'required|not_in:0',
               'product_name' => 'required',
               'cost'         => 'required',
               'sell'         => 'required',

           ]);

           $insert = DB::table('product_info')
               ->where('id',$request->id)
               ->update([
                   'product_type_id'  => $request->cat_id,
                   'product_name'     => $request->product_name,
                   'cost'             => $request->cost,
                   'sell'             => $request->sell,
                   'product_image'    => $request->product_image,
                   'description'      => $request->description,
                   'product_image'    => $request->default_image,
//                   'creator_id'       => $user,
                   'creator_id'       => \Illuminate\Support\Facades\Auth::id(),
                   'created_at'       => $this->getDate(),
               ]);


           if($insert){
               session()->flash('message.level', 'success');
               session()->flash('message.content','Product update successfully.');
               return redirect('product_edit/'.$request->id);
           }else{
               session()->flash('message.level', 'danger');
               session()->flash('message.content','Failed To update Product, Try Later');
               return redirect('product_edit/'.$request->id);
           }

           /*if ($insert){
               return back()->with('message','Product update successfully.');
           }*/

       }

    }


    /*
     * show Product info By Id
     * */
    public function showById($id){

        $productById = DB::table('product_info')
            ->join('catagory', 'product_info.product_type_id', '=', 'catagory.id')
            ->select('product_info.*','product_info.id as p_id','catagory.id as cat_id','catagory.cname')
            ->where('product_info.id', $id)
            ->first();

        return view('admin.product.productShowById',['productById'=>$productById]);
    }


    /*
     * getting product Status
     * */
    public function getStatus(){


//        $status = DB::select("SELECT product_status.product_in, product_status.product_out, product_status.available,catagory.cname,product_info.product_name FROM product_status JOIN product_info ON product_info.id = product_status.product_id JOIN catagory ON catagory.id = product_info.product_type_id");

        $catagories = \Illuminate\Support\Facades\DB::table('catagory')->select('id', 'cname')->get();
        $info_arr = array();

        foreach ($catagories as $cat){
            $cat_id = $cat->id;
            $cat_name = $cat->cname;


            $products = \Illuminate\Support\Facades\DB::table('product_info')
                ->select('id', 'product_name')
                ->where('product_type_id', $cat_id)
                ->get();

            if (sizeof($products)>0){
                $info_arr[$cat_id][] = array();

                foreach($products as $product){
                    $product_id = $product->id;
                    $product_name = $product->product_name;

                    $purchase_qt = \Illuminate\Support\Facades\DB::table('purchase_single')
                        ->select('quantity')
                        ->where('product_id', $product_id)
                        ->sum('quantity');

                    $purchase_return_qt = \Illuminate\Support\Facades\DB::table('purchase_return_details')
                        ->select('quantity')
                        ->where('product_id', $product_id)
                        ->sum('quantity');

                    $sale_qt = \Illuminate\Support\Facades\DB::table('memo_entry')
                        ->select('quantity')
                        ->where('product_id', $product_id)
                        ->sum('quantity');

                    $sale_return_qt = \Illuminate\Support\Facades\DB::table('return_memo_entry')
                        ->select('quantity')
                        ->where('product_id', $product_id)
                        ->sum('quantity');

                    $available_qt = $purchase_qt - $sale_qt - $purchase_return_qt + $sale_return_qt;


                    $info_arr[$cat_id][$product_id]['cat_name'] = $cat_name;
                    $info_arr[$cat_id][$product_id]['product_id'] = $product_id;
                    $info_arr[$cat_id][$product_id]['product_name'] = $product_name;
                    $info_arr[$cat_id][$product_id]['purchase'] = $purchase_qt;
                    $info_arr[$cat_id][$product_id]['sale'] = $sale_qt;
                    $info_arr[$cat_id][$product_id]['p_return'] = $purchase_return_qt;
                    $info_arr[$cat_id][$product_id]['s_return'] = $sale_return_qt;
                    $info_arr[$cat_id][$product_id]['available_qt'] = $available_qt;
                }
                unset($info_arr[$cat_id][0]);
            }



        }

   /*     echo '<pre>';
        print_r($info_arr);
        echo '</pre>';*/

        return view('admin.product.productStatus',compact('info_arr'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = DB::table('product_info')->where('id', $id)->delete();

        if($success){
            session()->flash('message.level', 'success');
            session()->flash('message.content','Product deleted successfully.');
            return redirect('product_list');
        }else{
            session()->flash('message.level', 'danger');
            session()->flash('message.content','Failed To delete Product, Try Later');
            return redirect('product_list');
        }


//        return redirect('product_list')->with('message','Product delete successfully');
    }
}
