@extends('Main.Boilerplate')

@section('assets')

  @parent

  <meta name="title" content="{{ trans('main.meta title') }}">
  <meta name="description" content="{{ trans('main.meta description') }}">

  <meta name="keywords" content="{{ trans('main.meta keywords') }}">

@stop

@section('bodytag')
	<body id="home" class="nav-trans animate-nav">
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

	  {{--News column--}}
	  <div class="col-sm-8 home-news">
	    <div class="bordered-heading">
	    	<span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-bullhorn"></i> {{ trans('main.latest news') }}</span>

	    	@if (Helpers::hasAccess('news.update'))

					{{ Form::open(array('url' => 'news/external', 'class' => 'pull-right in-heading-form')) }}

                    	<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> {{ trans('dash.update') }}</button>

                  	{{ Form::close() }}

				@endif

	    	@if (Helpers::hasAccess('news.create'))
				<a href="{{ route(Str::slug(trans('main.news')) . '.create') }}" id="create-news" class="pull-right btn btn-info btn-xs"><i class="fa fa-pencil"></i> {{ trans('dash.create') }}</a>
			@endif
	    </div>

	  	  @foreach($news as $k => $n)

		    @if ($k == 3)

	            @if($ad = $options->getHomeNewsAd())
	            	<div class="row ads-row">{{ $ad }}</div>
	            @endif

		    @endif

		    <div class="media">
				@if ($options->scrapeNewsFully())
					<a class="pull-left hidden-xs" href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">
						<img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n->image) }}}" alt="{{ 'Image of News Item' . $k }}">
					</a>
			 	@else
			    	<a class="pull-left hidden-xs" href="{{{ $n->full_url ? $n->full_url : url('news', $n->id) }}}">
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
	  {{--news coloumn ends--}}

	  {{--in theaters now begins--}}
	  <div class="col-sm-4">
	    <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.in theaters') }}</span>

			@if (Helpers::hasAccess('titles.update'))

				{{ Form::open(array('route' => 'titles.updatePlaying', 'class' => 'pull-right in-heading-form')) }}

                	<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> {{ trans('dash.update') }}</button>

              	{{ Form::close() }}

			@endif

	    </div>

	  	  <section id="grid" class="browse-grid wookmark-fix">
 
          @foreach($playing as $k => $movie)

            <figure class="col-xs-6">

              <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">
                <img src="{{{ asset($movie['poster']) }}}" class="img-responsive" alt="{{ 'Poster of ' . $movie['title'] }}">
              </a>         
              
              <figcaption>
                <a href="{{ Helpers::url($movie['title'], $movie['id'], $movie['type']) }}">{{{ $movie['title'] }}}</a> <br>
              </figcaption>
            </figure> 

          @endforeach

        </section>

        @if (isset($facebook))

			<div class="col-sm-12 likebox">    	
				<iframe src="//www.facebook.com/plugins/likebox.php?href={{{ $facebook }}}&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
        	</div>

        @endif      
	</div>
	<div class="push"></div>
</div>{{--container--}}
 
@stop

@section('scripts')

	{{ HTML::script('assets/js/home-autocomplete.js') }}

@stop