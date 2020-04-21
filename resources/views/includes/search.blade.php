<div class="form-row justify-content-center">
  <div class="form-group col-8">
  <autocomplete :suggestions="availableCityList" v-model="selectedCityFrom" input-label="From">
  </autocomplete>
  </div>
  <div class="form-group col-8">
    <autocomplete :suggestions="availableCityList" v-model="selectedTo" input-label="To">
    </autocomplete>
  </div>
  <div class="form-group col-8">  
      <label for="startDate">Date of Journey</label> 
      <div id="sandbox-container">
        <div class="input-group date">
          <input name="date" id="startDate" class="form-control border-right-0" type="text" v-model="startDate" placeholder="Select Date">
          <span class="input-group-append">
              <div class="input-group-text bg-white"><i class="fas fa-calendar-alt"></i></div>
          </span>
        </div>
      </div>
  </div>
  <div class="col-8">
    <button type="button" v-on:click.prevent="searchBus" class="btn btn-warning btn-search form-control" :disabled="isDisabled">Search &nbsp;
      <i class="fa fa-search"></i>
    </button>
  </div>                          
</div> 