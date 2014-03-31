@if ( isset($news) && ! $news->isEmpty() )

	@foreach($news as $k => $n)

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
		            	<a href="{{ url("news/{$n['id']}/edit") }}" type="submit" class="btn btn-warning btn-sm">{{ trans('dash.edit') }}</a>
					@endif

		       </div>
		   </div>
		</div>

	@endforeach
</div>

@else

	<div><h3 class="reviews-not-released">{{ trans('main.no news items found') }}</h3></div>

@endif