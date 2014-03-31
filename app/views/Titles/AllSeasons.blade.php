@extends('Main.Boilerplate')

@section('title')
	<title>{{ trans('main.overview of') }} '{{{ $data->getTitle() }}}' {{ trans('main.seasons') }} - {{ trans('main.brand') }}</title>
@stop

@section('bodytag')
  <body class="nav-trans animate-nav" id="episodes-page">
@stop

@section('content')

	@include('Titles.Partials.Jumbotron');

<div class="container">

	<div class="row">
		<a href="{{ route('series.seasons.create', $data->getId()) }}" class="btn btn-success">Add new Season</a>
	</div>
	
	@foreach($data->getSeasons() as $v)

		<div class="media col-sm-12">

			<div class="pull-left col-sm-2">
			
				<img src="{{{ $v->poster ? asset($v->poster) : asset('assets/images/noimage.jpg') }}}" alt="{{ 'Poster of ' . $v->title }}" class="media-object img-responsive thumb">

			</div>

			<div class="media-body col-sm-10">

		    	<a href="{{URL::current() . '/' . $v->number}}" class="media-heading"><h4>{{{ $v->title ? $v->title : trans_choice('main.season', 1) . $v->number}} - {{ trans('main.see all eps') }}}</h4></a>
		    	<p>{{{ $v->overview }}}</p>
		    	<span class="row grey-out">{{ trans('main.first aired') }}: {{{ $v->release_date }}}</span>

				<span class="row">
			
					{{ trans('main.first episode') }}: <a href="#">{{{ $v->episode->first()->title }}}</a>
					<br>
		    		{{ trans('main.last episode') }}: <a href="#">{{{ $v->episode->last()->title }}}</a>

		    	</span> 
		    </div>
		</div>

	@endforeach

</div>

@stop