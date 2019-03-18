<div class="modal fade" id="editSellerInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.ubuyer-information')</code></h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="POST" id="sellerInfo">
					{{ csrf_field() }}
					@section('editmethod')
					@show
						<div class="row hidden">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.client-id')</p>
                                    <input type="text" name="client_id" class="form-control input-default" id="client_id" value="">
                                </div>
                            </div>
                        </div>

				    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.buyer-name')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.buyer-name')" name="new_org_name" id="new_org_name">
                                    <span class="text-danger" id="new_org_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.buyer-email')</p>
							        <input type="email" class="form-control input-default " placeholder="@lang('form.buyer-email')" name="seller_email" id="seller_email">
                                    <span class="text-danger" id="seller_email_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.buyer-address')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.buyer-address')" name="seller_address" id="seller_address">
                                    <span class="text-danger" id="seller_address_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.buyer-phone')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.buyer-phone')" name="seller_contact_no" id="seller_contact_no">
                                    <span class="text-danger" id="seller_contact_no_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="selllerInfoSubmit" class="btn btn-success btn-prime white btn-lg">{{__('button.save')}}</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">{{__('button.close')}}</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>


