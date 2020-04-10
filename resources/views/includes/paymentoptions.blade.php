<div class="payment-options p-2 my-2">
	<div class="radio">
	  <label class="radio-inline">
	    <input type="radio" name="paymentMethod" id="optionsRadios1" value="cash" v-model="payment.method">
	    Cash
	  </label>	  
	</div>
	<div class="radio">
	  <label class="radio-inline">
	    <input type="radio" name="paymentMethod" id="optionsRadios2" value="pos" v-model="payment.method">
	    POS
	  </label>
	</div>
	<div class="form-group" v-show="payment.method=='pos'">
    <label for="transacton">Transaction:</label>	
		<input type="text" class="form-control" name="transaction" id="transaction" v-model="payment.transaction" placeholder="Enter transaction number">
	</div>
</div>
{{-- <span> Picked @{{ url }}</span> --}}