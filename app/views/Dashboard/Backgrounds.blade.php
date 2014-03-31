@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard">
@stop


@section('title')
  <title>{{ trans('main.backgrounds') . ' - ' . trans('main.dashboard') }}  </title>
@stop

@section('bodytag')
  <body style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('content')

  <div class="custom-container">

    @include('Dashboard.Partials.Sidebar')

    <div class="col-sm-10 dash-main-content">

      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-home"></span> {{ trans('dash.home') }}</a></li>
        <li class="active">{{ trans('main.backgrounds') }}</li>
      </ol>

      @include('Dashboard.Partials.DbInfos')

      <section class="row trans-row">

        <section class="row">
          @include('Partials.Response')
        </section>

        <div class="row col-sm-11">

          {{ Form::open(array('url' => 'dashboard/backgrounds', 'class' => 'form-horizontal')) }}

            <div class="form-group on-image">
              {{ Form::label('home_bg', trans('dash.home bg'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('home_bg', isset($options->options['home_bg']) ? $options->options['home_bg'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('home_bg', '<span class="help-block alert alert-danger">:message</span>') }}
                <span class="help-block">* {{ trans('dash.bg expl') }} </span>
              </div>
            </div>
            
            <div class="form-group on-image">
              {{ Form::label('dash_bg', trans('dash.dash bg'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('dash_bg', isset($options->options['dash_bg']) ? $options->options['dash_bg'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('dash_bg', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>

            <div class="form-group on-image">
              {{ Form::label('login_bg', trans('dash.login bg'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('login_bg', isset($options->options['login_bg']) ? $options->options['login_bg'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('login_bg', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>

             <div class="form-group on-image">
              {{ Form::label('register_bg', trans('dash.register bg'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('register_bg', isset($options->options['register_bg']) ? $options->options['register_bg'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('register_bg', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>

            <div class="form-group on-image">
              {{ Form::label('404_bg', trans('dash.404 bg'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('404_bg', isset($options->options['404_bg']) ? $options->options['404_bg'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('404_bg', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>
            
            <div class="form-group on-image">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-dash-action"><i class="fa fa-pencil"></i> {{ trans('dash.update') }}</button>
              </div>
            </div>

          {{ Form::close() }}
        </div>

      </section>
    </div>
  </div>

    
@stop