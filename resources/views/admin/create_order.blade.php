@extends('template_admin.template')

@section('Content')
<div class="col-md-12">
  <form method="post" class="form-horizontal" id="form_master">
    <input type="hidden" name='subtotal' id='subtotal'>
    <div class="card ">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">Transaksi Barang</h4>
        {{-- <p class="card-category">Create Order</p> --}}
      </div>
      <div class="card-body first-step">

        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label" for="form_customer">No Transaksi</label>
          <div class="col-sm-4">
            <input id='form_no' name='form_no' class="form-control" data-style="btn btn-primary btn-round" title="Single Select">
          </div>
        </div>

       

        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-md-2 col-lg-2 col-form-label">Tanggal</label>
          <div class='col-sm-4 col-md-4 col-lg-4'>
              <div class="row">
                  <div class='col-sm-8 col-md-8 col-lg-8'>
                      <input type='date' class='form-control date' data-date-format='DD MMMM YYYY' name='form_date' id='form_date' style='width:100%' value={{isset($date1)?$date1:date("d/m/Y")}}>
                  </div>
              </div>
          </div>
        </div>

        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-md-2 col-lg-2 col-form-label">Jenis Transaksi</label>
          <div class="col-sm-8 col-md-8 col-lg-8">
              <select id='form_jenis' name='form_jenis' class="form-control" data-style="btn btn-primary btn-round" title="Single Select">
                <option selected value='MASUK'>MASUK</option>
                <option value='KELAR'>KELUAR</option>
              </select>
          </div>
        </div>

        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-md-2 col-lg-2 col-form-label">Kategori</label>
          <div class="col-sm-8 col-md-8 col-lg-8">
              <select id='form_kategori' name='form_kategori' class="form-control" data-style="btn btn-primary btn-round" title="Single Select">
                <option selected value='SUBMAT'>SUBMAT</option>
                <option value='RAWMAT'>RAWMAT</option>
              </select>
          </div>
        </div>

        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label" >Add Product</label>
          <div class="col-sm-2">
            <button class="btn btn-light" onclick=load_modalproduct(event)>Open List Products</button>
          </div>
          <div class="col-sm-4" >
            <button class='btn btn-success' style="float:right" onclick=save_order(event)><b>SAVE DRAFT ORDER</b></button>
          </div>
        </div>
      </div>

      <div class="card-body second-step" style="display:none">
        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label" >Address</label>
          <div class="col-sm-10">
            <div class="bmd-form-group">
              {{-- <label for="form_address" class="bmd-label-floating">Address</label> --}}
              <input type="text" class="form-control" id="form_address" name="form_address" readonly>
            </div>
          </div>
        </div>
        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
            <div class="row">
              <div class="col-md-4">
                <div class="bmd-form-group">
                  {{-- <label for="form_address" class="bmd-label-floating">Phone 1</label> --}}
                  <input type="text" class="form-control" id="form_phone1" name="form_phone1" onkeydown="return numOnly(event);" maxlength="12" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bmd-form-group">
                  {{-- <label for="form_address" class="bmd-label-floating">Phone 2</label> --}}
                  <input type="text" class="form-control" id="form_phone2" name="form_phone2" onkeydown="return numOnly(event);" maxlength="12" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="bmd-form-group">
                  {{-- <label for="form_address" class="bmd-label-floating">Phone 3</label> --}}
                  <input type="text" class="form-control" id="form_phone3" name="form_phone3" onkeydown="return numOnly(event);" maxlength="12" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label" >Remark</label>
          <div class="col-sm-10">
            <div class="bmd-form-group">
              {{-- <label for="form_address" class="bmd-label-floating">Address</label> --}}
              <textarea type="text" name='form_remark' id='form_remark' class="form-control input_form" placeholder="Remark..." rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="row" style='margin-bottom:1.5%'>
          <label class="col-sm-2 col-form-label" >Add Product</label>
          <div class="col-sm-2">
            <button type="button" class="btn btn-light" onclick=load_modalproduct(event)>Open List Products</button>
        </div>
        </div>
      </div>
    </div>
    <div class="card ">
      
      <div class="card-body" id="card-body-products">
        <div class="table-responsive">
          <table id="list_products" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info_products">
            <thead class=" text-primary">
              <th class='text-left'>
                ID
              </th>
              <th class='text-left'>
                Name
              </th>
              <th class='text-left'>
                Brand
              </th>
              <th class='text-left'>
                Price
              </th>
              <th class='text-left'>
                Qty
              </th>
              <th class='text-center delete_btn'>
                &nbsp;
              </th>
            </thead>
            <tbody id='main_table_products'>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </form>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id='modal_products'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="table-responsive">
        <table id="list_datas" class="table table-no-bordered table-hover dataTable dtr-inline table-bordered" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
          <thead class=" text-primary thead-light">
            <th class='text-left'>
              ID
            </th>
            <th class='text-left'>
              Name
            </th>
            <th class='text-left'>
              Category
            </th>
            <th class='text-center'>
              Qty
            </th>
            <th class='text-center'>
              &nbsp;
            </th>
          </thead>
          <tbody id='main_table'>
            
          </tbody>
        </table>
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
@endsection

<script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('/template_admin/js/jquery.formatCurrency-1.4.0.js') }}" type="text/javascript"></script>
<script>
    $(document).ready( function () {
      
    });

    function save_order(event){
      event.preventDefault();

      var valid = true;
      if ($("#form_no").val()=='' || $("#form_no").val()==null) {
        valid = false;
        alert("Please Fill NO TRANSAKSI!");
        $("#form_customer").focus();
        return false;
      }
      if (temp_cart=='' || temp_cart==null){
        valid = false;
        alert("Please Add any product!");
        return false;
      }
      // if ($("#form_address").val()=='' || $("#form_address").val()==null) {
      //   valid = false;
      //   alert("Please fill up address field!");
      //   $("#form_address").focus();
      //   return false;
      // }
      // if ($("#subtotal").val()=='' || $("#subtotal").val()==null) {
      //   valid = false;
      //   alert("Error total value !");
      //   return false;
      // }

      if (valid) {
        if (confirm('Save draft transaction ?')) {
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('save_order')}}",
            data: {
                "_token"            : "{{ csrf_token() }}",
                "cart"              : JSON.stringify(temp_cart),
                "id_customer"       : $("#form_no").val(),
                "date"              : $("#form_date").val(),
                "jenis"             : $("#form_jenis").val(),
                "kat"               : $("#form_kategori").val(),
            },
            success: function (data) {
                console.log(data);
                $("#modal_success").modal('show');
                window.location.href = "{{ action('App\Http\Controllers\OrderController@create_order') }}";
            },
          });
        } else {
          return false;
        }
        
      }
      
    }

    function load_anotherfield(sel){
      // var address = $('option:selected', sel).attr('data-addr');
      var phone1  = $('option:selected', sel).attr('data-phone1');
      var phone2  = $('option:selected', sel).attr('data-phone2');
      var phone3  = $('option:selected', sel).attr('data-phone3');
      var email   = $('option:selected', sel).attr('data-email');
      $("#form_address").val("");
      $("#form_phone1").val(phone1);
      $("#form_phone2").val(phone2);
      $("#form_phone3").val(phone3);
      $("#form_email").val(email);

      // LOAD COMPANY LIST
      console.log($('option:selected', sel).val());
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          url: "{{route('find_company_byId')}}",
          data: {
              "_token": "{{ csrf_token() }}",
              'id': $('option:selected', sel).val()
          },
          success: function (data) {
              var data = JSON.parse(data);
              console.log(data.length);
              $("#form_company").html("<option disabled selected>-- SELECT COMPANY --</option>");
              for (x=0;x<data.length;x++){
                $("#form_company").append("<option value='"+data[x]['id']+"' data-addr='"+data[x]['address']+"'>"+data[x]['name']+"</option>");
              }
              console.log(data);
          },
      });
    }

    function load_anotherfield2(sel){
      var address = $('option:selected', sel).attr('data-addr');
      $("#form_address").val(address);
    }

    var temp_cart = [];

    function del_from_cart(id){
      var temp_cart_x = [];
      // REINDEX ARRAY
      for (var x = 0; x < temp_cart.length; x++) {
        var done_delete = false;
        if (temp_cart[x]['id']==id){
          delete temp_cart[x]; 
          done_delete = true;
        }
        if (temp_cart[x]!=null) {
          temp_cart_x.push(temp_cart[x]);
        }
      }
      // END OF REINDEX ARRAY
      temp_cart  = temp_cart_x;
      add_product_temp();
    }
    function add_product_temp(){
      // $("#card-body-products")
      var string_html = "";
      var sub_total   = 0;
      for (var z = 0; z < temp_cart.length; z++) {
        // sub_total += parseInt(temp_cart[z]['price'])*parseInt(temp_cart[z]['qty']);
        // var price   = "<td>Rp. "+addCommas(temp_cart[z]['price'])+"</td>";
        var btn_del = "<td class='text-center delete_btn'><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=del_from_cart('"+temp_cart[z]['id']+"')><i class='material-icons'>close</i></button></td>";
        string_html += "<tr><td>"+temp_cart[z]['id']+"</td><td>"+temp_cart[z]['name']+"</td><td>"+temp_cart[z]['cat']+"</td><td>"+temp_cart[z]['qty']+"</td>"+btn_del+"</tr>";
      }
      // if (temp_cart.length>0){
      //   string_html += "<tr><td colspan='3' class='text-right'><b class='text-right'>SUB TOTAL</b></td><td colspan='2'>Rp. "+addCommas(sub_total)+"</td></tr>";
      // }
      // $("#subtotal").val(sub_total);
      // console.log("sub_total",sub_total);
      // console.log($("#subtotal").val());
      
      $("#main_table_products").html(string_html);
    }

    function add_to_cart(sel){
      var obj = {};
      var id = $(sel).attr('data-id');
      id = id.replace(/\s/g,"%20");
      var qty_id = "qty_"+id;
      var valid = true;
      if ($("#"+qty_id).val()<1){
        alert("Qty must be greater than 0");
        return false;
      } else {
        // ADD TO TEMP CART
        obj['id']     = id;
        obj['name']   = $(sel).attr('data-name');
        obj['cat']   = $(sel).attr('data-cat');
        obj['qty']    = parseInt($("#"+qty_id).val());
        var found = false;
        // for (var z = 0; z < temp_cart.length; z++) {
        //   if (temp_cart[z]['id']==id){
        //     // UPDATE TEMP ONLY 
        //     if (temp_cart[z]['price']!= $(sel).attr('data-price')){
        //       alert("Please remove product "+id+" from cart before changing price!");
        //       valid =false;
        //       return false;
        //     }
        //     found = true;
        //     if (valid){
        //       temp_cart[z]['qty']  = parseInt($("#"+qty_id).val())+parseInt(temp_cart[z]['qty']);
        //     }
           
        //   }
        // }
        if (!found){
          // INSERT INTO TEMP
          temp_cart.push(obj);
        }
        console.log(temp_cart);
        add_product_temp();
      }
    }

    function load_modalproduct(event){
      event.preventDefault();
      var id = $("#id_supplier").val();
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          url: "{{route('show_product')}}",
          data: {
              "_token": "{{ csrf_token() }}"
          },
          success: function (data) {
              if (data.success){
                if ( $.fn.DataTable.isDataTable( '#list_datas' ) ) {
                  $("#list_datas").dataTable().fnDestroy()
                  // $("#list_datas").DataTable({});
                }
                
                $("#main_table").html('');
                var string_html = '';
                for (var x = 0; x < data.data.length; x++) {
                  // data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                  var id = data.data[x]['KODE_BARANG'].replace(/\s/g,"%20");
                  var name = data.data[x]['NAMA_BARANG'].replace(/\s/g,"%20");
                  var btn_del = "<td class='text-center'><button id='btn_"+id+"' class='btn btn-success btn-fab btn-fab-mini btn-round' onclick=add_to_cart(this) data-id='"+data.data[x]['KODE_BARANG']+"' data-name='"+data.data[x]['NAMA_BARANG']+"' data-cat='"+data.data[x]['KATEGORI']+"'><i class='material-icons'>add</i></button></td>";
                  string_html += "<tr><td>"+data.data[x]['KODE_BARANG']+"</td><td style='width:40%'>"+data.data[x]['NAMA_BARANG']+"</td><td style='width:10%'>"+data.data[x]['KATEGORI']+"</td><td style='width:10%'><input type='number' class='form-control' id='qty_"+data.data[x]['KODE_BARANG']+"' name='qty_"+data.data[x]['KODE_BARANG']+"' value=0 onkeydown='return numOnly(event);' min='0'></td>"+btn_del+"</tr>";
                }
                $("#main_table").html(string_html);
                // initMaskMoney($(string_html).find('input'));
                $("#modal_products").modal('show');
                
                $("#list_datas").DataTable({
                    searching: false,bLengthChange: false,rowReorder: true,ordering: false
                });
              }
          },
      });
    }

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

    function numOnly(event) {
      var key = event.keyCode;
      return ((key >= 48 && key <= 57) || key == 8 || key==32 || key==37 || key==39);
    };

    function open_detail(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('show_contact_person')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                var success = data['result'];
                var data    = data['data'];
                var html_   = "";
                for (var x = 0; x < data.length; x++) {
                    var tooltips = "<td class='td-actions text-right'>"+
                      "<button type='button' rel='tooltip' class='btn btn-fab btn-info'>"+
                          "<i class='material-icons'>person</i>"+
                      "</button>"+
                      "<button type='button' rel='tooltip' class='btn btn-fab btn-success'>"+
                          "<i class='material-icons'>edit</i>"+
                      "</button>"+
                      "<button type='button' rel='tooltip' class='btn btn-fab btn-danger'>"+
                          "<i class='material-icons'>close</i>"+
                      "</button>"+
                    "</td>";
                    html_ += "<tr><td class='text-left'>"+data[x]['name']+"</td><td class='text-left'>"+data[x]['phone_1']+"</td><td class='text-left'>"+data[x]['phone_2']+"</td><td class='text-left'>"+data[x]['email_']+"</td>"+tooltips+"</tr>";
                    console.log(data[x]);
                }
                $("#modal_details_body").html(html_);
                // var emailPembeli = data['email'];
                // var telpPembeli = data['phone'];
                // var namaPembeli = data['name'];
                // $("#edit-id").val(id);
                // $("#edit-name").val(namaPembeli);
                // $("#edit-address").val(tujuanPengiriman);

                $("#modal_details").modal('show');
            },
        });
    }
</script>