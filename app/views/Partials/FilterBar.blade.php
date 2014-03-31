<div class="row btn-row">
<div class="col-xs-3 hidden-xs hidden-sm">
<div class="btn-group" id="grid-sorters">
  <button type="button" class="btn btn-sort" data-sortby="popularity">{{ trans('main.popularity') }}</button>
  <button type="button" class="btn btn-sort" data-sortby="name">{{ trans('main.title a-z') }}</button>
</div>
</div>

<div class="col-sm-12 col-md-9">
<div class="btn-group hidden-xs">	
	{{ Form::open(array('url' => $action, 'class' => 'form-inline', 'method' => 'GET')) }}

		<strong class="hidden-sm hidden-md">{{ trans('main.year') }}:</strong>

		<div class="form-group">
			{{ Form::selectYear('min_year', 1880, Carbon\Carbon::now()->addYears(5)->year,
			e(Input::get('min_year')), array('class' => 'form-control')) }}
		</div>
		{{ trans('main.to') }}
		<div class="form-group">
			{{ Form::selectYear('max_year', 1880, Carbon\Carbon::now()->addYears(5)->year,
			Input::get('max_year') ? e(Input::get('max_year')) : Carbon\Carbon::now()->addYears(5)->year, array('class' => 'form-control')) }}
		</div>
		

		<strong>{{ trans('main.rating') }}:</strong>

		<div class="form-group">
			{{ Form::selectRange('min_rating', 1, 10,
			
			e(Input::get('min_rating')), array('class' => 'form-control')) }}
		</div>
		{{ trans('main.to') }}
		<div class="form-group">
			{{ Form::selectRange('max_rating', 1, 10,
			
			Input::get('max_rating') ? e(Input::get('max_rating')) : 10, array('class' => 'form-control')) }}
		</div>
			
		<strong class="hidden-sm hidden-md">{{ trans('main.genre') }}:</strong>

		<div class="form-group">
			{{ Form::select('genre',

			array('all'       => trans('main.all'),       'action' => trans('main.action'),
				  'animation' => trans('main.animation'), 'horror'      => trans('main.horror'),
				  'drama'     => trans('main.drama'),     'fantasy'     => trans('main.fantasy'),
			      'sci'    => trans('main.sci-fi'),    'romance'     => trans('main.romance'),
			      'comedy'    => trans('main.comedy'),    'adventure'   => trans('main.adventure'),
				  'crime'     => trans('main.crime'),     'mystery'     => trans('main.mystery'),
				  'western'   => trans('main.western'),   'documentary' => trans('main.documentary')),

			Input::get('genre') ? e(Input::get('genre')) : 'action', array('class' => 'form-control')) }}
		</div>
		
		{{ Form::submit(trans('main.filter'), array('class' => 'btn btn-warning hidden-xs')) }}

	{{ Form::close() }}
	</div>
</div>
</div>