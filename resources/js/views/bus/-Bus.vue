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
              <li class="breadcrumb-item active">Bus</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <strong>Add Bus</strong>
          </template>

          <form> 
                <border color="navy-blue" pattern="dashed" width="1" 
                  heading-background="#F2B705" heading-width="150" heading-show="true"
                >
                  <template v-slot:heading>Seat Plan Info</template> 
                  <div class="form-row justify-content-center">     
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="seatPlan">Seat Plan#</label>
                          <select v-model="selectedSeatPlanId" class="form-control" id="seatPlan" :disabled="editMode">
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
                        <input v-model="selectedSeatPlan.total_seats" type="number" min="1" max="50" value="36" class="form-control" id="numberOfSeat" placeholder="Number of Seat" disabled>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="view-button">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalComponent" v-on:click.prevent="modal=true" :disabled="selectedSeatPlanId == ''">    
                          <i class="fa fa-eye fa-fw"></i>View
                        </button>
                      </div>                     
                    </div>
                  </div>  
                </border>

                <border color="eastern-blue" pattern="dashed" width="1" 
                  heading-background="lightgreen" heading-width="200" heading-show="true"
                >
                  <template v-slot:heading>Bus Registraion Info</template> 
                  <div class="form-row justify-content-center">  
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="regNumber">Registration #</label>
                        <input v-model.lazy="bus.regNumber" type="text" class="form-control" id="regNumber" placeholder="Registration Number" v-bind:style="formControl">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="numberPlate">Number Plate #</label>
                        <input v-model="bus.numberPlate" v-bind:style="formControl" type="text" class="form-control" id="numberPlate" placeholder="Number Plate" :disabled="isDisabled">
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="busType">Bus Type #</label>
                          <select v-model="bus.selectedBusType" v-bind:style="formControl" class="form-control" id="busType">
                              <option disabled value="">Please select one</option>
                              <option v-for="option in options" v-bind:value="option.value">
                                  {{ option.text }}
                              </option>                                              
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-10">
                      <div class="form-group">
                        <label for="busDescription">Description</label>
                        <textarea v-model="bus.busDescription" v-bind:style="formControl" type="text" min="1" max="50" value="36" class="form-control" id="busDescription" placeholder="Description" :disabled="isDisabled"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <!-- <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="disableShowButton">Show</button> -->
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
      
        <div class="row justify-content-center view-available-info">
          <div class="card card-info">
            <div class="card-header">Bus Info <span> {{ availableBusList.length }} </span></div>
            <div class="card-body">
                <div id="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Sl. No.</th>
                          <th>Bus ID
                              <span type="button" @click="sortByIdOf('bus')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span>
                          </th>                           
                          <th>Reg. Number
                              <span type="button" @click="sortByIdOf('registration')" :disabled="!disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span>
                          </th>
                          <th>Number Plate</th>
                          <th>Type</th>                                
                          <th>Total Seats</th>     
                          <th>Seat Plan ID</th>     
                          <th>Descriptin</th> 
                          <th>Action</th>    
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(bus, index) in availableBusList" >                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ bus.bus.id }}</td>
                          <td>{{ bus.bus.reg_no }}</td>
                          <td>{{ bus.bus.number_plate }}</td>
                          <td>{{ ucwords(bus.bus.type) }}</td>                         
                          <td><strong>{{ bus.total_seats }}</strong></td>
                          <td><strong>{{ bus.bus.seat_plan_id }}</strong></td>
                          <td>{{ bus.bus.description }}</td>
                          <td> 
                              <button v-on:click.prevent="edit(bus)" class="btn btn-primary">
                                <i class="fa fa-edit fa-fw"></i>Edit
                              </button>  
                              <button v-on:click.prevent="remove(bus.bus)" class="btn btn-danger">
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
               Bus
                <strong> {{ actionStatus }} </strong> successfully!
              </show-alert>
            </div>
          </div>
        </div>           
      </div>

      <modal :show.sync="modal">
        <seat-layout :seatList="selectedSeatPlan.seat_list"></seat-layout>
      </modal>                          

    </section>        
  </div>      
</template>
<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
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
                    regNumber: '',
                    numberPlate: '',
                    numberOfSeat: '',
                    busDescription: '',
                    selectedBusType: '',
                    selectedSeatPlan: '',
                    selectedSeatPlanId: '',
                    showAlert: false,
                    show: false,                    
                    modal: false,               
                    options: [
                      { text: 'AC', value: 'ac' },
                      { text: 'AC-Deluxe', value: 'ac-deluxe' },
                      { text: 'Deluxe', value: 'deluxe' },
                      { text: 'Non-AC', value: 'Non-AC' }
                    ]
                    
                }

                },
                watch: {
                    regNumber() {
                        var aa = this.isRegNumberAvailableInBusList(this.availableBusList, this.regNumber);
                        if (aa) {
                            if(this.editMode) {
                              alert('Edit Mode Started..');
                              return;
                            }
                            alert('Registration Number is already exist!');
                        }
                    },

                    selectedSeatPlanId() {
                      this.selectedSeatPlan = this.availableSeatPlanList.find(element => element.id == this.selectedSeatPlanId);
                      this.numberOfSeat = this.selectedSeatPlan.total_seats;
                    },
                },      
                mounted() {
                    // this.fetchBusIds();
                    // this.createIndexList();  
                    this.fetchAvailableBuses();
                    this.fetchAvailableSeatPlans();
                    this.enableScroll();                
                },
                computed: {
                    isValid() {
                        return this.regNumber != '' && 
                                this.numberPlate != '' &&
                                //this.numberOfSeat != '' &&
                                this.selectedBusType != '' &&
                                this.busDescription != '' 
                     }
                }, 
                methods: {
                  ucwords (str) {
                      return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                          return $1.toUpperCase();
                      });
                  },                    
                    save() {
                        var vm = this;
                        axios.post('/buses', {
                            seat_plan_id: this.selectedSeatPlanId,
                            reg_no: this.regNumber,
                            number_plate: this.numberPlate,
                            type: this.selectedBusType,                
                            //total_seats: this.numberOfSeat,
                            description: this.busDescription
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
                            //console.log(response.status);                            
                        });
                    },
                    edit(bus) {
                      this.busToedit.id = bus.bus.id;
                      let busToedit = this.availableBusList.find(element => element.bus.id == bus.bus.id);
                      this.busToedit.index = this.availableBusList.indexOf(busToedit);
                      //console.log(this.availableBusList.indexOf(busToedit));
                      this.selectedSeatPlanId = busToedit.bus.seat_plan_id;
                      this.regNumber = busToedit.bus.reg_no;
                      this.numberPlate = busToedit.bus.number_plate;
                      this.selectedBusType = busToedit.bus.type;
                      this.busDescription = busToedit.bus.description;
                      this.editMode = true;
                      //this.show = true;
                      this.formControl.backgroundColor = 'lightyellow';
                      //console.log(busToedit);
                    },
                    update() {
                      var vm = this;
                        axios.patch('/buses/'+ this.busToedit.id, {
                            seat_plan_id: this.selectedSeatPlanId,
                            reg_no: this.regNumber,
                            number_plate: this.numberPlate,
                            type: this.selectedBusType,                
                            //total_seats: this.numberOfSeat,
                            description: this.busDescription
                        })          
                        .then(function (response) {
                            //console.log(response.data);
                            response.data.error ? vm.error = response.data.error : vm.response = response.data;
                            // vm.availableBusList.push({
                            //   bus: vm.response,
                            //   total_seats: vm.numberOfSeat
                            // });
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
                      this.availableBusList[index].bus.reg_no = this.regNumber;
                      this.availableBusList[index].bus.number_plate = this.numberPlate;
                      this.availableBusList[index].bus.type = this.selectedBusType;
                      this.availableBusList[index].bus.description = this.busDescription;
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
                        axios.get('/api/buses')  //--> api/bus?q=xyz        (right)
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
                      axios.get('/api/seatplans')  //--> api/bus?q=xyz        (right)
                          .then(function (response) {                  
                             response.data.error ? vm.error = response.data.error : vm.availableSeatPlanList = response.data;
                             vm.sortBySeatPlanId(vm.availableSeatPlanList);                       
                             vm.loading = false;
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
                            var nameA = a.bus.reg_no; //.toUpperCase(); // ignore upper and lowercase
                            var nameB = b.bus.reg_no; //.toUpperCase // ignore upper and lowercase
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
                        // this.disableShowButton = false;
                        // this.disableSaveButton= true;
                        //this.selectedSeatPlanId = '';
                        this.regNumber = '' ; 
                        this.numberPlate = '';
                        this.selectedBusType = '';
                        this.busDescription = '';
                        this.formControl.backgroundColor = '#fff';

                    }
        }
    }
</script>
<style lang="scss" scoped>
  .view-button button {
    margin: 1.9rem auto; 
  }     

</style>