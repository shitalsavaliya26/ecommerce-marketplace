<h1 class="text-black font-16 font-GilroySemiBold mb-0">{{$defaultaddress->name}} ({{$defaultaddress->country_code ? $defaultaddress->country_code : $defaultaddress->countrycode}}) {{$defaultaddress->contact_number ? $defaultaddress->contact_number : $defaultaddress->contact_no}}
	<?php 
	$fulladdress = implode(", ", array_filter([$defaultaddress->defaultaddress_line1, $defaultaddress->defaultaddress_line2, $defaultaddress->town, $defaultaddress->state, $defaultaddress->country, $defaultaddress->postal_code])) ;
	?>
	<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
</div>