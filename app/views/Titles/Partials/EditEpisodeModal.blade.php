<button title="{{ trans('dash.edit') }}" data-toggle="modal" data-target='#{{ "modal{$v->id}" }}' class="btn btn-warning"><i class="fa fa-edit"></i>{{ trans('main.edit ep') }}</button>

<div class="modal animated bounce edit-season-modal" id='{{ "modal{$v->id}" }}' tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">

        <div class="row" id="modal-response"></div>

          {{ Form::model($v, array('url' => url(Str::slug(trans('main.series'))) . '/' . $data->getId() . "/seasons/$num/episodes/{$v->episode_number}", 'method' => 'PUT', 'class' => 'edit-episode')) }}

            <div class="form-group">
              {{ Form::label('title', trans('main.title')) }}
              {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
              {{ $errors->first('title', "<span class='help-block alert alert-danger'>:message</span>") }}
            </div>

            <div class="form-group">
              {{ Form::label('poster', trans('main.poster path')) }}
              {{ Form::text('poster', Input::old('poster'), array('class' => 'form-control')) }}  
              {{ $errors->first('poster', "<span class='help-block alert alert-danger'>:message</span>") }}                
            </div>

            <div class="form-group">
              {{ Form::label('release_date', trans('main.release date')) }}
              {{ Form::text('release_date', Input::old('release_date'), array('class' => 'form-control')) }}
              {{ $errors->first('release_date', "<span class='help-block alert alert-danger'>:message</span>") }}         
            </div>

            <div class="form-group">
              {{ Form::label('plot', trans('main.plot')) }}
              {{ Form::textarea('plot', Input::old('plot'), array('class' => 'form-control', 'rows' => '7')) }}   
              {{ $errors->first('plot', "<span class='help-block alert alert-danger'>:message</span>") }}            
            </div>

            <div class="form-group">
              {{ Form::label('promo', trans('main.promo')) }}
              {{ Form::text('promo', Input::old('promo'), array('class' => 'form-control')) }}   
              {{ $errors->first('promo', "<span class='help-block alert alert-danger'>:message</span>") }}            
            </div>

             <div class="form-group">
              {{ Form::label('episode_number', trans('main.number')) }}
              {{ Form::text('episode_number', Input::old('episode_number'), array('class' => 'form-control')) }}  
            {{ $errors->first('episode_number', "<span class='help-block alert alert-danger'>:message</span>") }}             
            </div>

            {{ Form::hidden('title_id', $data->getId()) }}
            {{ Form::hidden('season_id', $data->getSeasons($num)->id) }}
            {{ Form::hidden('season_number', $num) }}
            {{ Form::hidden('allow_update', 0) }}
            {{ Form::hidden('updated_at', Carbon\Carbon::now()) }}

          <div class="modal-footer">
            <div class="col-sm-2 pull-left" id="ajax-loading">
              <img src="{{{ asset('assets/images/ajax_loader.gif') }}}" alt="Ajax loading image" class="img-responsive">
              <div class="row" id="ajax-loading-text">{{ trans('main.wait')}} </div>
            </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            {{ Form::submit('Confirm', array('class' => 'btn btn-success')) }}
          </div>
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>