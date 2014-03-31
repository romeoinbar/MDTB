@if ( $user = Helpers::loggedInUser())

	@if( ! isset($watchlist[$data->getId()]))

		{{ Form::open(array('action' => 'ListsController@postAdd', 'class' => 'lists-form')) }}

			{{ Form::hidden('user', $user->id) }}
			{{ Form::hidden('title', $data->getid()) }}
			{{ Form::hidden('list', 'watchlist') }}

			<button data-user="{{{ $user->id }}}" type="submit" title="{{ trans('main.add to watchlist') }}" data-title="{{{ $data->getid() }}}" class="btn btn-default no-bord-left lists"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans('main.add to watchlist') }}</span></button>
   
		{{ Form::close() }}

	@else

		{{ Form::open(array('action' => 'ListsController@postRemove', 'class' => 'lists-form')) }}

		  {{ Form::hidden('user', $user->id) }}
		  {{ Form::hidden('title', $data->getid()) }}
		  {{ Form::hidden('list', 'watchlist') }}

		  <button data-user="{{{ $user->id }}}" type="submit" title="{{ trans('main.remove from favorites') }}" data-title="{{{ $data->getid() }}}" class="btn btn-default no-bord-left lists watchlisted"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans('main.watchlisted') }}</span></button>

		{{ Form::close() }}

	@endif

	@if ( ! isset($favorites[$data->getid()]))

		{{ Form::open(array('action' => 'ListsController@postAdd', 'class' => 'lists-form')) }}

			{{ Form::hidden('user', $user->id) }}
			{{ Form::hidden('title', $data->getid()) }}
			{{ Form::hidden('list', 'favorite') }}
		  
		  <button type="submit" data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" title="{{ trans('main.add to favorites') }}" class="btn btn-default no-bord-left lists"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm">{{ trans('main.favorite') }}</span></button>
		  
		{{Form::close()}}

	@else

		{{ Form::open(array('action' => 'ListsController@postRemove', 'class' => 'lists-form')) }}

		  {{ Form::hidden('user', $user->id) }}
		  {{ Form::hidden('title', $data->getid()) }}
		  {{ Form::hidden('list', 'favorite') }}

		  <button type="submit" data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" title="{{ trans('main.remove from favorites') }}" class="btn btn-default no-bord-left lists watchlisted"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm">{{ trans('main.favorited') }}</span></button>

		{{ Form::close() }}


	@endif

@else

	<a href="{{ url('login') }}" title="{{ trans('main.add to watchlist') }}" class="btn btn-default no-bord-left lists"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">{{ trans('main.add to watchlist')}}</span></a>
	<a href="{{ url('login') }}" title="{{ trans('main.add to favorites') }}" class="btn btn-default no-bord-left lists"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm">{{ trans('main.favorite') }}</span></a>

@endif