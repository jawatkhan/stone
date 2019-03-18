@extends('layouts.app')
@section('page_title')
    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#productAdd" style="background:#11c75a;">
      @lang('button.add-product')
    </button>
    <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#extraCostAdd" style="background:#11c75a;">
      @lang('button.add-extra-cost')
    </button>
@endsection
@section('content')
<div class="row" id="product_table_part">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <h1 id="product_title">@lang('general.product-list')</h1>
            </div>
            <div class="bootstrap-data-table-panel">
                <div class="">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.invoice-number')</th>
                                <th>@lang('table.category-name')</th>
                                <th>@lang('table.product-name')</th>
                                <th>@lang('table.qty')</th>
                                <th>@lang('table.rate')</th>
                                <th>@lang('table.amount')</th>
                                <th>@lang('table.action')</th>
                            </tr>
                        </thead>
                        <tbody id="p_show">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">@lang('table.total-amount')</th>
                                <th id="grandTotal" style="text-align: right;"></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row modal-footer">
                    <div class="col-md-12" style="float: right;">
                    <label id="recive_amount_btn" class="btn btn-info btn-prime white btn-lg" style="margin-bottom:10px;">@lang('table.payment-amount')</label>
                    <input type="number" name="recive_amount" id="recive_amount" class="form-control input-default" placeholder="@lang('general.write-receive-amount')">
                    </div>
                    <div class="col-md-12">
                    <button type="button" id="finalVoucherSubmit" class="btn btn-success btn-prime white btn-lg">@lang('button.final-voucher-create')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard.seller_info.addProductModal')
@include('dashboard.seller_info.addExtraCostModal')
@include('dashboard.seller_info.editProductModal')
@include('dashboard.seller_info.editExtraCostModal')
@endsection