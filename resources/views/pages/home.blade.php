@extends('layouts.app')
@section('warningbar')
  @include('includes.unverified.phone-warning')                
@endsection
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
              {{-- @auth
                <div v-show="{{ !auth()->user()->hasVerifiedPhone() }}" class="text-center alert alert-info fade show" role="alert">  
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  Your phone is not verified. <a class="mx-2 btn btn-primary btn-sm" href="{{ route('phoneverification.notice') }}" role="button">Verify your phone please!</a>                  
                </div>
              @endauth --}}
              
              <div v-show="!isSeatBooked" class="card border-0 bg-transparent">
                {{-- <div class="card-heading">Search Schedule</div> --}}
                <div class="card-body">                  
                  <form>
                    <div class="row align-items-center">
                      <div class="col-5 search-form shadow">
                        @include('includes.search')                       
                      </div>
                      <div class="col-7">                        
                      </div>
                    </div>                    
                  </form> 
                </div>
              </div>
              {{-- SCHEDULE --}}    
              <div v-show="showSchedule" class="info-table">              
                <div class="card">
                  <div class="card-body p-0">
                    {{-- <div id="scrollbar"> --}}
                      <table class="table table-striped table-hover">
                       <!-- Table Headings -->
                        <thead>
                            <th>SL No.</th>                                
                            <th>Dept. Time</th>            
                            <th>Arr. Time</th>             
                            <th>Type</th>                                
                            <th>Available Seats</th>
                            <th>Fare</th>                                
                            <th>View</th>
                            {{-- <th>&nbsp;</th> --}}
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
                                   {{--  <button v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id, bus.fare)" class="btn btn-success">View</button>  --}}
                                  </div>
                                  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#staticBackdrop" v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id, bus.fare)">    
                                      <i class="button-icon fas fa-eye"></i>View
                                  </button>   
                                </td>
                            </tr>                                                            
                        </tbody>
                      </table>                        
                    {{-- </div> --}}
                  </div>            
                </div>
              </div>  

              <loader :show="loading"></loader>

              {{-- <div class="col-sm-6 col-sm-offset-2"> --}}
                  {{-- Booked Seat Info --}}
                  @include('includes.booking')
              {{-- </div>                     --}}

              <!-- Modal / unit in rem -->
              <modal :show.sync="modal" width="45" padding="0.5">
                @include('includes.seatselection')
              </modal>              
          </div>      
      </seat-display>              
    </div>      
  </div>
</div>
@endsection