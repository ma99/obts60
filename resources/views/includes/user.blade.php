{{-- <div class="card">
    <div class="card-header">For Rgistered User</div>
    <div class="card-body"> --}}
    	<div class="d-flex">
    		<div class="p-2 flex-fill info-l">
    			<i class="mt-3 fas fa-user-clock fa-2x"></i>
	    	</div>
	  		<div class="p-2 flex-fill info-r">
	  			<h5 class="mx-2">Ticket!</h6>
	  			<form method="POST" action="/seatbooking" v-on:submit.prevent="seatBookingByUser()">			
					<p class="mt-2 mx-2"> Book The Ticket(s) 
						<button :disabled="!isValid" class="mt-2 btn btn-primary btn-block">Continue</button>
					</p>
				</form>
	  		</div>    		
    	</div>    	
    {{-- </div>
</div> --}}
