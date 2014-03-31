@extends('Main.Boilerplate')

@section('title')
	<title> {{  trans('main.create new movie')}} </title>
@stop

@section('bodytag')
	<body id="editTitle">
@stop

@section('content')
    <div class="container">

      <div class="col-sm-12">

      	 <h3 class="heading">{{ trans('main.add a new movie') }} <i class="fa fa-pencil"></i></h3 class="heading">

        <p class="padding-top-bot"> {{ trans('main.add new movie expl') }} </p>
 
        {{ Form::open(array('route' => array('movies.store'))) }}

          <div class="form-group">
            {{ Form::label('title', trans('main.title')) }}
            {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
            {{ $errors->first('title', '<span class="help-block alert alert-danger">:message</span>') }}
          </div>
            
          <div class="form-group">
            {{ Form::label('type', trans('main.type')) }}
            {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
            {{ $errors->first('type', '<span class="help-block alert alert-danger">:message</span>') }}
            <span class="help-block">*Series or Movie</span>
          </div>

          <div class="form-group">
            {{ Form::label('plot', trans('main.plot')) }}
            {{ Form::textarea('plot', Input::old('plot'), array('class' => 'form-control', 'rows' => 3)) }}
          </div>
          
          <div class="form-group">
            {{ Form::label('tagline', trans('main.tagline')) }}
            {{ Form::text('tagline', Input::old('tagline'), array('class' => 'form-control')) }}
          </div>
            {{ $errors->first('password', '<span class="help-block alert alert-danger">:message</span>') }}

           <div class="form-group">
            {{ Form::label('genre', trans('main.genre')) }}
            {{ Form::text('genre', Input::old('genre'), array('class' => 'form-control')) }}
            <span class="help-block">*{{ trans('main.genre expl') }}</span>
          </div>

          <div class="form-group">
            {{ Form::label('poster', trans('main.poster')) }}
            {{ Form::text('poster', Input::old('poster'), array('class' => 'form-control')) }}
          </div>

         <div class="form-group">
            {{ Form::label('trailer', trans('main.trailer')) }}
            {{ Form::text('trailer', Input::old('trailer'), array('class' => 'form-control')) }}
            <span class="help-block">*{{ trans('main.trailer expl') }}</span>
          </div>

         <div class="form-group">
            {{ Form::label('imdb_id', trans('main.imdb_id')) }}
            {{ Form::text('imdb_id', Input::old('imdb_id'), array('class' => 'form-control')) }}
          </div>

         <div class="form-group">
            {{ Form::label('tmdb_id', trans('main.tmdb_id')) }}
            {{ Form::text('tmdb_id', Input::old('tmdb_id'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('imdb_rating', trans('main.imdb_rating')) }}
            {{ Form::text('imdb_rating', Input::old('imdb_rating'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('mc_user_score', trans('main.metacritic_rating')) }}
            {{ Form::text('mc_user_score', Input::old('mc_user_score'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('release_date', trans('main.release_date')) }}
            {{ Form::text('release_date', Input::old('release_date'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('background', trans('main.background')) }}
            {{ Form::text('background', Input::old('background'), array('class' => 'form-control')) }}
            <span class="help-block">*{{ trans('main.background expl') }}</span>
          </div>

          <div class="form-group">
            {{ Form::label('awards', trans('main.awards')) }}
            {{ Form::text('awards', Input::old('awards'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('runtime', trans('main.runtime')) }}
            {{ Form::text('runtime', Input::old('runtime'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('budget', trans('main.budget')) }}
            {{ Form::text('budget', Input::old('budget'), array('class' => 'form-control')) }}
          </div>

          <div class="form-group">
            {{ Form::label('revenue', trans('main.revenue')) }}
            {{ Form::text('revenue', Input::old('revenue'), array('class' => 'form-control')) }}
          </div>

          {{ Form::hidden('local', 1) }}

          <a type="button" href="{{ url('movies') }}" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> {{ trans('main.back') }}
          </a>
          <button type="submit" class="btn btn-default">{{ trans('dash.create') }}</button>

        {{ Form::close() }}

    </div>
</div>
  @stop