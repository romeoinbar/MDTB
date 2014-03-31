<div class="panel dashboard-panel">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-wrench"></i> {{ trans('dash.scrape adv search', array('provider' => 'imdb')) }}</h3>
  </div>
  <div class="panel-body">


    {{ Form::open(array('url' => 'dashboard/imdb-advanced', 'class' => 'form-horizontal')) }}

    <div class="form-group on-image col-sm-12">
      {{ Form::label('from', trans('dash.from')) }}
      {{ Form::text('from', 1980, array('class' => 'form-control')) }}
      {{ $errors->first('from', '<span class="help-block alert alert-danger">:message</span>') }}          
    </div>           

    <div class="form-group on-image col-sm-12">
      {{ Form::label('to', trans('dash.to')) }}
      {{ Form::text('to', 2015, array('class' => 'form-control')) }}
      {{ $errors->first('to', '<span class="help-block alert alert-danger">:message</span>') }}
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('minVotes', trans('dash.min votes')) }}
      {{ Form::text('minVotes', 2000, array('class' => 'form-control')) }}
      {{ $errors->first('minVotes', '<span class="help-block alert alert-danger">:message</span>') }}          
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('minRating', trans('dash.min rating')) }}
      {{ Form::text('minRating', 4, array('class' => 'form-control')) }}
      {{ $errors->first('minRating', '<span class="help-block alert alert-danger">:message</span>') }}         
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('howMuch', trans('dash.how much')) }}
      {{ Form::text('howMuch', 1000, array('class' => 'form-control')) }}  
      {{ $errors->first('howMuch', '<span class="help-block alert alert-danger">:message</span>') }}            
    </div>

    <div class="form-group on-image col-sm-12">
      {{ Form::label('offset', trans('dash.offset')) }}
      {{ Form::text('offset', Input::old('offset'), array('class' => 'form-control', 'placeholder' => '1000...')) }}   
      {{ $errors->first('offset', '<span class="help-block alert alert-danger">:message</span>') }}            
    </div>

    <button type="submit" class="btn btn-dash-action">{{ trans('dash.scrape') }}</button>


    {{ Form::close() }}

  </div>
</div>