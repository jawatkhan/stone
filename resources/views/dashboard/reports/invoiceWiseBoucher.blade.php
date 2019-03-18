@extends('layouts.app')
@section('page_title',__('general.payment-form'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
            </div>
            <div class="card-body">
                <div class="basic-form">
					<!-- new customer start -->
                    <form id="invoice_recive" method="POST" action="">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                        <div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12"></p>
							        <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner1" value="Customer">@lang('form.customer')
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="owner_id" id="checkOwner2" value="Seller">@lang('form.buyer')
								    </label><br>
                                    <span class="text-danger" id="owner_check_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.organization-name')</p>
							        <select class="form-control input-default" name="customer_name" id="customer_name">
							        	<option value="" selected="true" disabled="true">@lang('form.select-organization-name')</option>
							        </select>
                                    <span class="text-danger" id="customer_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.invoice-number')</p>
                                    <select class="form-control input-default" name="invoice_no" id="invoice_no">
                                        <option value="" selected="true" disabled="true">@lang('form.select-invoice-number')</option>
                                    </select>
                                    <span class="text-danger" id="invoice_no_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="@lang('button.submit')" id="invoice_submit">
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

<script type="text/javascript">
	$('body').on('click','#checkOwner1',function(){
		var typeid = $(this).val();
		var op = '';
		$.ajax({
			type:'GET',
			url:'{!!URL::to('/get-client-name')!!}',
			data:{'id':typeid},
			success:function(data){
				//console.log(data);
                op = '<option value="" selected="true" disabled="true">@lang('form.select-organization-name')</option>';
				for(var i=0;i<data.length;i++){
		          op+='<option value="'+data[i].id+'">'+data[i].org_name+'<span class="text-success"> // </span>'+data[i].address+'</option>';
		        }

		        $('#customer_name').html(" ");
		        $('#customer_name').append(op);
			}
		})
	});

	$('body').on('click','#checkOwner2',function(){
		var typeid = $(this).val();
		var op = '';
		$.ajax({
			type:'GET',
			url:'{!!URL::to('/get-client-name')!!}',
			data:{'id':typeid},
			success:function(data){
                op = '<option value="" selected="true" disabled="true">@lang('form.select-organization-name')</option>';
				for(var i=0;i<data.length;i++){
		          op+='<option value="'+data[i].id+'">'+data[i].org_name+'<span class="text-success"> // </span>'+data[i].address+'</option>';
		        }

		        $('#customer_name').html(" ");
		        $('#customer_name').append(op);
			}
		})
	})

    $('body').on('change','#customer_name',function(){
        var id = $(this).val();
        //console.log(id);
        var op = '';
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/get-invoice-no')!!}',
            data:{id:id},
            success:function(data) {
                //console.log(data);
                op = '<option value="" selected="true" disabled="true">@lang('form.select-organization-name')</option>';
                for(var i=0;i<data.length;i++){
                  op+='<option value="'+data[i].id+'">'+data[i].invoice_no+'</option>';
                }

                $('#invoice_no').html(" ");
                $('#invoice_no').append(op);
            }
        })
    })
	$('body').on('click', '#invoice_submit', function(){
        var addBalanceForm = $("#invoice_recive");
        var formData = addBalanceForm.serialize();
        $( '#owner_check_error' ).html( "" );
        $( '#customer_name_error' ).html( "" );
        $( '#invoice_no_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/get-boucher')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.owner_id){
                        $( '#owner_check_error' ).html( 'The Type field is required.' );
                    }
                    if(data.errors.customer_name){
                        $( '#customer_name_error' ).html( 'The Org field is required.' );
                    }
                    if(data.errors.invoice_no){
                        $( '#invoice_no_error' ).html( 'The Invoice field is required.' );
                    }
                }
                if(data.success){
                    if(data.owner == 'Seller'){
                        window.location = '{!!URL::to('/get-boucher-seller')!!}'+'/'+data.client_id+'/'+data.invoice_id;
                    }else if(data.owner == 'Customer'){
                       window.location = '{!!URL::to('/get-boucher-customer')!!}'+'/'+data.client_id+'/'+data.invoice_id; 
                    }
                    
                }
            },
        });
    });
</script>
@endsection