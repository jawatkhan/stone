@extends('layouts.app')
@section('page_title',__('general.sales-vouchar'))
@section('right-button')
    <a onclick="printDiv('printableArea')" class="float-right btn btn-lg" style="color: #1de610;padding-top:5px;font-size: 17px;"><i class="ti-printer"></i></a>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card" id="printableArea">
        	<div class="row">
        		<div class="col-md-12 purcheseCashMemo">
        			<h1>{{$org->org_name}}</h1>
        			<h4>{{$org->business_title}}</h4>
                    <p>@lang('general.bhola-office') : {{$org->office_address}}</p>
                    <p>@lang('general.field-office') : {{$org->store_address}}</p>
                    <p>@lang('general.e-mail') : {{$org->office_email}}</p>
                    <p>@lang('general.phone') : {{bfn($org->phone_no)}}, @lang('general.mobile') : {{bfn($org->mobile_no1)}}, {{bfn($org->mobile_no2)}}</p>
        			<h2>@lang('general.invoice-wise-sales-report')</h2>
        		</div>
        		<?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
        		<div class="col-md-12">
		            <div class="bootstrap-data-table-panel">
		                <div class="">
		                    <table class="table table-striped table-bordered voucherTable">
		                        <thead>
		                            <tr>
		                                <th>@lang('table.sl-no')</th>
		                                <th>@lang('table.client-name')</th>
		                                <th>@lang('table.address')</th>
		                                <th>@lang('table.invoice-no')</th>
		                                <th>@lang('table.product-amount')</th>
		                                <th>@lang('table.extra-cost')</th>
		                                <th>@lang('table.date')</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        	@foreach($allCusomer as $data)
		                            <tr>
		                                <td>{{ bfn($loop->iteration) }}</td>
		                                <td>{{$data->org_name}}</td>
		                                <td>{{$data->address}}</td>
		                                <td>{{ bfn($data->invoice_no) }}</td>
		                                <td>{{ bfn(number_format($data->total_amount,2)) }}</td>
		                                <td>{{ bfn(number_format($data->extra_cost,2)) }}</td>
		                                <td>{{ bfn(date('d-m-Y', strtotime($data->date))) }}</td>
		                            </tr>
		                            @endforeach
		                            
		                        </tbody>
		                    </table>
		                </div>
		            </div>
        		</div>
        	</div>
            <div class="row">
                <div class="col-md-12 authorNameClass">
                    <h4>@lang('general.report-maker')</h4>
                    <p>{{Auth::user()->name}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection