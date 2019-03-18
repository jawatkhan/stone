@extends('layouts.app')
@section('page_title',__('general.sales-order'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <input type="button" class="btn btn-lg btn-default" value="@lang('button.new-customer')" style="background:#11c75a;margin-bottom: 10px;" id="new_customer_btn">
                <input type="button" class="btn btn-lg btn-default" value="@lang('button.old-customer')" style="background:#11c75a;margin-bottom: 10px;" id="old_customer_btn">
            </div>
            <div class="card-body">
                <div class="basic-form">
                	<!-- form old seller start -->
					<form id="old_customer_info" method="POST" action="">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.customer-name')</p>
							        <select class="form-control input-default" name="old_customer" id="old_customer">
							        	<option value="" selected="true" disabled="true">@lang('form.org-name')</option>
							        	@foreach($customers as $id=>$customer)
                                            <option value="{{$id}}">{{$customer}}</option>
                                        @endforeach
							        </select>
                                    <span class="text-danger" id="old_customer_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="Submit" id="old_customer_submit">
							    </div>
                    		</div>
                    	</div>
					</form>
					<!-- end old customer -->
					<!-- new customer start -->
                    <form id="new_customer_info" method="POST" action="">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.customer-name')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.customer-name')" name="customer_org_name" id="customer_org_name">
                                    <span class="text-danger" id="customer_org_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.customer-email')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.customer-email')" name="customer_email" id="customer_email">
                                    <span class="text-danger" id="customer_email_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.customer-address')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.customer-address')" name="customer_address" id="customer_address">
                                    <span class="text-danger" id="customer_address_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.customer-phone')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.customer-phone')" name="customer_contact_no" id="customer_contact_no">
                                    <span class="text-danger" id="customer_contact_no_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="{{__('button.submit')}}" id="new_customer_submit">
							    </div>
                    		</div>
                    	</div>
					</form>
					<!-- end new customer -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#old_customer_btn").hide();
		$("#new_customer_info").hide();
		$("#new_customer_btn").click(function(){
			$(this).hide();
			$("#old_customer_info").hide();
			$("#old_customer_btn").show();
			$("#new_customer_info").show();
		})
		$("#old_customer_btn").click(function(){
			$(this).hide();
			$("#new_customer_info").hide();
			$("#new_customer_btn").show();
			$("#old_customer_info").show();
		})
	})

    $('body').on('click', '#new_customer_submit', function(){
        var addNewCustomerForm = $("#new_customer_info");
        var formData = addNewCustomerForm.serialize();
        $( '#customer_org_name_error' ).html( "" );
        $( '#customer_email_error' ).html( "" );
        $( '#customer_address_error' ).html( "" );
        $( '#customer_contact_no_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/customer/info-store')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.customer_org_name){
                        $( '#customer_org_name_error' ).html( 'The Organization field is required.' );
                    }
                    if(data.errors.customer_email){
                        $( '#customer_email_error' ).html('The Customer email must be a valid email address.');
                    }                  
                    if(data.errors.customer_address){
                        $( '#customer_address_error' ).html('The Address field is required.');
                    }
                    if(data.errors.customer_contact_no){
                        $( '#customer_contact_no_error' ).html('The phone/mobile no field is required and size 11 digit.');
                    }
                }
                if(data.success) {
                    var alert = bootbox.alert({ 
                        title: "<h3>Success</h3>",
                        message: "<b>New Customer add successfully.</b>",
                        backdrop: true                    
                    })

                    setInterval(function(){
                        alert.modal('hide');
                        window.location ='{!!URL::to('/customer-product-add')!!}'+'/'+ data.client_id+'/'+data.id;
                    }, 3000);
                }
            },
        });
    });

    $('body').on('click', '#old_customer_submit', function(){
        var addCustomerForm = $("#old_customer_info");
        var formData = addCustomerForm.serialize();
        $( '#old_customer_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/customer/invoice-store')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.old_customer){
                        $( '#old_customer_error' ).html( 'The Customer field is required.' );
                    }
                }
                if(data.success) {
                        window.location ='{!!URL::to('/customer-product-add')!!}'+'/'+ data.client_id+'/'+data.id;
                }
            },
        });
    });
</script>
@endsection