<div class="modal fade" id="productAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">@lang('general.product-add')</h3>
				<button type="button" class="close btn-lg" data-dismiss="modal" aria-hidden="true" style="padding-top: 8px;">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="post" id="product-Add">
					{{ csrf_field() }}
					@section('editmethod')
					@show
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
                                    <input type="text" class="form-control input-default " placeholder="@lang('form.date')" name="date" id="datepicker" value="{{date('Y-m-d')}}">
                                    <span class="text-danger" id="date_error"></span>
							    </div>
                    		</div>
                    	</div>

					<div class="row modal-footer">
						<button type="button" id="addProductForm" class="btn btn-success btn-prime white btn-lg">{{__('button.add')}}</button>
						<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" style="float: left;">{{__('button.close')}}</button>
					</div>					
				</form>
			</div>
		</div>
	</div>
</div>
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
 
    String.prototype.getDigitBanglaFromEnglish = function() {
        var retStr = this;
        for (var x in finalEnlishToBanglaNumber) {
             retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
        }
        return retStr;
    };

    var finalBanglaToEnglish={'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};
 
    String.prototype.getBanglaToEnglish = function() {
        var retStr = this;
        for (var x in finalBanglaToEnglish) {
             retStr = retStr.replace(new RegExp(x, 'g'), finalBanglaToEnglish[x]);
        }
        return retStr;
    };

    $('#recive_amount').hide();
    $('#recive_amount_btn').click(function(){
        $('#recive_amount').toggle(300);
    })

    $("#p_rate,#qty").keyup(function(){
        var qty = $("#qty").val().getBanglaToEnglish();
        var rate = $("#p_rate").val().getBanglaToEnglish();
        $("#total_amount").val((rate*qty).toFixed().getDigitBanglaFromEnglish());
    })
// -----------combo select------------
$('body').on('change','.article_no',function(){
        var id = $(this).val();
        console.log(id);
        var op = '';
        $.ajax({
            type: 'GET',
            url: '{!!URL::to('/category-change')!!}',
            data:{id:id},
            success:function(data) {
                  op = '<option value="">@lang('form.choose')</option>';
                for(i=0; i<data.length; i++ ){
                  op += '<option value="'+ data[i].id +'">'+ data[i].category_name +'</option>';
                }
                $('.color_id').html('');
                $('.color_id').append(op);

            }
        });
    }) 
// ------------add Product-----------
	$('body').on('click', '#addProductForm', function(){
        var addNewProductForm = $("#product-Add");
        var formData = addNewProductForm.serialize();
        var ids = $("#color_id").val();
        var tr = '';
        console.log(ids);
        $( '#article_no_error' ).html( "" );
        $( '#color_error' ).html( "" );
        $( '#qty_error' ).html( "" );
        $( '#p_rate_error' ).html( "" );
        $( '#date_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-product-add-temp')!!}',
            data:formData,
            success:function(data) {
                
               // console.log(data);
                
                if(data.errors) {                  
                    if(data.errors.article_no){
                        $( '#article_no_error' ).html('The Article no field is required.');
                    }
                    if(data.errors.color_id){
                        $( '#color_error' ).html('The color field is required.');
                    }
                    if(data.errors.qty){
                        $( '#qty_error' ).html('The Quantity field is required and must be numeric.');
                    }
                    if(data.errors.p_rate){
                        $( '#p_rate_error' ).html('The Product Rate field is required.');
                    }
                    if(data.errors.date){
                        $( '#date_error' ).html('The date no field is required.');
                    }
                }

                if(data.success){
                var val = data.prodArry;
                var grandProduct = 0;
                for(var i=0;i<val.length;i++){

                    tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+'" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandProduct += val[i].amount;
                }

                var valcost = data.costArry;
                var grandExtra = 0;
                for(var i=0;i<valcost.length;i++){
                    var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                    tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandExtra += valcost[i].amount;
                }

                    
                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                    $('.filter-option').html("Select colors");
                    $('li').removeClass('selected');
                    $('a').attr('aria-selected','false');
                    $('#product-Add')[0].reset();
                }
            },
        });
    });
// ------------ add extra cost--------------------------
    $('body').on('click', '#extraCostSubmit', function(){
        var addExtraCostForm = $("#extraCost");
        var formData = addExtraCostForm.serialize();
        var tr = '';
        $( '#owner_check_error' ).html( "" );
        $( '#description_error' ).html( "" );
        $( '#extra_cost_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-extra-cost-add')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.owner_id){
                        $( '#owner_check_error' ).html('The owner field is required.');
                    }                
                    if(data.errors.description){
                        $( '#description_error' ).html('The Description field is required.');
                    }
                    if(data.errors.extra_cost){
                        $( '#extra_cost_error' ).html('The Extra Cost field is required and must be numeric.');
                    }
                }

                if(data.success){

                var val = data.prodArry;
                var grandProduct = 0;
                for(var i=0;i<val.length;i++){
                    tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+'" class="btn btn-sm  btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandProduct += val[i].amount;
                }

                var valcost = data.costArry;
                var grandExtra = 0;
                for(var i=0;i<valcost.length;i++){
                    var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                    tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm  btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandExtra += valcost[i].amount;
                }

                    $('#extraCost')[0].reset();
                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                }
            },
        });
    });

// ------------ update product------------------

    $('body').delegate('#editProduct','click',function(e){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/customer-product-edit-temp')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    console.log(data.id);
                    $('#product-customer-edit').find('#id').val(data.id);
                    $('#product-customer-edit').find('.article_no').val(data.article_no);
                    // $('#product-customer-edit').find('.filter-option').html(data.color_id);
                    $('#product-customer-edit').find('.color_id').val(data.color_id);
                    $('#product-customer-edit').find('#qty').val((data.qty).toFixed().getDigitBanglaFromEnglish());
                    $('#product-customer-edit').find('#p_rate').val((data.rate).toFixed().getDigitBanglaFromEnglish());
                    $('#product-customer-edit').find('#total_amount').val((data.amount).toFixed().getDigitBanglaFromEnglish());
                    $('#product-customer-edit').find('.date').val(data.date);
                },
                error:function(){

                }
            });
        })

    $('body').on('click', '#editCustomerProductSubmit', function(){
        var UpdateProductForm = $("#product-customer-edit");
        var formData = UpdateProductForm.serialize();
        console.log(formData);
        var tr = '';
        $( '#article_no_error' ).html( "" );
        $( '#color_error' ).html( "" );
        $( '#qty_error' ).html( "" );
        $( '#p_rate_error' ).html( "" );
        $( '#date_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-product-update-temp')!!}',
            data:formData,
            success:function(data) {
                
               console.log(data);
                
                if(data.errors) {                  
                    if(data.errors.article_no){
                        $( '#article_no_error' ).html('The Article no field is required.');
                    }
                    if(data.errors.color_id){
                        $( '#color_error' ).html('The color field is required.');
                    }
                    if(data.errors.qty){
                        $( '#qty_error' ).html('The Quantity field is required and must be numeric.');
                    }
                    if(data.errors.p_rate){
                        $( '#p_rate_error' ).html('The Product Rate field is required.');
                    }
                    if(data.errors.date){
                        $( '#date_error' ).html('The date no field is required.');
                    }
                }

                if(data.success){
                var val = data.prodArry;
                var grandProduct = 0;
                for(var i=0;i<val.length;i++){
                    tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+' " class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandProduct += val[i].amount;
                }

                var valcost = data.costArry;
                var grandExtra = 0;
                for(var i=0;i<valcost.length;i++){
                    var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                    tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandExtra += valcost[i].amount;
                }

                    $('#product-customer-edit')[0].reset();
                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                    $("#productEdit .close").click();
                }
            },
        });
    });

    // -------------- delete Product-----------------
    $('body').on('click','#pro-dell',function(){
        var id = $(this).data('id');
        var invoice_id = $("#invoice_id").val();
        var client_id = $("#client_id").val();
        var tr = '';
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-product-delete')!!}',
            data:{id:id,invoice_id:invoice_id,client_id:client_id},
            dataType:'json',
            success:function(data){
                if(data.success){
                    var val = data.prodArry;
                    var grandProduct = 0;
                    for(var i=0;i<val.length;i++){
                        tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+' " class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                        grandProduct += val[i].amount;
                    }

                    var valcost = data.costArry;
                    var grandExtra = 0;
                    for(var i=0;i<valcost.length;i++){
                        var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                        tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                        grandExtra += valcost[i].amount;
                    }

                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                }
            }
        })
    })

    // ------------  delete extra cost-------------

    $('body').on('click','#cost-dell',function(){
        var id = $(this).data('id');
        var invoice_id = $("#invoice_id").val();
        var client_id = $("#client_id").val();
        var tr = '';
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-extra-cost-delete')!!}',
            data:{id:id,invoice_id:invoice_id,client_id:client_id},
            dataType:'json',
            success:function(data){
                if(data.success){
                var val = data.prodArry;
                var grandProduct = 0;
                for(var i=0;i<val.length;i++){
                    tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+' " class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandProduct += val[i].amount;
                }

                var valcost = data.costArry;
                var grandExtra = 0;
                for(var i=0;i<valcost.length;i++){
                    var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                    tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandExtra += valcost[i].amount;
                }

                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                }
            }
        })
    })

    // --------- Update Extra Cost-----------------------
        $('body').delegate('#editExtraCost','click',function(e){
        var id = $(this).data('id');
        //console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/customer-extra-cost-edit')!!}',
                data:{id:id},
                success:function(data){
                    //console.log('success');
                    // console.log(data);
                    // console.log(data.amount);
                    $('#editextraCost').find('#id').val(data.id);
                    $('#editextraCost').find('#description').val(data.descriptions);
                    $('#editextraCost').find('#extra_cost').val((data.amount).toFixed().getDigitBanglaFromEnglish());
                    if(data.owner_id == 1){
                        $('#editextraCost').find('#checkOwner1').attr('checked','true');
                    }else if(data.owner_id == 2){
                        $('#editextraCost').find('#checkOwner2').attr('checked','true');
                    }
                },
                error:function(){

                }
            });
        })

    $('body').on('click', '#updateExtraCostSubmit', function(){
        var editExtraCostForm = $("#editextraCost");
        var formData = editExtraCostForm.serialize();
        var tr = '';
        $( '#owner_check_error' ).html( "" );
        $( '#description_error' ).html( "" );
        $( '#extra_cost_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-extra-cost-update')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.owner_id){
                        $( '#owner_check_error' ).html('The owner field is required.');
                    }               
                    if(data.errors.description){
                        $( '#description_error' ).html('The Description field is required.');
                    }
                    if(data.errors.extra_cost){
                        $( '#extra_cost_error' ).html('The Extra Cost field is required and must be numeric.');
                    }
                }

                if(data.success){

                var val = data.prodArry;
                var grandProduct = 0;
                for(var i=0;i<val.length;i++){
                    tr += '<tr><td>'+val[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+val[i].cat_name+'</td><td>'+val[i].category_name+'</td><td>'+val[i].qty.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].rate.toFixed().getDigitBanglaFromEnglish()+'</td><td>'+val[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editProduct" data-toggle="modal" data-target="#productEdit" data-id="'+val[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="pro-dell" type="button" data-id="'+val[i].id+'" class="btn btn-sm  btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandProduct += val[i].amount;
                }

                var valcost = data.costArry;
                var grandExtra = 0;
                for(var i=0;i<valcost.length;i++){
                    var owner = (valcost[i].owner_id==1) ? "@lang('form.own')" : "@lang('form.seller')";
                    tr += '<tr><td>'+valcost[i].invoice_no.getDigitBanglaFromEnglish()+'</td><td>'+owner+'</td><td colspan="3">'+valcost[i].descriptions+'</td><td>'+valcost[i].amount.toFixed().getDigitBanglaFromEnglish()+'</td><td><input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="'+valcost[i].id+'" class="btn btn-sm btn-info" value="Edit">|<input id="cost-dell" type="button" data-id="'+valcost[i].id+'" class="btn btn-sm  btn-danger btn-prime white btn-flat" value="Delete"></td></tr>';
                    grandExtra += valcost[i].amount;
                }

                    $('#editextraCost')[0].reset();
                    $('#p_show').html(" ");
                    $('#p_show').append(tr);
                    $('#grandTotal').html(" ");
                    $('#grandTotal').append((grandProduct+grandExtra).toFixed().getDigitBanglaFromEnglish());
                    $("#extraCostEdit .close").click();
                }
            },
        });
    });

// ---------- Final Submit Voucher----------------
    $('body').on('click','#finalVoucherSubmitCustomer',function(){
        var invoice_id = $('#invoice_id').val();
        var client_id = $('#client_id').val();
        var recive_amount = $('#recive_amount').val();
        console.log(invoice_id);
        console.log(client_id);
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-final-voucher-create')!!}',
            data:{'invoice_id':invoice_id,'client_id':client_id,'recive_amount':recive_amount},
            dataType:'json',
            success:function(data){
                console.log('success');
                console.log(data);
                if(data.success){
                    window.location = '{!!URL::to('/customer-voucher-page')!!}'+'/'+data.client_id+'/'+data.invoice_id;
                }else{
                    alert(data.message);
                }
            }
        })
    })
</script>
@endsection