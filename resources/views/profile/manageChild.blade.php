<ul>
	@foreach($childs as $child)
	<li>
		<img src="assets/images/profile1.png" class="img-fluid max-w-20px" alt="">

		<span class="child">{{ $child['name'] }} ({{$child['email']}})
			<br><span class="child-title">Role :</span>
			@if($child->role->name == "Gold")
			<span class="child-value Gold"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Silver")
			<span class="child-value Silver"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Diamond")
			<span class="child-value Diamond"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Executive")
			<span class="child-value Executive"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Customer")
			<span class="child-value Customer"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Platinum")
			<span class="child-value Platinum"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Sales manager")
			<span class="child-value Sales"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Finance Department")
			<span class="child-value Finance"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Shipping Department")
			<span class="child-value Shipping"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Receptionist")
			<span class="child-value Receptionist"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "tracking id check")
			<span class="child-value tracking"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Operation Manager")
			<span class="child-value Operation"> {{ $child->role->name }}</span>
			@endif
			@if($child->role->name == "Staff")
			<span class="child-value Operation"> {{ $child->role->name }}</span>
			@endif
			<!-- <br><span class="child-title">Monthly sales :</span> <span>RM {{ number_format(round($child->get_current_monthsale($child)),2) }}</span>
				<br><span class="child-title">Monthly group sales :</span> <span>RM {{ number_format(round($child->get_current_monthgroupsale($child)),2) }}</span> --></span>
				@if(count($child->childs))
				@include('profile.manageChild',['childs' => $child->childs])
				@endif
			</li>
			@endforeach
		</ul>