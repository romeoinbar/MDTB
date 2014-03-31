<table class="table table-bordered col-sm-12 table-cast">

  <thead>
    <tr>
      <th>id</th>
      <th>Image</th>
      <th>Actor</th>
      <th>Character</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    
    @foreach($title->actor as $actor)

      <tr>
        <td id="id" class="col-xs-1">{{{ $actor->id }}}</td>
        <td id="image" class="col-xs-1" ><img src="{{{ asset($actor->image) }}}" alt="{{'Image of ' . $actor->name }}" class="img-responsive thumb"></td>
        <td id="actor" class="col-xs-4"><a href="{{ Helpers::url($actor->name, $actor->id, trans('main.people')) }}">{{{ $actor->name }}}</a></td>
        <td id="char" class="col-xs-5">{{{ $actor->pivot->char_name }}}</td>
        <td id="action" class ="col-xs-1" >

        <!-- Button trigger modal -->
        <button title="{{ trans('dash.edit') }}" data-toggle="modal" data-target='#{{ "modal{$actor->id}" }}' class="btn btn-warning edit-cast-btn pull-right"><i class="fa fa-edit"></i></button>

        <!-- Modal -->
        <div class="modal animated bounce edit-cast-modal" id='{{ "modal{$actor->id}" }}' tabindex="-1" role="dialog" aria-labelledby="edit actor/char" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">

              <div class="row" id="modal-response"></div>

                {{ Form::open(array('url' => 'private/edit-cast', 'id' => 'edit-relation')) }}

                  <div class="form-group">
                    {{ Form::label('actor', 'Actor Name') }}
                    {{ Form::text('name', $actor->name, array('class' => 'form-control')) }}
                    {{ Form::hidden('id', $actor->id) }}
                    {{ Form::hidden('pivot_id', $actor->pivot->id) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('image', 'Actor image path/url') }}
                    {{ Form::text('image', $actor->image, array('class' => 'form-control')) }}                  
                  </div>

                  <div class="form-group">
                    {{ Form::label('char', 'Char Name') }}
                    {{ Form::text('char_name', $actor->pivot->char_name, array('class' => 'form-control')) }}               
                  </div>

                <div class="modal-footer">
                  <div class="col-sm-2 pull-left" id="ajax-loading">
                    <img src="{{{ asset('assets/images/ajax_loader.gif') }}}" alt="Ajax loading image" class="img-responsive">
                    <div class="row" id="ajax-loading-text">{{ trans('main.wait')}} </div>
                  </div>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  {{ Form::submit('Confirm', array('class' => 'btn btn-success')) }}
                </div>
              </div>
            </div><!-- /.modal-content -->
            {{ Form::close() }}
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

          {{ Form::open(array('url' => 'private/destroy-relation', 'class' => 'pull-right')) }}
            {{ Form::hidden('title', $title->id) }}
            {{ Form::hidden('actor', $actor->id) }}
            {{ Form::hidden('char', $actor->pivot->char_name) }}
            <button type ="submit" title="{{ trans('dash.delete') }}" class="btn btn-danger delete-cast-btn"><i class="fa fa-trash-o"></i></button>
          {{ Form::close() }}
        </td>
      </tr>

    @endforeach

  </tbody>

  </table>