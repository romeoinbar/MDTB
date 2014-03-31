<div class="panel dashboard-panel">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-wrench"></i> {{ trans('dash.scrape adv search', array('provider' => 'tmdb')) }}</h3>
  </div>
  <div class="panel-body">

    {{ Form::open(array('url' => 'dashboard/tmdb-discover', 'class' => 'form-horizontal')) }}

    <div class="form-group on-image col-sm-12">
      {{ Form::label('sort_by', trans('dash.sort by')) }}
      {{ Form::select('sort_by', array('popularity.desc' => trans('dash.popularity'), 'vote_average.desc' => trans('dash.votes'), 'release_date.desc' => trans('dash.year')), 'popularity.desc', array('class' => 'form-control')) }}
      {{ $errors->first('sort_by', '<span class="help-block alert alert-danger">:message</span>') }}          
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('include_adult', trans('dash.include adult')) }}
      {{ Form::select('include_adult', array('true' => trans('dash.yes'), 'false' => trans('dash.no')), 'false', array('class' => 'form-control')) }}
      {{ $errors->first('include_adult', '<span class="help-block alert alert-danger">:message</span>') }}          
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('type', trans('main.type')) }}
      {{ Form::select('type', array('movie' => trans('main.movie'), 'tv' => trans('main.series')), 'movie', array('class' => 'form-control')) }}
      {{ $errors->first('type', '<span class="help-block alert alert-danger">:message</span>') }}          
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('language', trans('dash.language')) }}
      {{ Form::text('language', '', array('class' => 'form-control')) }}
      <span class="help-block"> * {{ trans('dash.tmdb lang expl') }}.</span>
      {{ $errors->first('language', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('release_date*gte', trans('dash.from')) }}
      {{ Form::text('release_date*gte', '1980-01-01', array('class' => 'form-control')) }}
      {{ $errors->first('release_date*gte', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>
     
    <div class="form-group on-image col-sm-12">
      {{ Form::label('release_date*ite', trans('dash.from')) }}
      {{ Form::text('release_date*ite', '2015-01-01', array('class' => 'form-control')) }}
      {{ $errors->first('release_date*ite', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('howMuch', trans('dash.how much')) }}
      {{ Form::text('howMuch', 100, array('class' => 'form-control')) }}
      {{ $errors->first('howMuch', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('page', trans('dash.offset')) }}
      {{ Form::text('page', 1, array('class' => 'form-control')) }}
      {{ $errors->first('page', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>

    <button type="submit" class="btn btn-dash-action">{{ trans('dash.scrape') }}</button>

    {{ Form::close() }}
  </div>
</div>