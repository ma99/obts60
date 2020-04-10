<div class="icon-box {{ $status }}">
	{{-- <i class="material-icons">&#xE876;</i> --}}	
	{{-- <i class="fas fa-check-circle"></i> --}}
	<i class="fas {{ $icon }}"></i>
</div>	
<div class="card-body mt-4">
	<h5 class="card-title">{{ $title }}</h5>
	<p class="card-text"> {{ $msg }} </p>
	@if ($status == 'error')
		<form method="post" action="{{ route('make.payment') }}">
	        @csrf
	        <input id="booking_id2" name="booking_id" type="hidden" value="{{ $booking_id }}">                                
	        <button class="btn btn-primary btn-block">Try Again</button>			
    	</form>	
	@endif
		<form method="get" action="{{ route('home') }}">
	        @csrf                                
	        <button class="btn btn-{{ $button }} btn-block mt-2">Ok</button>
			{{-- <button class="btn btn-outline-primary btn-block">Ok</button> --}}		
    	</form>	
	{{-- @endif	 --}}
</div>