@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-12">        
        welcome to home page of obts
      </div>
     {{--  <seat cities= "{{ $cities }}" ></seat>        --}}
     <div class="col-12 mt-3">
      <seat-display inline-template>
          <div>
              {{-- @if (auth()->check())
              <div v-show="false">  @{{ guestUser = false }} </div>
              @endif --}}
              <div v-show="!isSeatBooked" class="card shadow-sm">
                {{-- <div class="card-heading">Search Schedule</div> --}}
                <div class="card-body">                  
                  <form>
                    <div class="row align-items-center">
                      <div class="col-5 search-form">
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
                            <button type="button" v-on:click.prevent="searchBus" class="btn btn-primary btn-search form-control" :disabled="isDisabled">Search &nbsp;
                              <i class="fa fa-search"></i>
                            </button>
                          </div>                          
                        </div>                        
                      </div>
                      <div class="col-7"></div>
                    </div>                    
                  </form> 
                </div>
              </div>
              {{-- SCHEDULE --}}    
              <div v-show="showSchedule" class="card">
                  <div class="card-heading">Schedule Details</div>
                  <table class="table table-striped task-table">
                     <!-- Table Headings -->
                      <thead>
                          <th>SL No.</th>                                
                          <th>Dept. Time</th>            
                          <th>Arr. Time</th>             
                          <th>Type</th>                                
                          <th>Available Seats</th>
                          <th>Fare</th>                                
                          <th>View</th>
                          <th>&nbsp;</th>
                      </thead>
                      <!-- Table Body -->
                      <tbody>
                          <tr v-for="(bus, index) in buses">
                              <td class="table-text">
                                <div> @{{ index + 1 }} </div>
                              </td>

                              <td class="table-text">
                                <div> @{{ bus.departure_time }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.arrival_time }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.bus_type }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.available_seats }} </div>
                              </td>
                              <td class="table-text">
                                <div> @{{ bus.fare }} </div>
                              </td>
                              <td class="table-text">
                                <div> 
                                  <button v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id, bus.fare)" class="btn btn-success">View</button> 
                                </div>
                              </td>
                          </tr>                                                            
                      </tbody>
                  </table>
                  <div v-show="busError" class="alert alert-danger" role="alert">
                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                      @{{ busError }}
                  </div>
              </div>
              <loader :show="loading">              
              </loader>
              <div class="col-sm-6 col-sm-offset-2">
                  {{-- Booked Seat Info --}}
                  @include('includes.booking')
              </div>                    

              <!-- Modal -->
              <modal :show.sync="modal">                  
                <div class="row">
                  <div id="seat-layout" class="col-sm-6" v-show="!seatError">
                    <div class="card card-default">
                      <div class="card-header">Seat Plan</div>
                      <div class="row card-body">
                        <div class="seat-plan-body">
                          <div class="col-xs-offset-8">
                            <button :disabled="true">Driver Seat</button>
                          </div>              
                          <button
                            class="col-xs-2"
                            v-bind:class="{ 
                              'is-active': seat.checked, 
                              booked: seat.status=='booked'? true : false,
                              buying: isSeatBuying(seat.status),
                              {{-- 'fa fa-refresh fa-spin': seat.status=='buying'? true : false,  --}}
                              confirmed: seat.status=='confirmed'? true : false, 
                              empty: seat.status=='n/a'? true : false,             
                              'col-xs-offset-2': emptySpace(index, seat.seat_no) }"
                            v-for="(seat, index) in seatList"          
                            @click="toggle(seat)"           
                            :disabled="isDisabledSeatSelection(seat.status)"                   
                          >               
                            {{-- @{{ seat.seat_no }} - @{{ seat.status }} --}}
                            <span v-show="!isSeatBuying(seat.status)" > @{{ seat.seat_no }} </span>
                            <span v-show="isSeatBuying(seat.status)" class="fa fa-refresh fa-spin text-danger"></span>  
                            {{-- <i v-show="seat.status=='buying' class="fa fa-refresh fa-spin text-danger"></i>   --}}
                          </button> 
                        </div>
                      </div>
                      {{-- card-footer --}}
                      {{-- <div class="card-footer">                     --}}
                      <div class="card-footer">
                        <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false"> 
                        <!-- altert type can be info/warning/danger -->
                          <strong>@{{ seatNo }} </strong> has been <strong>@{{ seatStatus }} </strong>
                        </show-alert>
                      </div>  
                      
                     {{--  <div v-show="false" class="card-footer" 
                         v-bind:class="{ 
                            'alert-info': seatStatus=='available'? true : false, 
                            'alert-warning': seatStatus=='booked'? true : false, 
                            'alert-danger': seatStatus=='confirmed'? true : false 
                         }" 
                         id="status-alert"
                      >
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>@{{ seatNo }} </strong> has been <strong>@{{ seatStatus }} </strong>
                      </div>   --}}                          
                    </div>
                    
                    {{-- <div class="card card-success">
                      <div class="card-heading">Pickup & Dropping</div>
                      <div class="card-body">
                        @include('includes.stops')
                      </div>
                    </div>   --}}

                  </div>
                  
                  <!-- Seat Plan Not Available -->
                  <div class="col-sm-6" v-show="seatError">
                    <div class="alert alert-warning seat-error" role="alert">
                      <h3> @{{ seatError }}</h3>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <!-- Selected Seat with Price  -->
                    {{-- <div v-show="isSeatSelected" class="card card-primary row"> --}}
                    <div v-show="isSeatSelected" class="card card-primary">
                      <div class="card-header">Selected Seat Info</div>
                      <table class="table table-striped">
                        <thead>
                          <th>Sl.#</th>
                          <th>Seat Selected</th>
                          <th>Price</th>
                          <th>Remove</th>
                          <!-- <th>&nbsp;</th> -->
                        </thead>
                        <tbody>
                          <tr v-for="(seat, index) in selectedSeat">
                            <td class="table-text">
                              <div> @{{ index + 1 }} </div>
                            </td>
                            <td class="table-text">
                              <div> @{{ seat.seat_no }} </div>
                            </td>
                            <td class="table-text text-primary">
                               <div> @{{ seat.fare }} </div>
                            </td>
                            <td class="table-text">
                               <div>
                                  <button @click.prevent="removeSeat(seat.seat_no, seat)" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                   <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  </button>
                                </div>
                              </td>                                          
                          </tr>                                      
                          @{{ totalFareForSelectedSeats }}      
                        </tbody>
                      </table> 
                      {{-- <span class="total"> Total Amount @{{ totalFare }} </span> --}}
                      <div class="card-footer total"><strong>Total Amount:</strong> @{{ totalFare }} </div>
                    </div>
                    
                    <!-- Pickup & Dropping Selection -->
                    <div class="card card-success">
                      <div class="card-heading">Pickup & Dropping</div>
                      <div class="card-body">
                        @include('includes.stops')
                      </div>
                    </div>  

                    <!-- User/ Guest Info Entry -->
                    {{-- <div class="row"> --}}                        
                        @if (auth()->check())
                          @if (auth()->user()->isNormalUser())
                            @include('includes.user')
                          @else
                            @include('includes.guest')
                          @endif                          
                        @else
                          @include('includes.guest')
                        @endif       
                    {{-- </div> --}}
                    {{-- <button v-on:click.prevent="seatBooking()" class="btn btn-primary">Continue
                    </button> --}}

                  </div>
                </div>    
              </modal> 
          </div>  
    
      </seat-display>              
     </div>
      
    </div>
</div>
@endsection