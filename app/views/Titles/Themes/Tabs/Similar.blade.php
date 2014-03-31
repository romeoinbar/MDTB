@if ( ! empty($similar) && isset($similar[1]) )

<section id="grid2" class="browse-grid">

    @foreach($similar as $k => $v)

      @unless($v->title == $data->getTitle())

        <figure class="col-sm-2">

          <div class="img-container">
            
            <a href="{{ Helpers::url($v->title, $v->id, $v->type) }}">
              <img src="{{{ $v->poster ? asset($v->poster) : asset('assets/images/imdbnoimage.jpg') }}}" class="img-responsive" alt="{{ 'Picture of ' . $v->title }}">
            </a>         
            
            <figcaption>
              <a href="{{ Helpers::url($v->title, $v->id, $v->type) }}">{{ Helpers::shrtString($v->title, 25) }}</a>
            </figcaption>

          </div>

        </figure>

      @endunless 

    @endforeach

</section>

@else

<div><h3 class="reviews-not-released"><i class="fa fa-exclamation-circle"></i> {{ trans('main.no similar movies')}}</h3></div>

@endif