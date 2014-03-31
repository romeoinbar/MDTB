@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard">
@stop

@section('title')
  <title>{{ trans('main.appearance') . ' - ' . trans('main.dashboard') }}  </title>
@stop

@section('bodytag')
  <body style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('content')

  <div class="custom-container">

    @include('Dashboard.Partials.Sidebar')

    <div class="col-sm-10 dash-main-content">

      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><span class="fa fa-home"></span> {{ trans('dash.home') }}</a></li>
        <li class="active">{{ trans('dash.dashboard') }}</li>
      </ol>

      @include('Dashboard.Partials.DbInfos')

      <section class="row trans-row">

        <section class="row">
          @include('Partials.Response')
        </section>

        <div class="row col-sm-11">

          {{ Form::open(array('url' => 'dashboard/options', 'class' => 'form-horizontal')) }}

            <div class="form-group on-image">
              {{ Form::label('success_color', trans('dash.success color'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('success_color', isset($options->options['success_color']) ? $options->options['success_color'] : '', array('class' => 'form-control')) }}
                <span class="help-block">* {{ trans('dash.color expl') }}</span>
                {{ $errors->first('success_color', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>

            <div class="form-group on-image">
              {{ Form::label('warning_color', trans('dash.warning color'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('warning_color', isset($options->options['warning_color']) ? $options->options['warning_color'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('warning_color', '<span class="help-block alert alert-danger">:message</span>') }}
                <span class="help-block">* {{ trans('dash.warning color expl') }}</span>
              </div>
            </div>

            <div class="form-group on-image">
              {{ Form::label('danger_color', trans('dash.danger color'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('danger_color', isset($options->options['danger_color']) ? $options->options['danger_color'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('danger_color', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>

            <div class="form-group on-image">
              {{ Form::label('title_view', trans('dash.title page des'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('title_view', array('tabs' => 'tabs', 'NoTabs' => 'No tabs'), isset($options->options['title_view']) ? $options->options['title_view'] : 'tabs', array('class' => 'form-control')) }}
                {{ $errors->first('title_view', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div> 

             <div class="form-group on-image">
              {{ Form::label('home_view', trans('dash.home page des'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('home_view', array('columns' => 'Columns', 'rows' => 'Rows'), isset($options->options['home_view']) ? $options->options['home_view'] : 'Columns', array('class' => 'form-control')) }}
                {{ $errors->first('home_view', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div>

             <div class="form-group on-image">
              {{ Form::label('news_ex_len', trans('dash.news exe len'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('news_ex_len', isset($options->options['news_ex_len']) ? $options->options['news_ex_len'] : '', array('class' => 'form-control')) }} 
                {{ $errors->first('news_ex_len', '<span class="help-block alert alert-danger">:message</span>') }}
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