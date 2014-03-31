@extends('Main.Boilerplate')

@section('title')
  <title>{{{ $news->title }}} - {{ trans('main.brand') }}</title>
@stop

@section('assets')

  @parent
  
  <meta name="title" content="{{{ $news->title . ' - ' . trans('main.brand') }}}">
  <meta name="description" content="{{{ Helpers::shrtString($news->body, 200) }}}">
  <meta property="og:title" content="{{{ $news->title . ' - ' . trans('main.brand') }}}"/>
  <meta property="og:url" content="{{ Request::url() }}"/>
  <meta property="og:site_name" content="{{ trans('main.brand') }}"/>
  <meta property="og:image" content="{{ $news->image }}"/>

@stop

@section('bodytag')
  <body id="newsSingle">
@stop

@section('content')

	<div class="container push-footer-wrapper">
		
		<div class="row">
			<article class="col-sm-7">
			<div class="row">
				<h1 class="reviews-not-released">{{{ $news->title }}}</h1>			
			</div>

			<section class="row body-row">
				{{ $news->body }}
			</section>

			@if ($news->source)
				<p class="row">{{ trans('main.source') }}: <a href="{{ $news->full_url }}">{{ $news->source }}</a></p>
			@endif
		</article>
		<div class="col-sm-5">
			<div class="bordered-heading"><span class="text-border-top"><i class="fa fa-fire"></i>{{ trans('main.recent news') }}</span></div>

			@if (isset($recent) && ! empty($recent))

				@foreach($recent as $k => $n)

				    @if ($k == 3)

						<div class="row ads-row">
							{{--PLACE YOUR AD CODE HERE--}}
						</div>

				    @endif

				    <div class="media">

				    	@if ($options->scrapeNewsFully())
							<a class="pull-left hidden-xs hidden-sm" href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">
							    <img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n->image) }}}" alt="{{ 'Image of News Item' . $k }}">
							</a>
					 	@else
					    	<a class="pull-left hidden-xs" href="{{{ $n->full_url ? $n->full_url : Helpers::url($n->title, $n->id, 'news') }}}">
							    <img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n->image) }}}" alt="{{ 'Image of News Item' . $k }}">
							</a>
				      	@endif
					  

					  <div class="media-body">
					    <p class="home-news-body">



					      @if ($options->scrapeNewsFully())
								<a href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n->title }}}</a> 
						  @else
						    	<a href="{{{ $n->full_url ? $n->full_url : Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n->title }}}</a> 
					      @endif
					      	<br>
							<span class="visible-xs visible-sm">{{ Helpers::shrtString($n->body, 100) }}</span>
					     </p>

					     <span class="home-news-time pull-left"> {{ trans('main.from') }} {{{ $n->source ? $n->source : trans('main.brand') }}}
					       <span class="home-news-ago"><i class="fa fa-clock-o"></i> 
					           {{ \Carbon\Carbon::createFromTimeStamp(strtotime($n->created_at))->diffForHumans() }}
					       </span>
					     </span>
					   </div>
					</div>

			  	  @endforeach

			@endif
		</div>
		</div>

	@if (isset($disqus))
	
      <div class="row">
      	<section class="disqus row">
        	<div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-comments"></i> {{ trans('main.comments') }}</div>
            <div id="disqus_thread"></div>
        </section>

	    @include('Titles.Partials.Disqus')

      </div>
    @endif
	
	<div class="push"></div>
	</div>


@stop