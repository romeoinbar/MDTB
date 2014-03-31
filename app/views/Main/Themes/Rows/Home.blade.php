@extends('Main.Boilerplate')

@section('assets')

  @parent

  <meta name="title" content="{{ trans('main.meta title') }}">
  <meta name="description" content="{{ trans('main.meta description') }}">

  <meta name="keywords" content="{{ trans('main.meta keywords') }}">

@stop

@section('bodytag')
	<body id="home-rows" class="nav-trans animate-nav">
@stop

@section('nav')
	@include('Partials.Navbar')
@stop

@section('content')
 
  @include('Partials.Jumbotron')

    <div class="home container push-footer-wrapper">

      <div class="row ads-row">
	      @if($ad = $options->getHomeJumboAd())
	          {{ $ad }}
	      @endif
      </div>

    	<div class="yt-modal-box"></div>

    	@include('Partials.Response')

	  {{--in theaters now begins--}}
	  <div class="col-sm-12">
	    <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.in theaters') }}</span>

			@if (Helpers::hasAccess('titles.update'))

				{{ Form::open(array('route' => 'titles.updatePlaying', 'class' => 'pull-right in-heading-form')) }}

                	<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> {{ trans('dash.update') }}</button>

              	{{ Form::close() }}

			@endif

	    </div>

	  	  <section class="browse-grid">
 
	          @foreach($playing->slice(0, 12) as $k => $movie)

	            <figure class="col-sm-2">

	              <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">
	                <img src="{{{ asset($movie['poster']) }}}" class="img-responsive" alt="{{ 'Poster of ' . $movie['title'] }}">
	              </a>         
	              
	              <figcaption title="{{{ $movie['title'] }}}" >
	                <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">{{{ Helpers::shrtString($movie['title']) }}}</a> <br>
	              </figcaption>
	            </figure> 

	          @endforeach

        </section>

        @if (isset($upcoming) && ! $upcoming->isEmpty())

			<section class="browse-grid">

				 <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.upcoming') }}</span></div>
 
		          @foreach($upcoming as $k => $movie)

		            <figure class="col-sm-2">

		              <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">
		                <img src="{{{ asset($movie['poster']) }}}" class="img-responsive" alt="{{ 'Poster of ' . $movie['title'] }}">
		              </a>         
		              
		              <figcaption title="{{{ $movie['title'] }}}" >
		                <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">{{{ Helpers::shrtString($movie['title']) }}}</a> <br>
		              </figcaption>
		            </figure> 

		          @endforeach

	        </section>

        @endif
		
		<div class="row">
	        <div class="col-sm-7">

	        	<div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.latest news') }}</span></div>
	        	
				@foreach($news->slice(0,6) as $k => $n)

			    @if ($k == 3)

					@if($ad = $options->getHomeNewsAd())
				        <div class="ads-row">{{ $ad }}</div>
				    @endif

			    @endif

			    <div class="media">
					@if ($options->scrapeNewsFully())
						<a class="pull-left hidden-xs" href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">
							<img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n->image) }}}" alt="{{ 'Image of News Item' . $k }}">
						</a>
				 	@else
				    	<a class="pull-left hidden-xs" href="{{{ $n->full_url ? $n->full_url : Helpers::url($n->title, $n->id, 'news') }}}">
						    <img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n->image) }}}" alt="{{ 'Image of News Item' . $k }}">
						</a>
			      	@endif

				  <div class="media-body">

				  	@if ($options->scrapeNewsFully())
						<h4 class="media-heading"><a href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n['title'] }}}</a> </h4>
				   @else
				       <h4 class="media-heading"><a href="{{{ $n['full_url'] ? $n['full_url'] : Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n['title'] }}}</a> </h4>
			       @endif
				    

				    <p class="home-news-body">

				      {{ Helpers::shrtString($n['body'], $options->getNewsExeLen()) }}

				     </p>

				     <span class="home-news-time pull-left"> {{ trans('main.from') }} {{{ $n['source'] ? $n['source'] : trans('main.brand') }}}
				       <span class="home-news-ago"><i class="fa fa-clock-o"></i> 
				           {{ \Carbon\Carbon::createFromTimeStamp(strtotime($n['created_at']))->diffForHumans() }}
				       </span>

				       @if ($options->scrapeNewsFully())
							<a href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">{{ trans('main.read full article') }} <i class="fa fa-external-link"></i></a>
					   @else
					       <a href="{{{ $n['full_url'] ? $n['full_url'] : Helpers::url($n->title, $n->id, 'news') }}}">{{ trans('main.read full article') }} <i class="fa fa-external-link"></i></a>
				       @endif

				     </span>
				   </div>
				</div>

		  	  @endforeach
		    </div>

	        <div class="col-sm-5">
		    	
				@if ($latest && $latest->review)

					<div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.reviews for', array('title' => Helpers::shrtString($latest->title, 20))) }}</span></div>

			      @foreach($latest->review->slice(0,4) as $k => $r)

			         @if ($k == 4)

			            <div class="row ads-row">
			              {{--PLACE YOUR AD CODE HERE--}}
			            </div>

			            {{--<hr>--}}

			         @endif

			        <div class="row review-info">
			          <span class="review-score"><span>{{{ $r['score'] }}}</span></span> {{ trans('main.by') }} 

			          @if ($r['author'])
			            <strong>{{{ $r['author'] }}}</strong> - 
			          @endif

			          <strong>{{{ $r['source'] }}}</strong>
			        </div>

			        <p class="review-body">{{{ $r['body'] }}}</p>

			        @if ($r['link'])
			        	<p class="row review-full">
				          <a href="{{{ $r['link'] }}}">{{ trans('main.full review') }} <i class="icon-share-alt"></i></a>	        
			      		</p>
			        @endif
			        
		            <hr> 

		      	  @endforeach
		      	@endif
				
				@if (isset($facebook))

					<div class="col-sm-12 likebox">    	
						<iframe src="//www.facebook.com/plugins/likebox.php?href={{{ $facebook }}}&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
	        		</div>

	        	@endif
	    	</div>
	    </div>
    </div>
    <div class="col-sm-12">
    	 @if (isset($actors) && ! $actors->isEmpty())

			<section class="browse-grid">

				 <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.popular actors') }}</span></div>
 
		          @foreach($actors as $k => $v)

		            <figure class="col-sm-2">

		              <a href="{{ Helpers::url($v['name'], $v['id'], 'people') }}">
		                <img src="{{{ asset($v['image']) }}}" class="img-responsive" alt="{{ 'Poster of ' . $v['name'] }}">
		              </a>         
		              
		              <figcaption>
		                <a href="{{ Helpers::url($v['name'], $v['id'], 'people') }}">{{{ $v['name'] }}}</a> <br>
		              </figcaption>
		            </figure> 

		          @endforeach

	        </section>

        @endif
    </div>
</div>
<div class="push"></div>
 
@stop

@section('scripts')

	{{ HTML::script('assets/js/home-autocomplete.js') }}

@stop