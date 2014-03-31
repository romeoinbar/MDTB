@extends('Main.Boilerplate')

@section('bodytag')
<body class="padding nav search-page">
@stop

@section('nav')
  @include('Partials.Navbar')
@stop

@section('content')

<div class="container push-footer-wrapper">

	<div class="row well search-well">

		<div class="col-xs-6">
			<p><i class="fa fa-search"></i> {{ trans('main.top matches for') }} <strong>{{{ $term }}}</strong></p>
		</div>

    	<div class="col-xs-6 hidden-xs">
			<ul class="btn-group">
			    <li><a id="trigger" href="#movies" class="btn" data-toggle="tab"><i class="fa visible-xs fa-users"></i><span class="hidden-xs">{{ trans('main.movies') }}</span></a></li>
			    <li><a id="trigger2" href="#series" class="btn" data-toggle="tab"><i class="fa visible-xs fa-thumbs-up"></i><span class="hidden-xs">{{ trans('main.series') }}</span></a></li>			
			    <li><a id="trigger3" href="#people" class="btn no-bord-right" data-toggle="tab"><i class="fa fa-video-camera visible-xs"></i><span class="hidden-xs">{{ trans('main.people') }}</span></a></li>
			    <li><a href="#news" class="btn no-bord-right" data-toggle="tab"><i class="fa fa-video-camera visible-xs"></i><span class="hidden-xs">{{ trans('main.news') }}</span></a></li>
			  </ul>
		 </div>

	</div>

    <div class="row"> @include('Partials.Response') </div>

		<div class="tab-content">
	      <div class="tab-pane fade in active" id="movies">
	       	@include('Search.MoviesGrid')
	      </div>

	      <div class="tab-pane fade" id="series">
	       @include('Search.SeriesGrid')
	      </div>

	      <div class="tab-pane fade" id="people">
	        @include('Search.PeopleGrid')
	      </div>

	      <div class="tab-pane fade" id="news">
	        @include('Search.NewsResults')
	      </div>
	    </div>

	
<div class="push"></div>
</div>

@stop
