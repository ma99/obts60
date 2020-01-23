<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Route</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Route</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>    

    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>Add Route</template>
          <form>     
            <div class="row">
              <div class="col">
                <border color="navy-blue" pattern="dashed" width="1" 
                  heading-background="#FBDB7B" heading-width="180" heading-show="true"
                >
                  <template v-slot:heading>Departure City Info</template>
                  <div class="form-row justify-content-center">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="divisionName">Division </label>
                        <select v-model="selectedDivisionForDeparture" class="form-control" id="divisionName">
                            <option disabled value="">Please select one</option>
                            <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                              {{ division.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="departureCity">City</label>
                        <select v-model="selectedDepartureCity" class="form-control" id="departureCity">
                            <option disabled value="">Please select one</option>
                            <!-- <option v-for="city in departureCityList" v-bind:valaue="{ id: division.id, name: division.name }"> -->
                            <option v-for="city in departureCityList">
                              {{ city.name }}
                            </option>                             
                        </select>
                      </div>
                    </div>
                  </div>
                </border>
              </div>

              <div class="col">
                <border color="eastern-blue" pattern="dashed" width="1" 
                  heading-background="lightgreen" heading-width="180" heading-show="true"
                >
                  <template v-slot:heading>Arrival City Info</template> 
                  <div class="form-row justify-content-center">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="divisionName">Division</label>
                        <select v-model="selectedDivisionForArrival" class="form-control" id="divisionName">
                            <option disabled value="">Please select one</option>
                            <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                              {{ division.name }}
                            </option>                             
                        </select>
                      </div>        
                    </div>
                    <!-- City-->
                    <div class="col-sm-5">
                      <div class="form-group">
                        <label for="arrivalCity">City</label>
                        <select v-model="selectedArrivalCity" class="form-control" id="arrivalCity">
                            <option disabled value="">Please select one</option>
                            <option v-for="city in arrivalCityList">
                              {{ city.name }}
                            </option> 
                        </select>
                      </div>
                    </div>
                  </div>
                </border>
              </div>
            </div>
            <div class="form-row">
              <div class="col-sm-4 offset-sm-3">
                <div class="form-group">
                  <label for="routeDistance">Route Distance</label>
                  <input v-model="routeDistance" type="number" class="form-control" name="route_distance" id="routeDistance" placeholder="Distance">
                </div>
              </div>
              <div class="col-sm-5"></div>
              <div class="col-sm-4 offset-sm-3">
                <div class="button-group">
                  <button v-on:click.prevent="save()" class="btn btn-primary" :disabled="!isValid">Save</button>
                  <button v-on:click.prevent="reset()" class="btn btn-primary" :disabled="!isValid">Cancel</button>
                </div>
              </div>
            </div>
          </form>
          <template v-slot:footer>
            <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
              <strong> Route </strong> has been <strong>{{ actionStatus }} </strong>
              </show-alert>
          </template>
        </add-section>

        <loader :show="loading"></loader>

        <div class="row justify-content-center">
          <div class="card card-info w-100">
            <div class="card-header">Route Info <span> {{ availableRouteList.length }} </span></div>
            <div class="card-body">
                <div id="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Sl. No.</th>
                          <th>From
                                <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                          </th>
                          <th>To                      
                          </th>
                          <th>Distance
                            <span type="button" @click="isSortingAvailableBy('distance')" :disabled="!disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                          </th>                          
                          <th>
                            Route ID
                          </th>
                          <th>Action</th>                                                         
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(route, index) in availableRouteList">                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ route.departure_city }}</td>
                          <td>{{ route.arrival_city }}</td>                              
                          <td>{{ route.distance }}</td>                          
                          <td><strong>{{ route.id }}</strong></td>
                          <td>
                              <button v-on:click.prevent="remove(route)" class="btn btn-danger">
                                <i class="fa fa-trash fa-fw"></i>Remove
                              </button> 
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
                </div>
            </div>
            <!-- {{-- card-footer --}} -->
            <div class="card-footer">                    
              <show-alert :show.sync="showAlert" :type="alertType">               
                <strong>{{ routeName }} </strong> has been 
                <strong> {{ actionStatus }} </strong> successfully!
              </show-alert>
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
            arrivalCityList: [],
            availableRouteList: [], 
            departureCityList: [],            
            disableSorting: true,
            districtList: [],
            divisionList: [],
            error: '',
            loading: false,                        
            tempCityList: [],            
            response: '',
            routeDistance: '',
            routeId: '',
            routeName: '',
            selectedArrivalCity: '',
            selectedDepartureCity: '',
            selectedDivisionForArrival: '',
            selectedDivisionForDeparture: '',
            show: false,
            showAlert: false,  
          }
        },
        mounted() {           
           this.fetchDistricts();
           this.fetchDivisions();
           this.fetchAvailableRoutes();           
           this.enableScroll();
        },
        watch: {
            selectedDivisionForDeparture() {
                this.fetchCitiesByDivision(this.selectedDivisionForDeparture.id, 'departure'); 
            },
            selectedDivisionForArrival() {
                this.fetchCitiesByDivision(this.selectedDivisionForArrival.id, 'arrival'); 
            },            
        },
        computed: {
          isValid() {
            return this.selectedDepartureCity != '' &&
              this.selectedArrivalCity != ''
          }
        },
        methods: {
          actionAlert(routeName) {
              swal({           
                title: routeName,
                text: 'Added successfully!',
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          },
          setRouteName() {
            this.routeName = this.selectedDepartureCity+' - '+this.selectedArrivalCity;
          },          
          save() {
            this.setRouteName();
            var vm = this;            
            axios.post('/routes', {
                departure_city: this.selectedDepartureCity,
                arrival_city: this.selectedArrivalCity,
                distance: this.routeDistance,                                
            })          
            .then(function (response) {
                //console.log(response.data);
              response.data.error ? vm.error = response.data.error : vm.response = response.data;
                
              vm.availableRouteList.push(vm.response);
              vm.loading = false;
              vm.actionAlert(vm.routeName);
              //vm.actionStatus = 'Added';
              vm.reset();
              //vm.alertType = 'success';
              //vm.showAlert = true;              
            });
          },                      
          enableScroll() {
            $('#scrollbar').overlayScrollbars({ /* your options */ 
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: "never",
                clickScrolling: true
              }
            });                 
          },          
          fetchCitiesByDivision(divisionId, status) {
            this.loading = true;
            this.tempCityList= [];     
            this.tempCityList =  this.districtList.filter(district => district.division_id == divisionId);

            if (status == 'arrival') {
              this.arrivalCityList = this.tempCityList;
              this.loading = false;
              return;                  
            }
            this.departureCityList = this.tempCityList;
            this.loading = false;
          },
          fetchDistricts() {
            this.loading = true;
            this.districtList= [];            
            var vm = this;                      
            axios.get('/api/districts')  
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.districtList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchDivisions() {
            this.loading = true;
            this.divisionList= [];            
            var vm = this;                                  
            axios.get('/api/divisions')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchAvailableRoutes() {
            this.loading = true;
            this.availableRouteList= [];            
            var vm = this;                
            axios.get('/api/routes')  
                .then(function (response) {
                   response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                   vm.loading = false;
                   vm.sortByCityNameAvailableRouteList(vm.availableRouteList);                 
            });
          },          
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.sortByCityNameAvailableRouteList(this.availableRouteList);
                this.disableSorting = true;
                return;
            }
            this.sortByDistanceAvailableRouteList(this.availableRouteList);
            this.disableSorting = false;
          },
          remove(route) {  // role id of user/staff in roles table
            var vm = this;            
            this.routeName = route.departure_city + ' to ' + route.arrival_city;
            swal({
              title: "Are you sure?",
              text: "This ROUTE will be Removed!",
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
                axios.delete('/routes/'+route.id)         
                .then(function (response) {               
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                    if (vm.response) {                
                        vm.removeRouteFromAvailableRouteList(route.id); // update the array after removing
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
          removeRouteFromAvailableRouteList(routeId) {
            var indx = this.availableRouteList.findIndex(function(route){                 
                 return route.id == routeId;
            });        
            this.availableRouteList.splice(indx, 1);            
          },          
          reset() {
            this.selectedArrivalCity = '';
            this.selectedDepartureCity = '';
            this.selectedDivisionForArrival = '';
            this.selectedDivisionForDeparture = '';
            this.routeDistance = '';
          },
          sortByCityNameAvailableRouteList(arr) {
            // sort by name            
            arr.sort(function(a, b) {
              var nameA = a.departure_city.toUpperCase(); // ignore upper and lowercase
              var nameB = b.departure_city.toUpperCase(); // ignore upper and lowercase
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
          sortByDistanceAvailableRouteList(arr) {
            // sort by distance 
                arr.sort(function(a, b) {
                  return a.distance - b.distance;
                });
          },          
        }
    }
</script>
<style lang="scss" scoped>
</style>