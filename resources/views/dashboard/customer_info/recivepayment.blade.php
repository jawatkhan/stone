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
                    <form id="balance_recive" method="POST" action="">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                        <div class="row">
                    		<div class="col-md-6">
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
							        <p class="text-muted m-b-15 f-s-12">@lang('form.organization-name')</p>
							        <select class="form-control input-default" name="customer_name" id="customer_name">
							        	<option value="" selected="true" disabled="true">@lang('form.org-name')</option>
							        </select>
                                    <span class="text-danger" id="customer_name_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12" id="r_amount">@lang('form.recive-amount')</p>
							        <input type="text" class="form-control input-default " placeholder="@lang('form.recive-amount')" name="recive_amount" id="recive_amount">
                                    <span class="text-danger" id="recive_amount_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="{{__('button.submit')}}" id="balance_submit">
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
    $('#checkOwner2').on('click',function(){
        var repl = $('#r_amount').text().replace('Recive','Payment');
        $('#r_amount').html(repl);
    });
    $('#checkOwner1').on('click',function(){
        var repl = $('#r_amount').text().replace('Payment','Recive');
        $('#r_amount').html(repl);
    });

	$('body').on('click','#checkOwner1',function(){
		var typeid = $(this).val();
		var op = '';
		$.ajax({
			type:'GET',
			url:'{!!URL::to('/get-client-name')!!}',
			data:{'id':typeid},
			success:function(data){
				//console.log(data);
                op = '<option value="" selected="true" disabled="true">@lang('form.org-name')</option>';
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
                op = '<option value="" selected="true" disabled="true">@lang('form.org-name')</option>';
				for(var i=0;i<data.length;i++){
		          op+='<option value="'+data[i].id+'">'+data[i].org_name+'<span class="text-danger"> // </span>'+data[i].address+'</option>';
		        }

		        $('#customer_name').html(" ");
		        $('#customer_name').append(op);
			}
		})
	})

    $('body').on('change','#customer_name',function(){
        var typeid = $(this).val();
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/get-client-amount')!!}',
            data:{'id':typeid},
            success:function(data){
                //console.log(data);
                var amount = data[0].total_purchase_amount-data[0].total_deposit_amount;

                $('#recive_amount').val(amount);
            }
        })
    })

	$('body').on('click', '#balance_submit', function(){
        var addBalanceForm = $("#balance_recive");
        var formData = addBalanceForm.serialize();
        $( '#owner_check_error' ).html( "" );
        $( '#customer_name_error' ).html( "" );
        $( '#recive_amount_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/recive-payment-store')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {
                    if(data.errors.owner_id){
                        $( '#owner_check_error' ).html( 'The Type field is required.' );
                    }
                    if(data.errors.customer_name){
                        $( '#customer_name_error' ).html( 'The Org field is required.' );
                    }
                    if(data.errors.recive_amount){
                        $( '#recive_amount_error' ).html( 'The Recive Amount field is required and must be numeric.' );
                    }
                }
                if(data.success) {
                        window.location ='{!!URL::to('balance-recive')!!}';
                }
            },
        });
    });
</script>
@endsection