@forelse (getCurrencies() as $currency)
<option value="{{$currency->id}}" >{{$currency->code}}</option>
@empty
@endforelse
