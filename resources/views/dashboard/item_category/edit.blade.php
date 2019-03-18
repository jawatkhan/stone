@extends('layouts.app')
@section('page_title',__('general.category-update'))
@section('content')
                 <?php function bfn($str) { 
                         $search=array("0","1","2","3","4","5",'6',"7","8","9"); 
                         $replace=array( "০","১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"); 
                         return str_replace($search,$replace,$str); 
                    } ?>
<div class="panel panel-default">
<div class="panel-body">
	<form class="form-horizontal" action="{{ URL::to('/category-update') }}" method="post">
		{{ csrf_field() }}
		@section('editmethod')
		@show
		<div class="form-group hidden">
          	<label for="">@lang('form.id') : </label>
            <input type="text" class="form-control" name="categoryid" value="{{$category->id}}">
        </div>
		<div class="form-group {{ $errors->has('category_name') ? ' has-error' : '' }}">
            <label class="col-lg-3 control-label">@lang('form.category-name') :</label>
            <div class="col-lg-8">
              <input class="form-control" value="{{$category->category_name}}" type="text" name="category_name">
                @if ($errors->has('category_name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('category_name') }}</strong>
	                </span>
	            @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <button type="submit" class="btn btn-success btn-lg">{{__('button.save')}}</button>
            </div>
        </div>
	</form>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ URL::to('/category') }}">@lang('general.home')</a></li>
  </ol>
</nav>
@include('partials.message')
<div class="panel-body">
	<table id="" class="table table-striped table-bordered table-hover display" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>@lang('table.sl-no')</th>
		        <th>@lang('table.category-name')</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			  @foreach ($categories as $category)
	      		<tr>
	      			<td style="text-align:center; width: 10%;">{{ $loop->iteration }}</td>
	      			<td style="text-align:center;text-decoration: none;"><a href="{{URL::to('sub-category')}}/{{$category->id}}" style="text-decoration: none;">{{ $category->category_name }}</a></td>
	      			<td style="width: 15%;">
	      				<a href="{{URL::to('/category-edit')}}/{{$category->id}}" class="btn btn-primary btn-lg"><i class="fa fa-pencil-square-o" aria-hidden="true"> @lang('button.edit')</i></a>
	      				<form action="{{URL::to('/category-delete')}}/{{$category->id}}" method="post" class="pull-right" onclick="return confirm('Are you sure you want to delete this item?');">
	      					{{ csrf_field() }}
	      					{{ method_field('DELETE')}}
	      					<button class="btn btn-danger btn-lg" type="submit"><i class="fa fa-trash" aria-hidden="true"> @lang('button.delete')</i></button>
						</form>
	      			</td>
	      		</tr>
	      	@endforeach
		</tbody>
	</table>
</div>
<!-- /.panel-body -->
</div>


@endsection