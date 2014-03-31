@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard" style="background: url( {{{ asset('assets/images/' . $options->getBg('dash')) }}} )">
@stop

@section('title')
  <title>{{ trans('main.news') }} - {{ trans('main.dashboard') }}</title>
@stop

@section('content')

  <div class="custom-container">

    @include('Dashboard.Partials.Sidebar')

    <div class="col-sm-10 dash-main-content">

      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> {{ trans('main.dashboard') }}</a></li>
        <li class="active">{{ trans('main.news') }}</li>
      </ol>

      @include('Dashboard.Partials.DbInfos')


        <section class="row">
          @include('Partials.Response')
        </section>

        <div class="col-sm-12">
        
          <div class="panel panel-default dashboard-panel">
            <div class="panel-heading">
              <h3 class="panel-title">
                <i class="fa fa-book"></i>  {{ trans('dash.recently scraped news') }}
            
                  {{ Form::open(array('url' => 'news/external', 'class' => 'pull-right')) }}

                    <button type="submit" class="btn btn-dash-action btn-xs">{{ trans('dash.update now') }}</button>

                  {{ Form::close() }}

                  <a href="{{ route('news.create') }}" id="create-news" class="pull-right btn btn-dash-action btn-xs">{{ trans('dash.create') }}</a>

              </h3>
            </div>

            <div class="panel-body">
              <div class="media">
      
                @if ( ! $recentNews->isEmpty() )

                 @foreach ($recentNews as $k => $v)

                  <div class="row">
                    <a class="pull-left " href="{{{ $v['full_url'] ? $v['full_url'] : url('news', $v['id']) }}}">
                      <img style="max-width:235px" src="{{$v['image']}}" alt="" class="media-object">
                    </a>

                    <div class="media-body">
                      <h5 class="media-heading">{{{ $v['title'] }}}</h5>
                      <h6>{{ Helpers::shrtString($v['body'], 230) }}</h6>

                      <p><a href="{{{ $v['source'] }}}">{{{ $v['source'] }}}</a></p>

                      @if ($options->scrapeNewsFully())
                        <h4 class="media-heading"><a class="btn btn-dash-action success-trans" href="{{{  Helpers::url($v->title, $v->id, 'news') }}}">{{ trans('main.view') }}</a> 
                      @else
                      <h4 class="media-heading"><a class="btn btn-dash-action success-trans" href="{{{  $v['full_url'] ? $v['full_url'] : Helpers::url($v->title, $v->id, 'news') }}}">{{ trans('main.view') }}</a> 
                      @endif

                      {{ Form::open(array('route' => array("news.destroy", $v['id']), 'class' => 'pull-left', 'method' => 'DELETE')) }}

                        <button type="submit" class="btn btn-dash-action danger-trans">{{ trans('dash.delete') }}</button>

                      {{ Form::close() }}

                      <a href="{{ url("news/{$v['id']}/edit") }}" type="submit" class="btn btn-dash-action warning-trans">{{ trans('dash.edit') }}</a>

                    </div>
                  </div>

                  @endforeach

                @else

                  <p>{{ trans('dash.couldnt find any news') }}</p>

                @endif

              </div>
            </div>
          </div>
          
          {{ $recentNews->links() }}

        </div>
      </div>
   </div>

    
@stop