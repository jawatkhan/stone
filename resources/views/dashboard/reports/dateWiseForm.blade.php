@extends('layouts.app')
@section('page_title',__('general.date-wise-report'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
            </div>
            <div class="card-body">
                <div class="basic-form">
					<!-- new customer start -->
                    <form id="invoice_recive" method="POST" action="{{URL::to('/get-date-wise-report')}}">
                        {{ csrf_field() }}
                        @section('editmethod')
                        @show
                    	<div class="row">
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.start-date')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('start-date')" name="start_date" id="datepicker" value="{{date('Y-m-d')}}" required>
                                    <span class="text-danger" id="start_date_error"></span>
							    </div>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="form-group">
							        <p class="text-muted m-b-15 f-s-12">@lang('form.end-date')</p>
                                    <input type="text" class="form-control input-default " placeholder="@lang('end-date')" name="end_date" id="datepicker1" value="{{date('Y-m-d')}}" required>
                                    <span class="text-danger" id="end_date_error"></span>
							    </div>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group float-right">
							        <input type="Submit" class="btn btn-lg btn-success" value="@lang('button.submit')" id="invoice_submit">
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