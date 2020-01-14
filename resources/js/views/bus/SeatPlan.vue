<template>
  <div>    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Seat Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Seat Plan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <strong>Add Seat Plan</strong>
          </template>
          <form> 
            <div class="form-row">                
              <div class="col-1"></div>
              <div class="col">
                <div class="row">                       
                  <div class="form-group col-sm-3">
                    <label for="numberOfCol">Column #</label>
                    <input v-model="numberOfCol" type="number" min="1" max="4" value="4" class="form-control" id="numberOfCol" placeholder="Column Number" disabled>
                  </div>
                
                  <div class="form-group col-sm-3">
                    <label for="numberOfRow">Row #</label>
                    <input v-model="numberOfRow" type="number" min="1" max="25" value="9" class="form-control" id="numberOfRow" placeholder="Row Number" :disabled="isDisabled">
                  </div>
                
                  <div class="button-group col-sm-6">                        
                    <button v-on:click.prevent="createList()" class="btn btn-primary" :disabled="!isValidForShow">Show</button>
                    <button v-on:click.prevent="reset()" class="btn btn-primary">Reset</button>                    
                    <button v-on:click.prevent="saveSeatList()" class="btn btn-primary" :disabled="!isValidForSave">Save</button>
                  </div>
                </div>
              </div> 
            </div>
          </form>

          <template v-slot:footer>
            <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
              <strong> Seat Plan </strong> has been <strong>{{ actionStatus }} </strong>
              </show-alert>
          </template>

        </add-section>        
        
        <loader :show="loading"></loader>

        <div class="row" v-show="showSeatPlan">
          <div class="card">
            <div class="card-header">Seat Planning <span> [ {{ totalSeats}} ]</span></div>
            <div class="card-body">                
              <div class="seat-layout">
                <div class="row driver-seat">                      
                  <button :disabled="true">Driver Seat</button>                      
                </div>

                <div class="row">
                  <button
                      class="col-xs-2"            
                      v-bind:class="{ active : seat.checked, 
                              inactive : !seat.checked, 
                              'col-xs-offset-2': emptySpace(index, seat.no)
                              }"
                      v-for="(seat, index) in seatList"          
                      @click="toggle(seat)"                               
                  >                       
                      <i class="fa fa-check fa-lg tickmark" v-show="seat.checked"></i>
                      <i class="fa fa-times fa-lg crossmark" aria-hidden="true" v-show="!seat.checked"></i>

                      <!-- {{ seat.no }} - {{ seat.sts }} : {{index}}  -->
                      {{ seat.no }}
                      
                  </button> 
                </div>
              </div>                   
            </div>
          </div>              
        </div>

        <div class="row justify-content-center">          
            <div class="col">
              <div class="card card-info">
                <div class="card-header">Seat Plan Info <span> [ {{ availableSeatPlanList.length }} ]</span></div>
                <div class="card-body">
                    <div id="scrollbar">
                      <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Sl. No.</th>
                              <th>Seat Plan ID</th>         
                              <th>Total Seats
                                <span type="button" @click="sortByIdOf('totalSeats')" :disabled="!disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                              </th>
                              <th>Created On
                                <span type="button" @click="sortByIdOf('dateCreated')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                              </th>
                              <th>Action</th>                                                         
                              <!-- <th>&nbsp;</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <tr  v-for="(seatplan, index) in availableSeatPlanList" >                              
                              <td>{{ index+1 }}</td>                              
                              <td>{{ seatplan.id }}</td>
                              <td>{{ seatplan.total_seats }}</td>
                              <td>{{ dateCreated(seatplan.created_at) }}</td>
                              <td>
                                  <!-- <button v-on:click.prevent="view(seatplan)" class="btn btn-success"> -->
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalComponent" v-on:click.prevent="view(seatplan)">    
                                    <i class="fa fa-eye fa-fw"></i>View
                                  </button>   
                                  <!-- <button v-on:click.prevent="edit(seatplan)" class="btn btn-primary">
                                    <i class="fa fa-edit fa-fw"></i>Edit
                                  </button>   -->
                                  <button v-on:click.prevent="remove(seatplan)" class="btn btn-danger">
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
                   Seat Plan
                    <strong> {{ actionStatus }} </strong> successfully!
                  </show-alert>
                </div>
              </div>
            </div>
        </div>

      </div>
      <!-- Modal -->
      <modal :show.sync="modal">                          
        <div class="row justify-content-center">
          <div class="card w-75">
            <div class="card-header">Seat Planning <span> [ {{ totalSeats}} ]</span></div>
            <div class="card-body">                
              <div class="seat-layout">                
                <div class="row driver-seat">                      
                  <button :disabled="true">Driver Seat</button>                      
                </div>
                <div class="row">
                  <button
                    class="col-xs-2"
                    v-bind:class="{
                      empty: seat.status=='n/a'? true : false,                                    
                      'col-xs-offset-2': emptySpace(index, seat.no) }"
                    v-for="(seat, index) in selectedSeatPlan"                              
                  >               
                    {{ seat.no }}
                  </button> 
                </div>
              </div>                   
            </div>
          </div>              
        </div>
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
                              disableSorting: true,
                              alertType: '',
                              availableSeatPlanList: [],
                              disableShowButton: false,
                              disableSaveButton: true,
                              error: '',
                              numberOfCol: 4,                            
                              numberOfRow: 4,                            
                              response: '',
                              seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],
                              seatList: [],
                              seatListCloned: [],                    
                              seatListLength: '',
                              selectedSeatPlan: [],      
                              show: false,
                              showSeatPlan: false,
                              showAlert: false,              
                              isDisabled: false,
                              index: 2, // empty space strating for this index then index+4
                              indexList: [],
                              loading: false,
                              fiveColValue: '',
                              modal: false,
                              totalSeats: '',
                          }

                },
                mounted() {
                    this.createIndexList();
                    this.fetchAvailableSeatPlans();
                    this.enableScroll();
                },
                watch: {
                    numberOfRow() {
                        this.createIndexList();
                        this.isShowButtonDisable();                        
                    },

                    response() {
                      //this.availableSeatPlanList.push(this.response);
                      this.hideAlert();
                    },

                    seatList: {
                      handler(val, oldVal) {
                        this.totalSeatsCount(this.seatList);                        
                      },
                      deep: true
                    },
                    modal() {                      
                      if (!this.modal) {
                        this.selectedSeatPlan = [];
                      }
                    },
                },

                computed: {
                    isValidForShow() {                        
                        return  this.numberOfRow != '' &&
                                this.disableShowButton != true
                      },

                    isValidForSave() {                        
                      return  this.numberOfRow != '' &&
                              this.disableSaveButton != true
                    }
                },

                methods: {
                    dateCreated(dateString) {
                      var date = new Date(dateString);
                      return date.toLocaleDateString('en-GB');
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

                    totalSeatsCount(arrayName) {
                      let count=0;
                      //this.selectedSeatPlan.forEach(function(seat) {
                      arrayName.forEach(function(seat) {
                        if (seat.status === 'available') {
                         count++;                         
                        }
                      }); 
                      console.log(count);
                      this.totalSeats = count;
                    },

                    hideAlert() {
                      let vm = this;
                      setTimeout(function() { 
                        vm.showAlert = false;          
                      }, 3000);
                    },
                    
                    setRowNumber() {
                      let length = this.selectedSeatPlan.length-1;
                      this.numberOfRow = length/4;
                    },

                    createIndexList() {
                        this.indexList=[];
                        var r;
                        var numberOfRow = this.numberOfRow;
                        var index = this.index;
                        for ( r=1; r<numberOfRow; r++ ) { 
                            this.indexList.push(index);
                            index = index+4; 
                            //console.log('index', index);
                        }
                    },                  
                    isShowButtonDisable() {
                        this.disableShowButton = ( this.numberOfRow == '' || this.numberOfRow == 0) ? 
                                                true : false;
                    },

                   isSaveButtonDisable() {                       
                      this.disableSaveButton = (this.seatListLength == '') ? 
                                              true : false;                    
                  },
                  emptySpace(index, seatNo) {  //2, 6, 10
                      if ( this.isFiveCol(seatNo) ) {
                          return false; // no need empty space between columns
                      }
                      return this.isEmptySpaceAvailable(index);
                  }, 
                  
                  isFiveCol(seatNo) {                        
                      var numberOfRow = this.numberOfRow;
                      var lastRowChar = this.seatChar[numberOfRow-1]; //B
                      lastRowChar = lastRowChar.trim();
                      
                      var seatChar = seatNo.substr(0, 1); //extract char from seat no
                      return ( lastRowChar == seatChar ) ? true : false ;
                  },
                  
                  isEmptySpaceAvailable(index) {

                      var val = this.indexList.find( function(indx) {                            
                          return indx == index;
                      });
                      return (index == val) ? true : false;
                  },                    

                  createList() {
                      var r; //row                    
                      var code = 64;
                      var seatNo;
                      var numberOfRow = this.numberOfRow//8;
                      var numberOfCol = this.numberOfCol //4;
                      for ( r=1; r<=numberOfRow; r++ ) {
                          // console.log('row=', r);
                          var c; //col                            
                          for( c=1; c<=numberOfCol; c++) {
                              seatNo = String.fromCharCode(code+r)+ c ;
                              // console.log('col=', c);
                              // console.log('seat=', seatNo); 
                              this.seatList.push({
                                  no: seatNo,
                                  status: 'available', 
                                  checked: true
                              });
                          }
                      }

                      // for 5th column                         
                      this.fiveColValue = code+numberOfRow;
                      seatNo = String.fromCharCode(code+parseInt(numberOfRow))+ c ; //64+6 + 5 E5
                      this.seatList.push({
                                  no: seatNo,
                                  status: 'available', 
                                  checked: true
                      }); 

                      this.seatListCloned = this.cloneSeatList(); 

                      this.isDisabled = true;
                      this.disableShowButton = true;
                      this.disableSaveButton = false;
                      this.seatListLength = this.seatList.length;
                      this.showSeatPlan = true;                        
                  },
                  
                  fetchAvailableSeatPlans() {
                      this.loading = true;
                      this.availableSeatPlanList= [];            
                      var vm = this;                
                      axios.get('/api/seatplans')  //--> api/bus?q=xyz        (right)
                          .then(function (response) {                  
                             response.data.error ? vm.error = response.data.error : vm.availableSeatPlanList = response.data;
                             //vm.sortByBusId(vm.availableSeatPlanList);                       
                             vm.loading = false;
                      });
                  },

                 remove(seatplan) { 
                    var vm = this;
                    swal({
                      title: "Are you sure?",
                      text: "This SEAT PLAN will be Removed!",
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

                        axios.delete('/seatplans/'+seatplan.id)          
                        .then(function (response) {               
                            response.data.error ? vm.error = response.data.error : vm.response = response.data;
                            if (vm.response) {                                
                                vm.removeFromAvailableSeatPlanList(seatplan.id); // update the array after removing
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
                  removeFromAvailableSeatPlanList(seatplanId) {
                      var indx = this.availableSeatPlanList.findIndex(function(seatplan){                 
                           return seatplan.id == seatplanId;
                      });        
                      this.availableSeatPlanList.splice(indx, 1);
                      //return;
                  },

                  reset() {
                      this.seatList=[];
                      this.numberOfRow = '';
                      this.isDisabled = false;
                      this.disableShowButton = false;
                      this.seatListLength = '';
                      this.showSeatPlan = false;
                  },

                  saveSeatList() {
                      var vm = this;
                      this.loading = true;                      
                      axios.post('/seatplans', {
                          seat_list: this.seatList,
                          total_seats: this.totalSeats
                      })          
                      .then(function (response) {
                             console.log(response.data);
                             response.data.error ? vm.error = response.data.error : vm.response = response.data;
                             vm.availableSeatPlanList.push(vm.response);
                             vm.loading = false;
                             vm.actionStatus = 'Added';
                             vm.reset();
                             vm.alertType = 'success';
                             vm.showAlert = true;
                             console.log(response.status);
                      });
                  },

                  toggle(seat) {                     
                      seat.checked = !seat.checked; 
                      if (seat.checked) {                          
                          seat.status = 'available';                          
                          this.updateSeatList(seat, 'available');                       
                          return ;
                      }                                                       
                      seat.status = 'n/a';                     
                      this.updateSeatList(seat, 'n/a');                       
                  },

                  updateSeatList(seat, status) {                        
                    var clonedSeatList = this.cloneSeatList();
                    var index = this.seatList.indexOf(seat);                     
                    var rightColIndexList = this.createIndexListOfRightMostColumn();   
                    var indexExist = rightColIndexList.includes(index);                 
                    
                    switch (status) {
                      case 'n/a':           
                        if (!indexExist) {                     
                          this.seatList[index+1].no = seat.no; 
                          while (!rightColIndexList.includes(index)) {
                            //console.log('newindex='+index);                            
                            if (index == this.seatListLength-2) { 
                              return;
                            }                             
                            var seatToShift = clonedSeatList[index+1].no; 
                            var seatToBeReplaced = this.seatList[index+2].no; 

                            if (seatToShift.substring(0, 1) != seatToBeReplaced.substring(0, 1))  {
                              return;
                            }
                            this.seatList[index+2].no = seatToShift;
                            index++;                                                   
                          }
                        }                        
                        break;
                      
                      case 'available':
                        let seatListCloned = this.seatListCloned; 
                        var idx = this.findIndexOf(seat, seatListCloned);
                        console.log('idx='+idx);                       

                        while (!rightColIndexList.includes(index))  
                        {  
                          //console.log('cindx='+indx);                      
                          console.log('cindx='+index);                      
                          this.seatList[index+1].no = this.seatListCloned[idx+1].no;                          
                          //this.seatList[index+1].no = this.seatListCloned[index+1].no;                          
                          index++; 
                          idx++;
                          if (index == this.seatListLength-1) { 
                            return;
                          } 
                        }                        
                        break;

                      default:
                        console.log('Sorry, we are out of ' + status + '.');
                    }                    
                  },

                  findIndexOf(obj, arr) {
                    for (let i = 0; i < arr.length; i++) {
                        if (arr[i].checked == obj.checked && 
                            arr[i].no == obj.no && 
                            arr[i].status == obj.status) {
                            return i;
                        }
                    }
                    return -1;                
                  },

                  createIndexListOfRightMostColumn() {
                    var indexList=[];
                    var r;
                    var numberOfRow = this.numberOfRow;
                    var index = 4;
                    for ( r=1; r<=numberOfRow; r++ ) { 
                        (r == numberOfRow) ?
                        indexList.push(index) : indexList.push(index-1); //3 7 11 15
                        index = index+4; //8 12 16
                        //console.log('index', index);
                    }
                    //console.table(indexList);
                    return indexList;
                  },

                  cloneSeatList() {
                    return JSON.parse(JSON.stringify(this.seatList));
                  },                   
                  
                  view(seatplan) {
                    this.selectedSeatPlan = seatplan.seat_list;
                    this.setRowNumber();
                    this.createIndexList(); 
                    this.modal = true;
                    this.totalSeatsCount(this.selectedSeatPlan);
                  },

                }
    }
</script>
<style lang="scss" scoped>
    .seat-layout .active {
        background-color: #f4e542;
        position: relative;
    }                   
    .inactive {
        background-color: #c4c0c0;  
    }                       
    .tickmark {
        /*background-color: green;*/
        color: green;
        /*padding: 5px;*/
    }
    .crossmark {
        /*background-color: red;*/
        /*padding: 5px;*/
        color: red;
    }
    /*#app button {               
        height: 50px;
        margin: 10px 10px 0 0;
    }*/
    .seat-layout button {               
        height: 50px;
        margin: 10px 10px 0 0;
    }
    #app button.col-xs-2 {
        width: 16.76666667%;
    }
    #app button.col-xs-offset-2 {
        margin-left: 17.666667%;
    }
    // section.content { 
    //     padding-left: 30px;
    //     padding-right: 30px;
    // }
    #app .seat-layout {
        padding-left: 50px;
    }
    #app .button-group {
      margin: 1.9rem auto; 
    }    

    div.row.driver-seat {      
      height: 4rem;
      position: relative;
    }

  div.row.driver-seat > button {
    position: absolute;
    top: 0;
    right: 10%;
  }

  .empty {
    background-color: white;
    border-width: 0;   
    color:white;        
  }
  
  // #scrollbar {
  //   height: 25rem; /*400px;*/
  //   span {
  //           cursor: pointer;
  //           margin-left: 5px;
  //       }
  //       span[disabled] {
  //           cursor: not-allowed;
  //           opacity: 0.65;
  //       }
  // }
  // div.card-header span {
  //   background-color: #F2B705; //yellow;
  //   font-weight: 600;
  //   float: right;
  //   padding: 2px 6px;
  //   color: #F24405;//royalblue;
  // }

</style>