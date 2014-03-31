@extends('Main.Boilerplate')

@section('title')
  <title>{{{ $actor['name'] . '-' . trans('main.brand') }}} </title>
@stop

@section('assets')

  @parent
  
  <meta name="title" content="{{{ $actor['name'] . ' - ' . trans('main.brand') }}}">
  <meta name="description" content="{{{ $actor['bio'] }}}">
  <meta name="keywords" content="{{ trans('main.meta actor keywords') }}">
  <meta property="og:title" content="{{{ $actor['name'] . ' - ' . trans('main.brand') }}}"/>
  <meta property="og:url" content="{{ Request::url() }}"/>
  <meta property="og:site_name" content="{{ trans('main.brand') }}"/>
  <meta property="og:image" content="{{str_replace('w342', 'original', asset($actor['image']))}}"/>

@stop

@section('bodytag')
  <body id ="actor">
@stop

@section('content')

	<div class="container push-footer-wrapper">

		<div class="row">

			{{--image column begins--}}
			<section class="col-sm-3">
				<img src="{{{ asset($actor['image']) }}}" alt="{{ 'Image of ' . $actor['name'] }}" class="img-responsive thumb">
			</section>
			{{--image column ends--}}

			{{--person facts column begins--}}
			<section class="col-sm-9">

			  <h1 class="row actor-name">

			  	{{{ $actor['name'] }}}

			  	@if (Helpers::hasAccess('people.edit'))

					<a href="{{ route(Str::slug(trans('main.people')) . '.edit', $actor['id']) }}" class="btn btn-info actor-edit-btn"><i class="fa fa-edit"></i> {{ trans('main.edit') }}</a>

			  	@endif
		  	
			  </h1>

			  <section class="row">

			  	@if ($actor['bio'])
			    
			    	<p class="actor-bio">{{{ $actor['bio'] }}}</p>

			      	<br>
			    @else

			    	{{{ trans('main.no bio') . ' ' . $actor['name'] }}}.

			    @endif	      
			      <a href="{{{ $actor['full_bio_link'] }}}"><i class="fa fa-book"></i> {{ trans('main.read bio at') . ' ' . $provider }}</a> | <a href="{{ Helpers::wikiUrl($actor['name']) }}">{{ trans('main.read bio at') }} Wikipedia</a>

			    </section>			    
				<hr>

			  <dl class="dl-horizontal row">			  
			    <dt>{{ trans('main.born') }}: </dt>
			    <dd>
			      @if ($actor['birth_date'])
				    {{ Carbon\Carbon::parse($actor['birth_date'])->toFormattedDateString() }}
				  @endif

				  @if ($actor['birth_place'])
				    {{ trans('main.in') }} {{{ $actor['birth_place'] }}}
				  @endif
			    </dd>
			    
			    @if ( ! $actor->title->isEmpty())
			    	<dt>{{ trans('main.movie/tv credits') }}: </dt>
			    	<dd>{{ count($actor['title']) }}</dd>
				    <dt>{{ trans('main.first appeared') }}: </dt>
				    <dd>{{ trans('main.in the') }} {{{ $actor->title->last()->type }}} <a href="{{ Helpers::url($actor->title->last()->title, $actor->title->last()->id, $actor->title->last()->type) }}">{{{ $actor->title->last()->title }}}</a> {{{ $actor->title->last()->release_date }}}</dd>
				    <dt>{{ trans('main.latest project') }}: </dt>
				    <dd>{{{ $actor->title->first()->type }}} <a href="{{ Helpers::url($actor->title->first()->title, $actor->title->first()->id, $actor->title->first()->type) }}">{{{ $actor->title->first()->title }}} </a> {{{ $actor->title->first()->release_date }}}</dd>
				  </dl>
				@endif

			    @if ($actor['awards'])

			    	<p class="row well actor-awards">
			    		<i class="fa fa-trophy"></i> 
			       		{{{ $actor['awards'] }}}
			       	</p>

			    @endif
			    	  
			</section>
			{{--person facts column ends--}}
		</div>

		<div class="row actor-known-for">

		  <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-star"></i> {{ trans('main.known for') }}</span>

		  	@if (Helpers::hasAccess('people.edit'))
		  		<a href="{{ route('people.editFilmo', $actor['id']) }}" type="button"class="pull-right btn btn-info btn-xs"><i class="fa fa-edit"></i> {{trans('main.edit') }}</a>
		  	@endif

		  </div>

			@foreach ($actor['title'] as $v)

				@if ($v['pivot']['known_for'])

					<figure class="col-xs-3">
						<a href="{{ Helpers::url($v['title'], $v['id'], $v['type']) }}">
							<img src="{{{ asset($v['poster'] ? $v['poster'] : 'assets/images/cinema.png') }}}" alt="{{ 'Poster of ' . $v['title'] }}" class="img-responsive thumb">
						</a>
					</figure>

				@endif

			@endforeach

		</div>

		<div class="row actor-filmo">

			<div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-star"></i> {{ trans('main.filmo') }}</span>

				@if (Helpers::hasAccess('people.edit'))

					<a href="{{ route('people.editFilmo', $actor['id']) }}" type="button"class="pull-right btn btn-info btn-xs"><i class="fa fa-edit"></i> {{ trans('main.edit') }}</a>
				@endif

			</div>

			<table class="table table-condensed col-sm-12">
				<tbody>		

					@foreach ( Helpers::sortByYear($actor['title']) as $v)

			        	<tr>
			        		<td class="col-sm-1">
			        			{{{ $v['type'] == 'movie' ? trans('main.movie') : trans('main.series')}}}
			        		</td>
			        		<td class="col-sm-6">
			        			<a href="{{ Helpers::url($v['title'], $v['id'], $v['type']) }}">{{{ $v['title'] }}}</a>
			        		</td>
			        		<td class="col-sm-2">
			        			{{{ $v['release_date'] ? $v['release_date'] : $v['year']}}}
			        		</td>
			        	</tr>
			      		 
					@endforeach

				</tbody>
			</table>

		</div>
	<div class="push"></div>
	</div>

@stop