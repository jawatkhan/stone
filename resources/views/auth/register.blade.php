@extends('layouts.app')
@section('page_title','Registration')
@section('content')
<div class="row" id="org_create">
    <div class="col-md-12">
        <div class="card">
            <div class="card-title">
                <h2>Register</h2>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form class="form-horizontal" method="POST" action="{{ route('user.register') }}" enctype="multipart/form-data">
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
                                        <option selected="true" disabled="true">Select Once</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
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

