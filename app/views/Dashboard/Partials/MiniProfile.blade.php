<div id="mini-profile" class="panel panel-default dashboard-panel">
	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('users.mini profile') }}</h3>
	</div>

	<div class="panel-body">

		<div class="row">
			<i class="fa fa-user"></i> <span>{{{ $user->username }}}</span>
		</div>
		<div class="row">
			<i class="fa fa-envelope"></i> <span>{{{ $user->email }}}</span>
		</div>

		@if ( Sentry::findThrottlerByUserId($user->id)->isBanned() )
			<a href="{{url('users/'.$user->username.'/unban')}}" class="btn btn-dash-action danger-trans">{{ trans('users.unban') }}</a>
		@else
			<a href="{{url('users/'.$user->username.'/ban')}}" class="btn btn-dash-action warning-trans">{{ trans('users.ban') }}</a>
		@endif


		{{ Form::open(array('class' => 'btn', 'action' => array('UserController@destroy', $user->username), 'method' => 'DELETE')) }}
			<button class="btn btn-dash-action danger-trans" type="submit"><i class="fa fa-trash-o"></i> {{ trans('main.delete') }}</button>
		{{Form::close()}}

		
		{{ Form::open(array('class' => 'pull-right', 'action' => array('UserController@assignToGroup', $user->username))) }}
				
  			@if(isset($groups))
				<div>
					<select name="group" class="form-control success-trans" onchange="this.form.submit()">
					    <option disabled="disabled" selected>{{ trans('dash.assign group') }}</option>
    					@foreach($groups as $g)
      						<option>{{{ $g->name }}}</option>
						@endforeach
					</select>					  
				</div>
			@else
      			<p>{{ trans('dash.no groups found') }}</p> 
			@endif

		{{ Form::close() }}
	</div>
</div>