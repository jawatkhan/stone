<div class="modal fade" id="employerEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.update-employer')</h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="GET" id="edit_employer">
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
							        <input type="text" class="form-control input-default date" placeholder="@lang('form.employer-name')" name="employer_name" id="employer_name" value="">
                                    <span class="text-danger" id="employer_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.fathers-name')</p>
                                    <input type="text" class="form-control input-default" placeholder="@lang('form.fathers-name')" name="father_name" id="father_name" value="">
                                    <span class="text-danger" id="father_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.employer-address')</p>
                                    <input type="text" class="form-control input-default" placeholder="@lang('form.employer-address')" name="address" id="address" value="">
                                    <span class="text-danger" id="address_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.conatct-number')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.conatct-number')" name="contact_no" id="contact_no">
                                    <span class="text-danger" id="contact_no_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.employer-designation')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.employer-designation')" name="designation" id="designation">
                                    <span class="text-danger" id="designation_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.employer-present-salary')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.employer-present-salary')" name="present_salary" id="present_salary">
                                    <span class="text-danger" id="present_salary_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="updateEmployerSubmit" class="btn btn-success btn-prime white btn-lg">@lang('button.update')</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">@lang('button.close')</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>


