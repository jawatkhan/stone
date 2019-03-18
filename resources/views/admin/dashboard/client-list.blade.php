@extends('admin.app')
@section('page_title','Client List')
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
                                <th>Organization Name/Name</th>
                                <th>Office Address</th>
                                <th>Mobile/phone</th>
                                <th>Email Address</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($clients as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->org_name}}</td>
                                <td>{{$data->office_address}}</td>
                                <td>{{$data->phone_no}}</td>
                                <td>{{$data->email}}</td>
                                <td>
                                    <img src="{{asset('../storage/app/public/images')}}/{{$data->logo}}" width="50" height="50" />
                                </td>
                                <td>
                                	<a class="btn btn-sm btn-{{ $data->status == 1 ? 'success' : 'danger' }} userStatus" data-id="{{ $data->id }}" style="color:#fff;">{{ $data->status==1 ? 'Active' : 'Inactive' }}</a>
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
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
	$('body').delegate('.userStatus','click',function(e) {
		var id = $(this).data('id');
		//console.log(id);
	    $.ajax({
	    	type:'GET',
	        url: '{!!URL::to('admin/client-approved')!!}',
	        data:{id:id},
	        success:function(data){
	        	console.log(data);
	        	if(data.success) {
					window.location = '{!!URL::to('admin/client-list')!!}';
                }
	        }
	    })
	})
})
</script>
@endsection