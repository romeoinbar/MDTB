@if ( isset($data) && ! $data->isEmpty() )

	<div id="grid" class="browse-grid">

	@foreach($data->slice(0,12) as $k => $r)

		@if ($r->type == 'movie')

			<figure class="col-sm-3 col-lg-2 col-xs-6" data-filter-class='{{ Helpers::genreFilter($r->genre) }}' data-popularity="{{ ($r['imdb_votes_num'] ? $r['imdb_votes_num'] : $r['tmdb_popularity']) }}" data-name="{{{ $r->title }}}" data-release="{{{ $r->year }}}">
		    	<div class="img-container">
		    		<a href="{{Helpers::url($r['title'], $r['id'], $r['type'])}}">
		    			<img class ="img-responsive" src="{{str_replace('w185', 'w342', $r->poster) }}" alt="{{{ $r['title'] }}}">
					</a>

			  	  <figcaption title="{{{ $r->title }}}" >
			  	  	<a href="{{Helpers::url($r['title'], $r['id'], $r['type'])}}"> {{  Helpers::shrtString($r['title']) }} </a>
					


			  	  	<section class="row action-buttons">

			  	  		@include('Partials.AddToListButtons')

		    			@if ($r['imdb_rating'])
		    				<span class="pull-right">{{ ! str_contains($r['imdb_rating'], '.') ? $r['imdb_rating'] . '.0' : $r['imdb_rating'] }}</span>
		    			@elseif ($r['tmdb_rating'])
		    				<span class="pull-right">{{ ! str_contains($r['tmdb_rating'], '.') ? $r['tmdb_rating'] . '.0' : $r['tmdb_rating'] }}</span>
		    			@endif
		    			
			  	  	</section>

			  	  </figcaption>

		    	</div>	      
		    </figure>

		@endif

	@endforeach

</div>

@else

	<div><h3 class="reviews-not-released">{{ trans('main.no movies found') }}</h3></div>

@endif