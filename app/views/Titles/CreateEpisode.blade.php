@extends('Main.Boilerplate')

@section('title')
	<title> {{ trans('main.adding new episode') }} - {{ trans('main.brand') }} </title>
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')

	<div class="container push-footer-wrapper">
		<div class="col-sm-12 no-pad">

			<h3 class="heading">{{ trans('main.create new ep', array('title' => $data->getTitle())) }} <i class="fa fa-pencil"></i></h3 class="heading">

        	<p> {{ trans('main.new ep expl') }} </p>
	
			<div class="row" id="responses"> @include('Partials.Response') </div>

			{{ Form::open(array('url' => Str::slug(trans('main.series')) . '/' . $data->getId() . "/seasons/$num/episodes")) }}

				<div class="form-group">
				  {{ Form::label('title', trans('main.title')) }}
				  {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
				  {{ $errors->first('title', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>
				  
				<div class="form-group">
				  {{ Form::label('release_date', trans('main.release date')) }}
				  {{ Form::text('release_date', Input::old('release_date'), array('class' => 'form-control')) }}
				  {{ $errors->first('release_date', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				<div class="form-group">
				  {{ Form::label('plot', trans('main.plot')) }}
				  {{ Form::textarea('plot', Input::old('plot'), array('class' => 'form-control', 'rows' => '6')) }}
				  {{ $errors->first('plot', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				<div class="form-group">
				  {{ Form::label('poster', trans('main.poster path')) }}
				  {{ Form::text('poster', Input::old('poster'), array('class' => 'form-control')) }}
				  {{ $errors->first('poster', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				<div class="form-group">
				  {{ Form::label('episode_number', trans('main.number')) }}
				  {{ Form::text('episode_number', Input::old('episode_number'), array('class' => 'form-control')) }}
				  {{ $errors->first('episode_number', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				{{ Form::hidden('title_id', $data->getId()) }}
	            {{ Form::hidden('season_id', $data->getSeasons($num)->id) }}
	            {{ Form::hidden('season_number', $num) }}
	            {{ Form::hidden('allow_update', 0) }}

				<a href='{{ url(Str::slug(trans("main.series")) . "/{$data->getId()}/seasons/$num") }}' class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{ trans('main.back') }}</a>
				<button type="submit" class="btn btn-success">{{ trans('dash.create') }}</button>

			{{ Form::close() }}

		</div>

		<div class="push"></div>
	</div>

@stop