<div class="modal animated bounce" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="edit actor/char" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <div class="review-form-heading"> {{ trans('main.write a review', array('title' => $data->getTitle())) }} </div>
      </div>

      <div class="modal-body">

        <section class="review-form">

          {{ Form::open(array('route' => array(Str::slug(trans('main.movies')) . '.reviews.store'), 'data-path' => asset('assets/images'), 'data-url' => Request::url(), 'id' => 'user-review-form')) }}
            
            <p class="pull-left">{{ trans('main.your rating') }}:</p>

            <div class="row">
              <div id="rating" class="pull-left"></div>
              <div class="current pull-left"></div>
            </div>

            <div class="row" id="modal-errors"></div>
            

              @if(Helpers::loggedInUser())
                {{ Form::hidden('author', Helpers::loggedInUser()->username) }}

                {{ Form::hidden('user_id', Helpers::loggedInUser()->id) }}
              @endif
              
            {{ Form::hidden('title_id', $data->getId()) }}

            {{ Form::textarea('body', Input::old('body'), array('rows' => 15, 'class' => 'form-control')) }}
            
            <br>
          
        </section>

        <div class="modal-footer">
          <div class="col-sm-1 pull-left" id="ajax-loading">
            <img src="{{{ asset('assets/images/ajax_loader.gif') }}}" alt="Ajax loading image" class="img-responsive">
          </div>
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('main.close') }}</button>

            @if (Sentry::check())
              <button type="submit" class="btn btn-success pull-right">{{ trans('main.publish') }}</button>
            @else
              <a class="btn btn-success pull-right" href="{{ url('login') }}">{{ trans('main.login') }}</a>
            @endif

          {{ Form::close() }}
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->