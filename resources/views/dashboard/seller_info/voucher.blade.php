@extends('layouts.app')
@section('page_title',__('general.purchase-vouchar'))
@section('right-button')
    <a onclick="printDiv('printableArea')" class="float-right btn btn-lg" style="color: #1de610;padding-top:5px;font-size: 17px;"><i class="ti-printer"></i></a>
@endsection
@section('style')
@endsection
@section('content')
<div class="row" id="font-info">
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
                    <h2>@lang('general.purchase-cash-memo')</h2>
        		</div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
        		<div class="col-md-12">
        			<div class="row">
        				<div class="col-md-8 firstTable">
        					<div class="clientPurchesPage">
        						<table class="table table-striped table-bordered">
        							<body>
        								<tr>
        									<td>@lang('table.name')</td>
        									<td>:</td>
        									<td>{{$proData[0]->org_name}}</td>
        								</tr>
        								<tr>
        									<td>@lang('table.address')</td>
        									<td>:</td>
        									<td>{{$proData[0]->address}}</td>
        								</tr>
        								<tr>
        									<td>@lang('table.mobile')</td>
        									<td>:</td>
        									<td>{{bfn($proData[0]->contact_no)}}</td>
        								</tr>
        							</tbody>
        						</table>
        					</div>
        				</div>
        				<div class="col-md-4 secoundTable">
        					<div class="clientPurchesPage">
        						<table class="table table-striped table-bordered">
        							<body>
        								<tr>
        									<td>@lang('table.vouchar-no')</td>
        									<td>:</td>
        									<td>{{bfn($proData[0]->invoice_no)}}</td>
        								</tr>
        								<tr>
        									<td>@lang('table.date')</td>
        									<td>:</td>
        									<td>{{bfn(date('d-m-Y',strtotime($proData[0]->date)))}}</td>
        								</tr>
        							</tbody>
        						</table>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div class="col-md-12">
		            <div class="bootstrap-data-table-panel">
		                <div class="">
		                    <table class="table table-striped table-bordered voucherTable">
		                        <thead>
		                            <tr>
                                        <th>@lang('table.sl-no')</th>
                                        <th>@lang('table.category-name')</th>
                                        <th>@lang('table.product-name')</th>
                                        <th>@lang('table.qty')</th>
                                        <th>@lang('table.rate')</th>
                                        <th>@lang('table.taka')</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        	@foreach($proData as $data)
		                            <tr>
		                                <td>{{bfn($loop->iteration)}}</td>
		                                <td>{{$data->cat_name}}</td>
		                                <td>{{$data->category_name}}</td>
		                                <td>{{bfn($data->qty)}}</td>
		                                <td>{{bfn($data->rate)}}</td>
		                                <td>{{bfn(number_format($data->amount,2))}}</td>
		                            </tr>
		                            @endforeach
		                            @if(count($extraCost)>0)
		                            	<?php  $sl = (count($proData))+1;?>
		                            	@foreach($extraCost as $data)
		                            	<tr>
		                            		<td>{{ bfn($sl++) }}</td>
		                            		<td colspan="2">
                                                {{ $data->owner_id == 1 ? __('table.own') : __('table.seller') }}
                                            </td>
		                            		<td colspan="2">{{ $data->descriptions }}</td>
		                            		<td>{{bfn(number_format($data->amount,2))}}</td>
		                            	</tr>
		                            	@endforeach
		                            @endif
		                        </tbody>
		                        <tfoot>
		                        	<tr>
		                        		<th colspan="5" style="text-align:right;">@lang('table.total-taka')</th>
                                        <th>
                                            <?php
                                                $totalPamount=0;
                                                foreach ($proData as $amounts) {
                                                    $totalPamount += $amounts->amount;
                                                }
                                                $extraamount = 0;
                                                foreach ($extraCost as $key => $extra) {
                                                    $extraamount += $extra->amount;
                                                }
                                            ?>
                                            {{bfn(number_format($ptotal=$totalPamount+$extraamount,2))}} @lang('table.taka')
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align:right;">@lang('table.paid-taka')</th>
                                        <th>
                                            {{bfn(number_format($dtotal = $proData[0]->deposit_amount,2))}} @lang('table.taka')
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align:right;">@lang('table.payable-taka')</th>
                                        <th>
                                            {{bfn(number_format($ptotal-$dtotal,2))}} @lang('table.taka')
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.in-word')</th>
                                        <th colspan="5">
                                            {{ (($ptotal-$dtotal) > 0) ? App\Libraries\Library::numToWord(number_format($ptotal-$dtotal,2,'.','')) : App\Libraries\Library::numToWord(number_format($dtotal,2,'.','')) }}
                                        </th>
                                    </tr>
		                        </tfoot>
		                    </table>
		                </div>
		            </div>
        		</div>
        	</div>
            <div class="row">
                <div class="col-md-6 authorNameClass">
                    <div style="margin-top: 11px;">
                        <span>------------------------</span>
                    <h4 style="margin-left: 20px;">@lang('general.customer-signature')</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right" style="margin-top: 30px;">
                        <span>-----------------------------------</span>
                    <h4><span style="font-size: 14px;margin-left: 20px;">@lang('general.in-favor')</span>@lang('general.fortune-international')</h4>
                    </div>
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