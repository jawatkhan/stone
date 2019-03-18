@extends('layouts.app')
@section('page_title',__('general.profit-report'))
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
                    <h2>@lang('general.simple-profit-report')</h2>
                </div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
                <div class="col-md-12">
                    <h3>@lang('table.date') : {{bfn(date('d-m-Y', strtotime($start_date)))}} @lang('general.to') {{bfn(date('d-m-Y', strtotime($end_date)))}}</h3>
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">@lang('table.purchase-account')</th>
                                        <th colspan="2" class="text-center">@lang('table.sales-account')</th>
                                    </tr>
                                </thead>
                                </tbody>
                                    <tr>
                                        <th>@lang('table.total-purchase-amount')</th>
                                        <th>{{bfn(number_format($sellerPrice,2))}} @lang('table.taka')</th>
                                        <th>@lang('table.total-sales-amount')</th>
                                        <th>{{bfn(number_format($customerPrice,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr><th>@lang('table.total-extra-cost')</th>
                                        <th>{{bfn(number_format($sellerextra,2))}} @lang('table.taka')</th>
                                        <th>@lang('table.total-extra-cost')</th>
                                        <th>{{bfn(number_format($customerextra,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr><th>@lang('table.total-purchase-amount-paid')</th>
                                        <th>{{bfn(number_format($sellerDeposit,2))}} @lang('table.taka')</th>
                                        <th>@lang('table.total-sales-recive-amount')</th>
                                        <th>{{bfn(number_format($customerDeposit,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.total-purchase-amount-due')</th>
                                        <th>{{bfn(number_format(($sellerPrice+$sellerextra)-$sellerDeposit,2))}} @lang('table.taka')</th>
                                        <th>@lang('table.total-sales-amount-due')</th>
                                        <th>{{bfn(number_format(($customerPrice+$customerextra)-$customerDeposit,2))}} @lang('table.taka')</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3>@lang('table.date') : {{bfn(date('d-m-Y', strtotime($start_date)))}} @lang('table.to') {{bfn(date('d-m-Y', strtotime($end_date)))}}</h3>
                    <div class="bootstrap-data-table-panel">
                        <div class="">
                            <table class="table table-striped table-bordered voucherTable">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">@lang('table.profit')</th>
                                    </tr>
                                </thead>
                                </tbody>
                                    <tr>
                                        <th width="50%">@lang('table.total-sales-amount')</th>
                                        <th>{{bfn(number_format($customerPrice,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.total-purchase-amount')</th>
                                        <th>{{bfn(number_format($avarage_rate*$customer_p_qty,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.total-extra-cost')</th>
                                        <th>{{bfn(number_format($cost = $sellerextra+$customerextra,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.total-salary-cost')</th>
                                        <th>{{bfn(number_format($employerSalary->total_salary?$emp=$employerSalary->total_salary:$emp=0,2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.profit')</th>
                                        <th>{{bfn(number_format($profit = $customerPrice-(($avarage_rate*$customer_p_qty)+$cost+$emp),2))}} @lang('table.taka')</th>
                                    </tr>
                                    <tr>
                                        <th>@lang('table.in-word')</th>
                                        <th>{{ \App\Libraries\Library::numToWord(number_format(($profit < 0 ?-1*$profit : $profit),2,'.','')) }} @lang('table.taka-only')</th>
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