@extends('Main.Boilerplate')

@section('title')
	<title>{{ trans('main.news archive') }} - {{ trans('main.brand') }}</title>
@stop

@section('bodytag')
	<body class="padding nav" id="master-news">
@stop

@section('content')
	
	<div class="container push-footer-wrapper">

		<div class="row"> @include('Partials.Response') </div>
		
		@if ( ! $news->isEmpty() )

			<div class="col-sm-10 action-row">

				{{ $news->links() }}
				
				@if (Helpers::hasAccess('news.create'))
					<a href="{{ route(Str::slug(trans('main.news')) . '.create') }}" id="create-news" class="pull-right btn btn-success"><i class="fa fa-pencil"></i> {{ trans('dash.create') }}</a>
				@endif

				@if (Helpers::hasAccess('news.update'))

					{{ Form::open(array('url' => 'news/external', 'class' => 'pull-right form-update-news')) }}

                    	<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> {{ trans('dash.update') }}</button>

                  	{{ Form::close() }}

				@endif

				

			</div>

			@foreach($news as $k => $n)

				@unless($options->scrapeNewsFully() && $n->fully_scraped && strlen($n->body) < 350)

					@if ($k == 3)

						<div class="row ads-row">
							{{--PLACE YOUR AD CODE HERE--}}
						</div>

			    	@endif

					<div class="media col-sm-12">
						@if ($options->scrapeNewsFully())
							<a class="pull-left hidden-xs" href="{{{ Helpers::url($n->title, $n->id, 'news') }}}">
								<img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n['image']) }}}" alt="{{ 'Image of News Item' . $k }}">
							</a>
					 	@else
					    	<a class="pull-left hidden-xs" href="{{{ $n['full_url'] ? $n['full_url'] : Helpers::url($n->title, $n->id, 'news') }}}">
							    <img style="max-width:235px" class="media-object img-responsive" src="{{{ asset($n['image']) }}}" alt="{{ 'Image of News Item' . $k }}">
							</a>
				      	@endif

						<div class="media-body">
							@if ($options->scrapeNewsFully())
								<h4 class="media-heading"><a href="{{{  Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n['title'] }}}</a> 
						 	@else
						    	<h4 class="media-heading"><a href="{{{  $n['full_url'] ? $n['full_url'] : Helpers::url($n->title, $n->id, 'news') }}}">{{{ $n['title'] }}}</a> 
					      	@endif
							</h4>

					    	<p class="home-news-body">

					      		{{ Helpers::shrtString($n['body'], $options->getNewsExeLen()) }}

					     	</p>

					     	<div class="home-news-time col-sm-12 no-padding"> {{ trans('main.from') }} {{{ $n['source'] ? $n['source'] : trans('main.brand') }}}
					       		<span class="home-news-ago"><i class="fa fa-clock-o"></i> 
					           		{{ \Carbon\Carbon::createFromTimeStamp(strtotime($n['created_at']))->diffForHumans() }}
					       		</span>

								@if ($n['full_url'] && ! $options->scrapeNewsFully())							
									<a href="{{{ $n['full_url'] ? $n['full_url'] : Helpers::url($n->title, $n->id, 'news') }}}">{{ trans('main.read full article') }} <i class="fa fa-external-link"></i></a>
								@else
									<a href='{{ Helpers::url($n->title, $n->id, 'news') }}'>{{ trans('main.read full article') }} <i class="fa fa-external-link"></i></a>
								@endif

					       </div>
					       <div class="col-sm-12 edit-btns-row">

					        	@if(Helpers::hasAccess('news.delete'))
					        		{{ Form::open(array('action' => array('NewsController@destroy', $n['id']), 'class' => 'pull-left padd-right', 'method' => 'delete')) }}
					               		<button type="submit" class="btn btn-danger btn-sm">{{ trans('dash.delete') }}</button>
					           		{{ Form::close() }}
					        	@endif

					        	@if(Helpers::hasAccess('news.edit'))
					            	<a href="{{ Helpers::url($n->title, $n->id, 'news') . '/edit' }}" type="submit" class="btn btn-warning btn-sm">{{ trans('dash.edit') }}</a>
								@endif

								@if ($n->source != 'ScreenRant')
									<div class="news-master-share">
								  		<div class="news-master-share-inner" data-image="{{ $n->image }}" data-url="{{ Helpers::url($n->title, $n->id, 'news') }}" data-text="{{ $n->title }}"></div>
									</div>
								@endif

					       </div>
					   </div>
					</div>

				@endunless

			@endforeach

			<div class="col-sm-10 bot-pagination">{{ $news->links() }}</div>

		@else

			{{ trans('main.no news found') }}

		@endif

	<div class="push"></div>
</div>

<div class="row"></div>

@stop