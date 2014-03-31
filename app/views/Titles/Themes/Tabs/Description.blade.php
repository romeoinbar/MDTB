<section class="row images-row">

     @if ($data->getImages())

        <div id="links">

         @foreach(array_slice($data->getImages(), 0, 6) as $k => $img)
    
          <a href="{{ asset(Helpers::original($img)) }}" class="col-sm-2 col-xs-6 image-col" data-gallery>
            <img src="{{{ Helpers::thumb($img) }}}" data-num="{{ $k }}" data-original="{{ Helpers::original(asset($img)) }}" alt="{{ 'Still of ' . $data->getTitle() }}" class="img-responsive pull-left thumb lightbox">
          </a>
        
         @endforeach

        </div>

        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" >
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>

     @endif

    

</section>

<section class="row">
    <div class="col-sm-6">
        @if(Sentry::check() and $data->getType() == 'movie')
            <button type="button" class="btn btn-danger btn-add-link">
                <span><i class="fa fa-plus-square"></i>Add Link</span>
            </button>
            <div class="modal fade" id="add-link-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="modal-close" aria-hidden="true" data-dismiss="modal" type="button"></button>
                            <h4 class="modal-title"><strong>Add New Link</strong></h4>
                        </div>
                        <div class="modal-body row form-horizontal">
                            <div class="col-md-6">
                                <div class="fixed-height">
                                    <div class="alert alert-success hidden">Success</div>
                                    <div class="alert alert-danger hidden"></div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('movie-title', 'Movie', array('class' => 'col-md-4 control-label')) }}
                                    <div class="col-md-8">
                                        <input type="text" readonly value="{{$data->getTitle()}}" class="form-control" id="movie-title"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('link-language', 'Language', array('class' => 'col-md-4 control-label')) }}
                                    <div class="col-md-8">
                                        <?php
                                            $options = array();
                                            foreach($languages as $lang) {
                                                $options[$lang->id] = $lang->name;
                                            }
                                        ?>
                                        {{ Form::select('link-language', $options, null, array('class' => 'form-control'))}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('link-url', 'New Link', array('class' => 'col-md-4 control-label')) }}
                                    <div class="col-md-8">
                                        {{ Form::text('link-url', null, array('class' => 'form-control'))}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('captcha', 'Captcha', array('class' => 'col-md-4 control-label')) }}
                                    <div class="col-md-8">
                                        {{ Form::text('captcha', null, array('class' => 'form-control', 'id' => 'captcha'))}}
                                        <a href="javascript:void(0)" id="reload-captcha">Reload captcha</a>
                                        <img id="captcha-img" width="100%" />
                                        {{ Form::hidden('captcha_id', null, array('id' => 'captcha-id'))}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger col-md-4" id="add-link" data-loading-text="Adding...">Add Link</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('Partials.AddLinkTerm')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($data->getTagline())
            <h3>{{{ $data->getTagline() }}}</h3>
        @endif

        @if ($data->getPlot())
            <p>{{{ $data->getPlot() }}}</p>
        @endif

        @if ($data->getAwards())

        <p class="row well actor-awards" style="background-color:{{ $data->getJumboMenuColor() }}">
            <i class="fa fa-trophy"></i> 
            {{{ $data->getAwards() }}}
        </p>

        @endif

        @if ($custom = $data->getCustomField())
            <p>{{ $custom }} </p>
        @endif

        @if($data->getType() == 'movie')
            @foreach($data->getMovieLinks() as $index => $links)
            <p>
                Link <img src="{{url($languages[$index]->icon)}}" data-title="{{$languages[$index]->name}}" />
                @foreach($links as $key => $link)
                    <?php
                        $user = $link->user; 
                        $userpage = url('/users'). '/'. $user->id. '-'. $user->username;
                    ?>
                    <a data-id="{{$link->id}}" data-username="{{$user->username}}" data-userpage="{{$userpage}}" class="movie-link" href="javascript:void(0)">{{$key + 1}}</a>
                @endforeach
            </p>
            @endforeach

            <div class="modal fade" id="play-link-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="modal-close" aria-hidden="true" data-dismiss="modal" type="button"></button>
                            <h4 class="modal-title">
                                <strong>{{$data->getTitle()}}</strong>
                                <span id="reported" class="pull-right">
                                    <input type="hidden" id="link-id">
                                    <a href="javascript:void(0)" id="report">
                                        <img src="{{url('assets/images/report_link.png')}}" width="24" />
                                        Dead Link
                                    </a>
                                    (<span id="reported-number"></span>)
                                </span>
                            </h4>
                        </div>
                        <div class="modal-body row">
                            <p id="movie-iframe"></p>
                            <p>
                                <span class="pull-left">
                                    <strong>Added by:</strong> <a id="username"></a>
                                </span>
                                <span class="pull-right">
                                    <strong><span id="views"></span> Views</strong>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-5">

        <h3>{{ trans('main.details') }}</h3>

        <dl class="dl-horizontal title-desc-crew">
                
            <div class="title-dt-group">
                @if ($directors = $data->getDirectors())

                    <dt>{{ trans('main.directors') }}:</dt>
                    <dd>
                        @foreach($directors as $d)
                            {{{ $d['name'] }}},
                        @endforeach
                    </dd>

                @endif
            </div>

            <div class="title-dt-group">
                @if ($writers = $data->getWriters())

                    <dt>{{ trans('main.writing') }}:</dt>
                    <dd>
                        @foreach($writers as $w)
                            {{{ $w['name'] }}},
                        @endforeach
                    </dd>


                @endif
            </div>

            <div class="title-dt-group">
                @if ($stars = array_slice($data->getCast(), 0, 3))

                    <dt>{{ trans('main.stars') }}:</dt>
                    <dd>
                        @foreach($stars as $s)
                            <a href="{{ Helpers::url($s['name'], $s['id'], 'people') }}">{{{ $s['name'] }}}</a>,
                        @endforeach
                    </dd>

                @endif
            </div>

            @if ($country = $data->getCountry())
                <div class="title-dt-group">
                    <dt>{{ trans('main.country') }}:</dt>
                    <dd>{{{ $country }}}</dd>               
                </div>
            @endif

            @if ($language = $data->getLanguage())
                <div class="title-dt-group">
                    <dt>{{ trans('main.lang') }}:</dt>
                    <dd>{{{ $language }}}</dd>              
                </div>
            @endif

            @if ($data->getRating())

                <h3>{{ trans('main.ratings') }}</h3>

            @endif

            <div class="title-ratings">
                @if ($imdb = $data->getImdbRating())
                    <dt>IMDb {{ trans('main.rating') }}:</dt>           
                    <dd id="imdb-rate"><strong class="pull-right">({{ $imdb }}/10)</strong></dd>
                @endif          
            </div>

            <div class="title-ratings">
                @if ($mcUser = $data->getMcUserRate())
                    <dt>Metacritic {{ trans('main.user') }}:</dt>           
                    <dd id="mc-user-rate"><strong class="pull-right">({{ $mcUser }}/10)</strong></dd>
                @endif
            </div>

            <div class="title-ratings">
                @if ($mcCritic = $data->getMcCriticRate())
                    <dt>Metacritic {{ trans('main.critic') }}:</dt>         
                    <dd id="mc-critic-rate"><strong class="pull-right">({{ $mcCritic }}/10)</strong></dd>
                @endif
                <div class="raty"></div>
            </div>

            <div class="title-ratings">
                @if ($tmdb = $data->getTmdbRating() && Carbon\Carbon::parse($data->getReleaseDate()) < Carbon\Carbon::now()->toDateString())
                    <dt>TMDB {{ trans('main.rating') }}:</dt>           
                    <dd id="tmdb-rate"><strong class="pull-right">({{ $tmdb }}/10)</strong></dd>
                @endif
            </div>

            @if ($data->getBudget() || $data->getRevenue())
                <h3>{{ trans('main.box office') }}</h3>
            @endif
            
            @if ($budget = $data->getBudget())
                <div class="title-ratings">         
                    <dt>{{ trans('main.budget') }}:</dt>            
                    <dd>{{ $budget }}</dd>              
                </div>
            @endif

            @if ($revenue = $data->getRevenue())
                <div class="title-ratings">         
                    <dt>{{ trans('main.revenue') }}:</dt>           
                    <dd>{{ $revenue }}</dd>             
                </div>
            @endif

        </dl>

    </div>
</section>