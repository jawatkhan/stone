@extends('layouts.app')
@section('page_title','User List')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	
                        	@foreach($userList as $data)
                        	@if($data->author_id == $data->id)
                        	@else
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->role_name}}</td>
                                <td>
                                	<a class="btn btn-sm btn-{{ $data->status == 1 ? 'success' : 'danger' }} userStatus" data-id="{{ $data->id }}" style="color:#fff;">{{ $data->status==1 ? 'Active' : 'Inactive' }}</a>
                                </td>
                                <td>
                                    @can('delete-data')
                                	<input type="button" onclick="deleteUser( {{ $data->id }} )" class="btn btn-sm btn-danger btn-prime white btn-flat" value="Delete">
                                    @endcan
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
	$('body').delegate('.userStatus','click',function(e) {
		var id = $(this).data('id');
		//console.log(id);
	    $.ajax({
	    	type:'GET',
	        url: '{!!URL::to('user/approved')!!}',
	        data:{id:id},
	        success:function(data){
	        	console.log(data);
	        	if(data.success) {
					window.location = '{!!URL::to('user/list')!!}';
                }
	        }
	    })
	})
})
 function deleteUser(Id){
        bootbox.confirm({ 
            title: "Confirmation",
          message: "This <b>User</b> will delete permanently! Are you sure?", 
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
          callback: function(result){ 
            if(result == true){
                    window.location.href="{{ url('user/delete-user') }}"+'/'+Id;
               }
          }
        });
    }
   
</script>
@endsection