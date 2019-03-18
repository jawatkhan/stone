@extends('layouts.app')
@section('page_title',__('general.stock'))
@section('right-button')
<div id="message">
</div>
@endsection
@section('content')
                 <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('table.sl-no')</th>
                                <th>@lang('table.category')</th>
                                <th>@lang('table.product')</th>
                                <th>@lang('table.quantity')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $data)
                            <tr>
                                <td>{{bfn($loop->iteration)}}</td>
                                <td>{{$data->cat_name}}</td>
                                <td>{{$data->category_name}}</td>
                                <td>{{bfn($data->qty)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
