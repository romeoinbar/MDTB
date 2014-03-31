@extends('Main.Boilerplate');

@section('htmltag')
  <html id="register-page" class="nav-no-border" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('title')
  <title>{{ trans('users.change password') . ' - ' . trans('main.brand') }}</title>
@stop

  @section('content')
    <div class="container push-footer-wrapper">
      <div class="col-sm-2"></div>

      <div class="col-sm-8">

        {{ Form::open(array('route' => array('users.storeNewPass', $user['username']))) }}

          <div class="form-group">
            <label for="old_password"><i class="fa fa-user"></i> {{ trans('users.old password') }}</label>
            {{ Form::password('old_password', array('class' => 'form-control')) }}
            {{ $errors->first('old_password', "<span class='help-block alert alert-danger'>:message</span>") }}
          </div>

           <div class="form-group">
            <label for="new_password"><i class="fa fa-user"></i> {{ trans('users.new password') }}</label>
            {{ Form::password('new_password', array('class' => 'form-control')) }}
            {{ $errors->first('new_password', "<span class='help-block alert alert-danger'>:message</span>") }}
          </div>

          <div class="form-group">
            <label for="confirm_new_password"><i class="fa fa-user"></i> {{ trans('users.confirm new password') }}</label>
            {{ Form::password('new_password_confirmation', array('class' => 'form-control')) }}
            {{ $errors->first('new_password_confirmation', "<span class='help-block alert alert-danger'>:message</span>") }}
          </div>

          <button type="submit" class="btn btn-warning pull-right">{{ trans('users.confirm') }}</button>
          
        {{ Form::close() }}
    </div>

    <div class="col-sm-2"></div>

    <div class="push"></div>

  </div>
  @stop
  
  @section('ads')
  @stop