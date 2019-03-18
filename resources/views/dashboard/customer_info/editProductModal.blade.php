<div class="modal fade" id="productEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.product-add')</h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="GET" id="product-customer-edit">
					{{ csrf_field() }}
					@section('editmethod')
					@show
                    <div class="hidden">
                        <input type="text" name="id" id="id" value="@yield('id')">
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
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.category-name')</p>
                                    <select class="form-control input-default article_no" name="article_no" id="article_no">
                                        <option value="">@lang('form.choose')</option>
                                        @foreach($category as $data)
                                           <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="article_no_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.product-name')</p>
                                    <select class="form-control input-default color_id" name="color_id" id="color_id">
                                        <option value="">@lang('form.choose')</option>
                                    </select>
                                    <span class="text-danger" id="color_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">@lang('form.quantity')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.quantity')" name="qty" id="qty">
                                    <span class="text-danger" id="qty_error"></span>
                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.product-rate')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.product-rate')" name="p_rate" id="p_rate">
                                    <span class="text-danger" id="p_rate_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.total-amount')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.total-amount')" name="total_amount" value="" id="total_amount" disabled="true">
							    </div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.date')</p>
                                    <input type="text" class="form-control input-default date" placeholder="@lang('form.date')" name="date" id="datepicker">
                                    <span class="text-danger" id="date_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="editCustomerProductSubmit" class="btn btn-success btn-prime white btn-lg">{{__('button.add')}}</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">{{__('button.close')}}</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>

