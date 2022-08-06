<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/template_admin/img/apple-icon.png') }}"> --}}
        {{-- <link rel="icon" type="image/png" href="{{ asset('/img/favicon.png') }}"> --}}
        {{-- <link rel="icon" type="image/png" href="{{ asset('/img/logo2.png') }}"> --}}
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>
          TEST INDOSPRING
        </title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/template_admin/css/material-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('/template_admin/css/font-awesome.min.css') }}">
        <!-- CSS Files -->
        <link href="{{ asset('/template_admin/css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        {{-- <link href="{{ asset('/template_admin/demo/demo.css') }}" rel="stylesheet" /> --}}
        <style>
          /* MODAL CONFIRM SUCCESS */
          body {
            font-family: 'Varela Round', sans-serif;
          }
          .modal-confirm {		
            color: #636363;
            width: 325px;
            font-size: 14px;
          }
          .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
          }
          .modal-confirm .modal-header {
            border-bottom: none;   
            position: relative;
          }
          .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -15px;
          }
          .modal-confirm .form-control, .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px; 
          }
          .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -5px;
          }	
          .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
          }	
          .modal-confirm .icon-box {
            color: #fff;		
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: -70px;
            width: 95px;
            height: 95px;
            border-radius: 50%;
            z-index: 9;
            background: #82ce34;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
          }
          .modal-confirm .icon-box i {
            font-size: 58px;
            position: relative;
            top: 3px;
          }
          .modal-confirm.modal-dialog {
            margin-top: 80px;
          }
          .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            background: #82ce34;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border: none;
          }
          .modal-confirm .btn:hover, .modal-confirm .btn:focus {
            background: #6fb32b;
            outline: none;
          }
          .trigger-btn {
            display: inline-block;
            margin: 100px auto;
          }
        </style>
        <style>
          #list_datas_filter {
            float:right;
          }
          .modal-delete {		
            color: #636363;
            width: 400px;
          }
          .modal-delete .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
          }
          .modal-delete .modal-header {
            border-bottom: none;   
            position: relative;
          }
          .modal-delete h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
          }
          .modal-delete .close {
            position: absolute;
            top: -5px;
            right: -2px;
          }
          .modal-delete .modal-body {
            color: #999;
          }
          .modal-delete .modal-footer {
            border: none;
            text-align: center;		
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
          }
          .modal-delete .modal-footer a {
            color: #999;
          }		
          .modal-delete .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
          }
          .modal-delete .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
          }
          .modal-delete .btn, .modal-delete .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
          }
          .modal-delete .btn-secondary {
            background: #c1c1c1;
          }
          .modal-delete .btn-secondary:hover, .modal-delete .btn-secondary:focus {
            background: #a8a8a8;
          }
          .modal-delete .btn-danger {
            background: #f15e5e;
          }
          .modal-delete .btn-danger:hover, .modal-delete .btn-danger:focus {
            background: #ee3535;
          }
          .trigger-btn {
            display: inline-block;
            margin: 100px auto;
          }
        </style>
    </head>

    <body class="">
        <div class="wrapper ">
          <div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('/template_admin/img/sidebar-1.jpg') }}">
            <!-- Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger" Tip 2: you can also add an image using data-image tag -->
            <div class="logo" style='display:none'>
              <a href="" class="simple-text logo-normal">
                
              </a>
            </div>
            <div class="sidebar-wrapper">
              <ul class="nav">
                
                <li class="nav-item @if ($nav_tab=='dashboard') @php echo('active') @endphp @endif">
                  <a class="nav-link" href="{{ action('App\Http\Controllers\AdminController@index') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link collapsed" data-toggle="collapse" href="#order_menu" aria-expanded="false">
                    <i class="material-icons">content_paste</i>
                    <p>Orders
                      <b class="caret"></b>
                    </p>
                  </a>
                  <div class="collapse @if ($nav_tab=='create_order'||$nav_tab=='list_orders'||$nav_tab=='create_po'||$nav_tab=='list_po') @php echo('show') @endphp @endif" id="order_menu" style="">
                    <ul class="nav">
                      <li class="nav-item @if ($nav_tab=='create_order') @php echo('active') @endphp @endif"">
                        <a class="nav-link" href="{{ action('App\Http\Controllers\OrderController@create_order') }}">
                          <span class="sidebar-mini"> CO </span>
                          <span class="sidebar-normal">Create Order </span>
                        </a>
                      </li>
                      <li class="nav-item @if ($nav_tab=='list_orders') @php echo('active') @endphp @endif"">
                        <a class="nav-link" href="{{ action('App\Http\Controllers\OrderController@list_orders') }}">
                          <span class="sidebar-mini"> LO </span>
                          <span class="sidebar-normal"> List Orders </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="nav-item" id="logout_btn" onclick="logout_()">
                  <a class="nav-link" href="#">
                    <i class="material-icons">logout</i>
                    <p>Logout</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-bottom">
              <div class="container-fluid">
                <div class="navbar-wrapper">
                  <a class="navbar-brand" href="javascript:;"></a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="navbar-toggler-icon icon-bar"></span>
                  <span class="navbar-toggler-icon icon-bar"></span>
                  <span class="navbar-toggler-icon icon-bar"></span>
                </button>
              </div>
            </nav>
            <!-- End Navbar --> 
            <div class="content-new" style='margin-top:0%;'>
              <div class="container-fluid">
                  @yield('Content')
              </div>
            </div>
            <footer class="footer" style='display:none'>
              <div class="container-fluid">
                <nav class="float-left" >
                  <ul>
                    <li>
                      <a href="https://www.instagram.com/charlesfong20/">
                        Charles
                      </a>
                    </li>
                  </ul>
                </nav>
                <div class="copyright float-right">
                  &copy;
                  <script>
                    document.write(new Date().getFullYear())
                  </script>
                  {{-- , made with <i class="material-icons">favorite</i> by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web. --}}
                </div>
              </div>
            </footer>
          </div>
        </div>
        {{-- <div class="fixed-plugin">
          <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
              <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
              <li class="header-title"> Sidebar Filters</li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                  <div class="badge-colors ml-auto mr-auto">
                    <span class="badge filter badge-purple" data-color="purple"></span>
                    <span class="badge filter badge-azure" data-color="azure"></span>
                    <span class="badge filter badge-green" data-color="green"></span>
                    <span class="badge filter badge-warning" data-color="orange"></span>
                    <span class="badge filter badge-danger" data-color="danger"></span>
                    <span class="badge filter badge-rose active" data-color="rose"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="header-title">Images</li>
              <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{ asset('/template_admin/img/sidebar-1.jpg') }}" alt="">
                </a> 
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{ asset('/template_admin/img/sidebar-2.jpg') }}" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('/template_admin/img/sidebar-3.jpg') }}" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('/template_admin/img/sidebar-4.jpg') }}" alt="">
                </a>
              </li>
            </ul>
          </div>
        </div> --}}

        {{-- MODAL  --}}
        <div id="modal_delete" class="modal fade">
          <div class="modal-dialog modal-delete">
            <div class="modal-content">
              <div class="modal-header flex-column">
                <div class="icon-box">
                  <i class="material-icons">&#xE5CD;</i>
                </div>						
                <h4 class="modal-title w-100">Are you sure?</h4>	
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete these records <span id='modal_delete_info'></span>?</p>
              </div>
              <div class="modal-footer justify-content-center">
                <input type='hidden' name='id_delete' id='id_delete'>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id='btn_delete' onclick="go_delete()">Delete</button>
              </div>
            </div>
          </div>
        </div>     
        {{-- END OF MODAL DELETE --}}

        {{-- MODAL DELETE --}}
        <div id="modal_confirm" class="modal fade">
          <div class="modal-dialog modal-delete">
            <div class="modal-content">
              <div class="modal-header flex-column">
                <div class="icon-box">
                  <i class="material-icons">&#xE5CD;</i>
                </div>						
                <h4 class="modal-title w-100">Are you sure?</h4>	
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete these records <span id='modal_delete_info'></span>? This process cannot be undone.</p>
              </div>
              <div class="modal-footer justify-content-center">
                <input type='hidden' name='id_delete' id='id_delete'>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id='btn_delete' onclick="go_delete()">Delete</button>
              </div>
            </div>
          </div>
        </div>     
        {{-- END OF MODAL DELETE --}}

        {{-- MODAL SUCCESS --}}
        <div id="modal_success" class="modal fade">
          <div class="modal-dialog modal-confirm">
            <div class="modal-content">
              <div class="modal-header">
                <div class="icon-box">
                  <i class="material-icons">&#xE876;</i>
                </div>				
                <h4 class="modal-title w-100">Success!</h4>	
              </div>
              <div class="modal-body">
                <p class="text-center">Your process has been saved.</p>
              </div>
              <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>  
        {{-- END OF MODAL CONFIRM --}}

        <!--   Core JS Files   -->
        <script src="{{ asset('/template_admin/js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('/template_admin/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('/template_admin/js/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('/template_admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('/template_admin/js/plugins/moment.min.js') }}"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('/template_admin/js/plugins/sweetalert2.js') }}"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('/template_admin/js/plugins/jquery.validate.min.js') }}"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('/template_admin/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('/template_admin/js/plugins/bootstrap-selectpicker.js') }}"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('/template_admin/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('/template_admin/js/plugins/jquery.dataTables.min.js') }}"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('/template_admin/js/plugins/bootstrap-tagsinput.js') }}"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('/template_admin/js/plugins/jasny-bootstrap.min.js') }}"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('/template_admin/js/plugins/fullcalendar.min.js') }}"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('/template_admin/js/plugins/jquery-jvectormap.js') }}"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('/template_admin/js/plugins/nouislider.min.js') }}"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('/template_admin/js/plugins/arrive.min.js') }}"></script>
        <!--  Google Maps Plugin    -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHNjCuiqCCNYUfWDeB9-DUdLwZr-pRKv8"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('/template_admin/js/plugins/chartist.min.js') }}"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('/template_admin/js/plugins/bootstrap-notify.js') }}"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('/template_admin/js/material-dashboard.js?v=2.1.2') }}" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        {{-- <script src="{{ asset('/template_admin/demo/demo.js') }}"></script> --}}
        <script src="{{ asset('/js/mask.js') }}"></script>
        <script>

          var interval = 3000;
          var stopBlinking = false;

          function blink(selector) {
              if(stopBlinking)
                  return false;
            
              $(selector).fadeOut('slow', function() {
                  $(this).fadeIn('slow', function() {
                      blink(this);
                  });
              });
          }

          // blink("#new_module");

          setInterval(function(){ 
              stopBlinking = !stopBlinking; 
              blink("#new_module");
          }, interval);

          function addCommas(nStr) {
              nStr += '';
              x = nStr.split('.');
              x1 = x[0];
              x2 = x.length > 1 ? '.' + x[1] : '';
              var rgx = /(\d+)(\d{3})/;
              while (rgx.test(x1)) {
                  x1 = x1.replace(rgx, '$1' + '.' + '$2');
              }
              console.log(x1+"_"+x2);
              return x1 + x2;
          }
    
          function logout_(){
            // var data = {
            //     "_token": "{{ csrf_token() }}"
            // };
            // $.post("{{ route('logout') }}", function(data){
              
            // });
            $.ajax({
              type:'POST',
              url:"{{ route('logout') }}",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  "_token": "{{ csrf_token() }}",
              },
              success:function(){
                  window.location.href = '../';
              }
            });
          }
          $(document).ready(function() {
            $().ready(function() {
              $sidebar = $('.sidebar');
      
              $sidebar_img_container = $sidebar.find('.sidebar-background');
      
              $full_page = $('.full-page');
      
              $sidebar_responsive = $('body > .navbar-collapse');
      
              window_width = $(window).width();
      
              fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
      
              if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                  $('.fixed-plugin .dropdown').addClass('open');
                }
      
              }
      
              $('.fixed-plugin a').click(function(event) {
                // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                if ($(this).hasClass('switch-trigger')) {
                  if (event.stopPropagation) {
                    event.stopPropagation();
                  } else if (window.event) {
                    window.event.cancelBubble = true;
                  }
                }
              });
      
              $('.fixed-plugin .active-color span').click(function() {
                $full_page_background = $('.full-page-background');
      
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
      
                var new_color = $(this).data('color');
      
                if ($sidebar.length != 0) {
                  $sidebar.attr('data-color', new_color);
                }
      
                if ($full_page.length != 0) {
                  $full_page.attr('filter-color', new_color);
                }
      
                if ($sidebar_responsive.length != 0) {
                  $sidebar_responsive.attr('data-color', new_color);
                }
              });
      
              $('.fixed-plugin .background-color .badge').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
      
                var new_color = $(this).data('background-color');
      
                if ($sidebar.length != 0) {
                  $sidebar.attr('data-background-color', new_color);
                }
              });
      
              $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');
      
                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');
      
      
                var new_image = $(this).find("img").attr('src');
      
                if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                  $sidebar_img_container.fadeOut('fast', function() {
                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $sidebar_img_container.fadeIn('fast');
                  });
                }
      
                if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                  var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
      
                  $full_page_background.fadeOut('fast', function() {
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    $full_page_background.fadeIn('fast');
                  });
                }
      
                if ($('.switch-sidebar-image input:checked').length == 0) {
                  var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                  var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
      
                  $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                  $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }
      
                if ($sidebar_responsive.length != 0) {
                  $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }
              });
      
              $('.switch-sidebar-image input').change(function() {
                $full_page_background = $('.full-page-background');
      
                $input = $(this);
      
                if ($input.is(':checked')) {
                  if ($sidebar_img_container.length != 0) {
                    $sidebar_img_container.fadeIn('fast');
                    $sidebar.attr('data-image', '#');
                  }
      
                  if ($full_page_background.length != 0) {
                    $full_page_background.fadeIn('fast');
                    $full_page.attr('data-image', '#');
                  }
      
                  background_image = true;
                } else {
                  if ($sidebar_img_container.length != 0) {
                    $sidebar.removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                  }
      
                  if ($full_page_background.length != 0) {
                    $full_page.removeAttr('data-image', '#');
                    $full_page_background.fadeOut('fast');
                  }
      
                  background_image = false;
                }
              });
      
              $('.switch-sidebar-mini input').change(function() {
                $body = $('body');
      
                $input = $(this);
      
                if (md.misc.sidebar_mini_active == true) {
                  $('body').removeClass('sidebar-mini');
                  md.misc.sidebar_mini_active = false;
      
                  $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
      
                } else {
      
                  $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
      
                  setTimeout(function() {
                    $('body').addClass('sidebar-mini');
      
                    md.misc.sidebar_mini_active = true;
                  }, 300);
                }
      
                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                  window.dispatchEvent(new Event('resize'));
                }, 180);
      
                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                  clearInterval(simulateWindowResize);
                }, 1000);
      
              });
            });
          });
        </script>
        <script>
          $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();
      
          });
        </script>
    </body>
</html>
