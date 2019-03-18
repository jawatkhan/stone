@extends('admin.app')
@section('page_title',__('form.registration'))
@section('content')
<div class="row" id="org_create">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <h2>Register</h2>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.client-register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12"> User Name</p>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12">E-Mail Address</p>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12"> Roles</p>
                                    <select id="role" type="role" class="form-control" name="role" value="{{ old('role') }}" required>
                                        @foreach($roles as $id=>$role)
                                        <option value="{{$id}}">{{$role}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h2>Organization Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('org_name') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12">Organization Name</p>
                                    <input type="text" class="form-control input-default " placeholder="Organization Name" name="org_name" value="{{ old('org_name') }}" required>
                                    @if ($errors->has('org_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('org_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('office_address') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12">Office Address</p>
                                    <input type="text" class="form-control input-default " placeholder="Office Address" name="office_address"  value="{{ old('office_address') }}" required>
                                    @if ($errors->has('office_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('office_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">Store Address</p>
                                    <input type="text" class="form-control input-default " placeholder="Store Address" name="store_address"  value="{{ old('store_address') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone_no') ? ' has-error' : '' }}">
                                    <p class="text-muted m-b-15 f-s-12">Mobile/Phone Number</p>
                                    <input type="text" class="form-control input-default " placeholder="Mobile/Phone Number" name="phone_no"  value="{{ old('phone_no') }}" required>
                                    @if ($errors->has('phone_no'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">Office Email Address</p>
                                    <input type="email" class="form-control input-default " placeholder="Office Email Address" name="org_email"  value="{{ old('org_email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="text-muted m-b-15 f-s-12">Logo</p>
                                    <input type="file" class="form-control input-default " accept="image/*" placeholder="logo" name="logo"  value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-lg btn-primary" value="Register">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

