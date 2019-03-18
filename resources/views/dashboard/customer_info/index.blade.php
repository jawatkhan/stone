@extends('layouts.app')
@section('page_title',__('general.customer-information'))
@section('right-button')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.org-name')</th>
                                <th>@lang('table.address')</th>
                                <th>@lang('table.phone')</th>
                                <th>@lang('table.email')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $data)
                            <tr>
                                <td>{{$data->org_name}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{$data->contact_no}}</td>
                                <td>{{$data->email}}</td>
                                <td>
                                    @can('update-data')
                                    <input type="button" id="editSeller" data-toggle="modal" data-target="#editSellerInfo" data-id="{{$data->id}}" class="btn btn-info btn-lg" value="{{__('button.edit')}}">
                                    @endcan
                                    @can('delete-data')
                                    <input id="seller-dell" type="button" data-id="{{$data->id}}" class="btn btn-danger btn-prime white btn-lg" value="{{__('button.delete')}}">
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
@include('dashboard.customer_info.editSellerInfoModal')
@endsection
@section('script')
<script type="text/javascript">

    $('body').delegate('#editSeller','click',function(e){
        var id = $(this).data('id');
        //console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/customer-edit')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                   // console.log(data);
                    $('#sellerInfo').find('#client_id').val(data.id);
                    $('#sellerInfo').find('#new_org_name').val(data.org_name);
                    $('#sellerInfo').find('#seller_email').val(data.email);
                    $('#sellerInfo').find('#seller_address').val(data.address);
                    $('#sellerInfo').find('#seller_contact_no').val(data.contact_no);
                },
                error:function(){

                }
            });
        })
    $('body').on('click', '#selllerInfoSubmit', function(){
        var updateSellerForm = $("#sellerInfo");
        var formData = updateSellerForm.serialize();
        $( '#new_org_name_error' ).html( "" );
        $( '#seller_email_error' ).html( "" );
        $( '#seller_address_error' ).html( "" );
        $( '#seller_contact_no_error' ).html( "" );
        $.ajax({
            type:'POST',
            url:'{!!URL::to('/customer/info-update')!!}',
            data:formData,
            success:function(data) {
                
                console.log(data);
                
                if(data.errors) {
                    if(data.errors.new_org_name){
                        $( '#new_org_name_error' ).html( 'The Organization field is required.' );
                    }
                    if(data.errors.seller_email){
                        $( '#seller_email_error' ).html('The seller email must be a valid email address.');
                    }                  
                    if(data.errors.seller_address){
                        $( '#seller_address_error' ).html('The Address field is required.');
                    }
                    if(data.errors.seller_contact_no){
                        $( '#seller_contact_no_error' ).html('The phone/mobile no field is required and max size 11 digit.');
                    }
                }
                if(data.success) {
                    $("#editSellerInfo .close").click();
                    location.reload();
                }
            },
        });
    });
// --------- delete-------
    $('body').on('click','#seller-dell',function(){
        var id = $(this).data('id');
        //console.log(id);
        $.ajax({
            type:'GET',
            url:'{!!URL::to('/customer-delete')!!}',
            data:{id:id},
            success:function(data){
                //console.log('success');
                if(data.success){
                    location.reload();
                }
            }
        })
    })
</script>
@endsection