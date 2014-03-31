@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('title')
  <title>{{ trans('main.series') }} - {{ trans('main.dashboard') }}</title>
@stop

@section('content')

  <div class="custom-container">

    @include('Dashboard.Partials.Sidebar')

    <div class="col-sm-10 dash-main-content">

      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> {{ trans('main.dashboard') }}</a></li>
        <li class="active">{{ trans('main.series') }}</li>
      </ol>

      @include('Dashboard.Partials.DbInfos')


        <section class="row">
          @include('Partials.Response')
        </section>

        <div class="col-sm-12">
        
          <div class="panel panel-default dashboard-panel">
            <div class="panel-heading">
              <h3 class="panel-title">
                <i class="fa fa-book"></i>  {{ trans('dash.series in db') }}
                <a href="{{ url('series/create') }}" class="pull-right btn btn-dash-action btn-xs">{{ trans('main.create new') }}</a>
              </h3>
            </div>

            <div class="panel-body">
              <div class="media">
      
                @if ( ! empty($latest) )

                 @foreach ($latest as $k => $v)

                  <div class="row">
                    <a class="pull-left col-sm-2" href="#">
                      <img src="{{{ asset($v['poster']) }}}" alt="" class="media-object img-responsive">
                    </a>

                    <div class="media-body col-sm-10">
                      <h5 class="media-heading">{{{ $v['title'] }}}</h5>

                      @if ($v['plot'])
                        <h6>{{{ $v['plot'] }}}</h6>
                      @endif


                      {{ Form::open(array('url' => "movies/{$v['id']}", 'class' => 'pull-left', 'method' => 'delete')) }}

                        <button type="submit" class="btn btn-dash-action danger-trans">{{ trans('main.delete') }}</button>

                      {{ Form::close() }}

                      <a type="button" href="{{ url('series/' . $v['id']) }}" class="btn btn-dash-action success-trans">{{ trans('main.view') }}</a>

                      <a type="button" href="{{ url('series/' . $v['id'] . '/edit') }}" class="btn btn-dash-action warning-trans">{{ trans('main.edit') }}</a>
                    </div>
                  </div>

                  <hr>

                  @endforeach

                @else

                  <p>{{ trans('dash.couldnt find any movies') }}</p>

                @endif

              </div>
            </div>
          </div>
          
          {{ $latest->links() }}

        </div>
      </div>
   </div>

    
@stop