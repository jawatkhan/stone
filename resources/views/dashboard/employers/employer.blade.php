@extends('layouts.app')
@section('page_title')
	@can('create-data')
	<button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#addEmployer" style="background:#11c75a;">
	  @lang('button.add-employer')
	</button>
	@endcan
@endsection
@section('content')
<div class="row" id="product_table_part">
    <div class="col-md-12">
        <div class="card">
        	<div class="card-title">
                <h1 id="product_title">@lang('general.employer-list')</h1>
            </div>
            <div class="bootstrap-data-table-panel">
                <div class="">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.sl-no')</th>
                                <th>@lang('table.name')</th>
                                <th>@lang('table.fathers-name')</th>
                                <th>@lang('table.address')</th>
                                <th>@lang('table.contact-no')</th>
                                <th>@lang('table.designation')</th>
                                <th>@lang('table.present-salary-month')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($employer as $data)
                        	<tr>
                        		<td>{{$loop->iteration}}</td>
                        		<td>{{$data->name}}</td>
                        		<td>{{$data->father_name}}</td>
                        		<td>{{$data->address}}</td>
                        		<td>{{$data->contact_no}}</td>
                        		<td>{{$data->designation}}</td>
                        		<td>{{number_format($data->monthly_salary,2)}}</td>
                        		<td>
                        			@can('update-data')
                        			<input type="button" id="editEmployer" data-toggle="modal" data-target="#employerEdit" data-id="{{$data->id}}" class="btn btn-lg btn-info" value="@lang('button.edit')">
                        			@endcan
                        			
                        			@can('delete-data')
                        			| <input  onclick="deleteEmployer({{ $data->id }})" id="employer-dell" type="button" class="btn btn-sm  btn-danger btn-prime white btn-lg" value="@lang('button.delete')">
                        			@endcan
                        		</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                    </table>

                    {{ $employer->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.employers.employerModal')
@include('dashboard.employers.editEmployerModal')
@endsection

@section('script')
<script type="text/javascript">
	$('body').on('click', '#employerSubmit', function(){
        var addExtraCostForm = $("#employer_Add");
        var formData = addExtraCostForm.serialize();
        $( '#employer_name_error' ).html( "" );
        $( '#faher_name_error' ).html( "" );
        $( '#address_error' ).html( "" );
        $( '#contact_no_error' ).html( "" );
        $( '#designation_error' ).html( "" );
        $( '#present_salary_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/employer-add')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.employer_name){
                        $( '#employer_name_error' ).html('The Employer Name field is required.');
                    }                
                    if(data.errors.faher_name){
                        $( '#faher_name_error' ).html('The Father Name field is required.');
                    }
                    if(data.errors.address){
                        $( '#address_error' ).html('The Address field is required.');
                    }
                    if(data.errors.contact_no){
                        $( '#contact_no_error' ).html('The Contact No field is required and must be numeric.');
                    }
                    if(data.errors.designation){
                        $( '#designation_error' ).html('The Designation field is required.');
                    }
                    if(data.errors.present_salary){
                        $( '#present_salary_error' ).html('The Salary field is required.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/employer-list')!!}';
                }
            },
        });
    });

	 // --------- Update Extra Cost-----------------------
    $('body').delegate('#editEmployer','click',function(e){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/employer-edit')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    // console.log(data.amount);
                    $('#edit_employer').find('#id').val(data.id);
                    $('#edit_employer').find('#employer_name').val(data.name);
                    $('#edit_employer').find('#father_name').val(data.father_name);
                    $('#edit_employer').find('#address').val(data.address);
                    $('#edit_employer').find('#contact_no').val(data.contact_no);
                    $('#edit_employer').find('#designation').val(data.designation);
                    $('#edit_employer').find('#present_salary').val(data.monthly_salary);
                },
                error:function(){

                }
            });
        })


    $('body').on('click', '#updateEmployerSubmit', function(){
        var addExtraCostForm = $("#edit_employer");
        var formData = addExtraCostForm.serialize();
        $( '#employer_name_error' ).html( "" );
        $( '#faher_name_error' ).html( "" );
        $( '#address_error' ).html( "" );
        $( '#contact_no_error' ).html( "" );
        $( '#designation_error' ).html( "" );
        $( '#present_salary_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/employer-update')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.employer_name){
                        $( '#employer_name_error' ).html('The Employer Name field is required.');
                    }                
                    if(data.errors.faher_name){
                        $( '#faher_name_error' ).html('The Father Name field is required.');
                    }
                    if(data.errors.address){
                        $( '#address_error' ).html('The Address field is required.');
                    }
                    if(data.errors.contact_no){
                        $( '#contact_no_error' ).html('The Contact No field is required and must be numeric.');
                    }
                    if(data.errors.designation){
                        $( '#designation_error' ).html('The Designation field is required.');
                    }
                    if(data.errors.present_salary){
                        $( '#present_salary_error' ).html('The Salary field is required.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/employer-list')!!}';
                }
            },
        });
    });
    // ------------ delete----------------
    

    function deleteEmployer(Id){
		//Confirm message
		bootbox.confirm({
			title: "Confirmation",
			message: "This <b>Employer Information</b> will delete permanently! Are you sure?",
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
					window.location.href="{{ url('/employer-delete') }}"+'/'+Id;
			   }
			}
		}); 
	}
</script>
@endsection