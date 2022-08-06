<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\supplier;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
        $products = array();
        $suppliers= array();

        $check_param = explode("?",$_SERVER['REQUEST_URI']);
        if (count($check_param)>1){
            if (Auth::user()->name=='charles'){
                $split = explode("&",$check_param[1]);
                foreach ($split as $key => $value) {
                    $split_ = explode("=",$value);
                    if ($split_[0]=='brand'){
                        $request->brand = $split_[1];
                    } else {
                        $request->supplier = $split_[1];
                    }
                }
            }
        }
        if ($request->brand!=null){
            if ($request->brand!='all'){
                $products       = product::where('brand',$request->brand)->where('status',true);
            } else {
                $products       = product::where('status',true);
            }

            if ($request->supplier!='all'){
                $products       = $products->where('id_supplier',$request->supplier);
            }
            $products           = $products->get();
        } else {
            $products           = product::where('status',true)->get(); 
        }
        $suppliers          = supplier::all();
        $categories         = category::all();
        $brands             = product::select('brand')->where('status',true)->groupBy("brand")->orderBy("brand")->get();
        
        return view('admin.product', [
            'nav_tab'   => 'list_products',
            'products'  => $products,
            'suppliers' => $suppliers,
            'brands'    => $brands,
            'categories'=> $categories
        ]);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $find_   = product::find($request->id);
            $product = new product($request->all());
            $product->CREATED_BY = Auth::user()->name;
            if ($find_==null){
                $product->saveOrFail();
                DB::commit();
                $products = product::where('status',true)->orderBy('id')->get();
                return response()->json(['success'=>true, 'data'=>$products],200);
            } else {
                DB::rollback();
                $products = product::where('status',true)->orderBy('id')->get();
                $msg      = "Saving failed.\nFound duplicate Product ID : ".$request->id."\nPlease use another Product ID. ";
                return response()->json(['success'=>false, 'data'=>$products,'msg'=>$msg],200);
            }
            
            
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['error'=>'Something went wrong, please try later.'],
                $e->getMessage()
            );
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        // try{
            $product        = product::find($request->id_old);
            $id_duplicate   = product::find($request->id);
            if ($product==null){
                DB::rollback();
                $products = product::where('status',true)->orderBy('id')->get();
                $msg      = "Update failed.\nProduct ID : ".$request->id." is not exist.";
                return response()->json(['success'=>false, 'data'=>$products,'msg'=>$msg],200);
            } else if ($id_duplicate!=null && $request->id!=$request->id_old) {
                DB::rollback();
                $products = product::where('status',true)->orderBy('id')->get();
                $msg      = "Update failed.\nFound duplicate Product ID : ".$request->id."\nPlease use another Product ID. ";
                return response()->json(['success'=>false, 'data'=>$products,'msg'=>$msg],200);
            } else {
                $product->id                = $request->id;
                $product->name              = $request->name;
                $product->customer_price    = $request->customer_price;
                $product->supplier_price    = $request->supplier_price;
                $product->description       = $request->description;
                $product->brand             = $request->brand;
                $product->unit              = $request->unit;
                $product->id_category       = $request->id_category;
                $product->id_supplier       = $request->id_supplier;

                $product->UPDATED_BY        = Auth::user()->name;
                $product->UPDATED_AT        = date('Y-m-d H:m:s');

                $product->saveOrFail();
                DB::commit();
                $products = product::leftJoin('suppliers as b', 'b.id', '=', 'products.id_supplier')
                ->where('products.status',true)->orderBy('id')
                ->selectRaw("products.*, b.name as supplier_name")->get();
                
                return response()->json(['success'=>true, 'data'=>$products],200);
            }
            
            
        // } catch(\Exception $e) {
        //     DB::rollback();
        //     return response()->json(
        //         ['error'=>'Something went wrong, please try later.'],
        //         $e->getMessage()
        //     );
        // } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $product = product::find($request->id);
            // $product->status=false;
            // $product->updated_by=Auth::user()->name;
            // $product->update();
            $product->delete();

            DB::commit();
            $products = product::leftJoin('suppliers', 'products.id_supplier', '=', 'suppliers.id')
            ->select(['products.*','suppliers.name as name_supplier'])->where('products.status',true)
            ->orderBy('products.id')->get();

            return response()->json(['success'=>true, 'data'=>$products],200);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['error'=>'Something went wrong, please try later.'],
                $e->getCode()
            );
        }
    }

    public function find_product_byId(Request $request) {
        $product = product::find($request->id);
        return json_encode($product);
    }

    public function find_unit_byId($id) {
        $product = product::find($id);
        return ($product);
    }
}
