@extends('Main.Boilerplate')

@section('title')
	<title> {{ trans('main.adding new season') }} - {{ trans('main.brand') }} </title>
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')

	<div class="container push-footer-wrapper">
		<div class="col-sm-12 no-pad">

			<h3 class="heading">{{ trans('main.create or edit seasons', array('title' => $series->title)) }} <i class="fa fa-pencil"></i></h3 class="heading">

        	<p> {{ trans('main.new season expl') }} </p>
	
			<div class="row" id="responses"> @include('Partials.Response') </div>

			{{ Form::open(array('route' => array(Str::slug(trans('main.series')) . '.seasons.store', $series->id))) }}

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
				  {{ Form::label('overview', trans('main.overview')) }}
				  {{ Form::text('overview', Input::old('overview'), array('class' => 'form-control')) }}
				  {{ $errors->first('overview', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				<div class="form-group">
				  {{ Form::label('poster', trans('main.poster path')) }}
				  {{ Form::text('poster', Input::old('poster'), array('class' => 'form-control')) }}
				  {{ $errors->first('poster', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				<div class="form-group">
				  {{ Form::label('number', trans('main.number')) }}
				  {{ Form::text('number', Input::old('number'), array('class' => 'form-control')) }}
				  {{ $errors->first('number', '<span class="help-block alert alert-danger">:message</span>') }}
				</div>

				{{ Form::hidden('allow_update', 0) }}
				{{ Form::hidden('fully_scraped', 1) }}
				{{ Form::hidden('title_id', $series->id) }}
				{{ Form::hidden('title_imdb_id', $series->imdb_id) }}
				{{ Form::hidden('title_tmdb_id', $series->tmdb_id) }}

				<a href="{{ Helpers::url($series->title, $series->id, 'series') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Series Page</a>
				<button type="submit" class="btn btn-success">Create</button>

			{{ Form::close() }}


			@include('Titles.Partials.EditSeasonsTable')

		</div>

		<div class="push"></div>
	</div>

<script>
  (function( $ ){

  $("#edit-season").submit(function(e)
  {
    e.preventDefault();
    var base = '{{ route(Str::slug(trans("main.series")) . ".seasons.store", $series->id) }}';
    $.ajax(
    {
      url: base,
      type: "POST",
      datatype: "json",
      data: $(this).serialize(),
      beforeSend: function()
      {
        $('#ajax-loading').show();
      }
    })
    .done(function(data)
    {
      console.log(data);
      if (data == 'success')
      {
        $('.edit-season-modal').modal('hide')

        $('#responses').html('<div class="alert alert-success alert-dismissable">{{ trans("main.ajax edit season success") }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
      }
      else
      {
        console.log(data);
        $('#modal-response').html('<div class="alert alert-danger alert-dismissable">' + data + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
      }

      $('#ajax-loading').hide();      
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
        $('#ajax-loading').hide();
        console.log(jqXHR);
        alert('Something went wrong on our end, sorry.');
    });
    return false;
  });

})( jQuery );

</script>

@stop