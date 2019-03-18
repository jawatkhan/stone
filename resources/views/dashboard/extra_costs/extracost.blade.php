@extends('layouts.app')
@section('page_title')
	@can('create-data')
	<button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#extraCostAdd" style="background:#11c75a;">
	  @lang('button.add-extra-cost')
	</button>
	@endcan
@endsection
@section('content')

               <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
<div class="row" id="product_table_part">
    <div class="col-md-12">
        <div class="card">
        	<div class="card-title">
                <h1 id="product_title">@lang('general.owner-extra-cost-list')</h1>
            </div>
            <div class="bootstrap-data-table-panel">
                <div class="">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.sl-no')</th>
                                <th>@lang('table.description')</th>
                                <th>@lang('table.date')</th>
                                <th>@lang('table.amount')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($extraCost as $data)
                        	<tr>
                        		<td>{{bfn($loop->iteration)}}</td>
                        		<td>{{$data->descriptions}}</td>
                        		<td>{{bfn(date('d-m-Y',strtotime($data->date)))}}</td>
                        		<td>{{bfn(number_format($data->amount,2))}}</td>
                        		<td>
                        			@can('update-data')
                        			<input type="button" id="editExtraCost" data-toggle="modal" data-target="#extraCostEdit" data-id="{{$data->id}}" class="btn btn-lg btn-info" value="@lang('button.edit')">
                        			@endcan
                        			
                        			@can('delete-data')
                        			| <input  onclick="deleteExtraCost({{ $data->id }})" id="cost-dell" type="button"  class="btn btn-lg  btn-danger btn-prime white btn-flat" value="@lang('button.delete')">
                        			@endcan
                        		</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                    </table>

                    {{ $extraCost->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.extra_costs.addExtraCostModal')
@include('dashboard.extra_costs.editExtraCostModal')
@endsection

@section('script')
<script type="text/javascript">
	$('body').on('click', '#extraCostSubmit', function(){
        var addExtraCostForm = $("#extraCost");
        var formData = addExtraCostForm.serialize();
        var tr = '';
        $( '#owner_check_error' ).html( "" );
        $( '#date_error' ).html( "" );
        $( '#description_error' ).html( "" );
        $( '#extra_cost_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/extra-cost-add')!!}',
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
                    if(data.errors.date){
                        $( '#date_error' ).html('The Date field is required.');
                    }
                    if(data.errors.extra_cost){
                        $( '#extra_cost_error' ).html('The Extra Cost field is required and must be numeric.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/owner-extra-cost')!!}';
                }
            },
        });
    });

	 // --------- Update Extra Cost-----------------------
        $('body').delegate('#editExtraCost','click',function(e){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/extra-cost-edit')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    // console.log(data.amount);
                    $('#editextraCost').find('#id').val(data.id);
                    $('#editextraCost').find('.date').val(data.created_at);
                    $('#editextraCost').find('#description').val(data.descriptions);
                    $('#editextraCost').find('#extra_cost').val(data.amount);
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
        var addExtraCostForm = $("#editextraCost");
        var formData = addExtraCostForm.serialize();
        var tr = '';
        $( '#owner_check_error' ).html( "" );
        $( '#date_error' ).html( "" );
        $( '#description_error' ).html( "" );
        $( '#extra_cost_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/extra-cost-update')!!}',
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
                    if(data.errors.date){
                        $( '#date_error' ).html('The Date field is required.');
                    }
                    if(data.errors.extra_cost){
                        $( '#extra_cost_error' ).html('The Extra Cost field is required and must be numeric.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/owner-extra-cost')!!}';
                }
            },
        });
    });
    // ------------ delete----------------
    function deleteExtraCost(Id){
        //Confirm message
        bootbox.confirm({
            title: "Confirmation",
            message: "This <b>Extra Cost</b> will delete permanently! Are you sure?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-success'
                }
            },
            callback: function(result) {
               if(result == true){
                    window.location.href="{{ url('/extra-cost-delete') }}"+'/'+Id;
               }
            }
        }); 
    }
</script>
@endsection