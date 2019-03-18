@extends('layouts.app')
@section('page_title')
	@can('create-data')
	<button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#salaryAdd" style="background:#11c75a;">
	  @lang('button.salary-payment-form')
	</button>
	@endcan
@endsection
@section('content')
<div class="row" id="product_table_part">
    <div class="col-md-12">
        <div class="card">
        	<div class="card-title">
                <h1 id="product_title">@lang('general.employer-salary-payment-list')</h1>
            </div>
            <div class="bootstrap-data-table-panel">
                <div class="">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.sl-no')</th>
                                <th>@lang('table.name')</th>
                                <th>@lang('table.contact-no')</th>
                                <th>@lang('table.designation')</th>
                                <th>@lang('table.present-salary-month')</th>
                                <th>@lang('table.salary-payment-date')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($salary as $data)
                        	<tr>
                        		<td>{{$loop->iteration}}</td>
                        		<td>{{$data->name}}</td>
                        		<td>{{$data->contact_no}}</td>
                        		<td>{{$data->designation}}</td>
                        		<td>{{number_format($data->salary,2)}}</td>
                        		<td>{{date('d-m-Y',strtotime($data->date))}}</td>
                        		<td>
                        			@can('update-data')
                        			<input type="button" id="editSalary" data-toggle="modal" data-target="#salaryEdit" data-id="{{$data->id}}" class="btn btn-lg btn-info" value="Edit">
                        			@endcan
                        			
                        			@can('delete-data')
                        			| <input  onclick="deleteSalary({{ $data->id }})" id="salary-dell" type="button" class="btn btn-lg  btn-danger btn-prime white btn-flat" value="Delete">
                        			@endcan
                        		</td>
                        	</tr>
                        	@endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.employers.salaryModal')
@include('dashboard.employers.editSalaryModal')
@endsection

@section('script')
<script type="text/javascript">
	$('body').on('click', '#salarySubmit', function(){
        var addExtraCostForm = $("#add_salary");
        var formData = addExtraCostForm.serialize();
        $( '#employer_name_error' ).html( "" );
        $( '#present_salary_error' ).html( "" );
        $( '#payment_date_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/employer-salary-insert')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.employer_name){
                        $( '#employer_name_error' ).html('The Employer Name field is required.');
                    }                
                    if(data.errors.present_salary){
                        $( '#present_salary_error' ).html('The Salary field is required.');
                    }
                    if(data.errors.payment_date){
                        $( '#payment_date_error' ).html('The Date field is required.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/employer-salary')!!}';
                }
            },
        });
    });

	 // --------- Update Extra Cost-----------------------
    $('body').delegate('#editSalary','click',function(e){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/employer-salary-edit')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                    $('#edit_salary').find('#id').val(data.id);
                    $('#edit_salary').find('#employer_name').val(data.employer_id);
                    $('#edit_salary').find('#present_salary').val(data.salary);
                    $('#edit_salary').find('.payment_date').val(data.date);
                },
                error:function(){

                }
            });
        })


    $('body').on('click', '#updateSalarySubmit', function(){
    	var addExtraCostForm = $("#edit_salary");
        var formData = addExtraCostForm.serialize();
        $( '#employer_name_error' ).html( "" );
        $( '#present_salary_error' ).html( "" );
        $( '#payment_date_error' ).html( "" );
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/employer-salary-update')!!}',
            data:formData,
            success:function(data) {
                
                //console.log(data);
                
                if(data.errors) {                 
                    if(data.errors.employer_name){
                        $( '#employer_name_error' ).html('The Employer Name field is required.');
                    }                
                    if(data.errors.present_salary){
                        $( '#present_salary_error' ).html('The Salary field is required.');
                    }
                    if(data.errors.payment_date){
                        $( '#payment_date_error' ).html('The Date field is required.');
                    }
                }

                if(data.success){
                	window.location = '{!!URL::to('/employer-salary')!!}';
                }
            },
        });
    });
    // ------------ delete----------------
    

    function deleteSalary(Id){
		//Confirm message
		bootbox.confirm({
			title: "Confirmation",
			message: "This <b>Employer Salary</b> will delete permanently! Are you sure?",
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
					window.location.href="{{ url('/employer-salary-delete') }}"+'/'+Id;
			   }
			}
		}); 
	}
</script>
@endsection