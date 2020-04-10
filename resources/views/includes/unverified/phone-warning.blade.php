<div class="container-fluid">
	<div class="row" style="background-color: #b4ddff;">
		<div class="col-12">
			@auth
                <div v-show="{{ !auth()->user()->hasVerifiedPhone() }}" class="text-center alert fade show" style="padding: 0.3rem; margin-bottom: 0;" role="alert">  
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  Dear {{ auth()->user()->name }}! Your phone is not verified. Please <a class="mx-2 btn btn-primary btn-sm" href="{{ route('phoneverification.notice') }}" role="button">verify your phone</a>
                </div>
              @endauth
		</div>
	</div>
</div>					