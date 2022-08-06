@extends('template_admin.template')

@section('Content')

<link rel="stylesheet" type="text/css" href="{{ asset('/multiselect/jquery.dropdown.css') }}" />
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<script src="{{ asset('/multiselect/dist/js/BsMultiSelect.min.js') }}"></script>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8">
        <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title ">Report
            {{-- <button type="button" class="btn btn-success" style="float:right" onclick="open_modal_create()">ADD NEW COURIER</button> --}}
            </h4>
        </div>
        <div class="card-body">
            <form id="form_report">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row" style='margin-bottom:1.5%'>
                    <label class="col-sm-4 col-md-4 col-lg-4 col-form-label">Customer</label>
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <select id='form_customer' name='form_customer' class="form-control" data-style="btn btn-primary btn-round" title="Single Select" onchange="load_anotherfield(this)">
                        <option disabled selected>-- SELECT CUSTOMER --</option>
                        <option selected value='ALL'>ALL</option>
                        @foreach ($customers as $customer)
                            <option value='{{$customer->id}}' data-addr='{{$customer->address}}' data-phone1='{{$customer->phone1}}' data-phone2='{{$customer->phone2}}' data-phone3='{{$customer->phone3}}' data-email='{{$customer->email}}'>{{$customer->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="row" style='margin-bottom:1.5%'>
                    <label class="col-sm-4 col-md-4 col-lg-4 col-form-label">Date</label>
                    <div class='col-sm-4 col-md-4 col-lg-4'>
                        <div class="row">
                            <div class='col-sm-8 col-md-8 col-lg-8'>
                                <input type='date' class='form-control date' data-date-format='DD MMMM YYYY' name='date1' id='date1' style='width:100%' value={{isset($date1)?$date1:date("d/m/Y")}}>
                            </div>
                            <div class='col-sm-4 col-md-4 col-lg-4'>
                                <span style=" font-size: 0.8em;">To</span>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-4 col-md-4 col-lg-4'>
                        <div class="row">
                            <div class='col-sm-8 col-md-8 col-lg-8'>
                                <input type='date' class='form-control date' data-date-format='DD MMMM YYYY' name='date2' id='date2' style='width:100%' value={{isset($date2)?$date2:date("d/m/Y")}}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style='margin-bottom:1.5%'>
                    <label class="col-sm-4 col-md-4 col-lg-4 col-form-label">Product Categories</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 multi_categories">
                        <select id='form_categories' name='form_categories' class="form-control" style="display:block">
                        <option disabled selected>-- SELECT CATEGORIES --</option>
                        <option selected value='ALL'>ALL</option>
                        @foreach ($categories as $category)
                            <option value='{{$category->id}}'>{{$category->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="row" style='margin-bottom:1.5%'>
                    <label class="col-sm-4 col-md-4 col-lg-4 col-form-label">Order Status</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 multi_categories">
                        <select id='form_status' name='form_status' class="form-control" style="display:block">
                            <option disabled selected>-- SELECT STATUS --</option>
                            <option selected value='0'>Draft</option>
                            <option selected value='1'>Processed</option>
                            <option selected value='2'>Ready Deliver</option>
                            <option selected value='3'>Delivering</option>
                            <option selected value='4'>Done</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8 col-md-8 col-lg-8">

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type='button' class="btn btn-light" style="float:right" onclick=go_search() value="Go">
                    </div>
                </div>
            </form>
            {{-- <select name="states" id="example" class="form-control"  multiple="multiple" style="display: none;">
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option selected value="CA">California</option>
            </select> --}}
            {{-- <div class="row" id="company_section" style='margin-bottom:1.5%'>
                <label class="col-sm-2 col-form-label" for="form_customer">Company</label>
                <div class="col-sm-4">
                <select id='form_company' name='form_company' class="form-control" data-style="btn btn-primary btn-round" title="Single Select">
                    <option disabled selected>-- SELECT COMPANY --</option>
                </select>
                </div>
            </div> --}}
        </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top:-2%;display:none;" id="row_bottom">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row" style="background-color: white;">
                    <label style="color: #555;" class="col-sm-12 col-md-12 col-lg-12 col-form-label" id="title_"></label>
                    <table id="table_result" class="table table-no-bordered table-hover dataTable dtr-inline table-bordered" cellspacing="0" width="100%" style="width: 100%;" role="grid">
                        <thead class=" text-primary thead-light">
                            <th>Name</th>
                            <th>Total Price to Customer</th>
                            <th>Total Price from Supplier</th>
                            <th>Margin</th>
                        </thead>
                        <tbody id='main_table2'>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('/multiselect/jquery.dropdown.js') }}"></script>
<script type="text/javascript" src="{{ asset('/multiselect/mock.js') }}"></script>
<script>

    $(document).ready( function () {
        $("#list_datas").DataTable({
            // searching: false,bLengthChange: false,rowReorder: true,ordering: false
            searching: true,bLengthChange: false,rowReorder: true
        });
        // $('.multi_categories').dropdown({
        //     input: '<input type="text" maxLength="20" placeholder="Search">'
        // });

        
    });

    // $(function(){
    //     $("select").bsMultiSelect();
    // });

    $("#form_report").submit(function(e){
        return false;
    });
    function go_search(){
        
        var date1   = '<?= (isset($_GET["date1"]) ? $_GET["date1"] : date('Y-m-d')) ?>';
        var date2   = '<?= (isset($_GET["date2"]) ? $_GET["date2"] : date('Y-m-d')) ?>';
        if ($("#date1").val()==""||$("#date1").val()==null){
            $("#date1").val(date1);
        }
        if ($("#date2").val()==""||$("#date2").val()==null){
            $("#date2").val(date2);
        }
        var tanggal1 = $("#date1").val();
        var tanggal2 = $("#date2").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{route('get_data_order')}}",
            data: $("#form_report").serialize(),
            success: function (data) {
                var data = JSON.parse(data);
                console.log(data);
                $(".remove_later").remove();
                $("#row_bottom").show();
                var categories_selected = $("#form_categories option:selected").text();
                var status_selected     = $("#form_status option:selected").text();
               
                $("#title_").html("Date : ("+tanggal1+" / "+tanggal2+"), Product Categories : "+categories_selected+", Status : "+status_selected);
                var total_price = 0;
                var total_dprice= 0;
                var total_profit= 0;
                for (var i = 0; i < data.length; i++) {
                    var html = "<tr class='remove_later'>";
                    html += "<td>"+data[i].name+"</td>";
                    html += "<td>Rp. "+addCommas(data[i].total_price)+"</td>";
                    html += "<td>Rp. "+addCommas(data[i].total_dprice)+"</td>";
                    html += "<td>Rp. "+addCommas(data[i].total_profit)+"</td>";
                    html += "</tr>";
                    total_price  += data[i].total_price;
                    total_dprice += data[i].total_dprice;
                    total_profit += data[i].total_profit;
                    $("#main_table2").append(html);
                }
                $("#main_table2").append("<tr class='remove_later'><td><b>Total</b></td><td><b>Rp. "+addCommas(total_price)+"</b></td><td><b>Rp. "+addCommas(total_dprice)+"</b></td><td><b>Rp. "+addCommas(total_profit)+"</b></td></tr>");
                // $("#form_company").html("<option disabled selected>-- SELECT COMPANY --</option>");
                // for (x=0;x<data.length;x++){
                //     $("#form_company").append("<option value='"+data[x]['id']+"' data-addr='"+data[x]['address']+"'>"+data[x]['name']+"</option>");
                // }
            },
        });
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function load_anotherfield(sel){
        if ($('option:selected', sel).val()=='ALL'){
            $("#form_company").html("<option disabled selected>-- SELECT COMPANY --</option>");
            $("#form_company").attr("disabled", true);
        } else {
            $("#form_company").attr("disabled", false);
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
                    $("#form_company").html("<option disabled selected>-- SELECT COMPANY --</option>");
                    for (x=0;x<data.length;x++){
                        $("#form_company").append("<option value='"+data[x]['id']+"' data-addr='"+data[x]['address']+"'>"+data[x]['name']+"</option>");
                    }
                },
            });
        }
    }

    function open_detail(id){
        $("#modal_details").modal('show');
    }
    
    function save_reset_field(){
        $('.input_form').each(function(){
            this.value = null;
        });
    }

    function save_data() {
        var form = $("#form_modal_create");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('save_courier')}}",
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
                    var name = data.data[x]['name'].replace(/\s/g,'#');
                    var btn = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+data.data[x]['id']+"')><i class='material-icons'>view_list</i></button></td>";
                    var btn_del = "<td class='text-center'><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+data.data[x]['id']+"','"+name+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['name']+"</td><td>"+data.data[x]['address']+"</td><td>"+data.data[x]['phone1']+"</td><td>"+data.data[x]['email']+"</td>"+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  $("#modal_create").modal('hide');
                  
                  $("#list_datas").DataTable({
                      searching: false,bLengthChange: false,rowReorder: false,ordering: false
                  });
                  save_reset_field();
                  $("#modal_success").modal('show');
                }
            },
        });
    }

    function open_delete(id,name) {
      name = name.replace(/\#/g,' ');
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
            url: "{{route('delete_courier')}}",
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

                    var name = data.data[x]['name'].replace(/\s/g,'#');
                    var btn = "<td class='text-center'><button class='btn btn-primary btn-fab btn-fab-mini btn-round' onclick=open_detail('"+data.data[x]['id']+"')><i class='material-icons'>view_list</i></button></td>";
                    var btn_del = "<td class='text-center'><button class='btn btn-danger btn-fab btn-fab-mini btn-round' onclick=open_delete('"+data.data[x]['id']+"','"+name+"')><i class='material-icons'>delete</i></button></td>";
                    string_html += "<tr><td>"+data.data[x]['name']+"</td><td>"+data.data[x]['address']+"</td><td>"+data.data[x]['phone1']+"</td><td>"+data.data[x]['email']+"</td>"+btn_del+"</tr>";
                  }
                  $("#main_table").html(string_html);
                  $("#modal_delete").modal('hide');
                  
                  $("#list_datas").DataTable({
                      searching: false,bLengthChange: false,rowReorder: true,ordering: false
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

    function open_modal_create() {
      $("#modal_create").modal('show');
    }
</script>