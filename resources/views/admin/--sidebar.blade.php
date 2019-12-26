<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" exact><i class="nav-icon fas fa-clock-o"></i> <span>Home</span></router-link>
          </li>
          <li class="nav-item">
            <router-link to="/about"><i class="nav-icon fas fa-table" aria-hidden="true"></i>About</router-link>
          </li>            
          <li class="nav-item">
            <router-link to="/contact"><i class="nav-icon fas fa-link" aria-hidden="true"></i>Contact</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/staff-management"><i class="nav-icon fas fa-cog" aria-hidden="true"></i>Staff Management</router-link>
          </li>                        
          <li class="nav-item has-treeview">
            <a href="#">
              <i class="nav-icon fas fa-user"></i> 
              <span>User<i class="fas fa-angle-left right"></i></span>          
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/profile">
                  <i class="nav-icon fas fa-address-card" aria-hidden="true"></i>
                  Profile
                </router-link> 
              </li>
              <li class="nav-item"> 
                <router-link to="/roles">
                  <i class="nav-icon fas fa-plus" aria-hidden="true"></i>
                  Set Roles
                </router-link>
             </li>
              <li class="nav-item">
                <router-link to="/staff-list">
                  <i class="nav-icon fas fa-address-book-o" aria-hidden="true"></i>
                  Admin Staff
                </router-link>
              </li>                  
              <li class="nav-item"><a href="#">Link in level 2</a></li>
              <li class="nav-item"><a href="#">Link in level 2</a></li>
            </ul>
          </li>
          {{-- Bus Management --}}      
          <li class="nav-item has-treeview">
            <a href="#">
              <i class="nav-icon fas fa-bus" aria-hidden="true"></i>
              <span>Bus <i class="fas fa-angle-left right"></i></span>              
            </a>
            <ul class="nav nav-treeview">
              <li>
                <router-link to="/bus">
                    <i class="nav-icon fas fa-bus" aria-hidden="true"></i>Bus
                </router-link> 
              </li>          
              <li> 
                <router-link to="/bus-list">
                  <i class="nav-icon fas fa-plus" aria-hidden="true"></i>Bus List
                </router-link>
             </li> 
             <li>
                <router-link to="/city">
                  <i class="nav-icon fas fa-map-marker" aria-hidden="true"></i>City
                </router-link> 
              </li>
              <li>
                <router-link to="/route">
                  <i class="nav-icon fas fa-exchange" aria-hidden="true"></i>Route
                </router-link> 
              </li>
              <li>
                <router-link to="/seat-plan">
                  <i class="nav-icon fas fa-list-alt" aria-hidden="true"></i>Seat Plan
                </router-link> 
              </li> 
              <li>
                <router-link to="/schedule">
                  <i class="nav-icon fas fa-list-alt" aria-hidden="true"></i>Schedule
                </router-link> 
              </li>           
              <li>
                <router-link to="/stop">
                  <i class="nav-icon fas fa-link" aria-hidden="true"></i>Stop
                </router-link> 
              </li>  
            </ul>
          </li>
        </ul>
      </nav>  
  </div>
</aside>