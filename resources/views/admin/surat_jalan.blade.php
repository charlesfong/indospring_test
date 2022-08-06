<link href="{{ asset('/template_admin/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
<style>
    body{
        /* margin-top:20px;
        background:rgb(221, 221, 221); */
        display:flex; 
        flex-direction:column; 
        font-size: 1.3em;
    }

    .invoice {
        /* padding: 30px; */
    }

    .invoice {
        padding: 10px;
    }
    table td, table th{
        border:1px solid black;
        border-collapse: collapse;
    }
    
    .borderless tr td {
        border: none !important;
        padding: 0px !important;
    }

    .invoice h2 {
        margin-top: 0px;
        line-height: 0.8em;
    }

    .invoice .small {
        font-weight: 300;
        /* font-size: 5.8em !important; */
    }

    .invoice hr {
        /* margin-top: 10px;
        border-color: #ddd; */
    }

    .invoice .table tr.line {
        /* border-bottom: 1px solid #ccc; */
    }

    .invoice .table td {
        /* border: none; */
    }

    .invoice .identity {
        margin-top: 2%;
        font-size: 0.8em;
        font-weight: 300;
    }

    .invoice .identity strong {
        font-weight: 600;
    }


    .grid {
        position: relative;
        width: 100%;
        /* background: #fff; */
        color: #000000;
        border-radius: 5px;
        /* margin-bottom: 25px; */
        /* box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1); */
    }

    .table-manual-style {
        width:100%;
    }
    .tracking_no_ {
        display : none;
    }
    
    p {
        line-height:0.5cm;
    }
    @media print {
        /* @page {size: landscape} */
        html, body {
            background:rgb(255, 0, 0);
            /* width: 210mm;
            height: 148.5mm; */
            height: 100%;
            font-size: 1.3em;
            /* margin:0%; */
            color:#000000; 
            margin: 0 !important;
            padding: 0 !important;
        }
        .special_size {
            font-size: 0.8em;
        }
        .special_size2 {
            font-size: 0.8em;
        }
        p {
            line-height:0.7cm;
        }
        th div, td div {
            /* margin-top:-8px;
            padding-top:8px; */
            page-break-inside:avoid;
        }
        table { page-break-inside:auto }
        tr,td    { page-break-inside:avoid; page-break-after:auto }
        /* ... the rest of the rules ... */

    }
</style>
<div class="container">
    <div class="row">
        <!-- BEGIN INVOICE -->
        <div class="col-xs-12">
            <div class="grid invoice_">
                <div class="grid-body">
                    <div class="invoice-title">
                        <div class="row" style="height:100px">
                            @if ($modal_view ?? '')
                            
                            @else
                            <div class="col-xs-5 col-md-5 col-lg-5">
                                <img src="{{ asset('/img/logo_transparent.png') }}" class="img-fluid" width="180px" style='margin-left:20px;margin-top:0cm;position: absolute; top: -0.4cm'>
                            </div>
                            <div class="col-xs-7 col-md-7 col-lg-7 special_size2" style="float:right;margin-top:0%">
                                <div class="row">
                                    <div class="col-xs-2 col-md-2 col-lg-2" style="line-height:0.6cm">
                                        Address
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1" style="line-height:0.6cm">
                                        :
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-lg-9" style="line-height:0.6cm">
                                        Jl. Margomulyo Permai C3-3A, Surabaya
                                    </div>

                                    <div class="col-xs-2 col-md-2 col-lg-2" style="line-height:0.6cm">
                                        Phone
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1" style="line-height:0.6cm">
                                        :
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-lg-9" style="line-height:0.6cm">
                                        +62 811-330-9959
                                    </div>

                                    <div class="col-xs-2 col-md-2 col-lg-2" style="line-height:0.6cm">
                                        Email 
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1" style="line-height:0.6cm">
                                        :
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-lg-9" style="line-height:0.6cm">
                                        admin@andalanjayateknik.com
                                    </div>

                                    {{-- <div class="col-xs-2 col-md-2 col-lg-2">
                                        Web
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1">
                                        :
                                    </div>
                                    <div class="col-xs-9 col-md-9 col-lg-9">
                                        Aloha.com
                                    </div> --}}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if ($modal_view ?? '')
                    
                    @else
                    <div class="text-center" style="border-top: 0.2px solid rgb(0, 0, 0)">
                        <h3 style='margin-top:0px;'><b id="order_title">Surat Jalan</b></h3>
                    </div>
                    @endif
                   
                    
                    <div class="row" style="margin-left: 0.1cm;">
                        <div class="col-xs-6 col-md-6 col-lg-6">
                            <div class="row">
                                @if ($modal_view ?? '')
                                    <div class="col-xs-3 col-md-3 col-lg-3">
                                        Draft Date
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1">
                                        :
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8">
                                        <span id="draft_date_id"></span>
                                    </div>

                                    <div class="col-xs-3 col-md-3 col-lg-3 processed_date">
                                        Invoice Date
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1 processed_date">
                                        :
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 processed_date">
                                        <span id="paid_date_id"></span>
                                    </div>

                                    <div class="col-xs-3 col-md-3 col-lg-3 ready_delivery_date">
                                        Ship Date
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1 ready_delivery_date">
                                        :
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 ready_delivery_date">
                                        <span id="ready_delivery_date_id"></span>
                                    </div>

                                    <div class="col-xs-3 col-md-3 col-lg-3 delivery_date">
                                        Delivery
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1 delivery_date">
                                        :
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 delivery_date">
                                        <span id="delivery_date_id"></span>
                                    </div>

                                    <div class="col-xs-3 col-md-3 col-lg-3 done_date">
                                        Done Date
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1 done_date">
                                        :
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 done_date">
                                        <span id="done_date_id"></span>
                                    </div>

                                @else
                                    <div class="col-xs-5 col-md-5 col-lg-5 special_size" style="line-height:0.6cm">
                                        <strong>Order ID</strong>
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 special_size" style="line-height:0.6cm">
                                        :&nbsp;<strong id="order_id">{{$order->id}}</strong>
                                    </div>

                                    <div class="col-xs-5 col-md-5 col-lg-5 special_size" style="line-height:0.6cm">
                                        Date
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 special_size" style="line-height:0.6cm">
                                        :&nbsp;<span id="date_id">{{$order->CREATED_AT}}</span>
                                    </div>

                                    @if ($shipment!=null)
                                    <div class="col-xs-5 col-md-5 col-lg-5 text-left special_size" style="line-height:0.6cm">
                                        Shipping Method
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 text-left special_size" style="line-height:0.6cm">
                                        :<span id="cust_name">
                                            @php
                                                if ($shipment->id_courier=='self'){
                                                    echo("Self Pick-up");
                                                } else {
                                                    echo($shipment->courier_name);
                                                }
                                            @endphp
                                        </span>
                                    </div>
                                    
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-right">
                            <div class="row">
                                @if ($modal_view ?? '')
                                    <div class="col-xs-4 col-md-3 col-lg-4 text-left">
                                        <strong>Order ID</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1">
                                        <strong>:</strong>
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 text-left">
                                        <strong id="order_id"></strong>
                                    </div>
                                    <div class="col-xs-4 col-md-3 col-lg-4 text-left">
                                        Customer
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1">
                                        :
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 text-left">
                                        <span id="cust_name"></span>
                                    </div>

                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left">
                                        Shipment
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1">
                                        :
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 text-left shipment_">
                                        
                                    </div>

                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left tracking_no_">
                                        Tracking No
                                    </div>
                                    <div class="col-xs-1 col-md-1 col-lg-1 tracking_no_">
                                        :
                                    </div>
                                    <div class="col-xs-7 col-md-7 col-lg-7 text-left tracking_no_">
                                        <input type='text' size='10' id='tracking_no_value'>
                                        <span id='tracking_no_display'>

                                        </span>
                                    </div>

                                    <div class="col-xs-6 col-md-6 col-lg-6 receipt">
                                        <input type='hidden' id='order_id_hidden'>
                                        <button style="float:left" id="open_receipt" class="btn btn-gray" onclick="open_receipt()">Show Receipt</button>
                                    </div>
                                @else 
                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left special_size" style="line-height:0.6cm">
                                        Customer
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 text-left special_size" style="line-height:0.6cm">
                                        :&nbsp;<span id="cust_name">{{$customer->name}}</span>
                                    </div>

                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left special_size" style="line-height:0.6cm">
                                        Address
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 text-left special_size" style="line-height:0.6cm">
                                        @php
                                            $id_address = \App\Http\Controllers\CustomerController::find_company_byId_first($order->id_address);
                                        @endphp
                                        :&nbsp;<span id="cust_name">{{$id_address->name." - ".$order->shipping_address}}</span>
                                    </div>
                                    @if ($shipment!=null)
                                    @if ($shipment->id_courier!='self')
                                    <div class="col-xs-4 col-md-4 col-lg-4 text-left special_size" style="line-height:0.6cm">
                                        Tracking No
                                    </div>
                                    <div class="col-xs-8 col-md-8 col-lg-8 text-left special_size" style="line-height:0.6cm">
                                        :&nbsp;<span id="cust_name">{{$shipment->tracking_no}}</span>
                                    </div>
                                    @endif

                                @endif
                                    
                               
                                {{-- <div class="col-xs-4 col-md-4 col-lg-4 text-left">
                                    Created By
                                </div>
                                <div class="col-xs-1 col-md-1 col-lg-1">
                                    :
                                </div>
                                <div class="col-xs-7 col-md-7 col-lg-7 text-left">
                                    <span id="created_by">{{$order->CREATED_BY}}</span>
                                </div> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top:0.3cm">
                        <div class="col-md-12">
                            {{-- <h3>ORDER SUMMARY</h3> --}}
                            <table class="table-manual-style" id="table_receipt" style="width:98%; @if ($modal_view ?? '')  @else font-size: 0.9em; @endif">
                                <thead>
                                    <tr class="line">
                                        <td class="text-center" style="width: 1%"><strong>NO</strong></td>
                                        <td class="text-left"   style="width: 5%"><strong>CODE</strong></td>
                                        <td class="text-left"   style="width: 25%"><strong>NAME</strong></td>
                                        <td class="text-center" style="width: 1%"><strong>QTY</strong></td>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @if ($modal_view ?? '')

                                    @else
                                        @php
                                            $total      = 0;
                                            $sub_total  = 0;
                                            $no = 0;
                                        @endphp
                                        @foreach ($order_detail as $item)
                                            @php
                                                $no ++;
                                                $sub_total += $item->qty*$item->price;
                                            @endphp
                                            <tr>
                                                <td class='text-center'>{{$no}}</td>
                                                <td>{{$item->id_product}}</td>
                                                <td>{{$item->name_product}}</td>
                                                <td class='text-center'>{{$item->qty}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class='row'>
                                <div class="col-md-6">
                                    <span id='remark'>
                                        @if ($modal_view ?? '')
                                            
                                        @else
                                            @if ($order->remark!='' && $order->remark!=null && !empty($order->remark)) 
                                                <div class='small special_size' style='margin-bottom:5%;margin-top:2%;font-size: 0.8em'>Remark, <br><b><p style="padding: 0px; margin:0px">@php  echo(nl2br(preg_replace('~\s*<br ?/?>\s*~',"<br />",$order->remark)));  @endphp</p></b></div>
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>									
                    </div>
                    @if ($modal_view ?? '')
                    <div class="row">
                        <div class="col-md-12" >
                            <button style="float: left;" id="delete_btn" class="btn btn-danger"  onclick="delete_trx()">DELETE</button>
                            <button style="float: right;" id="next_step" class="btn btn-success" onclick="next_step()"></button>
                            <input type="hidden" id="id_order" name="id_order">
                        </div>
                    </div>
                    @else
                    <div class="row" style="margin-top:0.5cm;margin-left:1cm"> 
                        <div class="col-md-5 col-lg-5 col-sm-5 text-center" style="outline: 1px solid black;">
                            <table class='table borderless'>
                                <tr class="borderless">
                                    <td colspan="2">Tanda Terima Barang (paraf)</td>
                                </tr>
                                <tr>
                                    <td colspan='2'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>tgl :</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>jam :</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Nama :</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan='2'>&nbsp;</td>
                                </tr>
                            </table>
                            {{-- <p style="line-height:0.7cm;border-top: 0.2px solid rgb(0, 0, 0);position: absolute; bottom: -2.5cm;margin-left: auto;margin-right: auto;left: 0;right: 2cm;">Received</p> --}}
                        </div>
                        <div class="col-md-4 text-center identity">
                           
                        </div>
                        <div class="col-md-3 text-center identity" style='position: relative;'>
                            <p style="position: relative; bottom: -1.5cm;margin-left: auto;margin-right: auto;left: 0;right: 2cm;">{{$order->CREATED_BY}}</p>
                            <p style="line-height:0.7cm;border-top: 0.2px solid rgb(0, 0, 0);position: relative; bottom: -1.5cm;margin-left: auto;margin-right: auto;left: 0;right: 2cm;">Issued By</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- END INVOICE -->
    </div>
</div>