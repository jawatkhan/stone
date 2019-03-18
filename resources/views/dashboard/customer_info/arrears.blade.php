@extends('layouts.app')
@section('page_title',__('general.customer-information'))
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
                    <p><span>@lang('general.bhola-office') : </span>{{$org->office_address}}</p>
                    <p><span>@lang('general.field-office') : </span>{{$org->store_address}}</p>
                    <p><span>@lang('general.e-mail') : </span>{{$org->office_email}}</p>
                    <p><span>@lang('general.phone') : </span>{{bfn($org->phone_no)}}, <span>@lang('general.mobile') : </span>{{bfn($org->mobile_no1)}}, {{bfn($org->mobile_no2)}}</p>
                    <h2>@lang('general.cus-amount-details')</h2>
                </div>
                <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
            <div class="bootstrap-data-table-panel col-md-12">
                <div class="table-responsive">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.sl-no')</th>
                                <th>@lang('table.name')</th>
                                <th>@lang('table.total-amount')</th>
                                <th>@lang('table.total-rec-amount')</th>
                                <th>@lang('table.payable-amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesPurch as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->org_name}}</td>
                                <td>{{$data->total_sales}}</td>
                                <td>
                                    <?php 
                                        $depo = DB::table('deposits')
                                        ->where('deposits.user_id','=',Auth::user()->author_id)
                                        ->where('deposits.client_id','=',$data->client_id)
                                        ->select('deposits.client_id', DB::raw('SUM(deposits.deposit_amount) as total_deposit'))
                                        ->groupBy('deposits.client_id')
                                        ->get();
                                        if(count($depo)>0){
                                        echo $depo[0]->total_deposit;
                                        }else{
                                            echo 0;
                                        }
                                    ?>
                                </td>
                                <td>
                                    @if(count($depo)>0)
                                    {{$data->total_sales-$depo[0]->total_deposit}}
                                    @else
                                    {{$data->total_sales}}
                                    @endif
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