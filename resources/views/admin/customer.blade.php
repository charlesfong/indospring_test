@extends('template_admin.template')

@section('Content')
<style>
  td{
    cursor: pointer;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">List Customers
          <button type="button" class="btn btn-success" style="float:right" onclick="open_modal_create()">ADD NEW CUSTOMER</button>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="list_datas" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
            <thead class=" text-primary">
              {{-- <th class='text-left'>
                No
              </th> --}}
              <th class='text-left'>
                Name
              </th>
              <th class='text-left'>
                Address
              </th>
              <th class='text-left'>
                Phone
              </th>
              <th class='text-left'>
                Email
              </th>
              <th class='text-center'>
                Details
              </th>
            </thead>
            <tbody id='main_table'>
              @foreach ($customers as $key => $value)
                <tr>
                    {{-- <td>{{$key+1}}</td> --}}
                    <td class="td_name"   id="td_name_{{$value->id}}">{{$value->name}}</td>
                    <td class="td_addr"   id="td_addr_{{$value->id}}">{{$value->address}}</td>
                    <td class="td_phone1" id="td_phone1_{{$value->id}}">{{$value->phone1}}</td>
                    <td class="td_email"  id="td_email_{{$value->id}}">{{$value->email}}</td>
                    <td class='text-center' style='width:15%'>
                        <button class="btn btn-warning btn-fab btn-fab-mini btn-round" onclick="open_edit('{{$value->id}}')">
                            <i class="material-icons">edit</i>
                        </button>
                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="open_detail('{{$value->id}}')">
                          <i class="material-icons">view_list</i>
                        </button>
                        <button class="btn btn-danger btn-fab btn-fab-mini btn-round" onclick="open_delete('{{$value->id}}','{{$value->name}}')">
                            <i class="material-icons">delete</i>
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id='modal_details'>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">   
      <div class="modal-header row">
        <h5 class="modal-title col-md-3">
          Company
        </h5>
        <span class="col-md-8">
            <button type="button" class="btn btn-success btn-sm" style="float:right" onclick="open_modal_create_address()">ADD NEW COMPANY</button>
        </span>
        <button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
          <thead>
              <tr>
                  <th class="text-left">No</th>
                  <th class="text-left">Name</th>
                  <th class="text-left">Address</th>
                  <input type="hidden" id="id_customer_">
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
    <div class="modal-dialog modal-login" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Add New Customer</h4>
                </div>
                <div class="modal-body">
                    <form class="form" method="post" id="form_modal_create">
                        <div class="card-body">

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="material-icons">business</i></div>
                                  </div>
                                  <input type="text" name='name' id='cust-name' class="form-control input_form" placeholder="Name...">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="material-icons">home</i></div>
                                  </div>
                                  <input type="text" name='address' id='cust-address' class="form-control input_form" placeholder="Address...">
                                </div>
                            </div>
                          
                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                  </div>
                                  <input type="text" name='phone1' id='cust-phone1' class="form-control input_form" placeholder="Phone 1...">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                  </div>
                                  <input type="text" name='phone2' id='cust-phone2' class="form-control input_form" placeholder="Phone 2...">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                </div>
                                <input type="text" name='phone3' id='cust-phone3' class="form-control input_form" placeholder="Phone 3...">
                              </div>
                            </div>

                            <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">email</i></div>
                                </div>
                                <input type="text" name='email' id='cust-email' class="form-control input_form" placeholder="Email...">
                              </div>
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_data()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="" id='modal_edit'>
  <div class="modal-dialog modal-login" role="document">
      <div class="modal-content">
          <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit Customer - <span id='edit-title'></span></h4>
              </div>
              <div class="modal-body">
                  <form class="form" method="post" id="form_modal_edit">
                      <input type="hidden" name='edit_id_customer' id='edit-id_customer'>
                      <div class="card-body">

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">business</i></div>
                                </div>
                                <input type="text" name='edit_name' id='edit-cust-name' class="form-control input_form" placeholder="Name...">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">home</i></div>
                                </div>
                                <input type="text" name='edit_address' id='edit-cust-address' class="form-control input_form" placeholder="Address...">
                              </div>
                          </div>
                        
                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                </div>
                                <input type="text" name='edit_phone1' id='edit-cust-phone1' class="form-control input_form" placeholder="Phone 1...">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                </div>
                                <input type="text" name='edit_phone2' id='edit-cust-phone2' class="form-control input_form" placeholder="Phone 2...">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                              </div>
                              <input type="text" name='edit_phone3' id='edit-cust-phone3' class="form-control input_form" placeholder="Phone 3...">
                            </div>
                          </div>

                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">email</i></div>
                              </div>
                              <input type="text" name='edit_email' id='edit-cust-email' class="form-control input_form" placeholder="Email...">
                            </div>
                          </div>
                      </div>
                  </form> 
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="save_data('edit-customer')">Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="" id='modal_create_address'>
  <div class="modal-dialog modal-login" role="document">
      <div class="modal-content">
          <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title ">Add New Address</h4>
              </div>
              <div class="modal-body">
                  <form class="form" method="post" id="form_modal_create_address">
                      <input type="hidden" name='id_customer' id='id_customer'>
                      <div class="card-body">

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">business</i></div>
                                </div>
                                <input type="text" name='name' id='cust-name' class="form-control input_form" placeholder="Name...">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">home</i></div>
                                </div>
                                <input type="text" name='address' id='cust-address' class="form-control input_form" placeholder="Address...">
                              </div>
                          </div>
                        
                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">person</i></div>
                              </div>
                              <input type="text" name='cp_name1' id='cust-cpname1' class="form-control input_form" placeholder="Contact Person Name 1...">
                            </div>
                          </div>

                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">person</i></div>
                              </div>
                              <input type="text" name='cp_name2' id='cust-cpname2' class="form-control input_form" placeholder="Contact Person Name 2...">
                            </div>
                          </div>

                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">person</i></div>
                              </div>
                              <input type="text" name='cp_name3' id='cust-cpname3' class="form-control input_form" placeholder="Contact Person Name 3...">
                            </div>
                          </div>

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                </div>
                                <input type="text" name='phone1' id='cust-phone1' class="form-control input_form" placeholder="Phone 1...">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                </div>
                                <input type="text" name='phone2' id='cust-phone2' class="form-control input_form" placeholder="Phone 2...">
                              </div>
                          </div>

                          <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                              </div>
                              <input type="text" name='phone3' id='cust-phone3' class="form-control input_form" placeholder="Phone 3...">
                            </div>
                          </div>

                          {{-- <div class="form-group bmd-form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="material-icons">email</i></div>
                              </div>
                              <input type="text" name='email' id='cust-email' class="form-control input_form" placeholder="Email...">
                            </div>
                          </div> --}}
                      </div>
                  </form> 
              </div>
              <div class="modal-footer">
                  <button type="button" id='modal_save_button' class="btn btn-primary" onclick="save_data('Address')">Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection

<script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>

<script>
    $(document).ready( function () {
        $("#list_datas").DataTable({
            // searching: false,bLengthChange: false,rowReorder: true,ordering: false
            searching: true,bLengthChange: false,rowReorder: true
        });
        $('#cust-phone1').mask('000-000-000-000-000');
        $('#cust-phone2').mask('000-000-000-000-000');
        $('#cust-phone3').mask('000-000-000-000-000');

        $('#edit-cust-phone1').mask('000-000-000-000-000');
        $('#edit-cust-phone2').mask('000-000-000-000-000');
        $('#edit-cust-phone3').mask('000-000-000-000-000');
    });
    // function open_detail(id){
    //     $("#modal_details").modal('show');
    // }
    
    $(".td_name").dblclick(function(){
      alert("The paragraph was double-clicked");
    });

    function save_reset_field(){
        $('.input_form').each(function(){
            this.value = null;
        });
    }

    function save_data(mode=null) {
        $("#modal_save_button").prop('disabled', true);
        var form = $("#form_modal_create");
        var url  = "{{route('save_customer')}}";
        if (mode=='Address'){
          form = $("#form_modal_create_address");
          $("#id_customer").val($("#id_customer_").val());
          url = "{{route('save_address_customer')}}";
        } else if (mode=='edit-customer'){
          form = $("#form_modal_edit");
          url = "{{route('edit_customer')}}";
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url:  url,
            data: form.serialize(),
            success: function (data) {
                if (data.success){
                  $("#list_datas").dataTable().fnDestroy()
                  $("#main_table").html('');
                  var string_html = '';
                  for (var x = 0; x < data.data.length; x++) {
                    data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                    data.data[x]['phone1'] = data.data[x]['phone1']==null?'-':data.data[x]['phone1'];
                    data.data[x]['email'] = data.data[x]['email']==null?'-':data.data[x]['email'];
                    var btn = "<button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+data.data[x]['id']+"')><i class='material-icons'>view_list</i></button>";
                    var btn_del = "<button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+data.data[x]['id']+"','"+data.data[x]['name']+"')><i class='material-icons'>delete</i></button>";
                    var btn_edit = "<button class='btn btn-warning btn-fab btn-fab-mini btn-round' onclick=open_edit('"+data.data[x]['id']+"'')><i class='material-icons'>edit</i></button>";
                    string_html += "<tr><td>"+data.data[x]['name']+"</td><td>"+data.data[x]['address']+"</td><td>"+data.data[x]['phone1']+"</td><td>"+data.data[x]['email']+"</td><td class='text-center'>"+btn_edit+btn+btn_del+"</td></tr>";
                  }
                  $("#main_table").html(string_html);
                  
                  $("#modal_create").modal('hide');
                  
                  $("#list_datas").DataTable({
                      searching: true,bLengthChange: false,rowReorder: true
                  });
                  save_reset_field();
                  $("#modal_success").modal('show');
                  $("#modal_edit").modal('hide');
                  $("#modal_details").modal('hide');
                  $("#modal_create_address").modal('hide');
                }
            },
        });
        $("#modal_save_button").prop('disabled', false);
    }

    function open_delete(id,name) {
      $("#id_delete").val(id);
      name = name.replace(/%20/g, " ");
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
            url: "{{route('delete_customer')}}",
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
                    data.data[x]['address'] = data.data[x]['address']==null?'-':data.data[x]['address'];
                    data.data[x]['phone1'] = data.data[x]['phone1']==null?'-':data.data[x]['phone1'];
                    data.data[x]['email'] = data.data[x]['email']==null?'-':data.data[x]['email'];
                    var btn = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+data.data[x]['id']+"')><i class='material-icons'>view_list</i></button></td>";
                    var btn_del = "<td class='text-center'><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+data.data[x]['id']+"','"+data.data[x]['name'].replace(/\s/g,"%20")+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['name']+"</td><td>"+data.data[x]['address']+"</td><td>"+data.data[x]['phone1']+"</td><td>"+data.data[x]['email']+"</td>"+btn+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  $("#modal_delete").modal('hide');
                  
                  $("#list_datas").DataTable({
                      searching: true,bLengthChange: false,rowReorder: true
                  });
                }
            },
        });
    }
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
                      "<button type='button' rel='tooltip' class='btn btn-danger btn-fab btn-fab-mini btn-round'>"+
                          "<i class='material-icons'>delete</i>"+
                      "</button>"+
                    "</td>";
                    var mini_table = "<tr><table id='cp_table_"+data[x][id]+"'><tr><td>"+data[x]['cp_name1']+"</td><td>"+data[x]['phone1']+"</td></tr>"+
                      "<tr><td>"+data[x]['cp_name2']+"</td><td>"+data[x]['phone2']+"</td></tr>"+
                      "</table></tr>"; 
                    html_ += "<tr id='"+data[x]['id']+"' class='collapse_cp' data-toggle='collapse' data-target='.collapse_"+data[x]['id']+"'><td>"+(x+1)+"</td><td class='text-left'>"+data[x]['name']+"</td><td class='text-left'>"+data[x]['address']+"</td></tr>";
                    // html_ += "<table class='table table-bordered'><tr><td>1</td><td>2</td><td>3</td></tr></table>";
                    var cp_info_1 = "<tr class='collapse collapse_"+data[x]['id']+"'><td></td><td>"+data[x]['cp_name1']+"</td><td>"+data[x]['phone1']+"</td></tr>";
                    var cp_info_2 = "<tr class='collapse collapse_"+data[x]['id']+"'><td></td><td>"+data[x]['cp_name2']+"</td><td>"+data[x]['phone2']+"</td></tr>";
                    var cp_info_3 = "<tr class='collapse collapse_"+data[x]['id']+"'><td></td><td>"+data[x]['cp_name3']+"</td><td>"+data[x]['phone3']+"</td></tr>";
                    
                    if (data[x]['cp_name2']==null){
                      cp_info_2 = "";
                    }
                    if (data[x]['cp_name3']==null){
                      cp_info_3 = "";
                    }
                    html_ += cp_info_1+cp_info_2+cp_info_3;
                    // console.log(data[x]);
                    console.log(html_);
                }

                // <tr id='1' class='collapse_cp'>
                //   <td>1</td>
                //   <td class='text-left'>PT Jati Sari </td>
                //   <td class='text-left'>Raya Bromo, Rogojampi - Srono,Banyuwangi</td>
                // </tr>
                // <table>
                //   <tr>
                //     <td>Yogi</td>
                //     <td>08121615708</td>
                //   </tr>
                //   <tr>
                //     <td>null</td>
                //     <td>null</td>
                //   </tr>
                // </table>
                //   <tr id='2' class='collapse_cp'>
                //     <td>2</td>
                //     <td class='text-left'>PT Putra Prima Sentosa</td>
                //     <td class='text-left'>Raya Pandanlandung no 44,Wagir - Malang</td>
                //   </tr>
                // <table>
                //   <tr>
                //     <td>Bu Dewi (purch)</td>
                //     <td>081232963606</td>
                //   </tr>
                //   <tr>
                //     <td>Bp Rofiq </td>
                //     <td>081233028000</td>
                //   </tr>
                // </table>

                $("#modal_details_body").html(html_);
                // var emailPembeli = data['email'];
                // var telpPembeli = data['phone'];
                // var namaPembeli = data['name'];
                // $("#edit-id").val(id);
                // $("#edit-name").val(namaPembeli);
                // $("#edit-address").val(tujuanPengiriman);

                $("#id_customer_").val(id);
                $("#modal_details").modal('show');
            },
        });
    }

    function open_edit(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('show_customer')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function (data) {
                var success = data['result'];
                var data    = data['data'];
                var html_   = "";

                console.log(data);
                $("#edit-title").html("");
                $("#edit-title").html(data.name);
                $("#edit-cust-name").val(data.name);
                $("#edit-cust-address").val(data.address);
                $("#edit-cust-phone1").val(data.phone1);
                $("#edit-cust-phone2").val(data.phone2);
                $("#edit-cust-phone3").val(data.phone3);
                $("#edit-cust-email").val(data.email);

                $("#edit-id_customer").val(id);
                $("#modal_edit").modal('show');
            },
        });
    }

    function open_modal_create() {
      $("#modal_create").modal('show');
    }
    function open_modal_create_address() {
      $("#modal_create_address").modal('show');
    }
</script>