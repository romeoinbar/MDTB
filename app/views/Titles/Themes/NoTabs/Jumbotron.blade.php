<section class="jumbotron title" style="background-image: url({{{ asset($data->getBackground()) }}})">
  <div class="transparent">
    <section class="row title-jumbo-row">
      <a href="{{ Helpers::url($data->getTitle(), $data->getId(), $data->getType()) }}" class="col-sm-2 hidden-xs hidden-sm title-poster"><img class="img-responsive" src="{{{ asset($data->getPoster()) }}}" alt="{{{ $data->getTitle() }}}"></a>
      <div class="col-sm-12 col-md-10">
        <div class="row"><a href="{{ Helpers::url($data->getTitle(), $data->getId(), $data->getType()) }}" class="title-title">{{{ $data->getTitle() }}}</a></div>
        <div class="row title-info">

          @if ($data->getRuntime())
            <span>{{ $data->getRuntime() . ' ' . trans('main.min')}}</span> - 
          @endif

          @if ($data->getGenre())
            <span>{{ $data->getGenre() }}</span> - 
          @endif

           @if ($data->getReleasedate())
            <span>{{{ $data->getReleasedate() }}}</span>
          @endif
          
        </div>

        <div class="row">
          <button type="button" class="btn trans-button trailer-trigger" data-trailer="{{{ $data->getTrailer() }}}">
            <span><i class="fa fa-play"></i> {{ trans('main.play trailer') }}</span>
          </button>
          <a type="button" href="{{{ $data->getBuyLink() }}}" class="btn trans-button">
            <span><i class="fa fa-money"></i> {{ trans('main.buy now') }}</span>
          </a>

          @if ( Helpers::hasAccess('titles.edit') )

            <a href="{{ Helpers::url($data->getTitle(), $data->getid(), $data->getType()) . '/edit' }}" type="button" class="btn trans-button">
              <span><i class="fa fa-edit"></i> {{ trans('main.edit') }}</span>
            </a>

          @endif

          <div class="title-list-btns">
            @include('Partials.TitleListButtons')
          </div>
         
        </div>

        <div class="row title-social">
        
          @unless( ! isset($disqus))
            <div><i class="fa fa-comment green-fill"></i> <a class="disqus-link" href="{{ Request::fullUrl() }}#disqus_thread"></a></div>
          @endunless
          
          <div><i class="fa fa-facebook blue-fill fix-circle"></i> <div id="facebook" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Likes"></div></div>
          <div><i class="fa fa-twitter blue-fill "></i> <div id="twitter" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Tweets"></div></div>
          <div><i class="fa fa-pinterest orange-fill "></i> <div id="pinterest" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Pin it"></div></div>
        </div>

        <div class="row title-plot">
              {{{ $data->getPlot() }}}
        </div>

        <div class="row no-mar-right" id="title-votes-row">
            <div class="col-sm-6 title-seasons">
                            
              @if ($data->getType() == 'series')

                {{ trans('main.seasons') }}:           

                @foreach ($data->getSeasons() as $v)

                  @if ($v->number == Request::segment(4))

                    <a href="{{ Helpers::season($data->getTitle(), $v) }}" class="active">{{{ $v->number }}}</a> |

                  @else

                    <a href="{{ Helpers::season($data->getTitle(), $v) }}">{{{ $v->number }}}</a> |

                  @endif

                @endforeach

                  @if (Helpers::hasAccess('titles.create'))

                    <a class="title-new-s" href="{{ Helpers::url($data->getTitle(), $data->getId(), 'series') . '/seasons/create'}}">{{ trans('main.new') }}</a>

                  @endif

              @endif
            </div>

            @if ($data->getRating())

              <div class="col-sm-6 title-vote-bar">
                <section class="title-vote-text">
                  @if($data->getImdbRating())
                    <div>{{ 'IMDb - ' . "<strong>{$data->getImdbRating()}</strong>" . '/10'}}</div>
                  @endif

                  @if($data->getMcRating())
                    <div >{{ 'Metacritic - ' . "<strong>{$data->getMcRating()}</strong>" . '/10' }}</div>
                  @endif

                   @if($data->getTmdbRating())
                    <div class="hidden-sm hidden-xs">{{ 'TMDB - ' . "<strong>{$data->getTmdbRating()}</strong>" . '/10'}}</div>
                   @endif                 
                </section>

              <div class="progress hidden-xs progress-striped">
                  <div class="progress-bar progress-bar-{{{ $data->getVoteBarColor() }}}" role="votebar" style="width: {{{ $data->getRating() }}}"></div>
                </div>
              </div>

            @endif
        </div>
      </div>

    </section>
  </div>
</section>