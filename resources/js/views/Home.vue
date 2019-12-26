<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fas fa-dashboard nav-icon"></i>Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">        
          <div class="col-md-8 col-md-offset-2">
              <div class="card">
                  <div class="card-header">Dashboard Home Page</div>
                  <div class="card-body">
                      Welcome to Dashboard home page
                  </div>
              </div>
          </div>    
          
          <div class="col-md-5">
              <div class="card">
                  <div class="card-header">Something-1</div>
                  <div class="card-body">
                      Welcome to Dashboard home page
                  </div>
              </div>
          </div> 

          <div class="col-md-5">
              <div class="card">
                  <div class="card-header">Something-2</div>
                  <div class="card-body">
                      Welcome to Dashboard home page
                  </div>
              </div>
          </div>
        </div>
      </div>       
    </section>        
  </div>      
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>