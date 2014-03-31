<section id="tabs-id" data-id="{{ $data->getId() }}" class="jumbotron title" style="background-image: url({{{ asset($data->getBackground()) }}})">
  <div class="transparent">
    <section class="row title-jumbo-row">
      <a href="{{ Helpers::url($data->getTitle(), $data->getId(), $data->getType()) }}" class="col-sm-2 hidden-xs hidden-sm title-poster"><img class="img-responsive" src="{{{ asset($data->getPoster()) }}}" alt="{{{ $data->getTitle() }}}"></a>

      @if (Request::segment(1) == 'series')
        <div class="col-sm-12 col-md-10 title-jumbo-text" style="margin-top:0px">
      @else
        <div class="col-sm-12 col-md-10 title-jumbo-text">
      @endif    

        <div class="row"><a href="{{ Helpers::url($data->getTitle(), $data->getId(), $data->getType()) }}" class="title-title">{{ $data->getTitle() }}</a></div>
        <div class="row title-info">

          @if ($data->getRuntime())
            <span>{{ $data->getRuntime() . ' ' . trans('main.min')}}</span> - 
          @endif

          @if ($data->getGenre())
            <span>{{ $data->getGenre() }}</span> - 
          @endif

           @if ($data->getReleasedate())
            <span>{{ $data->getReleasedate() }}</span>
          @endif
          
        </div>

        <div class="row">
          @if ($data->getTrailer())
            <button type="button" class="btn trans-button trailer-trigger" data-trailer="{{{ $data->getTrailer() }}}">
              <span><i class="fa fa-play"></i> {{ trans('main.play trailer') }}</span>
            </button>
          @endif
          <a target="_blank" href="{{{ $data->getBuyLink() }}}" class="btn trans-button">
            <span><i class="fa fa-money"></i> {{ trans('main.buy now') }}</span>
          </a>

          @if ( Helpers::hasAccess('titles.edit') )

            <div class="btn-group">
              <button id="btnGroupDrop1" type="button" class="btn trans-button dropdown-toggle" data-toggle="dropdown">
                <span class="drop-trans"><i class="fa fa-edit"></i> {{ trans('main.edit') }}</span>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu trans-menu" role="menu" aria-labelledby="btnGroupDrop1">
                <li><a href="{{ Helpers::url($data->getTitle(), $data->getid(), $data->getType()) . '/edit' }}">{{ trans('main.edit main') }}</a></li>
                <li><a href="{{ Helpers::url($data->getTitle(), $data->getid(), $data->getType()) . '/edit-cast' }}">{{ trans('dash.edit cast') }}</a></li>
                <li><a href="{{ Helpers::url($data->getTitle(), $data->getid(), $data->getType()) . '/edit-images' }}">{{ trans('main.edit images') }}</a></li>
                @if ($data->getType() == 'series')
                  <li><a href="{{ Helpers::url($data->getTitle(), $data->getid(), 'series') . '/seasons/create' }}">{{ trans('main.edit seasons') }}</a></li>
                @endif
              </ul>
            </div>
          </div>

        @endif

        <div class="row title-social">
        
          @unless( ! isset($disqus))
            <div><i class="fa fa-comment green-fill"></i> <a class="disqus-link" href="{{ Request::fullUrl() }}#disqus_thread"></a></div>
          @endunless
          
          <div><i class="fa fa-facebook blue-fill fix-circle"></i> <div id="facebook" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Likes"></div></div>
          <div><i class="fa fa-twitter blue-fill "></i> <div id="twitter" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Tweets"></div></div>
          <div><i class="fa fa-pinterest orange-fill "></i> <div id="pinterest" data-url="{{ Request::fullUrl() }}" data-text='{{ "{$data->getTitle()} - " . trans("main.twitter txt") }}' data-title="Pins"></div></div>
        </div>

        <div class="row title-plot">
              {{ $data->getPlot(300) }}
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

                  @if (Helpers::hasAccess('titles.create') && $options->getTitleView() == 'NoTabs')

                    <a class="title-new-s" href="{{ Helpers::url($data->getTitle(), $data->getId(), 'series') . '/seasons/create'}}">{{ trans('main.new') }}</a>

                  @endif

              @endif
            </div>
        </div>
      </div>

    </section>
  </div>
</section>
<div class="btn-group btns-under-jumbo center-block" style="background-color: {{ $data->getJumboMenuColor() }}">

  <ul>
    @if(Request::segment(3) == 'seasons' && Request::segment(4))
      <li class="active"><a href="#episodes" class="btn btn-default no-bord-left" data-toggle="tab">{{ trans('main.eps') }}</a></li>
      <li><a href="#description" class="btn btn-default no-bord-left" data-toggle="tab"><i class="visible-xs fa fa-tasks"></i><span class="hidden-xs">{{ trans('main.description') }}</span></a></li>
    @else
      <li class="active"><a href="#description" class="btn btn-default no-bord-left" data-toggle="tab"><i class="visible-xs fa fa-tasks"></i><span class="hidden-xs">{{ trans('main.description') }}</span></a></li>
    @endif
    <li><a id="trigger" href="#cast" class="btn btn-default" data-toggle="tab"><i class="fa visible-xs fa-users"></i><span class="hidden-xs">{{ trans('main.cast') }} &amp; {{ trans('main.crew') }}</span></a></li>
    <li><a href="#reviews" class="btn btn-default" data-toggle="tab"><i class="fa visible-xs fa-thumbs-up"></i><span class="hidden-xs">{{ trans('main.reviews') }}</span></a></li>
      @if(Request::segment(3) == 'seasons' && Request::segment(4) && Helpers::hasAccess('titles:edit'))
      <li><a class="btn btn-default" href='{{ url(Str::slug(trans("main.series")) . "/" . $data->getId() . "/seasons/$num/episodes/create") }}'><i class="fa fa-video-camera visible-xs"></i><strong class="hidden-xs">{{ trans('main.create new epi') }}</strong></a></li>
    @endif
    <li><a id="trigger2" href="#similar" class="btn btn-default no-bord-right" data-toggle="tab"><i class="fa fa-video-camera visible-xs"></i><span class="hidden-xs">{{ trans('main.moviesseries') }}</span></a></li>
  </ul>
  
  <div class="jumbo-watchlist-btns">
    @include('Titles.Themes.Tabs.TitleListButtons')
  </div>

 
</div>