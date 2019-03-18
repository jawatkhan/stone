<div class="modal fade" id="editOrg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.organization-information-update')</code></h3>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;font-size: 24px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="{{URL::to('/update-organization')}}" method="post" id="editOrg_form" enctype="multipart/form-data">
					{{ csrf_field() }}
					@section('editmethod')
					@show
					<div class="hidden">
						<input type="text" name="id" id="id" value="">
					</div>
				    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.organize-name')</p>
							        <input type="text" class="form-control input-default " placeholder="" name="org_name" id="org_name">
							    </div>
                    		</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.business-title')</p>
                                    <input type="text" class="form-control input-default " placeholder="" name="business_title" id="business_title">
                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.head-office-address')</p>
                                    <input type="text" class="form-control input-default " placeholder="" name="office_address" id="office_address">
                                </div>
                            </div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.field-office-address')</p>
							        <input type="text" class="form-control input-default " placeholder="" name="store_address" id="store_address">
							    </div>
                    		</div>
                    	</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.telephone-number')</p>
                                    <input type="text" class="form-control input-default " placeholder="" name="phone_no" id="phone_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.mobile-number1')</p>
                                    <input type="text" class="form-control input-default " placeholder="" name="mobile_no1" id="mobile_no1">
                                </div>
                            </div>
                        </div>
                    	<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.mobile-number2')</p>
                                    <input type="text" class="form-control input-default " placeholder="" name="mobile_no2" id="mobile_no2">
                                </div>
                            </div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.email-address')</p>
							        <input type="text" class="form-control input-default " placeholder="" name="email" id="email">
							    </div>
                    		</div>
                    	</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.logo')</p>
                                    <input type="file" class="form-control input-default " placeholder="Logo" name="logo">
                                </div>
                            </div>
                        </div>

					<div class="row modal-footer">
						<button type="submit" id="orgupdate" class="btn btn-success btn-prime white btn-lg">@lang('button.save')</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">@lang('button.close')</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>

