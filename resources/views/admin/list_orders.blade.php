@extends('template_admin.template')

@section('Content')
<?php
  if (!isset($_GET["status"])) {
    $_GET["status"] = 9;
  }
?>
<style>
  .input-group-addon {
    padding-right: 3%;
    padding-left : 3%;
    /* width        : 10%; */
    /* display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column; */
  }
  .input-daterange{
    margin-left: 3%;
    /* display: flex;
    justify-content: center;
    align-content: center; */
    /* flex-direction: column; */
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">List Orders</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="list_datas" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
            <thead class=" text-primary">
              <th class='text-left'>
                ID
              </th>
              <th class='text-left'>
                Name
              </th>
              <th class='text-left'>
                Date Time
              </th>
              <th class='text-center'>
                Amount
              </th>
              {{-- <th class='text-center'>
                Profit
              </th> --}}
              <th class='text-center'>
                Status
              </th>
              <th class='text-center'>
                Details
              </th>
            </thead>
            <tbody id='main_table'>
              @foreach ($orders as $key => $value)
                <tr>
                    <td>{{$value->id}}</td>
                    @php
                      //  dd($orders);
                        $total_amount = 0;
                        $total_profit = 0;
                        // $customer = \App\Http\Controllers\CustomerController::find_byId($value->id_customer);
                    @endphp
                    <td>{{$value->name_customer}}</td>
                    <td>{{$value->CREATED_AT}}</td>
                    @foreach ($order_details as $key => $detail)
                      @php
                          if ($detail->id_order==$value->id){
                            $total_amount += (int) $detail->qty * (int) $detail->price;
                            $total_profit += (int) $detail->qty * ((int) $detail->price - (int) $detail->d_price);
                          }
                      @endphp
                    @endforeach
                    <td class='text-right'>Rp. {{number_format($total_amount,0,'','.')}}</td>
                    {{-- <td>Rp. {{number_format($total_profit,0)}}</td> --}}
                    <td class='text-center'>
                      @if ($value->status==0)
                        Draft
                      @elseif ($value->status==1)
                        Processed
                      @elseif ($value->status==2)
                        Ready Deliver
                      @elseif ($value->status==3)
                        Delivering
                      @elseif ($value->status==4)
                        Done
                      @elseif ($value->status==5)
                        Canceled Draft
                      @endif
                    </td>
                    <td class='text-center'>
                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="open_detail('{{$value->id}}')" >
                            <i class="material-icons">view_list</i>
                        </button>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xlg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id='modal_details'>
  <div class="modal-dialog modal-xlg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @php
            $modal_view = true;
        @endphp
        @include('admin.receipt')
      </div>
      
    </div>
  </div>
</div>
@endsection



<script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>
<script>

    $(document).ready(function () {
      load_table_setting();
    });

    function load_table_setting() {
      $("#list_datas").DataTable({
          searching: true,bLengthChange: false,rowReorder: true,ordering: false
        });
        var date1   = '<?= (isset($_GET["date1"]) ? $_GET["date1"] : date('Y-m-d')) ?>';
        var date2   = '<?= (isset($_GET["date2"]) ? $_GET["date2"] : date('Y-m-d')) ?>';
          
        $(".cust_filter").html(
          "<div class='form-group input-group input-daterange row'>"+
          "<div class='col-md-3'><input type='date' class='form-control date' data-date-format='DD MMMM YYYY' name='date1' id='date1' value="+date1+"></div>"+
          "<div class='col-md-1 form-group input-group-addon' style='font-size: 10px;'>To</div>"+
          "<div class='col-md-3'><input type='date' class='form-control date' data-date-format='DD MMMM YYYY' name='date2' id='date2' value="+date2+"></div>"+
          "<div class='col-md-3 form-group' style='margin-left:3%;margin-right:3%;'>"+
          "<select class='form-controls selectpickers' data-style='btn btn-link' id='status_filter' style='width:100%'>"+
          "<option value='9' <?=$_GET['status']=='9'?'selected':''?> >&nbsp;ALL</option>"+
          "<option value='0' <?=$_GET['status']=='0'?'selected':''?>>&nbsp;Draft</option>"+
          "<option value='1' <?=$_GET['status']=='1'?'selected':''?>>&nbsp;Processed</option>"+
          "<option value='2' <?=$_GET['status']=='2'?'selected':''?>>&nbsp;Ready Deliver</option>"+
          "<option value='3' <?=$_GET['status']=='3'?'selected':''?>>&nbsp;Delivering</option>"+
          "<option value='4' <?=$_GET['status']=='4'?'selected':''?>>&nbsp;Done</option>"+
          "<option value='5' <?=$_GET['status']=='5'?'selected':''?>>&nbsp;Cancel</option>"+
          "</select></div>"+
          "<div class='col-md-1'><button style='margin-left:15%' class='btn btn-default btn-sm' id='btn_date_filter' onclick='go_filter_date()'>Go</button></div>"+
          "</div>");
    }
    
    // var date1 = "<?php echo (isset($_GET["date1"]) ? "date1=".$_GET["date1"] : "") ?>";
    // var date2 = "<?php echo (isset($_GET["date2"]) ? "date2=".$_GET["date2"] : "") ?>";
    // var status = "<?php echo (isset($_GET["status"]) ? "status=".$_GET["status"] : "") ?>";
    
    function go_filter_date() {
      var date1 = $("#date1").val();
      var date2 = $("#date2").val();
      var status= $("#status_filter").val();
      var url = "{{ action('App\Http\Controllers\OrderController@list_orders',':parameter') }}";
      url = url.replace(":parameter", "date1="+date1+"&date2="+date2+"&status="+status);
      window.location=url;
    }
    

    function numOnly(event) {
      var key = event.keyCode;
      return ((key >= 48 && key <= 57) || key == 8 || key==32 || key==37 || key==39);
    };

    function open_delete(id,name) {
      id   = id.replace(/%20/g, " ");
      name = name.replace(/%20/g, " ");
      $("#id_delete").val(id);
      $("#modal_delete_info").html("("+name+")");
      $("#modal_delete").modal('show');
    }

    function go_delete() {
      var id = $("#id_delete").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('delete_order')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                if (data.success){
                  window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
                }
            },
        });
    }

    function delete_trx() {
        open_delete($("#id_order").val(),$("#id_order").val());
    }

    function update_date_order() {
      var order_id = $("#order_id_hidden").val();
      var date_val = $("#update_date_id").val();
      if (confirm('Update date this order?')) {
      // SET DONE THE ORDER
      $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('update_date')}}",
            data: {
                "_token"        : "{{ csrf_token() }}",
                'id'            : order_id,
                'date_val'      : date_val,
            },
            success: function (data) {
              // var data = $.parseJSON(data);
              // console.log(data);
              window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
            },
        });
        // END OF SET DONE THE ORDER
      } else {
        return false;
      }
    }

    var sub_total = 0;
    function open_detail(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('find_order_byId')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                data = $.parseJSON(data);
                console.log(data);
                var order   = data.order;
                var detail  = data.detail;
                var couriers= data.couriers;
                $("#order_id").html(order.id);
                $("#order_id_hidden").val("");
                $("#order_id_hidden").val(order.id);
                $("#date_id").html(order.CREATED_AT);
                $("#cust_name").html(order.name);
                $("#created_by").html(order.CREATED_BY);
                $("#table_body").html();
                var html_body = "";
                var total = 0;
                var html_shipping_fee = "";
                var shipment = data.shipment;
                $(".receipt").show();
                $("#update_date_id").val((order.CREATED_AT).substring(0, 10));

                for (var x = 0; x < detail.length; x++) {
                  var style_tr = "";
                  if (x==detail.length-1){
                    style_tr = "line ";
                  }
                  total += parseInt(detail[x]['qty'])*parseInt(detail[x]['price']);
                  
                  var html_input_invoices = "";
                  var shipment_html = "";

                  if (data.has_sent){
                    var shipment_method = data.shipment;
                    console.log(shipment_method);
                    if (shipment_method.id_courier=='self'){
                      shipment_html = "Self Pick-up";
                    } else {
                      var courier_selected = couriers.find(couriers => couriers.id == shipment.id_courier);
                      console.log(courier_selected);
                      shipment_html = courier_selected.name;
                    }
                  } else {
                    shipment_html +=  "<select class='form-control' id='courier_' name='courier_' onchange=check_shipping_fee()><option selected disabled value=''>Choose Delivery Courier</option><option value='self'>Self Pick Up</option>";
                    for (var xx = 0; xx < couriers.length; xx++) {
                      shipment_html += "<option value='"+couriers[xx]['id']+"'>"+couriers[xx]['name']+"</option>";
                    }
                    shipment_html +=  "</select>"
                  }
                  $(".shipment_").html(shipment_html);
                  if (detail[x]['id_invoices_details']==null || detail[x]['id_invoices_details']=='' && order.status==0){
                    style_tr += " draft_tr";
                    var invoice_price = "<td><input class='price_mask' id='price_"+detail[x]['id_product']+"' type='text' value='Rp. "+addCommas(detail[x]['d_price'])+"' data-id='"+detail[x]['id_product']+"' data-cprice='"+detail[x]['price']+"' onkeydown='return numOnly(event)' onkeyup=format_currency(this,event) size='10'></td>";
                    html_input_invoices = "<td class='text-center'><input type='text' class='invoices_input' id='invoices_"+detail[x]['id_product']+"' name='invoices_"+detail[x]['id_product']+"' size='7' onChange=CheckInputInvoices(this) data-code='"+detail[x]['id_product']+"' data-orderid='"+order.id+"'></td>";
                    // $(".draft_th").show();
                    $("#draft_th").html("ADD INVOICE");
                  } else {
                    // $(".draft_th").hide();
                    $("#draft_th").html("INVOICE");
                    style_tr += " processed_tr";
                    var invoice_price = "<td>Rp. "+addCommas(detail[x]['d_price'])+"</td>";
                    html_input_invoices = "<td class='text-center'>"+detail[x]['id_invoices_details']+"</td>";
                  }
                  html_body += "<tr class='"+style_tr+" class_"+detail[x]['id_product']+"'><td>"+detail[x]['id_product']+"</td><td>"+detail[x]['name_product']+"</td><td class='text-center'>"+detail[x]['qty']+"</td><td class='text-center'>Rp. "+addCommas(detail[x]['price'])+"</td>"+invoice_price+"<td class='text-right'>Rp. "+addCommas(parseInt(detail[x]['qty'])*parseInt(detail[x]['price']))+"</td>"+html_input_invoices+"</tr>";
                }

                var colspan = "<td></td>";
                if (order.status==0){
                  $(".receipt").hide();
                  $(".surat_jalan_div").show();
                  $(".tracking_no_").show();
                  $(".surat_jalan_no_").show();
                  $("#tracking_no_value").show();
                  $("#tracking_no_display").html("");
                  // $("#surat_jalan_display").html("");
                  
                  $("#surat_jalan_value").show();

                  $("#next_step").show();
                  $("#delete_btn").show();
                  $(".processed_date").hide();
                  var draft_date = data.draft_date;
                  if (draft_date!=null){
                    $("#draft_date_id").html(draft_date.CREATED_AT+" ("+draft_date.CREATED_BY+")");
                  }
                  $(".processed_date").hide();
                  $(".ready_delivery_date").hide();
                  $(".delivery_date").hide();
                  $(".done_date").hide();

                  $("#next_step").html("PROCESS");
                } else if (order.status==1){
                  $(".tracking_no_").show();
                  $(".surat_jalan_no_").show();
                  $("#tracking_no_display").html("");
                  // $("#surat_jalan_display").html("");
                  if (data.shipment!=null){
                    if (data.shipment.remark==null || data.shipment.remark==""){
                      $("#surat_jalan_display").hide();
                      $("#surat_jalan_value").show();
                    } else {
                      $("#surat_jalan_display").show();
                      $("#surat_jalan_value").hide();
                      $("#surat_jalan_display").html("");
                      $("#surat_jalan_display").html(data.shipment.remark);
                    }
                  } else {
                    $("#tracking_no_value").show();
                    $("#surat_jalan_value").show();
                  }
                  
                  var paid_date = data.paid_date;
                  if (paid_date!=null){
                    $("#paid_date_id").html(paid_date.CREATED_AT+" ("+paid_date.CREATED_BY+")");
                    $(".processed_date").show();
                  }
                  var draft_date = data.draft_date;
                  if (draft_date!=null){
                    $("#draft_date_id").html(draft_date.CREATED_AT+" ("+draft_date.CREATED_BY+")");
                  }

                  $(".ready_delivery_date").hide();
                  $(".delivery_date").hide();
                  $(".done_date").hide();

                  $("#delete_btn").hide();
                  $("#next_step").show();
                  $("#next_step").html("SET ORDER DELIVERING");
                } else if (order.status==2){
                  $(".tracking_no_").show();
                  $(".surat_jalan_no_").show();
                  $("#tracking_no_value").show();
                  $("#surat_jalan_value").show();

                  var ready_date = data.ready_date;
                  console.log("ready_date",ready_date.CREATED_AT);
                  if (ready_date!=null){
                    $("#ready_delivery_date_id").html(ready_date.CREATED_AT+" ("+ready_date.CREATED_BY+")");
                    $(".ready_delivery_date").show();
                  }
                  var paid_date = data.paid_date;
                  if (paid_date!=null){
                    $("#paid_date_id").html(paid_date.CREATED_AT+" ("+paid_date.CREATED_BY+")");
                    $(".processed_date").show();
                  }
                  var draft_date = data.draft_date;
                  if (draft_date!=null){
                    $("#draft_date_id").html(draft_date.CREATED_AT+" ("+draft_date.CREATED_BY+")");
                  }

                  var shipment_method = data.shipment;
                  if (shipment_method.id_courier=='self'){
                    $(".tracking_no_").hide();
                    $("#tracking_no_value").hide();
                    $("#surat_jalan_value").hide();
                  } 

                  if (data.shipment!=null){
                    if (data.shipment.remark==null || data.shipment.remark==""){
                      $("#surat_jalan_display").hide();
                      $("#surat_jalan_value").show();
                    } else {
                      $("#surat_jalan_display").show();
                      $("#surat_jalan_value").hide();
                      $("#surat_jalan_display").html("");
                      $("#surat_jalan_display").html(data.shipment.remark);
                    }
                  } else {
                    $("#tracking_no_value").show();
                    $("#surat_jalan_value").show();
                  }

                  $(".delivery_date").hide();
                  $(".done_date").hide();

                  $("#delete_btn").hide();
                  $("#next_step").show();
                  $("#next_step").html("SET ORDER DELIVERING");

                } else if (order.status==3){
                  $(".tracking_no_").show();
                  $(".surat_jalan_no_").show();
                  $("#tracking_no_display").html("");
                  $("#tracking_no_display").html(data.shipment.tracking_no);
                  $("#tracking_no_value").hide();
                  $("#surat_jalan_value").hide();
                  var delivering_date = data.delivering_date;
                  if (delivering_date!=null){
                    $("#delivery_date_id").html(delivering_date.CREATED_AT+" ("+delivering_date.CREATED_BY+")");
                    $(".delivery_date").show();
                  }

                  var ready_date = data.ready_date;
                  if (ready_date!=null){
                    $("#ready_delivery_date_id").html(ready_date.CREATED_AT+" ("+ready_date.CREATED_BY+")");
                    $(".ready_delivery_date").show();
                  }
                  var paid_date = data.paid_date;
                  if (paid_date!=null){
                    $("#paid_date_id").html(paid_date.CREATED_AT+" ("+paid_date.CREATED_BY+")");
                    $(".processed_date").show();
                  }
                  var draft_date = data.draft_date;
                  if (draft_date!=null){
                    $("#draft_date_id").html(draft_date.CREATED_AT+" ("+draft_date.CREATED_BY+")");
                  }

                  var shipment_method = data.shipment;
                  if (shipment_method.id_courier=='self'){
                    $(".tracking_no_").hide();
                    $("#tracking_no_value").hide();
                    $("#surat_jalan_value").hide();
                  } 

                  if (data.shipment!=null){
                    if (data.shipment.remark==null || data.shipment.remark==""){
                      $("#surat_jalan_display").hide();
                      $("#surat_jalan_value").show();
                    } else {
                      $("#surat_jalan_display").show();
                      $("#surat_jalan_value").hide();
                      $("#surat_jalan_display").html("");
                      $("#surat_jalan_display").html(data.shipment.remark);
                    }
                  } else {
                    $("#tracking_no_value").show();
                    $("#surat_jalan_value").show();
                  }

                  $(".done_date").hide();

                  $("#delete_btn").hide();
                  $("#next_step").show();
                  $("#next_step").html("SET AS DONE");
                } else if (order.status==4){
                  $(".tracking_no_").show();
                  $(".surat_jalan_no_").show();
                  $(".receipt").show();
                  $("#tracking_no_value").hide();
                  $("#tracking_no_display").html("");
                  $("#tracking_no_display").html(data.shipment.tracking_no);

                  var done_date = data.done_date;
                  if (done_date!=null){
                    $("#done_date_id").html(done_date.CREATED_AT+" ("+done_date.CREATED_BY+")");
                    $(".done_date").show();
                  }

                  var delivering_date = data.delivering_date;
                  if (delivering_date!=null){
                    $("#delivery_date_id").html(delivering_date.CREATED_AT+" ("+delivering_date.CREATED_BY+")");
                    $(".delivery_date").show();
                  }

                  var ready_date = data.ready_date;
                  if (ready_date!=null){
                    $("#ready_delivery_date_id").html(ready_date.CREATED_AT+" ("+ready_date.CREATED_BY+")");
                    $(".ready_delivery_date").show();
                  }
                  var paid_date = data.paid_date;
                  if (paid_date!=null){
                    $("#paid_date_id").html(paid_date.CREATED_AT+" ("+paid_date.CREATED_BY+")");
                    $(".processed_date").show();
                  }
                  var draft_date = data.draft_date;
                  if (draft_date!=null){
                    $("#draft_date_id").html(draft_date.CREATED_AT+" ("+draft_date.CREATED_BY+")");
                  }

                  var shipment_method = data.shipment;
                  if (shipment_method.id_courier=='self'){
                    $(".tracking_no_").hide();
                    $("#tracking_no_value").hide();
                  } 

                  if (data.shipment!=null){
                    if (data.shipment.remark==null || data.shipment.remark==""){
                      $("#surat_jalan_display").hide();
                      $("#surat_jalan_value").show();
                    } else {
                      $("#surat_jalan_display").show();
                      $("#surat_jalan_value").hide();
                      $("#surat_jalan_display").html("");
                      $("#surat_jalan_display").html(data.shipment.remark);
                    }
                  } else {
                    // $("#tracking_no_value").show();
                    $("#surat_jalan_value").show();
                  }

                  $("#delete_btn").hide();
                  $("#next_step").hide();
                } 
                if (data.has_sent){
                  total += shipment.shipping_cost;
                  html_body += "<tr class='shipping_fee'><td colspan='2'></td><td colspan='3' class='text-right'><strong>Shipping Fee</strong></td><td class='text-right'>Rp. "+addCommas(shipment.shipping_cost)+"</td>"+colspan+"</tr>";
                } else {
                  html_body += "<tr class='shipping_fee'><td colspan='2'></td><td colspan='3' class='text-right'><strong>Shipping Fee</strong></td><td class='text-right'><input id='shipping_fee_input' type='text' value='Rp. "+addCommas(0)+"' onkeydown='return numOnly(event)' onkeyup=format_currency(this,event,false) size='10'></tr>";
                }
                sub_total = total;
                html_body += "<tr><td colspan='2'></td><td colspan='3' class='text-right'><strong>Total</strong></td><td class='text-right' id='total_'>Rp. "+addCommas(total)+"</td>"+colspan+"</tr>";
                $("#id_order").val(id);
                
                $("#table_body").html(html_body);
                
                if (data.has_sent){
                  $(".shipping_fee").show();
                } else {
                  $(".shipping_fee").hide();
                }

                $("#remark").html("");
                if (order.remark!=null && order.remark!=""){
                  $("#remark").html("<div class='small' style='margin-bottom:5%'>Remark, <br><b>"+order.remark+"</b></div>");
                }
                
                $("#modal_details").modal('show');

                // if (order.status!=0){
                //   $(".draft_th").hide();
                // } else {
                //   $(".draft_th").show();
                // }
            },
        });
    }
    
    function open_receipt() {
      var id = $("#order_id_hidden").val();
      var win   = window.open("{{ route('show_receipt','id') }}"+"="+id, "_blank");   
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
    }

    function open_surat_jalan() {
      var id = $("#order_id_hidden").val();
      var win   = window.open("{{ route('show_suratjalan','id') }}"+"="+id, "_blank");   
      if (win) {
          //Browser has allowed it to be opened
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
    }

    function check_shipping_fee(){
      if ($("#courier_").val()!='' && $("#courier_").val()!='self'){
        $(".shipping_fee").show();
        // $("#shipping_fee_input").val("Rp. "+addCommas(0));
      } else {
        $(".shipping_fee").hide();
        $("#shipping_fee_input").val("Rp. "+addCommas(0));
        $("#total_").html("Rp. "+addCommas(sub_total));
      }
    }

    $('.invoices_input').on('keypress', function(e) {
        if (e.keyCode == '13') {
            e.preventDefault();
            CheckInputInvoices($(this));
        };
    });

    function format_currency(sel,event,checking_=true) {
      var key = event.keyCode;
      var valid = true;
      if (key==37 || key==39 ) { // up key
          return false;
      } 

      if (checking_){
        var current_value = $(sel).val();
        var prdcd      = $(sel).attr('data-id');
        var cprice  = $(sel).attr('data-cprice');
        current_value = current_value.replace("Rp. ","");
        current_value = current_value.replace(/\./g,"");

        var invoice = $("#invoices_"+prdcd).val();
        invoice     = invoice.replace(/\s/g,"");
        
        if (isNaN(current_value)){
          current_value = 0;
          valid = false
        }
        if (current_value>parseInt(cprice)){
          valid = false;
          $(".class_"+prdcd).removeClass("draft_tr_done").addClass("draft_tr");
          alert("Minimum Invoice price is equal with selling price ("+prdcd+")!");
        } else if (invoice!="" && invoice!=null){
          $(".class_"+prdcd).removeClass("draft_tr").addClass("draft_tr_done");
        } else {
          $(".class_"+prdcd).removeClass("draft_tr_done").addClass("draft_tr");
          
        }
        current_value = addCommas(parseInt(current_value));
        $(sel).val("Rp. "+current_value);
        return valid;
      } else {
        var current_value = $(sel).val();
        current_value = current_value.replace("Rp. ","");
        current_value = current_value.replace(/\./g,"");

        if (isNaN(current_value)){
          current_value = 0;
          valid = false
        }
        $("#total_").html("Rp. "+addCommas(parseInt(sub_total)+parseInt(current_value)));
        current_value = addCommas(parseInt(current_value));
        $(sel).val("Rp. "+current_value);
      }
      
    }

    function CheckInputInvoices(sel) {
      console.log($(sel).val());
      var prdcd   = $(sel).attr('data-code');
      var trcd    = $(sel).attr('data-orderid');
      var invoice = $(sel).val();
      invoice     = invoice.replace(/\s/g,"");

      var current_value = $("#price_"+prdcd).val();
      var cprice        = $("#price_"+prdcd).attr('data-cprice');
      current_value     = current_value.replace("Rp. ","");
      current_value     = current_value.replace(/\./g,"");
      // console.log("current_value",current_value);
      // console.log("cprice",cprice);
      if (invoice==""||invoice==null){
        $(".class_"+prdcd).removeClass("draft_tr_done").addClass("draft_tr");
        alert("Please Fill up invoice for product "+prdcd);
        return false;
      } else if (parseInt(current_value)<parseInt(cprice)){
        $(".class_"+prdcd).removeClass("draft_tr").addClass("draft_tr_done");
      } else {
        $(".class_"+prdcd).removeClass("draft_tr_done").addClass("draft_tr");
        alert("Minimum Invoice price is equal with selling price!");
        return false;
      }
    }

    function next_step() {
      var id = $("#id_order").val();
      var array_invoices = [];
      var valid = true;
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          url: "{{route('find_order_byId')}}",
          data: {
              "_token": "{{ csrf_token() }}",
              'id': id
          },
          success: function (data) {
              data = $.parseJSON(data);
              console.log(data);
              var order   = data.order;
              var detail  = data.detail;
              var shipping_fee = $("#shipping_fee_input").val();
              if (shipping_fee!=null && shipping_fee!="" && shipping_fee!=undefined){
                shipping_fee     = shipping_fee.replace("Rp. ","");
                shipping_fee     = shipping_fee.replace(/\./g,"");
              }
              
              
              if (order.status==0){
                $('.invoices_input').each(function(){
                  // console.log($(this).val());
                  // console.log($(this).attr('data-code'));
                  // console.log($(this).attr('data-orderid'));
                  var obj = {};
                  
                  var prdcd = $(this).attr('data-code');
                  var current_value = $("#price_"+prdcd).val();
                  var cprice        = $("#price_"+prdcd).attr('data-cprice');
                  current_value     = current_value.replace("Rp. ","");
                  current_value     = current_value.replace(/\./g,"");
                  
                  if (parseInt(current_value)>parseInt(cprice)){
                    alert("Minimum Invoice price is equal with selling price ("+prdcd+")!");
                    valid = false;
                    return false;
                  }

                  if ($(this).val().replace(/\s/g,"")=='' || $(this).val()==null){
                    $(this).focus();
                    alert("Please Fill up invoice for product "+$(this).attr('data-code'));
                    valid = false;
                    return false;
                  } else {
                    obj['invoice']      = $(this).val();
                    obj['d_price']      = current_value;
                    obj['code']         = $(this).attr('data-code');
                    obj['orderid']      = $(this).attr('data-orderid');
                    array_invoices.push(obj);
                  }
                })

                if (valid){
                  if (confirm('Update the invoices and generate order?')) {
                  // INSERT THE INVOICES
                  $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        url: "{{route('process_order')}}",
                        data: {
                            "_token"        : "{{ csrf_token() }}",
                            'id'            : id,
                            'array_invoices':JSON.stringify(array_invoices),
                            'courier'       : $("#courier_").val(),
                            'shipping_fee'  : shipping_fee,
                            'tracking_no'   : $("#tracking_no_value").val(),
                        },
                        success: function (data) {
                          // var data = $.parseJSON(data);
                          // console.log(data);
                          window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
                        },
                    });
                    // END OF INSERT INVOICES
                  } else {
                    return false;
                  }
                }
                
                
                
              }
              if (order.status==1){
                if ($("#courier_").val()==null){
                  alert("Please select shipping method!");
                  valid = false;
                  return false;
                } else {
                  if (($("#tracking_no_value").val()==""||$("#tracking_no_value").val()==null)&&$("#courier_").val()!='self'){
                    alert("Please fill the tracking number!");
                    valid = false;
                    return false;
                  }
                }
                if (valid){
                  var confirm_msg = "";
                  if ($("#courier_").val()=='self'){
                    confirm_msg = 'Update this order to self pick up?';
                  } else {
                    confirm_msg = 'Update the tracking number of this order?';
                  }
                  if (confirm(confirm_msg)) {
                  // INSERT THE TRACKING NO
                  $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        url: "{{route('process_order')}}",
                        data: {
                            "_token"        : "{{ csrf_token() }}",
                            'id'            : id,
                            'array_invoices': null,
                            'courier'       : $("#courier_").val(),
                            'shipping_fee'  : shipping_fee,
                            'tracking_no'   : $("#tracking_no_value").val(),
                        },
                        success: function (data) {
                          // var data = $.parseJSON(data);
                          // console.log(data);
                          window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
                        },
                    });
                    // END OF INSERT TRACKING NO
                  } else {
                    return false;
                  }
                }
              }
              if (order.status==2){
                if (valid){
                  if (confirm('Update the tracking number of this order?')) {
                  // INSERT THE TRACKING NO
                  $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        url: "{{route('process_order')}}",
                        data: {
                            "_token"        : "{{ csrf_token() }}",
                            'id'            : id,
                            'array_invoices': null,
                            'courier'       : null,
                            'shipping_fee'  : null,
                            'tracking_no'   : $("#tracking_no_value").val(),
                        },
                        success: function (data) {
                          // var data = $.parseJSON(data);
                          // console.log(data);
                          window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
                        },
                    });
                    // END OF INSERT TRACKING NO
                  } else {
                    return false;
                  }
                }
              }
              if (order.status==3){
                if (valid){
                  if (confirm('Set Done this order?')) {
                  // SET DONE THE ORDER
                  $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        url: "{{route('process_order')}}",
                        data: {
                            "_token"        : "{{ csrf_token() }}",
                            'id'            : id,
                            'array_invoices': null,
                            'courier'       : null,
                            'shipping_fee'  : null,
                            'tracking_no'   : null,
                            'done'          : true,
                        },
                        success: function (data) {
                          // var data = $.parseJSON(data);
                          // console.log(data);
                          window.location.href = "{{ action('App\Http\Controllers\OrderController@list_orders') }}";
                        },
                    });
                    // END OF SET DONE THE ORDER
                  } else {
                    return false;
                  }
                }
              }
          },
      });
      
    }

</script>