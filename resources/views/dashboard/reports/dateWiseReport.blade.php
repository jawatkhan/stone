@extends('layouts.app')
@section('page_title',__('general.date-wise-report'))
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
                    <h2>@lang('general.date-wise-report')</h2>
                </div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } 
                ?>

                <div class="col-md-12">
                   <div class="bootstrap-data-table-panel">
                        <div class="">
                            <br><h3 style="font-size: 21px;font-weight: bold;margin-bottom: 12px;">@lang('table.date-wise-total-purchse') :</h3>
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('table.date')</th>
                                        <th class="text-center">@lang('table.total-purchas-amount')</th>
                                        <th class="text-center">@lang('table.total-payment-amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales_purchase as $sp)
                                        <tr>
                                            <td>{{ ($sp->typeOfClient == 'Seller') ? bfn(date('d-m-Y', strtotime($sp->date))) : '' }}</td>
                                            <td class="text-right">{{ ($sp->typeOfClient == 'Seller') ? bfn(number_format($sp->total_amount,2)) : '' }}</td>
                                            <td>{{ ($sp->typeOfClient == 'Seller') ? bfn(number_format($sp->recive_amount,2)) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="col-md-12">
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <br><h3 style="font-size: 21px;font-weight: bold;margin-bottom: 12px;">@lang('table.date-wise-purchase-deposit') :</h3>
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('table.date')</th>
                                        <th class="text-center">@lang('table.total-payment-deposit')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deposits as $deposit)
                                        <tr>
                                            <td>{{ ($deposit->typeOfClient == 'Seller') ? bfn(date('d-m-Y', strtotime($deposit->date))) : '' }}</td>
                                            <td class="text-right">{{ ($deposit->typeOfClient == 'Seller') ? bfn(number_format($deposit->total_deposit_amount,2)) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <br><h3 style="font-size: 21px;font-weight: bold;margin-bottom: 12px;">@lang('table.date-wise-total-sales') :</h3>
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('table.date')</th>
                                        <th class="text-center">@lang('table.total-sale-amount')</th>
                                        <th class="text-center">@lang('table.total-rec-amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales_purchase as $sp)
                                        <tr>
                                            <td>{{ ($sp->typeOfClient == 'Customer') ? bfn(date('d-m-Y', strtotime($sp->date))) : '' }}</td>
                                            <td class="text-right">{{ ($sp->typeOfClient == 'Customer') ? bfn(number_format($sp->total_amount,2)) : '' }}</td>
                                            <td>{{ ($sp->typeOfClient == 'Customer') ? bfn(number_format($sp->recive_amount,2)) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <br><h3 style="font-size: 21px;font-weight: bold;margin-bottom: 12px;">@lang('table.date-wise-sales-deposit') :</h3>
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('table.date')</th>
                                        <th class="text-center">@lang('table.total-rec-deposit')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deposits as $deposit)
                                        <tr>
                                            <td>{{ ($deposit->typeOfClient == 'Customer') ? bfn(date('d-m-Y', strtotime($deposit->date))) : '' }}</td>
                                            <td class="text-right">{{ ($deposit->typeOfClient == 'Customer') ? bfn(number_format($deposit->total_deposit_amount,2)) : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <br><h3 style="font-size: 21px;font-weight: bold;margin-bottom: 12px;">@lang('table.date-wise-total-extra-cost') :</h3>
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('table.date')</th>
                                        <th class="text-center">@lang('table.total-extra-cost')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($extra_costs as $extra_cost)
                                        <tr>
                                            <td>{{ bfn(date('d-m-Y', strtotime($extra_cost->date))) }}</td>
                                            <td class="text-right">{{ bfn(number_format($extra_cost->total_extra_amount,2)) }}</td>
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