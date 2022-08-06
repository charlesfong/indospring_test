<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\customer_address;
use App\Models\supplier;
use App\Models\Product;
use App\Models\Category;
use App\Models\courier;
use App\Models\shipment;
use App\Models\order;
use App\Models\order_detail;
use App\Models\order_log;
use Illuminate\Support\Facades\Auth;
use DB;


class ReportController extends Controller
{
    public function index()
    {
        $customers      = customer::all();
        $categories     = Category::all();
        return view('admin.report', [
            'nav_tab'       => 'report',
            'customers'     => $customers,
            'categories'    => $categories
        ]);
    }

    public function get_data_order(Request $request)
    {
        $filter_customer    = $request->form_customer;
        $filter_categories  = $request->form_categories;
        $filter_status      = $request->form_status;

        $request->date1 = date('Y-m-d', strtotime($request->date1));
        $request->date2 = date('Y-m-d', strtotime($request->date2));
       
        // $order = order::leftJoin('customers as c', 'orders.id_customer', '=', 'c.id')->where('orders.id',$id)->select(["orders.*","c.name"])->first();
        $order  = order::leftJoin('orders_details as b', 'orders.id', '=', 'b.id_order')
        ->leftJoin('products as c', 'c.id', '=', 'b.id_product')
        ->leftJoin('customers as d', 'd.id', '=', 'orders.id_customer');

        if ($request->date1==$request->date2){
            $order->whereRaw('DATE(orders.CREATED_AT) = ?', [$request->date1]);
        } else{
            $order->whereBetween('orders.CREATED_AT', [$request->date1,$request->date2]);
        }
       
        if ($request->form_customer!="ALL"){
            $order->where('orders.id_customer', $request->form_customer);
        }
        if ($request->form_status!="ALL"){
            $order->where('orders.status', $request->form_status);
        }
        if ($request->form_categories!="ALL"){
            $order->where('c.id_category', $request->form_categories);
        }
        $order = $order->selectRaw("orders.id_customer,d.name,sum(price*b.qty) as total_price,sum(d_price*b.qty) as total_dprice, sum(profit*b.qty) as total_profit")->groupBy('orders.id_customer','d.name')->get();

        return json_encode($order);
    }
}
