<template>
  <div>    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Fare</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Fare</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
              <span v-show="!editMode" style="font-size: 1.1rem; color: #81c784;">
                <span class="fa-stack fa-2x">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-file-invoice fa-stack-1x fa-inverse"></i>
                </span>  
                Add Fare 
              </span>              
            <span v-show="editMode" style="font-size: 1.1rem; color: #ff9800;">
              <span class="fa-stack fa-2x">
                <i class="fas fa-circle fa-stack-2x"></i>
                <i class="fas fa-edit fa-stack-1x fa-inverse"></i>
              </span>  
              Edit Fare 
            </span> 
          </template>
          <form> 
                <border color="eastern-blue" pattern="dashed" width="1"                
                >
                  <!-- <template v-slot:heading>Set Fare</template>  -->
                  <div class="form-row justify-content-center">
                     <div class="col-sm-4">
                      <div class="form-group">
                        <label for="route">Route</label>
                          <select v-model="route.id" class="form-control custom-select" id="route" :disabled="editMode">
                              <option disabled value="">Please select one</option>
                              <option v-for="route in availableRouteList" v-bind:value="route.id">
                                  <strong>{{ route.id }}</strong> <small> {{ route.departure_city }} -> {{ route.arrival_city }}</small>
                              </option>                                             
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="city">City</label>
                          <select v-model="city.id" class="form-control custom-select" id="city" :disabled="editMode">
                              <option disabled value="">Please select one</option>
                              <option v-for="city in citiesByRoute" v-bind:value="city.id">
                                  <strong>{{ city.name }}</strong> <small> {{city.pivot.distance}}</small>
                              </option>                                             
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <table class="table table-striped table-hover">
                        <thead><tr></tr></thead>
                        <tbody>
                              <tr>                                                               
                                <td v-for="(type, index) in types">
                                  <div class="form-group" v-show="isCombined(type)">
                                      <label>{{ type.name }}</label>
                                      <input v-model="fare[type.key]" type="text" v-bind:style="formControl" class="form-control" :placeholder="type.name" data-toggle="tooltip" data-placement="top" title="Use '|' i.e 800|900" required="required">
                                  </div>

                                  <div class="form-group" v-show="!isCombined(type)">
                                      <label>{{ type.name }}</label>
                                      <input v-model="fare[type.key]" type="number" v-bind:style="formControl" class="form-control" :placeholder="type.name" required="required">
                                  </div>
                                </td>
                              </tr>                           
                        </tbody>
                      </table>      
                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="save()"  type="button" class="btn btn-primary" v-show="!editMode">Save</button>
                        <button v-on:click.prevent="update()"  type="button" class="btn btn-success" v-show="editMode">Update</button>
                        <button v-on:click.prevent="reset()"  type="button" class="btn btn-primary">Cancel</button>
                      </div>
                    </div>
                  </div>
                </border>            
          </form>            

          <template v-slot:footer>
            <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
              <strong> Fare </strong> has been <strong>{{ actionStatus }} </strong>
              </show-alert>
          </template>
        </add-section>
        <loader :show="loading"></loader>
        <div class="row info-table">
          <div class="card w-100">
            <div class="card-body">
                <div id="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>SL.# </th>                                
                          <th>ROUTE
                            <span type="button" @click="sortByIdOf('totalSeats')" :disabled="!disableSorting">
                              <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                          </th>
                          <th>CITY</th>
                          <th>FARE</th>
                          <th>Action</th>                                                         
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(fare, index) in availableFareList" >                              
                          <td>{{ index+1 }}</td>                                                              
                          <td>{{ routeBy(fare.route_id) }}</td>
                          <td>{{ cityBy(fare.city_id) }}</td>
                          <!-- <td>{{ dateCreated(seatplan.created_at) }}</td> -->                          
                          <td>                            
                            <ol class="fare"> 
                              <li v-for="(type, index) in types"> 
                                {{type.name}}: {{fare.details[type.key]}} 
                              </li>
                            </ol>
                          </td>
                          <td>                              
                              <button type="button" class="btn btn-outline-info" v-on:click.prevent="edit(fare)">    
                                <i class="button-icon fas fa-pen"></i>Edit
                              </button>                                 
                              <button v-on:click.prevent="remove(fare)" class="btn btn-outline-danger">
                                <i class="button-icon fas fa-trash"></i>Remove
                              </button> 
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
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
        data() {
                return {                    
                    actionStatus: '',
                    alertType: '',                    
                    availableCityList: [],                    
                    availableFareList: [],                                        
                    disableShowButton: false,
                    //disableSaveButton: true,
                    disableSorting: true,
                    editMode: false,
                    error: '',        
                    formControl: {
                      backgroundColor: '#fff',
                    },                                    
                    response: '',                         
                    isDisabled: false,                    
                    loading: false,                                        
                    showAlert: false,
                    show: false,                    
                    modal: false,               
                    types: [],                    
                    fare: {},
                    fareToedit: {
                      id: '',
                      index: ''
                    },
                    availableRouteList: [],
                    citiesByRoute: [],
                    city: {
                      id: '',
                      name: '',
                      distance: ''
                    },
                    route: {
                      id: '',
                      departure_city: '',
                      arrival_city: '',
                      //distance: ''
                    },                    
                }
                },
                watch: {
                    'route.id'(val, oldVal) {
                      if (this.route.id) {                        
                        this.fetchCitiesBy(this.route.id);                        
                      }
                    },
                },      
                mounted() {                    
                    this.fetchBusTypes();
                    this.fetchCities();
                    this.fetchRoutes();                    
                    this.fetchAvailableFares();
                    this.enableScroll();                
                },  
                methods: {                  
                  isCombined(type) {
                    // if (type.key.includes('|')) {
                    //   let types = type.key.split('|');
                    //   let t1, t2;
                    //   t1= types[0];
                    //   t2= types[1];
                    //   this.combineType[type.key] = {                       
                    //     [t1]: types[0],
                    //     [t2]: types[1],
                    //   };                      
                    //   return true; 
                    // }
                    return type.key.includes('|') ? true : false;
                  },                  
                  cityBy(id) {
                    let city = this.availableCityList.find(city => city.id == id);
                    if(city) {                      
                      return `${city.name}`;
                    }                                  
                  },
                  routeBy(id) {
                    let route = this.availableRouteList.find(route => route.id == id);
                    if(route) {                      
                      return `${route.departure_city} to ${route.arrival_city}`;
                    }                                  
                  },
                  typeBy(id) {
                    let type = this.types.find(type => type.id == id);
                    if(type) {                      
                      return type.name;
                    }
                    // this.ucwords(type.name);                   
                  },
                  ucwords (str) {
                      return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                          return $1.toUpperCase();
                      });                  
                  },                                      
                  save() {
                      var vm = this;
                      axios.post('/fares', {                          
                          city_id: this.city.id,
                          route_id: this.route.id,
                          details: this.fare
                      })          
                      .then(function (response) {
                          //console.log(response.data);
                          response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          vm.availableFareList.push({
                            city_id: vm.city.id,
                            route_id: vm.route.id,
                            details: vm.fare
                          });
                          vm.loading = false;
                          vm.actionStatus = 'Added';
                          vm.reset();
                          vm.alertType = 'success';
                          vm.showAlert = true;
                      });
                  },
                  edit(fare) {
                    this.fareToedit.id = fare.id;
                    let fareToedit = this.availableFareList.find(element => element.id == fare.id);
                    this.fareToedit.index = this.availableFareList.indexOf(fareToedit);                    
                    this.fare = fareToedit.details;
                    this.city.id = fareToedit.city_id;
                    this.route.id =  fareToedit.route_id;
                    this.editMode = true;
                    this.show = true;                    
                    this.formControl.backgroundColor = 'lightyellow';
                    //console.log(busToedit);
                    //this.type.name = this.typeBy(this.bus.typeId);
                  },
                  update() {
                    var vm = this;
                      axios.patch('/fares/'+ this.fareToedit.id, {                          
                          city_id: this.city.id,
                          route_id: this.route.id,
                          details: this.fare
                      })          
                      .then(function (response) {
                          //console.log(response.data);
                          response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          vm.updateAvailableFareList();
                          vm.loading = false;
                          vm.actionStatus = 'Updated';
                          vm.reset();
                          vm.alertType = 'success';
                          vm.showAlert = true;
                          //console.log(response.status);                            
                      });
                  },
                  updateAvailableFareList() {
                    let index = this.fareToedit.index;

                    this.availableFareList[index] = {                      
                      city_id: this.city.id,
                      route_id: this.route.id,
                      details: this.fare
                    };
                  },            
                  enableScroll() {
                    //initializes the plugin with empty options
                    $('#scrollbar').overlayScrollbars({ /* your options */ 
                      sizeAutoCapable: true,
                      overflowBehavior : {
                        x : "scroll",
                        y : "scroll"
                      },
                      scrollbars: {
                        autoHide: "never",
                        clickScrolling: true
                      }
                    }); 
                  },       
                  fetchAvailableFares() {
                      this.loading = true;
                      this.availableFareList= [];            
                      var vm = this;                
                      axios.get('/api/fares')
                          .then(function (response) {                  
                             response.data.error ? vm.error = response.data.error : vm.availableFareList = response.data;
                             //vm.sortByRouteId(vm.availableFareList);                       
                             vm.loading = false;
                      });
                  },                 
                  fetchBusTypes() {
                    this.loading = true;
                    this.types= [];            
                    var vm = this;                
                    axios.get('/api/types')  
                        .then(function (response) {                  
                           response.data.error ? vm.error = response.data.error : vm.types = response.data;
                           //vm.sortBySeatPlanId(vm.availableSeatPlanList);      
                           //vm.createFareFor(vm.types);                 
                           vm.loading = false;
                    });
                  },
                  fetchRoutes() {
                    this.loading = true;
                    this.availableRouteList= [];            
                    var vm = this;                
                    axios.get('/api/routes')  
                        .then(function (response) {
                           response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                           vm.loading = false;
                           //vm.sortByCityNameAvailableRouteList(vm.availableRouteList);                 
                    });
                  },                  
                  fetchCities() {
                    this.loading = true;
                    this.availableCityList= [];            
                    var vm = this;                
                    axios.get('/api/cities')  
                        .then(function (response) {
                           response.data.error ? vm.error = response.data.error : vm.availableCityList = response.data;
                           vm.loading = false;
                    });
                  },
                  fetchCitiesBy(routeId) {
                    this.loading = true;
                    this.citiesByRoute= [];     
                    var vm = this;
                    axios.get('/api/'+routeId+'/cities')  
                        .then(function (response) {
                           response.data.error ? vm.error = response.data.error : vm.citiesByRoute = response.data;
                           vm.sortByDistance(vm.citiesByRoute);                 
                           vm.loading = false;
                    });
                  },                  
                  sortByDistance(arr) {
                    arr.sort((a, b) => {
                            return a.pivot.distance - b.pivot.distance;
                    });
                  },
                  isRegNumberAvailableInBusList(arr, val){
                       return arr.some(function(bus) {
                          return val === bus.bus.reg_no;
                      });
                  },
                  sortByIdOf(val) {
                      if (val== 'bus') { 
                          this.sortByBusId(this.availableBusList);
                          this.disableSorting = true;
                          return ;
                      }
                      this.sortByRegNumber(this.availableBusList);
                      this.disableSorting = false;
                  },

                  sortByRouteId(arr) {
                      arr.sort(function(a, b) {
                            return a.bus.id - b.bus.id;
                      });
                  },

                  sortByRegNumber(arr) {
                      arr.sort(function(a, b) {
                          var nameA = a.bus.reg_no; 
                          var nameB = b.bus.reg_no; 
                          if (nameA < nameB) {
                            return -1;
                          }
                          if (nameA > nameB) {
                            return 1;
                          }
                          // names must be equal
                          return 0;
                      });
                  },
                  sortBySeatPlanId(arr) {
                      arr.sort(function(a, b) {
                            return a.id - b.id;
                      });
                  },                    

                  remove(fare) { 
                      var vm = this;
                      swal({
                        title: "Are you sure?",
                        text: "This fare will be Removed!",
                        icon: "error",                 
                        dangerMode: true,
                        buttons: {
                            cancel: "cancel",
                            confirm: {
                              text: "Remove It!",
                              value: true,
                            },                                
                        },
                      })
                      .then((value) => {
                        if (value) {

                          vm.loading = true;
                          vm.response = '';
                          vm.showAlert = false;

                          axios.delete('/fares/'+fare.id)
                          .then(function (response) {               
                              response.data.error ? vm.error = response.data.error : vm.response = response.data;
                              if (vm.response) {               
                                  vm.removeFareFromAvailableFareList(fare.id); // update the array after removing
                                  vm.loading = false;
                                  vm.actionStatus = 'Removed';
                                  vm.alertType = 'danger';
                                  vm.showAlert= true;
                                  return;                      
                              }                            
                              vm.loading = false;
                          });                     
                        }                   
                      }); 
                  },
                  removeFareFromAvailableFareList(fareId) {
                      var indx = this.availableFareList.findIndex(function(fare){                 
                           return fare.id == fareId;
                      });        
                      this.availableFareList.splice(indx, 1);
                      //return;
                  },
                  reset() {                       
                      this.editMode = false;
                      this.fare = '';
                      this.city.id = '';
                      this.route.id = '';
                      this.formControl.backgroundColor = '#fff';
                  },
                  swAlert(text, icon) {
                    swal({
                      text: text, 
                      icon: icon,
                    });
                  },
        }
    }
</script>
<style lang="scss" scoped>  
  ol.fare {
    margin-left: -1.7rem;  
  }
  div.info-table .card .card-body {
    padding: 0;
  }    
</style>