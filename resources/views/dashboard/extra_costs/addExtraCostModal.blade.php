<div class="modal fade" id="extraCostAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.extra-cost')</h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="GET" id="extraCost">
					{{ csrf_field() }}
					@section('editmethod')
					@show

				    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.owner-select')</p>
							        <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner1" value="1" checked>@lang('form.own')
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner2" value="2" disabled="true">@lang('form.buyer')
								    </label><br>
                                    <span class="text-danger" id="owner_check_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.date')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.date')" name="date" id="datepicker" value="{{date('Y-m-d')}}">
                                    <span class="text-danger" id="date_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.description')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.description')" name="description" id="description">
                                    <span class="text-danger" id="description_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.extra-cost')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.extra-cost')" name="extra_cost" id="extra_cost">
                                    <span class="text-danger" id="extra_cost_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="extraCostSubmit" class="btn btn-success btn-prime white btn-lg">{{__('button.save')}}</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">{{__('button.close')}}</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>


