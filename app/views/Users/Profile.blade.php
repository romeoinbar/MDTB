@extends('Main.Boilerplate')

@section('title')

	<title>{{{ $user->username }}} - {{ trans('users.profile') }}</title>

@stop

@section('bodytag')
	<body class="padding nav user-profile">
@stop

@section('content')
	
	<div class="container push-footer-wrapper">
		
		@include('Users.Partials.Header')

		<div class="lists-wrapper">

			@include('Partials.FilterBar', array('action' => Helpers::url($user->username, $user->id, 'users') . '/' .Request::segment(3)))

			<div id="grid" class="browse-grid">

				@foreach (Request::segment(3) == 'favorites' ? $favorite : $watchlist as $w)
				
					<figure class="col-sm-3 col-lg-2 col-xs-6" data-filter-class='{{ Helpers::genreFilter($w['genre']) }}' data-popularity="{{{ $w['imdb_votes_num'] }}}" data-name="{{{ $w['title'] }}}" data-release="{{{ $w['year'] }}}">
				    	<div class="img-container">
				    		<a href="{{Helpers::url($w['title'], $w['id'], $w['type'])}}">
				    			<img class ="img-responsive" src="{{{ $w['poster'] ? asset($w['poster']) : asset('assets/images/imdbnoimage.jpg') }}}" alt="{{{ $w['title'] }}}">
							</a>

					  	  <figcaption title="{{{ $w['title'] }}}" >
					  	  	<a href="{{Helpers::url($w['title'], $w['id'], $w['type'])}}"> {{  Helpers::shrtString($w['title']) }} </a>

					  	  	@if(Helpers::isUser($user->username))
							
						  	  	{{ Form::open(array('url' => 'lists/remove', 'class' => 'trash-ico pull-right')) }}

						  	  	  {{ Form::hidden('title', $w['id']) }}
						  	  	  {{ Form::hidden('user', $user->id) }}
						  	  	  {{ Form::hidden('list', Request::segment(3) == 'favorites' ? 'favorite' : 'watchlist') }}
						  	  	  {{ Form::hidden('name', $w['title']) }}

				                  <button type = "submit" title="{{ trans('dash.remove') }}" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> </button> 
				                {{ Form::close() }}

				            @endif
					  	  </figcaption>

				    	</div>	      
				    </figure>
				@endforeach
			</div>

			@if (Request::segment(3) == 'favorites')
				{{ $favorite->appends(array())->links() }}
			@else
				{{ $watchlist->appends(array())->links() }}
			@endif
				
		</div>
	<div class="push"></div>
	</div>

@stop

@section('ads')
@stop
