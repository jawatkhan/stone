@extends('layouts.app')
@section('page_title',__('general.client-wise-report'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
            </div>
            <div class="card-body">
                <div class="basic-form">
					<!-- new customer start -->
                    <form id="invoice_recive" method="POST" action="{{URL::to('/get-client-wise-report')}}">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.select-client-type')</p>
                                    <label class="radio-inline">
                                      <input type="radio" name="owner_id" id="checkOwner1" value="Customer">@lang('form.customer')
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="owner_id" id="checkOwner2" value="Seller">@lang('form.buyer')
                                    </label><br>
                                    <span class="text-danger" id="owner_check_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.organization-name')</p>
                                    <select class="form-control input-default" name="customer_name" id="customer_name">
                                        <option value="" selected="true" disabled="true">@lang('form.org-name')</option>
                                    </select>
                                    <span class="text-danger" id="customer_name_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="Submit" class="btn btn-lg btn-success" value="@lang('button.submit')" id="invoice_submit">
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
                op = '<option value="" selected="true" disabled="true">@lang('form.organization-name')</option>';
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
                op = '<option value="" selected="true" disabled="true">@lang('form.organization-name')</option>';
				for(var i=0;i<data.length;i++){
		          op+='<option value="'+data[i].id+'">'+data[i].org_name+'<span class="text-success"> // </span>'+data[i].address+'</option>';
		        }

		        $('#customer_name').html(" ");
		        $('#customer_name').append(op);
			}
		})
	})

</script>
@endsection