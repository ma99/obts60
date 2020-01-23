<template>
  <div>         
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">City</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">City</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            Add City
          </template>

          <form> 
            <div class="form-row justify-content-center">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="divisionName">Division</label>
                  <select v-model="selectedDivision" class="form-control" id="divisionName">
                      <option disabled value="">Please select one</option>
                      <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                        {{ division.name }}
                      </option>                             
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="districtName">District</label>                       
                  <select v-model="selectedDistrict" class="form-control" id="districtName">
                      <option disabled value="">Please select one</option>                          
                      <option v-for="district in districtListByDivision" v-bind:value="{ id: district.id, name: district.name }">
                        {{ district.name }}
                      </option> 
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="upazilaName">Upazila</label>                       
                  <select v-model="selectedUpazila" class="form-control" id="upazilaName">
                      <option disabled value="">Please select one</option>                          
                      <option v-for="upazila in upazilaListByDistrict" v-bind:value="{ id: upazila.id, name: upazila.name }">
                        {{ upazila.name }}
                      </option> 
                  </select>
                </div>
              </div>              
            </div>
            <div class="form-row">
              <div class="col-sm-4 offset-sm-3">
                <div class="form-group">
                  <label for="cityName">City Name</label>
                  <input v-model="selectedCity.name" type="text" class="form-control" name="city_name" id="cityName" placeholder="City Name" disabled>
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
          <!-- <template v-slot:footer>
            <show-alert :show.sync="showAlert" :type="alertType"> 
              altert type can be success/info/warning/danger/dark
              <strong> City </strong> has been <strong>{{ actionStatus }} </strong>
            </show-alert>
          </template> -->
        </add-section>
        <loader :show="loading"></loader>
      
        <div class="row justify-content-center">
          <div class="card card-info w-100">
            <div class="card-header">Service Available City Info<span> {{ busAvailableToCityList.length }} </span></div>
            <div class="card-body">
                <div id="scrollbar">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>District ID
                          <span type="button" @click="isSortingAvailableBy('district')" :disabled="!disableSorting">
                            <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                          </span>
                        </th>
                        <th>City ID</th>
                        <th>City
                             <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>                        
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(city, index) in busAvailableToCityList">
                        <td>{{ index+1 }}</td>                              
                        <td>
                          <span data-toggle="tooltip" data-placement="top" :title="district.name" @mouseover="getNameOf(city)">
                            <high-light color="#4eb3f3" value="5"> {{ city.district_id }} </high-light>
                          </span>
                        </td>                              
                        <td>{{ city.id }}</td>                              
                        <td>{{ city.name }}</td>                              
                        <td> 
                            <button v-on:click.prevent="remove(city)" class="btn btn-danger">
                              <i class="fa fa-trash fa-fw"></i>Remove
                            </button>  
                        </td>                        
                      </tr>                            
                    </tbody>
                </table>                        
                </div>
            </div>
            <div class="card-footer">                                
              <show-alert :show.sync="showAlert" :type="alertType">
                <strong>{{ cityName }} </strong> has been 
                <strong> {{ actionStatus }} </strong> successfully!
              </show-alert>
            </div>
          </div>
        </div>           
      </div> <!-- container fluid -->     
    </section>        
  </div>      
</template>
<script>
    export default {
        data() {
          return {
            actionStatus: '',
            alertType: '',
            districtListByDivision: [],
            upazilaListByDistrict: [],
            cityName: '',
            district: '',
            busAvailableToCityList: [], //bus service availble to the cities
            divisionList: [],
            districtList: [],
            upazilaList: [],            
            disableSorting: true,
            error: '',
            loading: false,
            response: '',
            //selectedCityId: '',
            selectedCity: {
              districtId: '',
              name: ''
            },            
            selectedDivision: '',
            selectedDistrict: '',
            selectedUpazila: '',
            show: false,
            showAlert: false,  
          }
        },
        mounted() {           
           this.fetchDivisions();
           this.fetchDistricts();
           this.fetchUpazilas();
           this.fetchBusAvailableToCities();           
           this.enableScroll();
        },
        watch: {
            selectedDivision() {
                this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            },
            selectedDistrict() {
                this.fetchCitiesByDistrict(this.selectedDistrict.id);
                this.cityToBeAdded();
            },
            selectedUpazila() {
              this.cityToBeAdded();
            }
        },
        computed: {
          isValid() {
            return this.selectedCity != '' &&
              this.selectedDistrict != ''
              this.selectedDivision != ''
          },
        },
        methods: {
          cityToBeAdded() {
            this.selectedCity.districtId = this.selectedDistrict.id;
            if (this.selectedUpazila != '') {
              this.selectedCity.name = this.selectedUpazila.name;
              return;
            }
            this.selectedCity.name = this.selectedDistrict.name;
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
          fetchCitiesByDivision(divisionId) {
            this.loading = true;
            this.districtListByDivision= [];     
            this.districtListByDivision =  this.districtList.filter(district => district.division_id == divisionId);
            this.loading = false;
          },
          fetchCitiesByDistrict(districtId) {
            this.loading = true;
            this.upazilaListByDistrict= [];     
            this.upazilaListByDistrict =  this.upazilaList.filter(upazila => upazila.district_id == districtId);
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
          fetchUpazilas() {
            this.loading = true;
            this.upazilaList= [];            
            var vm = this;                      
            axios.get('/api/upazilas')  
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.upazilaList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchDivisions() {
            this.loading = true;
            this.divisionList= [];            
            var vm = this;                                  
            axios.get('/api/divisions')  
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
                   vm.loading = false;                  
            });
          },
          fetchBusAvailableToCities() {
            this.loading = true;
            this.busAvailableToCityList= [];            
            var vm = this;                
            axios.get('/api/cities')  
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.busAvailableToCityList = response.data;
                   vm.loading = false;
                   vm.sortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);
            });
          },
          getNameOf(city) {
            this.district = this.districtList.find(element => element.id == city.district_id);            
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.sortByCityNameBusAvailableToCityList(this.busAvailableToCityList);
                this.disableSorting = true;
                return;
            }
            this.sortByDistrictBusAvailableToCityList(this.busAvailableToCityList);
            this.disableSorting = false;
          },
          remove(city) {  
            var vm = this;
            this.cityName = city.name; 
            swal({
              title: "Are you sure?",
              text: "This CITY will be Removed!",
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
                axios.delete('/cities/'+city.id)          
                .then(function (response) { 
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                    if (vm.response) {               
                        vm.removeCityFromBusAvailableToCityList(city.id); // update the array after removing
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
          removeCityFromBusAvailableToCityList(cityid) {
            var indx = this.busAvailableToCityList.findIndex(function(city){ 
                // here 'city' is array object 
                 return city.id == cityid;
            });        
            this.busAvailableToCityList.splice(indx, 1);
            //return;
          },
          save() {
            var vm = this;
            //this.loading = true;            
            axios.post('/cities', {
                district_id: this.selectedCity.districtId,
                name: this.selectedCity.name,                
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   //vm.fetchBusAvailableToCities();
                   vm.busAvailableToCityList.push(vm.response);
                   vm.sortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);
                   vm.loading = false;
                   vm.actionAlert(vm.selectedCity.name);
                   vm.reset();
                   return;                   
                }
                vm.loading = false;                
            });
          },
          reset() {
            this.selectedCity = {
              districtId: '',
              name:  ''
            };
            this.selectedDistrict = '';
            this.selectedUpazila = '';
            this.selectedDivision = '';
          },
          sortByCityNameBusAvailableToCityList(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.name.toUpperCase(); // ignore upper and lowercase
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
          sortByDistrictBusAvailableToCityList(arr) {
            arr.sort((a, b) => {
              return a.district_id - b.district_id;
            });                            
          },
          actionAlert(cityName) {
              swal({           
                title: cityName,
                text: 'Added successfully!',
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          }
        }
    }
</script>
<style lang="scss" scoped>  
</style>