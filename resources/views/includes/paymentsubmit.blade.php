@csrf
<input id="booking_id" name="booking_id" type="hidden" :value="bookedSeatInfo.booking_ref">
<div class="form-group">
{{-- <button class="btn btn-success btn-block" :disabled="!bookedSeatInfo.booking_ref">Pay Now</button> --}}
<button class="btn btn-success btn-block" :disabled="disablePayButton">Pay Now</button>
</div>