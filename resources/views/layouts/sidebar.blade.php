<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name}}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <!-- Optionally, you can add icons to the links -->
      <li class="active"><a href="/"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
      <li>
        <a href="{{ url('employee-management') }}">
          <i class="fa fa-link"></i> 
          <span>Employee Management</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('system-management/department') }}">Department</a></li>
          <li><a href="{{ url('system-management/division') }}">Division</a></li>
          <li><a href="{{ url('system-management/country') }}">Country</a></li>
          <li><a href="{{ url('system-management/state') }}">State</a></li>
          <li><a href="{{ url('system-management/city') }}">City</a></li>
          <li><a href="{{ url('system-management/report') }}">Report</a></li>
        </ul>
      </li>
      <li>
        <a href="{{ route('user.index') }}">
          <i class="fa fa-link"></i> 
          <span>User management</span>
        </a>
      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
