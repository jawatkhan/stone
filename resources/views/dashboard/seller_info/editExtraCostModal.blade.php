<div class="modal fade" id="extraCostEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.extra-cost') <code>(@lang('general.if-any'))</code></h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="GET" id="editextraCost">
					{{ csrf_field() }}
					@section('editmethod')
					@show
					<div class="hidden">
						<input type="text" name="id" id="id" value="">
					</div>
						<div class="row hidden">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.client-id')</p>
                                    <input type="text" name="client_id" class="form-control input-default" id="client_id" value="{{$client_id}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.invoice-id')</p>
                                    <input type="text" class="form-control input-default" name="invoice_id" id="invoice_id" value="{{$invoice_id}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.owner-select')</p>
							        <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner1" value="1">@lang('form.own')
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner2" value="2">@lang('form.buyer')
								    </label><br>
                                    <span class="text-danger" id="owner_check_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.description')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.description')" name="description" id="description">
                                    <span class="text-danger" id="description_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.extra-cost')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.extra-cost')" name="extra_cost" id="extra_cost">
                                    <span class="text-danger" id="extra_cost_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="updateExtraCostSubmit" class="btn btn-success btn-prime white btn-lg">{{__('button.save')}}</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">{{__('button.close')}}</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>


