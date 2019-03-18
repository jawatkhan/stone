@extends('layouts.app')
@section('page_title',__('general.accounts-report'))
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
                    <h2>@lang('general.accounts-report')</h2>
                </div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
                <div class="col-md-12">
                    <h3>@lang('general.date') : {{bfn(date('d-m-Y'))}}</h3>
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <table class="table table-striped table-bordered voucherTable">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center" style="font-weight: bold;">@lang('table.purchase-account')</th>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-purchase-product-amount')</td>
                                        <td>{{bfn(number_format($totalProCostSeller,2))}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-extra-cost')</td>
                                        <td>{{bfn(number_format($totalExtraCostSeller,2))}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-payment')</td>
                                        <td>{{bfn(number_format($totalPaymentSeller,2))}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center" style="font-weight: bold;">@lang('table.sales-account')</th>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-sales-product-amount')</td>
                                        <td>{{bfn(number_format($totalProCostCustomer,2))}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-extra-cost')</td>
                                        <td>{{bfn(number_format($totalExtraCostCustomer,2))}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-rec-amount')</td>
                                        <td>{{bfn(number_format($totalPaymentCustomer,2))}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center" style="font-weight: bold;">@lang('table.salary-amount')</th>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-salary-cost')</td>
                                        <td>{{bfn(number_format($totalSalaryCost,2))}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center" style="font-weight: bold;">@lang('table.owner-extra-cost')</th>
                                    </tr>
                                    <tr>
                                        <td>@lang('table.total-extra-cost')</td>
                                        <td>{{bfn(number_format($totalOwnerExtraCost,2))}}</td>
                                    </tr>
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