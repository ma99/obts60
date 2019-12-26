<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="/images/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->    
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
       {{--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
          </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->          
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link" exact><i class="nav-icon fas fa-th"></i> <p>Home</p></router-link>
            </li>

            <li class="nav-item">
              <router-link to="/about" class="nav-link"><i class="nav-icon fas fa-th"></i> <p>About</p></router-link>
            </li>

            <li class="nav-item">
              <router-link to="/contact" class="nav-link"><i class="nav-icon fas fa-link" aria-hidden="true"></i>Contact</router-link>
            </li>

            <li class="nav-item">
              <router-link to="/staff-management" class="nav-link"><i class="nav-icon fas fa-cog" aria-hidden="true"></i>Staff Management</router-link>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i> 
                <p>User<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/profile" class="nav-link">
                    <i class="nav-icon fas fa-address-card" aria-hidden="true"></i>
                    Profile
                  </router-link> 
                </li>
                <li class="nav-item"> 
                  <router-link to="/roles" class="nav-link">
                    <i class="nav-icon fas fa-plus" aria-hidden="true"></i>
                    Set Roles
                  </router-link>
               </li>
                <li class="nav-item">
                  <router-link to="/staff-list" class="nav-link">
                    <i class="nav-icon far fa-circle" aria-hidden="true"></i>
                    Admin Staff
                  </router-link>
                </li>                  
                <li class="nav-item"><a href="#">Link in level 2</a></li>
                <li class="nav-item"><a href="#">Link in level 2</a></li>
              </ul>
            </li>
             {{-- Bus Management --}}      
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bus" aria-hidden="true"></i>
                <p>Bus <i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/bus" class="nav-link">
                      <i class="nav-icon fas fa-bus" aria-hidden="true"></i>Bus
                  </router-link> 
                </li>          
                <li class="nav-item"> 
                  <router-link to="/bus-list" class="nav-link">
                    <i class="nav-icon fas fa-plus" aria-hidden="true"></i>Bus List
                  </router-link>
               </li> 
               <li class="nav-item">
                  <router-link to="/city" class="nav-link">
                    <i class="nav-icon fas fa-map-marker" aria-hidden="true"></i>City
                  </router-link> 
                </li>
                <li class="nav-item">
                  <router-link to="/route" class="nav-link">
                    <i class="nav-icon fas fa-exchange" aria-hidden="true"></i>Route
                  </router-link> 
                </li>
                <li class="nav-item">
                  <router-link to="/seat-plan" class="nav-link">
                    <i class="nav-icon fas fa-list-alt" aria-hidden="true"></i>Seat Plan
                  </router-link> 
                </li> 
                <li class="nav-item">
                  <router-link to="/schedule" class="nav-link">
                    <i class="nav-icon fas fa-list-alt" aria-hidden="true"></i>Schedule
                  </router-link> 
                </li>           
                <li class="nav-item">
                  <router-link to="/stop" class="nav-link">
                    <i class="nav-icon fas fa-link" aria-hidden="true"></i>Stop
                  </router-link> 
                </li>  
              </ul>
            </li>          
            <li class="nav-header">MISCELLANEOUS</li>          
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>    
    <!-- /.sidebar -->
  </aside>