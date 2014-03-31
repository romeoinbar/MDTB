<section id="grid" class="order cast-grid">

    @foreach($data->getCast() as $k => $actor)

      <figure class="col-sm-2" data-order="{{{ $k }}}">

        <div class="img-container">
          
          <a href="{{ Helpers::url($actor['name'], $actor['id'], 'people') }}">
            <img src="{{{ asset($actor['image']) }}}" class="img-responsive" alt="{{ 'Picture of ' . $actor['name'] }}">
          </a>         
          
          <figcaption>
            <a href="{{ Helpers::url($actor['name'], $actor['id'], 'people') }}">{{{ $actor['name'] }}}</a> <br>

              {{{ $actor['pivot']['char_name'] }}}

          </figcaption>

        </div>

      </figure> 

    @endforeach

</section>