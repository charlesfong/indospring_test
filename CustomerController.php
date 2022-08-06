<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\customer_address;
use Illuminate\Http\Request;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = customer::orderBy('id')->get();
        // $cust = array();
        // foreach ($customers as $key => $value) {
        //     $customers_extra = customer_extra::where('id_customer',$value->id)->get();
        //     foreach ($customers_extra as $key => $value) {
        //         $cust[] = $value;
        //     }
            
        // }
        // dd($cust);
        $nav_tab   = 'customer';

        
        return view('admin.customer', compact('customers','nav_tab'));
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
        DB::beginTransaction();
        try{
            $customer = new customer($request->all());
            $customer->saveOrFail();
            
            DB::commit();
            $customers = customer::orderBy('id')->get();
            return response()->json(['success'=>true, 'data'=>$customers],200);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['error'=>'Something went wrong, please try later.'],
                $e->getCode()
            );
        }
    }

    public function store_address(Request $request)
    {
        DB::beginTransaction();
        try{
            $customer = new customer_address($request->all());
            // $customer = new customer_address();
            // $customer->id_customer  =  12;
            // $customer->name         = 'abc';
            // $customer->address      = 'add';
            // $customer->phone1       = 'phone1';
            // $customer->phone2       = 'phone2';
            // $customer->phone3       = 'phone3';
            $customer->save();
            
            DB::commit();
            $customers = customer::orderBy('id')->get();
            return response()->json(['success'=>true, 'data'=>$customers],200);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['success'=>false,'error'=>'Something went wrong, please try later.'],$e->getCode()
            );
        }
    }

    public function show_contact_person(Request $request)
    {
        // $customer = customer::all();
        $customer = customer_address::where('id_customer',$request->id)->select('customers_address.*')
        ->selectRaw(DB::raw("COALESCE(address, '-') AS address,COALESCE(phone1, '-') AS phone_1,COALESCE(phone2, '-') AS phone_2,COALESCE(phone3, '-') AS phone_3,COALESCE(email, '-') AS email_"))->get();
        // dd($customer);
        $data = ['result' => 1,
            'data' => $customer
        ];
        return response()->json($data, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $customer = customer_address::where('id_customer',$request->id)->first();
            if ($customer!=null) {
                // $customer->delete();
            }

            $customer = customer::find($request->id);
            $customer->delete();

            DB::commit();
            $customers = customer::orderBy('id')->get();

            return response()->json(['success'=>true, 'data'=>$customers],200);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(
                ['error'=>'Something went wrong, please try later.'],
                $e->getCode()
            );
        }
    }

    public function find_byId($id)
    {
        $customer = customer::where('id',$id)->first();
        return $customer;
    }

    public function find_company_byId(Request $request)
    {
        // var_dump($request->id);
        $customer = customer_address::where('id_customer',$request->id)->get();
        return json_encode($customer);
    }
}
