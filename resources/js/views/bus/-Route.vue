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
          <template v-slot:heading>
            <strong>Add Route</strong>
          </template>
          <form>
            <border color="navy-blue" pattern="dashed" width="1" 
              heading-background="#FBDB7B" heading-width="180" heading-show="true"
            >
              <template v-slot:heading>Departure City Info</template>
              <div class="form-row justify-content-center">
                <div class="col-sm-4">
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
                <div class="col-sm-4">
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

            <border color="eastern-blue" pattern="dashed" width="1" 
              heading-background="lightgreen" heading-width="180" heading-show="true"
            >
              <template v-slot:heading>Arrival City Info</template> 
              <div class="form-row justify-content-center">
                <div class="col-sm-4">
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
                <div class="col-sm-4">
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
            <div class="form-row justify-content-center">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="routeDistance">Route Distance</label>
                  <input v-model="routeDistance" type="number" class="form-control" name="route_distance" id="routeDistance" placeholder="Distance">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="button-group">
                  <button v-on:click.prevent="save()" class="btn btn-primary" :disabled="!isValid">Save</button>
                  <button v-on:click.prevent="reset()" class="btn btn-primary">Cancel</button>
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

        <div class="row justify-content-center view-available-info">
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
                            Fare
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
                          <td v-if="route.fare == null">N/A</td>                        
                          <td v-else> 
                            AC: {{ route.fare.details.ac }} </br>
                            Non-AC: {{ route.fare.details.non_ac }} </br> 
                            Deluxe: {{ route.fare.details.deluxe }} </br> 
                          </td>                              
                          <td><strong>{{ route.id }}</strong></td>
                          <td> 
                              <button v-on:click.prevent="editRoute(route)" class="btn btn-primary" :disabled="route.fare == null">
                                <i class="fa fa-edit fa-fw"></i>Edit
                              </button>  
                              <button v-on:click.prevent="removeRoute(route)" class="btn btn-danger">
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
            // disableSaveButton: true,
            // disableResetButton: true,
            disableSorting: true,
            districtList: [],
            divisionList: [],
            error: '',
            fare: {},
            fareId:'',            
            loading: false,
            lastUpdatedAt: '',
            modal: false,
            tempCityList: [],            
            response: '',
            routeDistance: '',
            routeId: '',
            routeName: '',
            //selectedCityId: '',
            selectedArrivalCity: '',
            //selectedDivisionForDepartureId: '',
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
                this.fetchCitiesByDivision(this.selectedDivisionForDeparture.id, 'departure'); // this.selectedDivisionForDepartureId
            },
            selectedDivisionForArrival() {
                this.fetchCitiesByDivision(this.selectedDivisionForArrival.id, 'arrival'); // this.selectedDivisionForDepartureId
            },
            // arrivalCityList() {
            //   this.isSaveButtonEnable();
            // },
            // departureCityList() {    
            //   this.isSaveButtonEnable();                            
            // },
        },
        computed: {
          isValid() {
            return this.selectedDepartureCity != '' &&
              this.selectedArrivalCity != ''
          }
        },
        methods: {
          save() {
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
              vm.disableSaveButton = true;
              vm.actionStatus = 'Added';
              vm.reset();
              vm.alertType = 'success';
              vm.showAlert = true;              
            });
          },            
          cancelEdit() {
            this.fare = '';            
            this.modal = false;
          },
          editRoute(route) {  // role id of user/staff in roles table
                console.log('route fare=', route.fare.details);
                //this.fare = route.fare.details;
                this.routeId = route.id;
                this.lastUpdatedAt = route.fare.updated_at;
                this.fareId = route.fare.id; 
                this.fare = _.clone(route.fare.details); //cloning or coppy                
                this.modal = true;                
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
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/districts')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.districtList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchDivisions() {
            this.loading = true;
            this.divisionList= [];            
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
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
            axios.get('/api/routes')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
                   //vm.tempAvailableRouteList = response.data;
                   vm.loading = false;
                   vm.SortByCityNameAvailableRouteList(vm.availableRouteList);                 
            });
          },

          isSaveButtonEnable() {

            this.disableSaveButton = ( (this.departureCityList.length < 1) || (this.arrivalCityList.length < 1) ) ? true : false; 
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.SortByCityNameAvailableRouteList(this.availableRouteList);
                this.disableSorting = true;
                return;
            }
            this.SortByDistanceAvailableRouteList(this.availableRouteList);
            this.disableSorting = false;
          },

          removeRoute(route) {  // role id of user/staff in roles table
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
                axios.post('/delete/route', {                            
                    route_id: route.id, 
                })          
                .then(function (response) {                                           
                    // response.data.error ? vm.error = response.data.error : vm.availableRouteList = response.data;
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
            //return;
          },
          
          reset() {
            this.selectedArrivalCity = '';
            this.selectedDepartureCity = '';
            this.selectedDivisionForArrival = '';
            this.selectedDivisionForDeparture = '';
            this.routeDistance = '';
          },
          SortByCityNameAvailableRouteList(arr) {
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
          SortByDistanceAvailableRouteList(arr) {
            // sort by distance 
                arr.sort(function(a, b) {
                  return a.distance - b.distance;
                });
          },
          routeAddedAlert(depatureCity, arrivalCity) {
              
              swal({
                //title: "Sorry! Not Available",
                //title: '<span style="color:#A5DC86"> <strong>'+ depatureCity + '&nbsp;' +' to '+ '&nbsp;' + arrivalCity +'</strong></span></br> Route Added successfully!',
                title: depatureCity + ''  +' to '+ ' ' + arrivalCity,
                text: 'Route Added successfully!',
                //text: '<span style="color:#F8BB86"> <strong>'+depatureCity+'</strong></span> Not Available.',
                //html: true,
                //type: "info",
                //type: "success",
                //content: html,
                icon: "success",
                timer: 2000,
                //showConfirmButton: false,
                closeOnClickOutside: true,
              });
          },
          updateRouteFare() {
            var vm = this;
                this.response = '';
                this.showAlert = false;
                //this.staffName = staff.name;                
                this.loading = true;
                axios.patch('/fares/'+this.fareId, {
                      //route_id: this.routeId,
                      fare: this.fare                      
                    })          
                    .then(function (response) {                                           
                      //response.data.error ? vm.error = response.data.error : vm.staffs = response.data;
                      response.data.error ? vm.error = response.data.error : vm.response = response.data;
                      if (vm.response) {
                          vm.updateFareAtAvailableRouteList(vm.routeId, vm.fare);
                          vm.loading = false;
                          vm.modal = false;
                          vm.actionStatus = 'Udated';
                          vm.alertType = 'info';                          
                          vm.showAlert= true;                                                                        
                      }
                    });
          },

          updateFareAtAvailableRouteList(routeId, fare) {
             var indx = this.availableRouteList.findIndex(function(route){                                        
                    return route.id == routeId;
             });                                     
             this.availableRouteList[indx].fare.details = fare;
             this.routeName = this.availableRouteList[indx].departure_city + ' to ' + this.availableRouteList[indx].arrival_city;
             this.fare = '';
          }
        }
    }
</script>

<style lang="scss" scoped>
    // .view-route-info .card-header span {
    // .view-available-info .card-header span {
    //   background-color: yellow;
    //   font-weight: 600;
    //   float: right;
    //   padding: 2px 6px;
    //   color: royalblue;
    // }
    // .route-info {
    //   border: 1px dashed lightblue;
    //   padding: 25px 10px;
    //   margin: 25px 25px 50px 25px;
    //   position: relative;
    //   text-align: center;      

    //   span {
    //     /* background-color: lightblue; */
    //     display: block;
    //     font-weight: 600;
    //     letter-spacing: 1px;        
    //     left: 14px;
    //     top: -16px;
    //     position: absolute;
    //     padding: 5px 10px;
    //     width: 90px;
    //   }
    //   .arrival {
    //     @extend span;
    //     background-color: lightblue;
    //   }
    //   .departure {
    //     @extend span;
    //     background-color: lightgreen;
    //   }
    // }

    // form {
    //      label {
    //       padding: 0 5px 0 15px;
    //      }
    // }

    // .route-distance {
    //   margin: -15px 10px 10px 15px;
    // }     
    // #scroll-routes {
    //     span {
    //         cursor: pointer;
    //         margin-left: 5px;
    //     }
    //     span[disabled] {
    //         cursor: not-allowed;
    //         opacity: 0.65;
    //     }
    // } 

</style>