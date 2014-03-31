@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard" style="background: url( {{{ asset('assets/images/' . $options->getBg('dash')) }}} )">
@stop

@section('title')
  <title>{{ trans('main.groups') }} - {{ trans('main.dashboard') }}</title>
@stop

@section('content')

  @include('Dashboard.Partials.Sidebar')

  <div class="col-sm-10 dash-main-content">
    <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> {{ trans('main.dashboard') }}</a></li>
      <li class="active">{{ trans('main.groups') }}</li>
    </ol>

    @include('Dashboard.Partials.DbInfos')


      <section class="row">
        @include('Partials.Response')
      </section>

      <div class="col-sm-12">
      
        <div class="col-sm-6">
          <div class="panel dashboard-panel">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> {{ trans('dash.create new group') }}</h3>
            </div>
            <div class="panel-body">
              
              {{ Form::open(array('url' => 'groups', 'method' => 'post')) }}

                <div class="form-group">
                  {{ Form::label('name', trans('main.name')) }}
                  {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => trans('dash.enter groups name'))) }}
                  {{ $errors->first('name', '<span class="help-block alert alert-danger">:message</span>') }}                   
                </div>

                <div class="form-group">
                  <label class="super">
                    <input type="hidden" name="super" value="0">
                    <input type="checkbox" name="super" value="1"> {{ trans('dash.super') }}
                  </label>
                  <label class="editTitles">
                    <input type="hidden" name="titles.edit" value="0">
                    <input type="checkbox" name="titles.edit" value="1"> {{ trans('dash.edit titles') }}
                  </label>
                  <label class="createTitles">
                    <input type="hidden" name="titles.create" value="0">
                    <input type="checkbox" name="titles.create" value="1"> {{ trans('dash.create titles') }}
                  </label>
                  <label class="deleteTitles">
                    <input type="hidden" name="titles.delete" value="0">
                    <input type="checkbox" name="titles.delete" value="1"> {{ trans('dash.delete titles') }}
                  </label>
                </div>

                <div class="form-group">
                  {{ Form::label('custom', trans('dash.custom permissions')) }}
                  {{ Form::text('custom', Input::old('custom'), array('class' => 'form-control', 'placeholder' => 'titles.delete:1, titles.create:0 etc...')) }}
                  {{ $errors->first('custom', '<span class="help-block alert alert-danger">:message</span>') }}
                  <span class="help-block">* {{ trans('dash.custom perm help') }}.</span>
                </div>

       
                <button type="submit" class="btn btn-dash-action">{{ trans('dash.create') }}</button>

              {{ Form::close() }}
            </div>{{--panel-body--}}
          </div>{{--panel--}}

          <div class="panel dashboard-panel">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-trash"></i> {{ trans('dash.delete group') }}</h3>
            </div>
            <div class="panel-body">
              
              {{ Form::open(array('action' => array('GroupController@destroy', 'delete'), 'method' => 'delete')) }}

                <select name="name" class="form-control">
                  @if($groups && ! empty($groups))
                    @foreach($groups as $g)
                      <option value="{{{ $g['name'] }}}">{{{ $g['name'] }}}</option>
                    @endforeach
                  @else
                    <span class="alert alert-danger">{{ trans('dash.no groups in db') }}</span>
                  @endif
                </select>

                <br>

                <button type="submit" class="btn btn-dash-action">{{ trans('dash.delete') }}</button>

              {{ Form::close() }}
            </div>
          </div>

        </div>

        <div class="col-sm-6">
          <div class="panel dashboard-panel">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="icon-refresh"></i> {{ trans('dash.recent group activity') }}</h3>
            </div>
            <div class="panel-body">
              @if($activity)
                @foreach($activity as $a)
                  <i class="fa fa-cut"></i> {{{ $a->message }}}
                  {{ Carbon\Carbon::createFromTimeStamp(strtotime($a->created_at))->diffForHumans() }}
                  <br>
                @endforeach
                  <br>
                  <a href="{{ action('GroupController@clear') }}" class="btn btn-dash-action">{{ trans('dash.clear') }}</a>
              @else
                <p>{{ trans('dash.no group activity') }}</p>
              @endif
            </div>
          </div>

        </div>

      </div>
    </div>

    
@stop