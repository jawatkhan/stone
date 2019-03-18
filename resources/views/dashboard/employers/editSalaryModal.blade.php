<div class="modal fade" id="salaryEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.update-employer-salary-payment')</h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="GET" id="edit_salary">
					{{ csrf_field() }}
					@section('editmethod')
					@show
					<div class="hidden">
						<input type="text" name="id" id="id" value="">
					</div>
                        <div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.employer-name')</p>
							        <select class="form-control input-default date" name="employer_name" id="employer_name">
							        	<option value="" selected="true" disabled="true">@lang('form.select-employer')</option>
							        	<?php foreach ($employer as $data): ?>
							        		<option value="{{$data->id}}">{{$data->name}}</option>
							        	<?php endforeach ?>
							        </select>
                                    <span class="text-danger" id="employer_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.employer-present-salary')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.employer-present-salary')" name="present_salary" id="present_salary">
                                    <span class="text-danger" id="present_salary_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.salary-payment-date')</p>
							        <input type="text" class="form-control input-default payment_date" name="payment_date" id="datepicker" value="{{date('Y-m-d')}}">
                                    <span class="text-danger" id="payment_date_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="updateSalarySubmit" class="btn btn-success btn-prime white btn-lg">@lang('button.update')</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">@lang('button.close')</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>


