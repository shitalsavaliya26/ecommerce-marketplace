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

					@foreach($cross as $key => $var)
					<tr>
						@for ($i = 0; $i < count($var); $i++)
								<td>{{$var[$i]}}</td>
						@endfor
						<td>
							<div class="form-group m-form__group row">
								<div class="col-lg-6 form-group m-form__group ">
									<label for="weight">Product weight (KG)</label>
									<div class="m-input-icon m-input-icon--right">
										<input type="text" class="form-control m-input weights{{$key}} required" id="weights-{{$key}}"							
											name="weights[{{$key}}]" placeholder="Enter weight" autofocus>
									</div>
								</div>
								<div class="col-lg-6 form-group m-form__group " style="padding-top: 0px;">
									<label for="length">Product dimension (length * width *
									height)</label>
									<div class="m-input-icon m-input-icon--right">
										<div class="row">
											<div class="col-lg-4">
												<input type="text" class="form-control m-input lengths-{{$key}} required"
												id="lengths-{{$key}}" name="lengths[{{$key}}]" placeholder="Length" autofocus>
											</div>

											<div class="col-lg-4">
												<input type="text" class="form-control m-input  widths-{{$key}} required"
												id="widths-{{$key}}" name="widths[{{$key}}]" placeholder="Width" autofocus>
											</div>

											<div class="col-lg-4">
												<input type="text" class="form-control m-input heights-{{$key}} required"
												id="heights-{{$key}}" name="heights[{{$key}}]" placeholder="Height" autofocus>
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
										<input type="text" class="form-control m-input customer_prices{{$key}} required" id="customer_prices-{{$key}}"
											name="customer_prices[{{$key}}]"
											placeholder="Enter customer price" min="0.01" autofocus>
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
										<input type="text" class="form-control m-input sell_prices{{$key}} required" id="sell_prices-{{$key}}"
											name="sell_prices[{{$key}}]" 
											placeholder="Enter selling price" min="0.01" autofocus>
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
											<input type="text" class="form-control m-input customer_cost_prices{{$key}} required" id="customer_cost_prices-{{$key}}"
												name="customer_cost_prices[{{$key}}]" 
												placeholder="Enter customer cost price" min="0.01" autofocus>
											@if ($errors->has('customer_cost_prices'))
											<span class="helpBlock">
												<strong>{{ $errors->first('customer_cost_prices') }}</strong>
											</span>
											@endif
										</div>
									</div>
									<!-- <div class="col-lg-4 form-group m-form__group "
										style="padding-right: 5px;">
										<label for="staff_prices">Staff price</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">RM</span>
											</div>
											<input type="text" class="form-control m-input staff_prices{{$key}} required" id="staff_prices-{{$key}}"
												name="staff_prices[{{$key}}]"
												placeholder="Enter staff price" min="0.01" autofocus>
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
										<input type="text" class="form-control m-input ex_prices{{$key}} required" id="ex_prices-{{$key}}"
											name="ex_prices[{{$key}}]"
											placeholder="Enter executive price" min="0.01" autofocus>
										@if ($errors->has('ex_prices'))
										<span class="helpBlock">
											<strong>{{ $errors->first('ex_prices') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-lg-4 form-group m-form__group ">
									<label for="si_prices">Silver</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">RM</span>
										</div>
										<input type="text" class="form-control m-input si_prices{{$key}} required" id="si_prices-{{$key}}"
											name="si_prices[{{$key}}]"
											placeholder="Enter silver price" min="0.01" autofocus>
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
										<input type="text" class="form-control m-input go_prices{{$key}} required" id="go_prices-{{$key}}"
											name="go_prices[{{$key}}]"
											placeholder="Enter gold price" min="0.01" autofocus>
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
										<input type="text" class="form-control m-input pl_prices{{$key}} required" id="pl_prices-{{$key}}"
											name="pl_prices[{{$key}}]"
											placeholder="Enter platinum price" min="0.01" autofocus>
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
											<input type="text" class="form-control m-input di_prices required" id="di_prices-{{$key}}"
												name="di_prices[{{$key}}]"
												placeholder="Enter diamond price" min="0.01" autofocus>
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
										<input type="number" class="form-control m-input qtys{{$key}} required" id="qtys-{{$key}}"
												name="qtys[{{$key}}]" placeholder="Enter quantity" min="1" autofocus>
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
										<select class="form-control m_selectpicker statuses{{$key}} required" name="statuses[{{$key}}]" id="statuses-{{$key}}">
											<option value="active">Active</option>
											<option value="inactive">Inactive</option>
										</select>
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
										<input type="text" class="form-control m-input executive_pv_points{{$key}} required"
											id="executive_pv_points-{{$key}}" name="executive_pv_points[{{$key}}]" placeholder="Enter executive pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
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
										<input type="text" class="form-control m-input silver_pv_points{{$key}} required"
											id="silver_pv_points-{{$key}}" name="silver_pv_points[{{$key}}]" placeholder="Enter silver pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
										@if ($errors->has('silver_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('silver_pv_points') }}</strong>
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
										<input type="text" class="form-control m-input golden_pv_points{{$key}}{{$key}} required"
											id="golden_pv_points-{{$key}}" name="golden_pv_points[{{$key}}]" placeholder="Enter gold pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
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
										<input type="text" class="form-control m-input platinum_pv_points{{$key}} required"
											id="platinum_pv_points-{{$key}}" name="platinum_pv_points[{{$key}}]" placeholder="Enter platinum pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
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
										<input type="text" class="form-control m-input diamond_pv_points{{$key}} required"
											id="diamond_pv_points-{{$key}}" name="diamond_pv_points[{{$key}}]" placeholder="Enter diamond pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
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
										<input type="text" class="form-control m-input staff_pv_points{{$key}} required"
											id="staff_pv_points-{{$key}}" name="staff_pv_points[{{$key}}]" placeholder="Enter staff pv points" autofocus
											pattern="(^100(\.0{1,2})?$)|(^([1-9]([0-9])?|0)(\.[0-9]{1,2})?$)">
										@if ($errors->has('staff_pv_points'))
										<span class="helpBlock">
											<strong>{{ $errors->first('staff_pv_points') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div> -->
							
							@if($key != 0)
								<div class="col-lg-12 m--align-right">
									<a class="btn btn-primary  font12 copy{{$key}} copyButton" id="copy-{{$key}}" name="copyButton"  style="color: white">
										<span>
											<span>Copy from above</span>&nbsp;&nbsp;
										</span>
									</a>
								</div>
							@endif
						</td>
					</tr>
					@endforeach
				</tr>
			</thead>
		</table>
	</div>
</div>
