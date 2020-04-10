{{-- <div v-show="isSeatBooked" class="row justify-content-center"> --}}
<div class="row justify-content-center mt-4">
  <div class="col-10">
    <div class="card w-75 shadow">
      <div class="icon-box success">        
        <i class="fas fa-file-invoice"></i>
      </div>  
      <div class="card-body">        
        <div class="row booking-info p-3">
          <div class="col-12 mt-2">
            <p class="text-muted text-center">Your Booking Request has been completed.</p>
          </div>          
          <div class="col-12 mb-3 border-bottom">
            <h4 class="card-title text-success text-center">Booking Details</h4>
          </div>          
        
        {{-- <h5 class="card-title">Thank You!</h5> --}}
          <div class="col-12 mb-3">
            Booking Ref: <strong>@{{ bookedSeatInfo.booking_ref }}</strong>
          </div>
        
          @auth
          @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
            {{-- @include('includes.guest') --}}
            <div class="col-6 mb-2">
              Name: <strong>@{{ form.name }}</strong>
            </div>
            <div class="col-6 mb-2">
              Phone: <strong>@{{ form.phone }}</strong>
            </div>
          @else 
            <div class="col-6 mb-2">
              Name: <strong>{{ auth()->user()->name }}</strong>
            </div>
            <div class="col-6 mb-2">
              Phone: <strong>{{ auth()->user()->phone }}</strong>
            </div>
          @endif
          @endauth

          <div class="col-7 mb-2">
            Seat No(s): <strong>@{{ bookedSeatInfo.seat_no}}</strong>
          </div>
          <div class="col-7 mb-2">
            Amount: <strong>@{{ bookedSeatInfo.amount }} </strong> Tk
          </div>
          <div class="col-6 mb-2">
            Date: <strong>@{{ bookedSeatInfo.date }}</strong>
          </div>
          <div class="col-6 mb-2">
            Time: <strong>@{{ bookedSeatInfo.departure_time }}</strong>
          </div>
          <div class="col-6 mb-2">
            Pickup Point: @{{ bookedSeatInfo.pickup_point }} 
          </div>
          <div class="col-6 mb-2">
            Dropping Point: @{{ bookedSeatInfo.dropping_point }} 
          </div>
          <div class="col-6 mb-2">
            Coach: @{{ bookedSeatInfo.bus_no }} 
          </div>         
          <div class="col-12 mt-2">
            {{-- <form method="post" action="{{ route('make.payment', ['booking' => bookedSeatInfo.booking_ref ]) }}"> --}}            
            
                  @auth
                    @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
                      <form method="post" action="{{ route('make.payment.cash')}}">            
                        @csrf   
                        @include('includes.paymentoptions')
                        <input id="booking_id" name="booking_id" type="hidden" :value="bookedSeatInfo.booking_ref">
                        <div class="form-group">
                            <button class="btn btn-success btn-block" :disabled="!bookedSeatInfo.booking_ref">Pay Now</button>
                        </div>
                      </form>                    
                    @endif

                    <form method="post" action="{{ route('make.payment.card')}}">            
                      @csrf
                      <input id="booking_id" name="booking_id" type="hidden" :value="bookedSeatInfo.booking_ref">
                      <div class="form-group">
                          <button class="btn btn-success btn-block" :disabled="!bookedSeatInfo.booking_ref">Pay Now</button>
                      </div>
                    </form>
                  @endauth 
          </div>
            {{-- <div class="col-6 mb-2 auth-verify">               
            </div> --}}
        {{-- </div> --}}
        </div>
      </div>
    </div>
  </div>
</div>