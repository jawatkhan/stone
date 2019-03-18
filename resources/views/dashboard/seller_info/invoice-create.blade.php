@extends('layouts.app')
@section('page_title',__('general.purchase-order'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <h2 id="product_title">@lang('general.new-invoice-add-form')</h2>
            </div>
            <div class="card-body">
                <div class="basic-form">
                	<!-- form old seller start -->
					<form id="invoce-create-form" method="POST" action="">
                        {{ csrf_field() }}
                       	<div class="hidden">
							<input type="text" name="client_id" id="client_id" value="{{$client_id}}">
						</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.invoice-number')</p>
							        <input type="text" name="invoice_no" id="invoice_no" class="form-control input-default">
                                    <span class="text-danger" id="invoice_no_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="button" class="btn btn-lg btn-success" value="{{__('button.submit')}}" id="invoice-submit">
							    </div>
                    		</div>
                    	</div>
					</form>
					<!-- end old seller -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">

    $('body').on('click', '#invoice-submit', function(){
        var addNewInvoiceForm = $("#invoce-create-form");
        var formData = addNewInvoiceForm.serialize();
        $( '#invoice_no_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/seller/invoice-store')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.invoice_no){
                        $( '#invoice_no_error' ).html( 'The Invoice field is required.' );
                    }
                }
                if(data.success) {
                        window.location ='{!!URL::to('/seller-product-add')!!}'+'/'+ data.client_id+'/'+data.id;
                }
            },
        });
    });
</script>
@endsection