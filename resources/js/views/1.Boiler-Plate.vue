<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Page Name</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fas fa-dashboard nav-icon"></i>Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Page Name</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <!-- Your Page Content Here -->     
        </div>
      </div>       
    </section>

  </div>      
</template>

<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
    }
</script>