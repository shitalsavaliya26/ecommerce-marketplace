<div class="m-portlet__head-caption">
	<div class="m-portlet__head-title">
		<h3 class="m-portlet__head-text">
			<b>Set Price </b>
		</h3>
		<table class="table table-striped">
			<thead>
				<tr>
					@foreach($attributeArray as $attributePrice)
						<th>{{$attributesData[$attributePrice]}}</th>
					@endforeach
					<?php $j = 0;?>
					@foreach($priceArrayFinal as $key => $var)
					<tr>
						<?php $attributionArray = explode('_', $newPriceCombine[$key]);?>
						@for ($i = 0; $i < count($attributionArray); $i++)
							<td>{{$attributionArray[$i]}}</td>
						@endfor
						<td>
							<div class="form-group m-form__group row">
								<div class="col-lg-6 form-group m-form__group ">
									<label for="weight">Product weight (KG)</label>
									<div class="m-input-icon m-input-icon--right">
										@if(!empty($var))
											<input type="text" class="form-control m-input weights{{$key}}" id="weights-{{$j}}"
												name="{{$key}}[weights]" value="{{$var['weight']}}"
												placeholder="Enter weight" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input weights{{$key}}" id="weights-{{$j}}"
												name="{{$key}}[weights]" value="{{$product->weight}}"
												placeholder="Enter weight" min="0" autofocus required onkeypress="validate(event)">
										@endif
									</div>
								</div>
								<div class="col-lg-6 form-group m-form__group " style="padding-top: 0px;">
									<label for="length">Product dimension (length * width *
									height)</label>
									<div class="m-input-icon m-input-icon--right">
										<div class="row">
											<div class="col-lg-4">
												@if(!empty($var))
													<input type="text" class="form-control m-input lengths{{$key}}" id="lengths-{{$j}}"
														name="{{$key}}[lengths]" value="{{$var['length']}}"
														placeholder="Enter length" min="0" autofocus required onkeypress="validate(event)">
												@else
													<input type="text" class="form-control m-input lengths{{$key}}" id="lengths-{{$j}}"
														name="{{$key}}[lengths]" value="{{$product->length}}"
														placeholder="Enter length" min="0" autofocus required onkeypress="validate(event)">
												@endif
											</div>

											<div class="col-lg-4">
												@if(!empty($var))
													<input type="text" class="form-control m-input widths{{$key}}" id="widths-{{$j}}"
														name="{{$key}}[widths]" value="{{$var['width']}}"
														placeholder="Enter width" min="0" autofocus required onkeypress="validate(event)">
												@else
													<input type="text" class="form-control m-input widths{{$key}}" id="widths-{{$j}}"
														name="{{$key}}[widths]" value="{{$product->width}}"
														placeholder="Enter width" min="0" autofocus required onkeypress="validate(event)">
												@endif
											</div>

											<div class="col-lg-4">
												@if(!empty($var))
													<input type="text" class="form-control m-input heights{{$key}}" id="heights-{{$j}}"
														name="{{$key}}[heights]" value="{{$var['height']}}"
														placeholder="Enter height" min="0" autofocus required onkeypress="validate(event)">
												@else
													<input type="text" class="form-control m-input heights{{$key}}" id="heights-{{$j}}"
														name="{{$key}}[heights]" value="{{$product->height}}"
														placeholder="Enter height" min="0" autofocus required onkeypress="validate(event)">
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group m-form__group row">
								<div class="col-lg-12 form-group m-form__group ">
									<h5>Price tire </h5>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="customer_prices">Customer</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="customer_prices-{{$j}}"
												name="{{$key}}[customer_prices]" value="{{$var['customer_price']}}"
												placeholder="Enter customer price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="customer_prices-{{$j}}"
												name="{{$key}}[customer_prices]" value="{{$product->customer_price}}"
												placeholder="Enter customer price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('customer_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('customer_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="sell_prices">Selling Price</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="sell_prices-{{$j}}"
												name="{{$key}}[sell_prices]" value="{{$var['sell_price']}}"
												placeholder="Enter selling price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="sell_prices-{{$j}}"
												name="{{$key}}[sell_prices]" value="{{$product->sell_price}}"
												placeholder="Enter selling price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('sell_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('sell_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								@if (in_array(Auth::user()->role_id, [1, 9, 16]))
									<div class="col-lg-4 form-group m-form__group " >
										<label for="customer_cost_prices">Cost</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">RM</span>
											</div>
											@if(!empty($var))
												<input type="text" class="form-control m-input" id="customer_cost_prices-{{$j}}"
													name="{{$key}}[customer_cost_prices]" value="{{$var['cost_price']}}"
													placeholder="Enter customer cost price" min="0" autofocus required onkeypress="validate(event)" >
											@else
												<input type="text" class="form-control m-input" id="customer_cost_prices-{{$j}}"
													name="{{$key}}[customer_cost_prices]" value="{{$product->cost_price}}"
													placeholder="Enter customer cost price" min="0" autofocus required onkeypress="validate(event)">
											@endif
											@if ($errors->has('customer_cost_prices'))
											<span class="helpBlock">
												<strong>{{ $errors->first('customer_cost_prices') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<!-- <div class="col-lg-4 form-group m-form__group ">
										<label for="staff_prices">Staff price</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">RM</span>
											</div>
											@if(!empty($var))
												<input type="text" class="form-control m-input" id="staff_prices-{{$j}}"
													name="{{$key}}[staff_prices]" value="{{$var['staff_price']}}"
													placeholder="Enter staff price" min="0" autofocus required onkeypress="validate(event)">
											@else
												<input type="text" class="form-control m-input" id="staff_prices-{{$j}}"
													name="{{$key}}[staff_prices]" value="{{$product->staff_price}}"
													placeholder="Enter staff price" min="0" autofocus required onkeypress="validate(event)">
											@endif
											@if ($errors->has('staff_prices'))
											<span class="helpBlock">
												<strong>{{ $errors->first('staff_prices') }}</strong>
											</span>
											@endif
										</div>
									</div> -->
								@endif
								<!-- <div class="col-lg-4 form-group m-form__group ">
									<label for="ex_prices">Executive</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="ex_prices-{{$j}}"
												name="{{$key}}[ex_prices]" value="{{$var['executive_leader_price']}}"
												placeholder="Enter executive price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="ex_prices-{{$j}}"
												name="{{$key}}[ex_prices]" value="{{$product->executive_leader_price}}"
												placeholder="Enter executive price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('ex_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('ex_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group " >
									<label for="si_prices">Silver</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="si_prices-{{$j}}"
												name="{{$key}}[si_prices]" value="{{$var['silver_leader_price']}}"
												placeholder="Enter silver price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="si_prices-{{$j}}"
												name="{{$key}}[si_prices]" value="{{$product->silver_leader_price}}"
												placeholder="Enter silver price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('si_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('si_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="go_prices">Gold</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="go_prices-{{$j}}"
												name="{{$key}}[go_prices]" value="{{$var['gold_leader_price']}}"
												placeholder="Enter gold price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="go_prices-{{$j}}"
												name="{{$key}}[go_prices]" value="{{$product->gold_leader_price}}"
												placeholder="Enter gold price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('go_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('go_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="pl_prices">Platinum</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="pl_prices-{{$j}}"
												name="{{$key}}[pl_prices]" value="{{$var['plat_leader_price']}}"
												placeholder="Enter platinum price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="pl_prices-{{$j}}"
												name="{{$key}}[pl_prices]" value="{{$product->plat_leader_price}}"
												placeholder="Enter platinum price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('pl_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('pl_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group " >
									<label for="di_prices">Diamond</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" id="di_prices-{{$j}}"
												name="{{$key}}[di_prices]" value="{{$var['diamond_leader_price']}}"
												placeholder="Enter diamond price" min="0" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="di_prices-{{$j}}"
												name="{{$key}}[di_prices]" value="{{$product->diamond_leader_price}}"
												placeholder="Enter diamond price" min="0" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('di_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('di_prices') }}</strong>
										</span>
										@endif
									</div>
								</div> -->
								<div class="col-lg-4 form-group m-form__group ">
									<label for="qtys">Quantity</label>
									<div class="input-group">
										@if(!empty($var))
											<input type="number" class="form-control m-input" id="qtys-{{$j}}" name="{{$key}}[qtys]"
												value="{{$var['qty']}}" placeholder="Enter quantity" min="1" autofocus required onkeypress="validate(event)">
										@else
											<input type="number" class="form-control m-input" id="qtys-{{$j}}"
													name="{{$key}}[qtys]" placeholder="Enter quantity" min="1" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('qtys'))
											<span class="helpBlock">
												<strong>{{ $errors->first('qtys') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="statuses">Status</label>
									<div class="input-group">
										@if(!empty($var))
											<select class="form-control m_selectpicker" name="{{$key}}[statuses]" id="statuses-{{$j}}">
												<option value="active" @if($var['status'] == 'active') selected @endif >Active</option>
												<option value="inactive"  @if($var['status'] == 'inactive') selected @endif>Inactive</option>
											</select>
										@else
											<select class="form-control m_selectpicker" name="{{$key}}[statuses]" id="statuses-{{$j}}">
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										@endif
									</div>
								</div>
							</div>
							<!-- <div class="form-group m-form__group row">
								<div class="col-lg-12 form-group m-form__group ">
									<h5>PV Points </h5>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="executive_pv_points">Executive</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="executive_pv_points-{{$j}}" name="{{$key}}[executive_pv_points]" value="{{$var['executive_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="executive_pv_points-{{$j}}"
												name="{{$key}}[executive_pv_points]" value="{{$product->executive_pv_points}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('executive_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('executive_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="silver_pv_points">Silver</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="silver_pv_points-{{$j}}" name="{{$key}}[silver_pv_points]" value="{{$var['silver_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="silver_pv_points-{{$j}}"
												name="{{$key}}[silver_pv_points]" value="{{$product->silver_pv_point}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('silver_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('silver_pv_point') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="golden_pv_points">Gold</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="golden_pv_points-{{$j}}" name="{{$key}}[golden_pv_points]" value="{{$var['golden_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="golden_pv_points-{{$j}}"
												name="{{$key}}[golden_pv_points]" value="{{$product->golden_pv_point}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('golden_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('golden_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="platinum_pv_points">Platinum</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="platinum_pv_points-{{$j}}" name="{{$key}}[platinum_pv_points]" value="{{$var['platinum_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="platinum_pv_points-{{$j}}"
												name="{{$key}}[platinum_pv_points]" value="{{$product->platinum_pv_point}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('platinum_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('platinum_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="diamond_pv_points">Diamond</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="diamond_pv_points-{{$j}}" name="{{$key}}[diamond_pv_points]" value="{{$var['diamond_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="diamond_pv_points-{{$j}}"
												name="{{$key}}[diamond_pv_points]" value="{{$product->diamond_pv_point}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('diamond_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('diamond_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group">
									<label for="staff_pv_points">Staff </label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">%</span>
										</div>
										@if(!empty($var))
											<input type="text" class="form-control m-input" 
												id="staff_pv_points-{{$j}}" name="{{$key}}[staff_pv_points]" value="{{$var['staff_pv_point']}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@else
											<input type="text" class="form-control m-input" id="staff_pv_points-{{$j}}"
												name="{{$key}}[staff_pv_points]" value="{{$product->staff_pv_point}}"
												placeholder="Enter executive pv points" autofocus required onkeypress="validate(event)">
										@endif
										@if ($errors->has('staff_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('staff_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div> -->
							@if($j != 0)
								<div class="col-lg-12 m--align-right">
									<a class="btn btn-primary  font12 copy{{$j}} copyButton" id="copy-{{$j}}" name="copyButton" style="color: white">
										<span>
											<span>Copy from above</span>&nbsp;&nbsp;
										</span>
									</a>
								</div>
							@endif							
						</td>
					</tr>
					<?php $j++ ?>
					@endforeach
				</tr>
			</thead>
		</table>
	</div>
</div>
