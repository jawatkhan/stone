@extends('layouts.app')
@section('page_title',__('general.purchase-order'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <input type="button" class="btn btn-lg btn-default" value="@lang('button.new-buyer')" style="background:#11c75a;margin-bottom: 10px;" id="new_seller_btn">
                <input type="button" class="btn btn-lg btn-default" value="@lang('button.old-buyer')" style="background:#11c75a;margin-bottom: 10px;" id="old_seller_btn">
            </div>
            <div class="card-body">
                <div class="basic-form">
                	<!-- form old seller start -->
					<form id="old_seller_info" method="GET" action="">
                        {{ csrf_field() }}
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.buyer-name')</p>
							        <select class="form-control input-default" id="old_org_name" name="old_org_name" required>
							        	<option value="" selected="true" disabled="true">@lang('form.org-name')</option>
                                        @foreach($sellers as $id=>$sellers)
							        	    <option value="{{$id}}">{{$sellers}}</option>
                                        @endforeach
							        </select>
                                    <span class="text-danger" id="old_org_name_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="{{__('button.submit')}}" id="old_seller_submit">
							    </div>
                    		</div>
                    	</div>
					</form>
					<!-- end old seller -->
					<!-- new seller start -->
                    <form id="new_seller_info" method="POST" action="">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
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
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="{{__('button.submit')}}" id="new_seller_submit">
							    </div>
                    		</div>
                    	</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$("#old_seller_btn").hide();
		$("#new_seller_info").hide();
		$("#new_seller_btn").click(function(){
			$(this).hide();
			$("#old_seller_info").hide();
			$("#old_seller_btn").show();
			$("#new_seller_info").show();
		})
		$("#old_seller_btn").click(function(){
			$(this).hide();
			$("#new_seller_info").hide();
			$("#new_seller_btn").show();
			$("#old_seller_info").show();
		})
	})

    $('body').on('click', '#new_seller_submit', function(){
        console.log('ok');
        var addNewSellerForm = $("#new_seller_info");
        var formData = addNewSellerForm.serialize();
        $( '#new_org_name_error' ).html( "" );
        $( '#seller_email_error' ).html( "" );
        $( '#seller_address_error' ).html( "" );
        $( '#seller_contact_no_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/seller/info-store')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.new_org_name){
                        $( '#new_org_name_error' ).html( 'The Organization field is required.' );
                    }
                    if(data.errors.seller_email){
                        $( '#seller_email_error' ).html('The seller email must be a valid email address.');
                    }                  
                    if(data.errors.seller_address){
                        $( '#seller_address_error' ).html('The Address field is required.');
                    }
                    if(data.errors.seller_contact_no){
                        $( '#seller_contact_no_error' ).html('The phone/mobile no field is required and max size 11 digit.');
                    }
                }
                if(data.success) {
                    var alert = bootbox.alert({ 
                        title: "<h3>Success</h3>",
                        message: "<b>New Seller add successfully.</b>",
                        backdrop: true                    
                    })

                    setInterval(function(){
                        alert.modal('hide');
                        window.location ='{!!URL::to('/seller-invoice-add')!!}'+'/'+ data.userid;
                    }, 3000);
                }
            },
        });
    });

    $('#old_seller_submit').on('click',function(){
        var divid = $('#old_org_name').val();
        console.log(divid);
        window.location ='{!!URL::to('/seller-invoice-add')!!}'+'/'+ divid;
    })
</script>
@endsection