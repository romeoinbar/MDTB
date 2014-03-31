@if ( $user = Helpers::loggedInUser())

	@if( ! isset($watchlist[$data->getId()]))

		{{ Form::open(array('action' => 'ListsController@postAdd', 'class' => 'lists-form')) }}

			{{ Form::hidden('user', $user->id) }}
			{{ Form::hidden('title', $data->getid()) }}
			{{ Form::hidden('list', 'watchlist') }}
		  
		  <button data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" type="submit" title="{{ trans('main.add to watchlist') }}" class="btn trans-button lists"><i class="fa fa-plus"></i> </button>

		{{ Form::close() }}

	@else

		{{ Form::open(array('action' => 'ListsController@postRemove', 'class' => 'lists-form')) }}

		  {{ Form::hidden('user', $user->id) }}
		  {{ Form::hidden('title', $data->getid()) }}
		  {{ Form::hidden('list', 'watchlist') }}

		  <button type="submit" title="{{ trans('main.remove from watchlist') }}" data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" class="btn trans-button lists watchlisted"><i class="fa fa-plus"></i></button>

		{{ Form::close() }}

	@endif

	@if ( ! isset($favorites[$data->getid()]))

		{{ Form::open(array('action' => 'ListsController@postAdd', 'class' => 'lists-form')) }}

			{{ Form::hidden('user', $user->id) }}
			{{ Form::hidden('title', $data->getid()) }}
			{{ Form::hidden('list', 'favorite') }}
		  
		  <button  type="submit" data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" title="{{ trans('main.add to favorites') }}" class="btn trans-button lists"><i class="fa fa-heart"></i> </button>

		{{Form::close()}}

	@else

		{{ Form::open(array('action' => 'ListsController@postRemove', 'class' => 'lists-form')) }}

		  {{ Form::hidden('user', $user->id) }}
		  {{ Form::hidden('title', $data->getid()) }}
		  {{ Form::hidden('list', 'favorite') }}

		  <button type="submit" title="{{ trans('main.remove from favorites') }}" data-user="{{{ $user->id }}}" data-title="{{{ $data->getid() }}}" class="btn trans-button lists watchlisted"><i class="fa fa-heart"></i></button>

		{{ Form::close() }}


	@endif

@else

	<a href="{{ url('login') }}" title="{{ trans('main.add to watchlist') }}" class="btn trans-button lists"><i class="fa fa-plus"></i> </a>
	<a href="{{ url('login') }}" title="{{ trans('main.add to favorites') }}" class="btn trans-button lists"><i class="fa fa-heart"></i> </a>

@endif