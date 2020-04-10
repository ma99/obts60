<div v-show="showDataErrors" class="alert alert-danger fade show" role="alert">
  
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  
  <ol class="my-4"> 
    <li class="mb-1" v-for="(error, index) in dataErrors"> 
      @{{ error[0] }} 
    </li>
  </ol>                  
  
</div>