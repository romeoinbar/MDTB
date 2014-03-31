<table class="table table-striped table-bordered col-sm-12 table-cast">

<thead>
  <tr>
    <th>{{ trans('main.id') }}</th>
    <th>{{ trans('main.poster') }}</th>
    <th>{{ trans('main.title') }}</th>
    <th class="hidden-xs">{{ trans('main.overview') }}</th>
    <th>{{ trans('main.number') }}</th>
    <th>{{ trans('main.action') }}</th>
  </tr>
</thead>

<tbody>
  
  @foreach($series->season as $season)

    <tr>
      <td id="id" class="col-xs-1">{{{ $season->id }}}</td>
      <td id="poster" class="col-xs-1" ><img src="{{{ asset($season->poster) }}}" alt="{{'Image of ' . $season->title }}" class="img-responsive thumb"></td>
      <td id="title" class="col-xs-1"><a href="{{ url('series/' . Request::segment(2) . '/seasons/' . $season->number) }}">{{{ $season->title }}}</a></td>
      <td id="overview" class="col-xs-7 hidden-xs">{{{ $season->overview }}}</td>
      <td id="number" class="col-xs-1">{{{ $season->number }}}</td>
      <td id="action" class ="col-xs-1" >

      <button title="{{ trans('dash.edit') }}" data-toggle="modal" data-target='#{{ "modal{$season->id}" }}' class="btn btn-warning edit-cast-btn pull-right"><i class="fa fa-edit"></i></button>

      <div class="modal animated bounce edit-season-modal" id='{{ "modal{$season->id}" }}' tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">

            <div class="row" id="modal-response"></div>

              {{ Form::model($season, array('route' => array(Str::slug(trans('main.series')) . '.seasons.store', $series->id), 'id' => 'edit-season')) }}

                <div class="form-group">
                  {{ Form::label('title', trans('main.title')) }}
                  {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                  {{ Form::label('poster', trans('main.poster path')) }}
                  {{ Form::text('poster', Input::old('poster'), array('class' => 'form-control')) }}                  
                </div>

                <div class="form-group">
                  {{ Form::label('release_date', trans('main.release date')) }}
                  {{ Form::text('release_date', Input::old('release_date'), array('class' => 'form-control')) }}               
                </div>

                <div class="form-group">
                  {{ Form::label('overview', trans('main.overview')) }}
                  {{ Form::textarea('overview', Input::old('overview'), array('class' => 'form-control', 'rows' => '7')) }}               
                </div>

                 <div class="form-group">
                  {{ Form::label('number', trans('main.number')) }}
                  {{ Form::text('number', Input::old('number'), array('class' => 'form-control')) }}               
                </div>

                {{ Form::hidden('id', $season->id) }}

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

        {{ Form::open(array('route' => array(Str::slug(trans('main.series')) . '.seasons.destroy', $series->id, $season->id), 'class' => 'pull-right', 'method' => 'delete')) }}

          <button type ="submit" title="{{ trans('dash.delete') }}" class="btn btn-danger delete-cast-btn"><i class="fa fa-trash-o"></i></button>

        {{ Form::close() }}
      </td>
    </tr>

  @endforeach

</tbody>

</table>