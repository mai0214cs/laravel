<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('tagtitle')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('libadmin/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('libadmin/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('libadmin/dist/css/skins/_all-skins.min.css')}}">
    
    <link href="/Lib/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
    
    
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
         
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>{{$data[0]['Trang quản trị Web']}}</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <?= \Session::get('ViewLanguage')?>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Bạn có 10 thư mới</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 thành viên đăng nhập hôm nay
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">Xem tất cả</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Bạn có 9 phản hồi mới</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">Xem tất cả phản hồi</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{@asset('libadmin/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{\Session::get('UserAdmin')->fullname}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{@asset('libadmin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{@asset('libadmin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{\Session::get('UserAdmin')->fullname}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>{{$data[0]['Trang chủ quản trị']}}</span></i>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>{{$data[0]['Sản phẩm']}}</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{@asset('admin/product/category')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Danh mục sản phẩm']}}</a></li>
                <li><a href="{{@asset('admin/product/list')}}"><i class="fa fa-circle-o"></i>Danh sách sản phẩm</a></li>
                <li><a href="{{@asset('admin/product/procedure')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Nhà sản xuất']}}</a></li>
                <li>
                    <a href="{{@asset('admin/product/filter')}}"><i class="fa fa-circle-o"></i><span>{{$data[0]['Trang Bộ lọc sản phẩm']}}</span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{@asset('admin/product/filterdefault')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Bộ lọc mặc đinh']}}</a></li>
                        <li><a href="{{@asset('admin/product/filter')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Bộ lọc tùy chọn']}}</a></li>
                    </ul>
                </li>
                <li><a href="{{@asset('admin/product/tags')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Tags Sản phẩm']}}</a></li>
                <li><a href="{{@asset('admin/product/tags')}}"><i class="fa fa-circle-o"></i>Thiết lập thanh toán</a></li>
                <li><a href="{{@asset('admin/product/tags')}}"><i class="fa fa-circle-o"></i>Thiết lập vận chuyển</a></li>
                <li><a href="{{@asset('admin/product/tags')}}"><i class="fa fa-circle-o"></i>Thiết lập khuyến mại</a></li>
                <li><a href="{{@asset('admin/product/tags')}}"><i class="fa fa-circle-o"></i>Thiết lập giảm giá</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>{{$data[0]['Tin tức']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{@asset('admin/news/category')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Danh mục tin tức']}}</a></li>
                <li><a href="{{@asset('admin/news/list')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Danh sách tin tức']}}</a></li>
                <li><a href="{{@asset('admin/news/tags')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Tags Tin tức']}}</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>{{$data[0]['Khách hàng']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> Nhóm khách hàng</a></li>
                <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Danh sách khách hàng</a></li>
                <li><a href="/admin/customer/commentnews"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Bình luận tin tức']}}</a></li>
                <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Phản hồi sản phẩm</a></li>
                <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Danh sách đơn hàng</a></li>
                <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Danh sách liên hệ</a></li>
                <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Danh sách đăng ký email</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-edit"></i> <span>{{$data[0]['Tiện ích']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> Banner</a></li>
                <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Footer</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Trình đơn</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Thư viện ảnh</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Thư viện video</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Thư viện download</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Bản đồ</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Hỗ trợ trực tuyến</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Thư viện ảnh</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Thăm dò dư luận</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Form Liên hệ</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Lịch làm việc</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Biểu đồ</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Nội dung HTML</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>{{$data[0]['Giao diện']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{@asset('admin/news/category')}}"><i class="fa fa-circle-o"></i> Thiết lập chung</a></li>
                <li><a href="{{@asset('admin/design/item/1')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Cài đặt mục Sản phẩm']}}</a></li>
                <li><a href="{{@asset('admin/design/item/0')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Cài đặt mục Tin tức']}}</a></li>
                <li><a href="{{@asset('admin/design/modul')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Cài đặt Modul']}}</a></li>
                <li><a href="{{@asset('admin/design/template')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Cài đặt Template']}}</a></li>
                <li><a href="{{@asset('admin/design/page')}}"><i class="fa fa-circle-o"></i>{{$data[0]['Trang Cài đặt Page']}}</a></li>
                <li><a href="{{@asset('admin/news/category')}}"><i class="fa fa-circle-o"></i> Giao diện trang mặc định</a></li>
              </ul>
            </li>
            <li class="treeview active">
              <a href="#">
                <i class="fa fa-folder"></i> <span>{{$data[0]['Đa ngôn ngữ']}}</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>{{$data[0]['Thành viên']}}</span>
              </a>
            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('title')
          </h1>
          <ol class="breadcrumb">
              <li><a href="admin/"><i class="fa fa-dashboard"></i> {{$data[0]['Trang chủ quản trị']}}</a></li>
              @yield('breadcumb')
          </ol>
        </section>
        <div class="box-msg">
            <?php $a = new \App\Common\InfoMessage(); $a->Index(); ?>
        </div>
        <!-- Main content -->
        <section class="content"><div class="box">
            @yield('content')
            </div></section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2015 <a href="http://netdesi.com">Mai Đức Thạch</a>.</strong> 
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('libadmin/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{asset('libadmin/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('libadmin/plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('libadmin/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('libadmin/dist/js/demo.js')}}"></script>
    <script src="{{asset('libadmin/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('libadmin/ckfinder/ckfinder.js')}}" type="text/javascript"></script>
    <script src="/Lib/Fancybox/jquery.fancybox.js" type="text/javascript"></script>
    <script src="/Lib/Fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/Lib/Fancybox/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>
    <script src="{{asset('libadmin/admin.js')}}"></script>
    @yield('footer')
  </body>
</html>
