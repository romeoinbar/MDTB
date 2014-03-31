@extends('Main.Boilerplate')

@section('title')
	<title>{{ trans('dash.edit') }} {{ trans('main.news') }} - {{ trans('main.brand') }}</title>
@stop

@section('assets')
	@parent

	{{ HTML::script('assets/js/ckeditor/ckeditor.js') }}
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')
	
	<div class="container push-footer-wrapper">

		@include('Partials.Response')
		
		{{ Form::model($news, array('route' => array(Str::slug(trans('main.news')) . '.update', $news['id']), 'method' => 'put')) }}

			<div class="row form-group">
    			{{ Form::label('title', trans('main.title') ) }}
    			{{ Form::text('title', null, array('class' => 'form-control')) }}
    			{{ $errors->first('title', '<span class="help-block alert alert-danger">:message</span>') }}
  			</div>

  			<div class="row form-group">
  				{{ Form::label('image', trans('main.image path') ) }}
    			{{ Form::text('image', null, array('class' => 'form-control')) }}
    			{{ $errors->first('image', '<span class="help-block alert alert-danger">:message</span>') }}
  			</div>

			<div class="row form-group">
				{{ Form::label('body', trans('main.body') ) }}
				{{ Form::textarea('body', null, array('class' => 'ckeditor', 'rows' => 50, 'cols' => 10)) }}
				{{ $errors->first('body', '<span class="help-block alert alert-danger">:message</span>') }}
			</div>
			
			{{ Form::hidden('author', Helpers::loggedInUser()->username) }}
		
			<button type="submit" class="btn btn-default">{{ trans('dash.update') }}</button>
	    
	    {{ Form::close() }}
	
	<div class="push"></div>
	</div>
@stop

@section('ads')
@stop