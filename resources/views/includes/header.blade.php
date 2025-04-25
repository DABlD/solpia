
  <header class="main-header">
    <a href="index2.html" class="logo">
      <span class="logo-mini">
        <img src="{{ asset('images/logo.png') }}" alt="Solpia Logo" width="30px" height="30px">
      </span>
      {{-- <span class="logo-lg">{{ env('app_name') }}</span> --}}
      {{-- <span class="logo-lg">Solpia</span> --}}
      <span class="logo-lg">
        <img src="{{ asset('images/logo.png') }}" alt="Solpia Logo" width="60%" height="50px">
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Messages: style can be found in messages.less -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">5</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 5 messages</li>
              <li>
                <ul class="menu">

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('images/default_avatar.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Test Name
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Test Message</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('images/default_avatar.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Test Name
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Test Message</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('images/default_avatar.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Test Name
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Test Message</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('images/default_avatar.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Test Name
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Test Message</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{ asset('images/default_avatar.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Test Name
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Test Message</p>
                    </a>
                  </li>

                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> Test Notif
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Test Notif Test Notif Test Notif Test Notif Test Notif Test Notif Test Notif
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> Test Notif
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> Test Notif
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> Test Notif
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset(auth()->user()->avatar)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ auth()->user()->fullname }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset(auth()->user()->avatar)}}" class="img-circle" alt="User Image">
                <p>
                  {{ auth()->user()->fullname }}
                  <small>Member since {{ auth()->user()->created_at->format('M. d, Y') }}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" style="color: white;">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" style="color: white;" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>