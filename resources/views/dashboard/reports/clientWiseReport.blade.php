@extends('layouts.app')
@section('page_title',__('general.client-report'))
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
                    <h2>@lang('general.client-wise-report')</h2>
                </div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered voucherTable">
                        <tr>
                            <th>@lang('table.client-name')</th>
                            <th>:</th>
                            <th>{{$clientwise[0]->org_name}}</th>
                        </tr>
                        <tr>
                            <th>@lang('table.address')</th>
                            <th>:</th>
                            <th>{{$clientwise[0]->address}}</th>
                        </tr>
                        <tr>
                            <th>@lang('table.contact-number')</th>
                            <th>:</th>
                            <th>{{ bfn($clientwise[0]->contact_no) }}</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th>@lang('table.sl-no')</th>
                                        <th>@lang('table.date')</th>
                                        <th>@lang('table.amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="3" class="text-center" style="font-weight: bold;">@lang('table.product-details')</th>
                                    </tr>
                                    <?php $total = 0; $totalCost =0; $totalPayment = 0; ?>
                                    @foreach($clientwise as $data)
                                    <tr>
                                        <td>{{ bfn($loop->iteration) }}</td>
                                        <td>{{ bfn(date('d-m-Y', strtotime($data->date))) }}</td>
                                        <td>{{ bfn(number_format($data->total_amount,2)) }}</td>
                                    </tr>
                                    <?php $total += $data->total_amount; ?>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" style="text-align: right;font-weight: bold;">@lang('table.total-product-amount')</th>
                                        <th style="font-weight: bold;">{{ bfn(number_format($total,2)) }} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center" style="font-weight: bold;">@lang('table.extra-cost')</th>
                                    </tr>
                                    @foreach($extracost as $data)
                                    <tr>
                                        <td>{{bfn($loop->iteration)}}</td>
                                        <td>{{$data->descriptions}}({{$data->owner_id==1?__('table.own'):__('table.customer')}})</td>
                                        <td>{{ bfn(number_format($data->amount,2)) }}</td>
                                    </tr>
                                    <?php $totalCost += $data->amount; ?>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" style="text-align: right;font-weight: bold;">@lang('table.total-extra-cost')</th>
                                        <th style="font-weight: bold;">{{ bfn(number_format($totalCost,2)) }} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center" style="font-weight: bold;">{{$owner=='Customer'?__('table.receive-amount-details'):__('table.payment-details')}}</th>
                                    </tr>
                                    @foreach($payment as $data)
                                    <tr>
                                        <td>{{ bfn($loop->iteration) }}</td>
                                        <td>{{ bfn(date('d-m-Y', strtotime($data->date))) }}</td>
                                        <td>{{ bfn(number_format($data->deposit_amount,2)) }}</td>
                                    </tr>
                                    <?php $totalPayment += $data->deposit_amount; ?>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" style="text-align: right;font-weight: bold;">{{$owner=='Customer'?__('table.total-recive-amount'):__('table.total-payment')}}</th>
                                        <th style="font-weight: bold;">{{ bfn(number_format($totalPayment,2)) }} @lang('table.taka')</th>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align: right;font-weight: bold;">@lang('table.total-balance')</th>
                                        <th>{{ bfn(number_format($total+$totalCost-$totalPayment,2)) }} @lang('table.taka')</th>
                                    </tr>
                                </tfoot>
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