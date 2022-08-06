@extends('template_admin.template')

@section('Content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">List Products
          <button type="button" class="btn btn-success" style="float:right" onclick="open_modal_create()">ADD NEW PRODUCT</button>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive" style="overflow-x:auto;">
          <table id="list_datas" class="table table-no-bordered table-hover dataTable dtr-inline table-bordered" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
            <thead class=" text-primary thead-light">
              <th class='text-left'>
                ID
              </th>
              <th class='text-left product_name_th' width='25%'>
                Name
              </th>
              <th class='text-left'>
                Price
              </th>
              <th class='text-left'>
                Brand
              </th>
              <th class='text-left'>
                Supplier
              </th>
              {{-- <th class='text-center'>
                Edit
              </th> --}}
              <th class='text-center' width='10%'>
                &nbsp;
              </th>
            </thead>
            <tbody id='main_table'>
              @foreach ($products as $key => $value)
                <tr id="tr_{{$value->id}}">
                    {{-- var string_html = '';
                    for (var x = 0; x < data.data.length; x++) {
                      // data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                      var price = "<td>Rp. "+addCommas(data.data[x]['customer_price'])+"</td>";
                      var id = data.data[x]['id'].replace(/\s/g,"%20");
                      var price = "<td><input class='price_mask' id='price_"+id+"' type='text' value='Rp. "+addCommas(data.data[x]['customer_price'])+"' data-id='"+data.data[x]['id']+"' onkeydown='return numOnly(event)' onkeyup=format_currency(this,event)></td>";
                      var name = data.data[x]['name'].replace(/\s/g,"%20");
                      var btn_del = "<td class='text-center'><button id='btn_"+id+"' class='btn btn-success btn-fab btn-fab-mini btn-round' onclick=add_to_cart(this) data-id='"+data.data[x]['id']+"' data-name='"+data.data[x]['name']+"' data-price='"+data.data[x]['customer_price']+"' data-dprice='"+data.data[x]['supplier_price']+"' data-brand='"+data.data[x]['brand']+"'><i class='material-icons'>add</i></button></td>";
                      string_html += "<tr><td>"+data.data[x]['id']+"</td><td style='width:40%'>"+data.data[x]['name']+"</td>"+price+"<td>"+data.data[x]['brand']+"</td><td style='width:10%'><input type='number' class='form-control' id='qty_"+data.data[x]['id']+"' name='qty_"+data.data[x]['id']+"' value=0 onkeydown='return numOnly(event);' min='0'></td>"+btn_del+"</tr>";
                    } --}}

                    {{-- <input type='hidden' name='customer_price_{{$value->id}}' id='customer_price_{{$value->id}}' value='{{$value->customer_price}}'>
                    <input type='hidden' name='distributor_price_{{$value->id}}' id='distributor_price_{{$value->id}}' value='{{$value->supplier_price}}'> --}}
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}<br>
                      @if ($value->description!=null)
                        <span style="font-size: 0.5em;background-color:rgba(214, 205, 205, 0.842);padding:0.5%">{{$value->description}}</span>
                      @endif
                    </td>
                    <td>
                      <table class="table table-striped table-no-bordered table-hover dtr-inline table-bordered small">
                        <tr style="background-color:rgb(130, 255, 146);">
                          {{-- <td>Customer Price : </td>
                          <td>
                              <input class='price_mask draft_tr_done' id='supplier_price_{{$value->id}}' type='text' value='Rp. {{number_format($value->customer_price,0,',','.')}}' data-id='{{$value->id}}' data-price='{{$value->customer_price}}' onkeydown='return numOnly(event)' onkeyup=format_currency(this,event)>
                          </td> --}}
                          <td>Customer Price : </td><td>Rp. {{number_format($value->customer_price,0)}}</td>
                        </tr>
                        <tr style="background-color:rgb(253, 255, 121);">
                          {{-- <td>Distributor Price : </td>
                          <td>
                              <input class='price_mask draft_tr_done' id='distributor_price_{{$value->id}}' type='text' value='Rp. {{number_format($value->supplier_price,0,',','.')}}' data-id='{{$value->id}}' data-price='{{$value->supplier_price}}' onkeydown='return numOnly(event)' onkeyup=format_currency(this,event)>
                          </td> --}}
                          <td>Distributor Price : </td><td>Rp. {{number_format($value->supplier_price,0)}}</td>
                        </tr>
                        <tr style="background-color:rgba(255, 199, 199, 0.863);">
                          <td >Margin : </td><td>Rp. {{number_format($value->customer_price-$value->supplier_price,0,',','.')}}</td>
                        </tr>
                      </table>
                    </td>
                    <td>{{$value->brand}}</td>
                    @php
                        $Supplier_info = \App\Http\Controllers\SupplierController::find_byId($value->id_supplier);
                    @endphp
                    <td>{{$Supplier_info->name}}</td>
                    {{-- <td class='text-center'>
                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="open_detail('{{$value->id}}')">
                            <i class="material-icons">view_list</i>
                        </button>
                    </td> --}}
                    <td class='text-center div_delete div_delete_{{$value->id}}' >
                      <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="open_detail('{{$value->id}}')">
                        <i class="material-icons">view_list</i>
                      </button>
                      <button class="btn btn-danger btn-fab btn-fab-mini btn-round" onclick="open_delete('{{$value->id}}','{{$value->name}}')">
                          <i class="material-icons">delete</i>
                      </button>
                    </td>
                    {{-- <td class='text-center div_save div_save_{{$value->id}}' style="display:none">
                      <button class="btn btn-success btn-fab btn-fab-mini btn-round" onclick="open_save('{{$value->id}}','{{$value->name}}')">
                          <i class="material-icons">save</i>
                      </button>
                    </td> --}}
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id='modal_details'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Contact Person</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
              <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Phone 1</th>
                  <th class="text-left">Phone 2</th>
                  <th class="text-left">Email</th>
              </tr>
          </thead>
          <tbody id='modal_details_body'>
              {{-- <tr>
                  <td class="text-left">Amin</td>
                  <td class="text-left">085236057632</td>
                  <td class="text-left"></td>
                  <td class="td-actions text-right">
                      <button type="button" rel="tooltip" class="btn btn-fab btn-info">
                          <i class="material-icons">person</i>
                      </button>
                      <button type="button" rel="tooltip" class="btn btn-fab btn-success">
                          <i class="material-icons">edit</i>
                      </button>
                      <button type="button" rel="tooltip" class="btn btn-fab btn-danger">
                          <i class="material-icons">close</i>
                      </button>
                  </td>
              </tr> --}}
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="" id='modal_create'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title card-title-editable">Add New Product</h4>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" id="form_modal_create">
                        <div class="card-body">

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                
                                <input type="text" name='id' id='product-id' class="form-control input_form" placeholder="ID...">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="weight" value="1">
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="material-icons">create</i></div>
                                  </div>
                                  <input type="text" name='name' id='product-name' class="form-control input_form" placeholder="Name...">
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text"><i class="material-icons">paid</i></div>
                                        </div>
                                        <input type="text" name='customer_price' id='product-cprice' class="form-control input_form" placeholder="Customer Price..." onkeydown="return numOnly(event,this.value,'sup-cprice');">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text"><i class="material-icons">paid</i></div>
                                        </div>
                                        <input type="text" name='supplier_price' id='product-sprice' class="form-control input_form" placeholder="Distributor Price..." onkeydown="return numOnly(event,this.value,'sup-dprice');">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                <textarea type="text" name='description' id='product-desc' class="form-control input_form" placeholder="Description..." rows="3"></textarea>
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                <input type="text" name='brand' id='product-brand' class="form-control input_form" placeholder="Brand...">
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                <select name='unit' id='product-unit' class="form-select form-control input_form" aria-label="Default select example">
                                  <option selected disabled>-- SELECT UNIT--</option>
                                  <option value='unit'>UNIT</option>
                                  <option value='pc'>PC</option>
                                  <option value='set'>SET</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                <select name='id_category' id='product-cat' class="form-select form-control input_form" aria-label="Default select example">
                                  <option selected disabled>-- SELECT CATEGORY--</option>
                                  @foreach ($categories as $category)
                                      <option value='{{$category->id}}'>{{$category->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">create</i></div>
                                </div>
                                <select name='id_supplier' id='product-supid' class="form-select form-control input_form" aria-label="Default select example">
                                  <option selected disabled>-- SELECT SUPPLIER--</option>
                                  @foreach ($suppliers as $supplier)
                                      <option value='{{$supplier->id}}'>{{$supplier->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                        </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='product-save' onclick="save_data()">Save</button>
                    <button type="button" class="btn btn-primary" id='product-update' onclick="update_data()">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>
<script>
    @php
      if (!isset($_GET["status"])) {
        // $_GET["status"] = 9;
      }
    @endphp
    
    function load_table_setting() {
      $("#list_datas").DataTable({
          searching: true,bLengthChange: false,rowReorder: true,ordering: false
        });
        var supplier_p    = '<?= (isset($_GET["supplier"]) ? $_GET["supplier"] : "ALL") ?>';
        var brand_p       = '<?= (isset($_GET["brand"]) ? $_GET["brand"] : "ALL") ?>';
        var brands  = JSON.parse('<?= ($brands) ?>');
        var brand_options = "<option value='all'>ALL</option>";
        for (var x = 0; x < brands.length; x++) {
          var selected = "";
          if (brand_p==brands[x]['brand']){
            selected = "selected";
          }
          brand_options += "<option "+selected+" value='"+brands[x]['brand']+"'>"+brands[x]['brand']+"</option>";
        }
        var suppliers         = JSON.parse('<?= ($suppliers) ?>');
        var suppliers_option  = "<option value='all'>ALL</option>";
        for (var x = 0; x < suppliers.length; x++) {
          var selected = "";
          if (supplier_p==suppliers[x]['id']){
            selected = "selected";
          }
          suppliers_option += "<option "+selected+" value='"+suppliers[x]['id']+"'>"+suppliers[x]['name']+"</option>";
        }

        $(".cust_filter").html(
          "<div class='form-group input-group input-daterange row'>"+
            "<div class='col-md-2 form-group' style='float:left;'>Supplier</div>"+
          "<div class='col-md-3 form-group' style='margin-right:3%;'>"+
          "<select class='form-controls selectpickers' data-style='btn btn-link' id='supplier_filter' style='width:100%'>"+
          suppliers_option+
          "</select></div>"+
          "<div class='col-md-2 form-group' style='float:left;'>Brand</div>"+ 
          "<div class='col-md-3 form-group' style='margin-right:3%;'>"+
          "<select class='form-controls selectpickers' data-style='btn btn-link' id='brand_filter' style='width:100%'>"+
          brand_options+
          "</select></div>"+
          "<div class='col-md-1'><button style='margin-left:15%' class='btn btn-default btn-sm' id='btn_date_filter' onclick='go_filter_product()'>Go</button></div>"+
          "</div>");
    }

    function go_filter_product() {
      var supplier_filter = $("#supplier_filter").val();
      var brand_filter    = $("#brand_filter").val();
      var url = "{{ action('App\Http\Controllers\ProductController@index',':parameter') }}";
      url = url.replace(":parameter", "brand="+brand_filter+"&supplier="+supplier_filter);
      window.location=url;
    }

    function CheckInputInvoices(sel) {
      console.log($(sel).val());
      var prdcd   = $(sel).attr('data-code');
      var trcd    = $(sel).attr('data-orderid');
      var invoice = $(sel).val();
      invoice     = invoice.replace(/\s/g,"");

      var current_value = $("#supplier_price_"+prdcd).val();
      var cprice        = $("#supplier_price_"+prdcd).attr('data-price');

      var dcurrent_value = $("#distributor_price_"+prdcd).val();
      var dprice         = $("#distributor_price_"+prdcd).attr('data-price');

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
    
    $(document).ready( function () {
        load_table_setting();
    });

    function format_currency(sel,event) {
      var key = event.keyCode;
      if (key==37 || key==39 ) { // up key
          return false;
      } 

      var current_value = $(sel).val();
      var id = $(sel).attr('data-id');
      current_value = current_value.replace("Rp. ","");
      current_value = current_value.replace(/\./g,"");
      if (isNaN(current_value)){
        current_value = 0;
      }
      $("#btn_"+id).attr('data-price',current_value);
      current_value = addCommas(parseInt(current_value));
      $(sel).val("Rp. "+current_value);
    }
    
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function numOnly(event,val,id) {
      var key = event.keyCode;
      if ((key >= 48 && key <= 57) || key == 8 || key==32){
        console.log($(id));
        $(this).val((val).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        return true;
      } else {
        return false;
      }
      // return ((key >= 48 && key <= 57) || key == 8 || key==32);
    };

    $('#sup-dprice').keyup(function(event) {

      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;

      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
    });

    // function open_detail(id){
    //     $("#modal_details").modal('show');
    // }
    
    function save_reset_field(){
        $('.input_form').each(function(){
            this.value = null;
        });
    }

    function save_data() {
        $("#modal_create").modal('hide');
        var form = $("#form_modal_create");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('save_product')}}",
            data: form.serialize(),
            success: function (data) {
                if (data.success){
                  $("#list_datas").dataTable().fnDestroy()
                  $("#main_table").html('');
                  var string_html = '';
                  for (var x = 0; x < data.data.length; x++) {
                    // data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                    var price = "<td><table class='table table-striped table-no-bordered table-hover dtr-inline table-bordered'>";
                    price += "<tr style='background-color:rgb(130, 255, 146);'><td>Customer Price :    </td><td>Rp. "+addCommas(data.data[x]['customer_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgb(253, 255, 121);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['supplier_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgba(255, 199, 199, 0.863);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['customer_price']-data.data[x]['supplier_price'])+"</td></tr>";
                    price += "</table></td>";
                    var id = data.data[x]['id'].replace(/\s/g,"%20");
                    var name = data.data[x]['name'].replace(/\s/g,"%20");
                    var btn_del = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+id+"')><i class='material-icons'>view_list</i></button><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+id+"','"+name+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['id']+"</td><td>"+data.data[x]['name']+"</td>"+price+"<td>"+data.data[x]['brand']+"</td><td>"+data.data[x]['supplier_name']+"</td>"+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  
                  $("#modal_success").modal('show');
                  
                  load_table_setting();
                  save_reset_field();
                } else {
                  alert(data.msg);
                }
            },
        });
    }

    function update_data() {
        $("#modal_create").modal('hide');
        var form = $("#form_modal_create");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('update_product')}}",
            data: form.serialize(),
            success: function (data) {
                if (data.success){
                  $("#list_datas").dataTable().fnDestroy()
                  $("#main_table").html('');
                  var string_html = '';
                  for (var x = 0; x < data.data.length; x++) {
                    // data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                    var price = "<td><table class='table table-striped table-no-bordered table-hover dtr-inline table-bordered'>";
                    price += "<tr style='background-color:rgb(130, 255, 146);'><td>Customer Price :    </td><td>Rp. "+addCommas(data.data[x]['customer_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgb(253, 255, 121);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['supplier_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgba(255, 199, 199, 0.863);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['customer_price']-data.data[x]['supplier_price'])+"</td></tr>";
                    price += "</table></td>";
                    var id = data.data[x]['id'].replace(/\s/g,"%20");
                    var name = data.data[x]['name'].replace(/\s/g,"%20");

                    var btn_del = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+id+"')><i class='material-icons'>view_list</i></button><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+id+"','"+name+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['id']+"</td><td>"+data.data[x]['name']+"</td>"+price+"<td>"+data.data[x]['brand']+"</td><td>"+data.data[x]['supplier_name']+"</td>"+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  
                  $("#modal_success").modal('show');
                  
                  load_table_setting();
                  save_reset_field();
                } else {
                  alert(data.msg);
                }
            },
        });
    }

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
            url: "{{route('delete_product')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                if (data.success){
                  $("#list_datas").dataTable().fnDestroy()
                  $("#main_table").html('');
                  var string_html = '';
                  for (var x = 0; x < data.data.length; x++) {
                    // data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                    var price = "<td><table class='table table-striped table-no-bordered table-hover dtr-inline table-bordered'>";
                    price += "<tr style='background-color:rgb(130, 255, 146);'><td>Customer Price :    </td><td>Rp. "+addCommas(data.data[x]['customer_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgb(253, 255, 121);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['supplier_price'])+"</td></tr>";
                    price += "<tr style='background-color:rgba(255, 199, 199, 0.863);'><td>Distributor Price : </td><td>Rp. "+addCommas(data.data[x]['customer_price']-data.data[x]['supplier_price'])+"</td></tr>";
                    price += "</table></td>";
                    var id = data.data[x]['id'].replace(/\s/g,"%20");
                    var name = data.data[x]['name'].replace(/\s/g,"%20");
                    var btn_del = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('{{$value->id}}')><i class='material-icons'>view_list</i></button><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+id+"','"+name+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['id']+"</td><td>"+data.data[x]['name']+"</td>"+price+"<td>"+data.data[x]['brand']+"</td><td>"+data.data[x]['name_supplier']+"</td>"+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  $("#modal_delete").modal('hide');
                  
                  load_table_setting();
                }
            },
        });
    }
    function open_detail(id) {
        id   = id.replace(/%20/g, " ");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('find_product_byId')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                var data    = JSON.parse(data);
                console.log(data);
                $("#form_modal_create").append('<input type="hidden" name="id_old" id="id-old" value="'+id+'" />');
                $(".card-title-editable").html("Edit Product : "+data.id+" - "+data.name);
                $("#product-id").val(data.id);
                $("#product-name").val(data.name);
                $("#product-cprice").val(data.customer_price);
                $("#product-sprice").val(data.supplier_price);
                $("#product-desc").val(data.description);
                $("#product-brand").val(data.brand);
                $("#product-cat").val(data.id_category);
                $("#product-unit").val(data.unit);
                $("#product-supid").val(data.id_supplier);

                $("#product-save").hide();
                $("#product-update").show();

                $("#modal_create").modal('show');
            },
        });
    }

    function open_modal_create() {
      $("#form_modal_create").find("input,textarea,select").val('').end();
      $(".card-title-editable").html("Add New Product");
      $("#product-save").show();
      $("#product-update").hide();
      $("#id-old").not('.MultiFiles').remove();
      $("#modal_create").modal('show');
    }
</script>