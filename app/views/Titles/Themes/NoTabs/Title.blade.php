@extends('Main.Boilerplate')

@section('title')
  <title>{{{ $data->getTitle() }}} - {{ trans('main.brand') }}</title>
@stop

@section('assets')

  @parent
  
  <meta name="title" content="{{{ $data->getTitle() . ' - ' . trans('main.brand') }}}">
  <meta name="description" content="{{{ $data->getPlot() }}}">
  <meta name="keywords" content="{{ trans('main.meta title keywords') }}">
  <meta property="og:title" content="{{{ $data->getTitle() . ' - ' . trans('main.brand') }}}"/>
  <meta property="og:url" content="{{ Request::url() }}"/>
  <meta property="og:site_name" content="{{ trans('main.brand') }}"/>
  <meta property="og:image" content="{{str_replace('w342', 'original', asset($data->getPoster()))}}"/>

@stop

@section('bodytag')
  <body class="nav-trans animate-nav" data-url="{{ url() }}">
@stop

@section('content')

  @include('Titles.Themes.NoTabs.Jumbotron')

  <section class="container push-footer-wrapper">

    <div class="yt-modal-box"></div> 

    <div class="row ads-row">
          @if($ad = $options->getTitleJumboAd())
              {{ $ad }}
          @endif
    </div>

    <div class="row responses"> @include('Partials.Response') </div>

    {{--Images row begins--}}
    <section class="row images-row">

     @if ($data->getImages())

      <div id="links">

         @foreach(array_slice($data->getImages(), 0, 6) as $k => $img)
    
          <a href="{{ asset(Helpers::original($img)) }}" class="col-sm-2 col-xs-6 image-col" data-gallery>
            <img src="{{{ asset($img) }}}" alt="{{ 'Still of ' . $data->getTitle() }}" class="img-responsive pull-left thumb lightbox">
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
     {{--Images row ends--}}
      
    {{--adapt the view based on if we have critic reviews or not--}}
    <div class="row">

      @if ( !! $data->getCriticReviews() )

        @include('Titles.Themes.NoTabs.HasCriticReviewsContent')

      @else

        @include('Titles.Themes.NoTabs.NoCriticReviewsContent')

      @endif

    </div>
    
  <div class="push"></div>
  </section>{{--container--}}

<div class="modal fade animated fadeInBig" id="img-modal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div></div></div>
</div>


@if (isset($disqus))

  <section class="container disqus">
    <div class="bordered-heading"><span class="text-border-top"><i class="fa fa-comments"></i> {{ trans('main.comments') }}</div>
    <div id="disqus_thread"></div>
  </section>

  @include('Titles.Partials.Disqus')

@endif

@section('scripts')

 <script>

   //add 0 comments to jumbotron if not already there.
  (function ($){

    if ( ! $('.disqus-link').text().trim().length)
    {
      $(".disqus-link").text('0 {{ trans("main.comments") }}');
    }

  })(jQuery);

 </script>

@stop

<noscript>{{ trans('main.enable js') }}</noscript>
    
@stop


  

