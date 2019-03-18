
<div class="row" id="org_create">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <h2>@lang('general.add-organization-information')</h2>
            </div>
            <div class="card-body">
                <div class="basic-form">
                	<!-- form old seller start -->
					<form id="org_info">
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.organize-name')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.organize-name')" name="org_name">
							    </div>
                    		</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.business-title')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.business-title')" name="business_title">
                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.head-office-address')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.head-office-address')" name="office_address">
                                </div>
                            </div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.field-office-address')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.field-office-address')" name="store_address">
							    </div>
                    		</div>
                    	</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.telephone-number')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.telephone-number')" name="phone_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.mobile-number1')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.mobile-number1')" name="mobile_no1">
                                </div>
                            </div>
                        </div>
                    	<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.mobile-number2')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.mobile-number2')" name="mobile_no2">
                                </div>
                            </div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.email-address')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.email-address')" name="email">
							    </div>
                    		</div>
                    	</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.logo')</p>
                                    <input type="file" class="form-control input-default " placeholder="@lang('form.logo')" name="logo">
                                </div>
                            </div>
                        </div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="submit" class="btn btn-lg btn-success" value="@lang('button.submit')" id="old_customer_submit">
							    </div>
                    		</div>
                    	</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>