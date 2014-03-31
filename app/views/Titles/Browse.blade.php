@extends('Main.Boilerplate')

@section('bodytag')
	<body class="padding nav" data-url="{{ url() }}">
@stop


@section('content')

  <div class="browse container push-footer-wrapper">

  <div class="row pagination-top">{{ $data->appends(array())->links() }}

  	@if(Helpers::hasAccess('titles.create'))	
  		<a style="margin-bottom:10px" href="{{ url(Str::slug(trans('main.movies')) . '/create') }}" class="pull-right hidden-xs btn btn-success">{{ trans('main.create new') }}</a>
  	@endif
  	
  </div>

	@include('Partials.FilterBar', array('action' => Str::slug(head(Request::segments()))))
			
	<div class="row"> @include('Partials.Response') </div>
    
    <div id="grid" class="browse-grid">	
		
		@if ( ! $data->isEmpty())

			
			@foreach($data as $k => $r)

			    <figure class="col-sm-3 col-lg-2 col-xs-6" data-filter-class='{{ Helpers::genreFilter($r->genre) }}' data-popularity="{{ $r['mc_num_of_votes'] ? $r['mc_num_of_votes'] : ($r['imdb_votes_num'] ? $r['imdb_votes_num'] : $r['tmdb_popularity'])}}" data-name="{{{ $r->title }}}" data-release="{{{ $r->year }}}">
			    	<div class="img-container">
			    		<a href="{{Helpers::url($r['title'], $r['id'], $r['type'])}}">
			    			<img class ="img-responsive" src="{{str_replace('w185', 'w342', $r->poster) }}" alt="{{{ $r['title'] }}}">
						</a>

				  	  <figcaption title="{{{ $r->title }}}" >
				  	  	<a href="{{Helpers::url($r['title'], $r['id'], $r['type'])}}"> {{  Helpers::shrtString($r['title']) }} </a>
						


				  	  	<section class="row action-buttons">

				  	  		@include('Partials.AddToListButtons')

			    			
			    			@if ($r['mc_critic_score'])
								<span class="pull-right">{{ substr($r['mc_critic_score'], 0, -1) . '/10' }}</span>
							@elseif ($r['imdb_rating'])
			    				<span class="pull-right">{{ ! str_contains($r['imdb_rating'], '.') ? $r['imdb_rating'] . '.0' : $r['imdb_rating'] . '/10'}} </span>
			    			@elseif ($r['tmdb_rating'])
			    				<span class="pull-right">{{ ! str_contains($r['tmdb_rating'], '.') ? $r['tmdb_rating'] . '.0' : $r['tmdb_rating'] . '/10'}}</span>
			    			@endif
			    			
				  	  	</section>

				  	  </figcaption>

			    	</div>	      
			    </figure>

		    @endforeach

		@else
			<div><h3 class="reviews-not-released"> {{ trans('main.no results') }}</h3></div>
		@endif
     
	</div> 
	{{ $data->appends(array())->links() }}
<div class="push"></div>				
</div>

@stop
