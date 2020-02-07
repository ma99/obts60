<template>
  <div>    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bus</h1>
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
          <template v-slot:heading>Add Fare</template>
          <form> 
                <!-- <border color="navy-blue" pattern="dashed" width="1" 
                  heading-background="#F2B705" heading-width="150" heading-show="true"
                >
                  <template v-slot:heading>Seat Plan Info</template> 
                  <div class="form-row justify-content-center">     
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="seatPlan">Seat Plan#</label>
                          <select v-model="bus.seatPlanId" class="form-control" id="seatPlan" :disabled="editMode">
                              <option disabled value="">Please select one</option>
                              <option v-for="seat in availableSeatPlanList" v-bind:value="seat.id">                         
                                  {{ seat.id }}
                              </option>                                              
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="numberOfSeat">Total Seat #</label>
                        <input v-model="numberOfSeat" type="number" min="1" max="50" value="36" class="form-control" id="numberOfSeat" placeholder="Number of Seat" disabled>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="view-button">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalComponent" v-on:click.prevent="modal=true" :disabled="bus.seatPlanId == ''">    
                          <i class="fa fa-eye fa-fw"></i>View
                        </button>
                      </div>                     
                    </div>
                  </div>  
                </border> -->

                <border color="eastern-blue" pattern="dashed" width="1" 
                  heading-background="lightgreen" heading-width="200" heading-show="true"
                >
                  <template v-slot:heading>Set Fare for Route Cities</template> 
                  <div class="form-row justify-content-center">
                     <div class="col-sm-4">
                      <div class="form-group">
                        <label for="route">Route</label>
                          <select v-model="route.id" v-bind:style="formControl" class="form-control custom-select" id="route">
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
                          <select v-model="city.id" v-bind:style="formControl" class="form-control custom-select" id="city">
                              <option disabled value="">Please select one</option>
                              <option v-for="city in citiesByRoute" v-bind:value="city.id">
                                  <strong>{{ city.name }}</strong> <small> {{city.pivot.distance}}</small>
                              </option>                                             
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <!-- <div id="scrollbar"> -->
                        <table class="table table-striped table-hover">
                            <thead>
                              <tr>
                                <!-- <th v-for="(type, index) in types">{{type.name}}</th>                                -->
                              </tr>
                            </thead>
                            <tbody>
                              <tr>                                                               
                                <td v-for="(type, index) in types">
                                  <!-- <template v-if="isCombined(type.name)">
                                  </template> -->
                                  <!-- <template v-else> -->
                                    <!-- <label>Email</label>
                                    <input placeholder="Enter your email address" key="email-input"> -->
                                    <div class="form-group" v-show="isCombined(type)">
                                      <label :for="'type-'+index">{{ type.name }}</label>
                                      <!-- <input v-model="fare[type.key].type1" type="text" class="form-control" :id="'type-'+index" :placeholder="type.key"> -->
                                      <!-- <input v-model="fare[type.key].type2" type="text" class="form-control" :id="'type-'+index" :placeholder="type.name"> -->
                                      <!-- <input :value="getValue(fare, type, 'type1')" @input="setValue(fare, type, 'type1', $event.target.value)"> -->
                                      <!-- <input :value="getValue(fare, [type.key].two)" @input="setValue(fare, [type.key].two, $event.target.value)"> -->

                                      <!-- <input v-model="fare[type.key].t1" type="text" class="form-control" :id="'type-'+index" :placeholder="type.name"> -->
                                      <!-- <input v-model="fareSelect" type="text" class="form-control" :id="'type-'+index" :placeholder="type.name"> -->

                                      <input :value="getValue(fare, 't1')" @input="setValue(fare, 't1', $event.target.value)">
                                      <input :value="getValue(fare, 't2')" @input="setValue(fare, 't2', $event.target.value)">
                                    </div>                                

                                    <div class="form-group" v-show="!isCombined(type)">
                                    <!-- <div class="form-group" v-else> -->
                                      <label :for="'type-'+index">{{ type.name }}</label>
                                      <input v-model="fare[type.key]" type="text" class="form-control" :id="'type-'+index" :placeholder="type.name">
                                  </div>

                                  <!-- </template>  -->
                                  <!-- <div class="form-group">
                                    <label :for="'type-'+index">{{ type.name }}</label>
                                    <input v-model="fare[type.key]" type="text" class="form-control" :id="'type-'+index" :placeholder="type.name">
                                  </div>                                 -->
                                </td>
                              </tr>                           
                            </tbody>
                        </table>      
                      <!-- </div> -->                 

                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="save()"  type="button" class="btn btn-primary" :disabled="!isValid" v-show="!editMode">Save</button>
                        <button v-on:click.prevent="update()"  type="button" class="btn btn-success" :disabled="!isValid" v-show="editMode">Update</button>
                        <button v-on:click.prevent="reset()"  type="button" class="btn btn-primary">Cancel</button>
                      </div>
                    </div>
                  </div>
                </border>            
          </form>            

          <template v-slot:footer>
            <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
              <strong> Bus </strong> has been <strong>{{ actionStatus }} </strong>
              </show-alert>
          </template>
        </add-section>
        <loader :show="loading"></loader>     
        
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
                    availableBusList: [],
                    availableSeatPlanList: [],
                    busToedit: {
                      id: '',
                      index: '',
                    },
                    combineType: {
                      //type1: '',
                      //type2: ''
                    },
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
                    //bus
                    bus: {
                      regNumber: '',
                      numberPlate: '',
                      description: '',
                      seatPlanId: '',
                      typeId: '',
                    },
                    numberOfSeat: '',
                    selectedSeatPlan: '',                    
                    showAlert: false,
                    show: false,                    
                    modal: false,               
                    types: [],
                    typeAttr: '',
                    fare: {},
                    cityListByRoute: [],
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
                      this.fetchCitiesBy(this.route.id);                        
                    },
                },      
                mounted() {                    
                    this.fetchBusTypes();
                    this.fetchRoutes();
                    //this.fetchCities();
                    this.fetchAvailableBuses();
                    this.fetchAvailableSeatPlans();
                    this.enableScroll();                
                },
                computed: {                    
                    isValid() {
                        return this.bus.regNumber != '' && 
                                this.bus.numberPlate != '' &&
                                this.bus.typeId != '' &&
                                this.bus.description != '' 
                     }
                }, 
                methods: {
                  getValue(object, p) {
                    var path = this.typeAttr+'.'+p;
                    console.log('mm='+ path);
                    let obj = object;
                    for (const key of path.split('.')) {
                      obj = obj[key];
                    }                    
                    return obj;
                     //return object[type.key[path]];
                     //console.log(this.fare[type.key[path]]);
                     //return this.fare[type.key[path]];
                  },                  
                  setValue(object, p, value) {
                    //console.log(type.key);
                    var path = this.typeAttr+'.'+p;
                    const keys = path.split('.');
                    let obj = object;
                    for (let i = 0; i < keys.length - 1; i++) {
                      obj = obj[keys[i]];
                    }                    
                    obj[keys[keys.length - 1]] = value;
                    //object[type.key[path]] = value;
                    // this.fare[type.key] = {
                    //   [path] : value,
                    // }
                    //this.fare[type.key[path]] = value;
                  },
                  isCombined(type) {
                    if (type.key.includes('|')) {
                      let types = type.key.split('|');
                      let t1, t2;
                      t1= types[0];
                      t2= types[1];
                      this.combineType[type.key] = {                       
                        [t1]: types[0],
                        [t2]: types[1],
                      };
                      // this.fare[type.key] = {
                      //  type1: '', //types[0],
                      //  type2: '',//types[1]
                      // }
                      //let key= type.key;
                      //this.combineType.key.type2 = types[1];
                      //console.log(this.combineType[type.key]['type1']);
                      return true; 
                    }
                    return false;
                  },
                  createFareForCombineType(types) {                    
                    types.forEach(type => {                      
                      if (type.key.includes('|')) {
                        this.typeAttr = type.key;

                        let types = type.key.split('|');
                        //let t1, t2;
                        //t1= types[0];
                        //t2= types[1];
                        this.fare[type.key] = {                       
                          t1: types[0],
                          t2: types[1],
                        }
                      }                      
                    });
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
                      axios.post('/buses', {
                          
                          seat_plan_id: this.bus.seatPlanId,
                          reg_no: this.bus.regNumber,
                          number_plate: this.bus.numberPlate,
                          type_id: this.bus.typeId,                
                          //total_seats: this.bus.numberOfSeat,
                          description: this.bus.description
                      })          
                      .then(function (response) {
                          //console.log(response.data);
                          response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          vm.availableBusList.push({
                            bus: vm.response,
                            total_seats: vm.numberOfSeat
                          });
                          vm.loading = false;
                          vm.actionStatus = 'Added';
                          vm.reset();
                          vm.alertType = 'success';
                          vm.showAlert = true;
                      });
                  },
                  edit(bus) {
                    this.busToedit.id = bus.bus.id;
                    let busToedit = this.availableBusList.find(element => element.bus.id == bus.bus.id);
                    this.busToedit.index = this.availableBusList.indexOf(busToedit);
                    //console.log(this.availableBusList.indexOf(busToedit));
                    this.bus.seatPlanId = busToedit.bus.seat_plan_id;
                    this.bus.regNumber = busToedit.bus.reg_no;
                    this.bus.numberPlate = busToedit.bus.number_plate;
                    this.bus.typeId = busToedit.bus.type_id;
                    this.bus.description = busToedit.bus.description;
                    //this.bus = busToedit.bus;
                    this.editMode = true;
                    //this.show = true;
                    this.formControl.backgroundColor = 'lightyellow';
                    //console.log(busToedit);
                    //this.type.name = this.typeBy(this.bus.typeId);
                  },
                  update() {
                    var vm = this;
                      axios.patch('/buses/'+ this.busToedit.id, {
                          seat_plan_id: this.bus.seatPlanId,
                          reg_no: this.bus.regNumber,
                          number_plate: this.bus.numberPlate,
                          type_id: this.bus.typeId,                
                          //total_seats: this.bus.numberOfSeat,
                          description: this.bus.description
                      })          
                      .then(function (response) {
                          //console.log(response.data);
                          response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          vm.updateAvailableBusList();
                          vm.loading = false;
                          vm.actionStatus = 'Updated';
                          vm.reset();
                          vm.alertType = 'success';
                          vm.showAlert = true;
                          //console.log(response.status);                            
                      });
                  },
                  updateAvailableBusList() {
                    let index = this.busToedit.index;

                    this.availableBusList[index].bus = {
                      reg_no: this.bus.regNumber,
                      number_plate: this.bus.numberPlate,
                      type_id: this.bus.typeId,
                      seat_plan_id: this.bus.seatPlanId,
                      description: this.bus.description,
                    };
                  },            
                  enableScroll() {
                    //initializes the plugin with empty options
                    $('#scrollbar').overlayScrollbars({ /* your options */ 
                      sizeAutoCapable: true,
                      scrollbars: {
                        autoHide: "never",
                        clickScrolling: true
                      }
                    }); 
                  },       

                  fetchAvailableBuses() {
                      this.loading = true;
                      this.availableBusList= [];            
                      var vm = this;                
                      axios.get('/api/buses')
                          .then(function (response) {                  
                             response.data.error ? vm.error = response.data.error : vm.availableBusList = response.data;
                             vm.sortByBusId(vm.availableBusList);                       
                             vm.loading = false;
                      });
                  },

                  fetchAvailableSeatPlans() {
                    this.loading = true;
                    this.availableSeatPlanList= [];            
                    var vm = this;                
                    axios.get('/api/seatplans')
                        .then(function (response) {                  
                           response.data.error ? vm.error = response.data.error : vm.availableSeatPlanList = response.data;
                           vm.sortBySeatPlanId(vm.availableSeatPlanList);                       
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
                           vm.createFareForCombineType(vm.types);                 
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
                           //vm.sortByCityNameAvailableRouteList(vm.availableRouteList);                 
                    });
                  },
                  fetchCitiesBy(routeId) {
                    this.loading = true;
                    this.citiesByRoute= [];     
                    var vm = this;
                    //this.citiesByRoute =  this.availableCityList.filter(city => city.division_id == divisionId);
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
                      //var vm = this;
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

                  sortByBusId(arr) {
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

                  remove(bus) { 
                      var vm = this;
                      swal({
                        title: "Are you sure?",
                        text: "This BUS will be Removed!",
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

                          axios.delete('/buses/'+bus.id)
                          .then(function (response) {               
                              response.data.error ? vm.error = response.data.error : vm.response = response.data;
                              if (vm.response) {               
                                  vm.removeBusFromAvailableBusList(bus.id); // update the array after removing
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
                  removeBusFromAvailableBusList(busId) {
                      var indx = this.availableBusList.findIndex(function(bus){                 
                           return bus.bus.id == busId;
                      });        
                      this.availableBusList.splice(indx, 1);
                      //return;
                  },
                  reset() {                       
                      this.isDisabled = false;
                      this.editMode = false;                                              
                      this.bus = {
                        regNumber:  '' , 
                        numberPlate:  '',
                        seatPlanId: '',
                        typeId:  '',
                        description:  '',
                      }
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
  .view-button button {
    margin: 1.9rem auto; 
  }  
</style>