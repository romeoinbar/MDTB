@extends('Main.Boilerplate')

@section('title')
	<title> {{  trans('main.create actor') . ' - ' . trans('main.brand') }}</title>
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')

<div class="container">

	<div class="col-sm-12">

    	<h3 class="heading">{{ trans('main.add a new actor') }} <i class="fa fa-pencil"></i></h3 class="heading">

    	<div class="row padding-top-bot"> @include('Partials.Response') </div>
 			
 			{{ Form::open(array('route' => array(Str::slug(trans('main.people')) . '.store'))) }}
			
				@include('Actor.Partials.CreateEditForm')

				{{ Form::hidden('allow_update', 0) }}

				<a type="button" href="{{ url('people') }}" class="btn btn-warning">
					<i class="fa fa-arrow-left"></i> {{ trans('main.back') }}
				</a>

				{{ Form::submit( trans('dash.create'), array('class' => 'btn btn-success') ); }}

			{{ Form::close() }}
        
    </div>
</div>

@stop

@section('ads')
@stop