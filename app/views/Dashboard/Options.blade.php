@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard">
@stop

@section('title')
  <title>{{ trans('main.options') . ' - ' . trans('main.dashboard') }}  </title>
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
              {{ Form::label('data_provider', trans('dash.primary data provider'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('data_provider', array('tmdb' => 'tmdb', 'imdb' => 'imdb', 'db' => 'db'), $options->options['data_provider'] == 'imdb' ? 'imdb' : ($options->options['data_provider'] === 'tmdb' ? 'tmdb' : 'db' ), array('class' => 'form-control')) }}
                <span class="help-block">
                  * {{ trans('dash.provider explanation') }} <strong><a href="http://www.themoviedb.org/">TMDB</a></strong>, <strong><a href="http://www.imdb.com/">IMDb</a></strong> {{ trans('dash.and') }} <strong>DB</strong> ({{ trans('dash.only loads') }})
                </span>
                {{ $errors->first('data_provider', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div> 

            <div class="form-group on-image">
              {{ Form::label('search_provider', trans('dash.primary search provider'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('search_provider', array('tmdb' => 'tmdb', 'imdb' => 'imdb', 'db' => 'db'), $options->options['search_provider'] == 'imdb' ? 'imdb' : ($options->options['search_provider'] === 'tmdb' ? 'tmdb' : 'db' ), array('class' => 'form-control')) }}
                <span class="help-block">* {{ trans('dash.search provider expl') }} </span>
                {{ $errors->first('search_provider', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div>          

            <div class="form-group on-image">
              {{ Form::label('tmdb_api_key', trans('dash.tmdb api key'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('tmdb_api_key', isset($options->options['tmdb_api_key']) ? $options->options['tmdb_api_key'] : '', array('class' => 'form-control')) }}
                <span class="help-block">* {{ trans('dash.register for') }} tmdb <a href="https://www.themoviedb.org/account/signup"><strong>{{ trans('dash.here') }}</strong></a> {{ trans('dash.key explanation') }}.</span>
                {{ $errors->first('tmdb_api_key', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>
            </div>
            
            <div class="form-group on-image">
              {{ Form::label('disqus_short_name', trans('dash.short name'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('disqus_short_name', isset($options->options['disqus_short_name']) ? $options->options['disqus_short_name'] : '', array('class' => 'form-control')) }}
                <span class="help-block">
                  * {{ trans('dash.register') }} <a href="https://disqus.com/admin/signup/"><strong>{{ trans('dash.here') }}</strong></a> {{ trans('dash.short name explanation') }}.
                </span>
                {{ $errors->first('disqus_short_name', '<span class="help-block alert alert-danger">:message</span>') }}        
              </div>             
            </div>

            <div class="form-group on-image">
              {{ Form::label('contact_us_email', trans('dash.contact us email'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('contact_us_email', isset($options->options['contact_us_email']) ? $options->options['contact_us_email'] : '', array('class' => 'form-control')) }}
                <span class="help-block">
                  * {{ trans('dash.contact email explanation') }}.
                </span>   
                {{ $errors->first('contact_us_email', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>              
            </div>

            <div class="form-group on-image">
              {{ Form::label('fb_url', trans('dash.facebook url'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('fb_url', isset($options->options['fb_url']) ? $options->options['fb_url'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('fb_url', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>              
            </div>
            
            <div class="form-group on-image">
              {{ Form::label('amazon_id', trans('dash.amazon aff id'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('amazon_id', isset($options->options['amazon_id']) ? $options->options['amazon_id'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('amazon_id', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>              
            </div>

            <div class="form-group on-image">
              {{ Form::label('tmdb_language', trans('dash.tmdb language'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('tmdb_language', isset($options->options['tmdb_language']) ? $options->options['tmdb_language'] : '', array('class' => 'form-control')) }}
                {{ $errors->first('tmdb_language', '<span class="help-block alert alert-danger">:message</span>') }}
                <span class="help-block"> * {{ trans('dash.tmdb lang expl') }}.</span>
              </div>              
            </div>

            <div class="form-group on-image">
              {{ Form::label('uri_separator', trans('dash.uri separator'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::text('uri_separator', isset($options->options['uri_separator']) ? $options->options['uri_separator'] : '', array('class' => 'form-control')) }}
                <span class="help-block">* {{ trans('dash.uri separator explanation') }}.</span>   
                {{ $errors->first('uri_separator', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>              
            </div>

            <div class="form-group on-image">
              {{ Form::label('scrape_news_fully', trans('dash.scrape news fully'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('scrape_news_fully', array(1 => 'yes', 0 => 'no'), isset($options->options['scrape_news_fully']) ? $options->options['scrape_news_fully'] : 'yes', array('class' => 'form-control')) }}
                {{ $errors->first('scrape_news_fully', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div> 

            <div class="form-group on-image">
              {{ Form::label('uri_case', trans('dash.resource uri first letter'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('uri_case', array('uppercase' => trans('dash.uppercase'), 'lowercase' => trans('dash.lowercase')), isset($options->options['uri_case']) ? $options->options['uri_case'] : 'lowercase', array('class' => 'form-control')) }}
                <span class="help-block">* <strong>254-Thor-The-Dark-World</strong> {{ trans('dash.or') }} <strong>254-thor-the-dark-world</strong></span>   
                {{ $errors->first('uri_case', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>              
            </div>

           <div class="form-group on-image">
              {{ Form::label('require_act', trans('dash.req user acti'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('require_act', array(1 => 'yes', 0 => 'no'), isset($options->options['require_act']) ? $options->options['require_act'] : 'yes', array('class' => 'form-control')) }}
                {{ $errors->first('require_act', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div>

             <div class="form-group on-image">
              {{ Form::label('use_cache', trans('dash.enable caching?'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('use_cache', array(1 => 'yes', 0 => 'no'), isset($options->options['use_cache']) ? $options->options['use_cache'] : 'yes', array('class' => 'form-control')) }}
                {{ $errors->first('use_cache', '<span class="help-block alert alert-danger">:message</span>') }}
              </div>            
            </div>

            <div class="form-group on-image">
              {{ Form::label('auto_upd_fet', trans('dash.auto update fet'), array('class' => 'col-sm-2')) }}
              <div class="col-sm-9">
                {{ Form::select('auto_upd_fet', array(1 => 'yes', 0 => 'no'), isset($options->options['auto_upd_fet']) ? $options->options['auto_upd_fet'] : 'yes', array('class' => 'form-control')) }}
                {{ $errors->first('auto_upd_fet', '<span class="help-block alert alert-danger">:message</span>') }}
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