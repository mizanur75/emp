<div class="container top-brand">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <div class="sidebar-header"> <a href="{{Auth::user()->role->id == 1? route('admin.dashboard'):route('employee.dashboard')}}"><img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo" style="height: 75px;"></a>
            </div>
        </div>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link">
                    <span title="Fullscreen" class="ti-fullscreen fullscreen"></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="ti-user" style="background-color: red; color: white; font-weight: bold;"></span>
                </a>
                <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                    <h5>{{Auth::user()->first_name}}</h5>
                    <a class="dropdown-item" href="#">
                        <span class="ti-settings"></span> Settings</a>
                    <a class="dropdown-item" href="#">
                        <span class="ti-help-alt"></span> Help</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" >
                        <span class="ti-power-off"></span> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                </div>
            </li>
        </ul>

    </nav>
</div>
<!-- Top Navigation -->
<!-- Menu -->
<div class="container menu-nav">
    <nav class="navbar navbar-expand-lg proclinic-bg text-white">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown {{Request::is('admin/dashboard')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <span class="ti-home"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/employee*')?'active':''}}">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fa fa-users"></i> Employees</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.employee.index')}}">All Employees</a>
                        <a class="dropdown-item" href="{{route('admin.employee.create')}}">Add Employee</a>
                    </div>
                </li>

                <li class="nav-item dropdown {{Request::is('admin/attendance*')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.attendance.index')}}">
                        <span class="fa fa-clock-o"></span> Attendance</a>
                </li>
                <li class="nav-item dropdown {{Request::is('admin/report*')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.report')}}">
                        <span class="fa fa-bar-chart"></span> Report</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- /Menu
