@extends('layouts.app')
@section('page_title',__('general.organizatio-information'))
@section('content')
<div class="row" id="org_details">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
            </div>
            <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.organize-name')</th>
                                <th>@lang('table.business-title')</th>
                                <th>@lang('table.head-office-address')</th>
                                <th>@lang('table.field-office-address')</th>
                                <th>@lang('table.telephone-number')</th>
                                <th>@lang('table.mobile-number1')</th>
                                <th>@lang('table.mobile-number2')</th>
                                <th>@lang('table.email-address')</th>
                                <th>@lang('table.logo')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$orgs->org_name}}</td>
                                <td>{{$orgs->business_title}}</td>
                                <td>{{$orgs->office_address}}</td>
                                <td>{{$orgs->store_address}}</td>
                                <td>{{bfn($orgs->phone_no)}}</td>
                                <td>{{bfn($orgs->mobile_no1)}}</td>
                                <td>{{bfn($orgs->mobile_no2)}}</td>
                                <td>{{$orgs->office_email}}</td>
                                <td><img src="{{asset('/storage/app/public/images/')}}/{{$orgs->logo}}" width="50" height="50"></td>
                                <td>
                                  @can('update-data')
                                	<input type="button" name="" class="btn btn-lg btn-info btn-prime white" value="@lang('button.edit')" data-id="{{$orgs->id}}"  data-toggle="modal" data-target="#editOrg" id="editOrganization">
                                  @endcan 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard/organization/edit')
@endsection
@section('script')
<script type="text/javascript">
     $('body').delegate('#editOrganization','click',function(e){
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
                type:'get',
                url:'{!!URL::to('/edit-organization')!!}',
                data:{id:id},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    console.log(data.id);
                    $('#editOrg_form').find('#id').val(data.id);
                    $('#editOrg_form').find('#org_name').val(data.org_name);
                    $('#editOrg_form').find('#business_title').val(data.business_title);
                    $('#editOrg_form').find('#office_address').val(data.office_address);
                    $('#editOrg_form').find('#store_address').val(data.store_address);
                    $('#editOrg_form').find('#phone_no').val(data.phone_no);
                    $('#editOrg_form').find('#mobile_no1').val(data.mobile_no1);
                    $('#editOrg_form').find('#mobile_no2').val(data.mobile_no2);
                    $('#editOrg_form').find('#email').val(data.office_email);
                },
                error:function(){

                }
            });
        })
</script>
@endsection