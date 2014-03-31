@if ( isset($actors) && ! $actors->isEmpty() )

	<div id="grid3" class="browse-grid">

	@foreach($actors as $k => $r)

		<figure class="col-sm-3 col-lg-2 col-xs-6">
	    	<div class="img-container">
	    		<a href="{{Helpers::url($r['name'], $r['id'], 'people')}}">
	    			<img class ="img-responsive" src="{{str_replace('w185', 'w342', $r->image) }}" alt="{{{ $r['name'] }}}">
				</a>

		  	  <figcaption title="{{{ $r->name }}}" >
		  	  	<a href="{{Helpers::url($r['name'], $r['id'], 'people')}}">{{ $r['name'] }} </a>
		  	  </figcaption>

	    	</div>	      
	    </figure>


	@endforeach

</div>

@else

	<div><h3 class="reviews-not-released">{{ trans('main.no actors found') }}</h3></div>

@endif