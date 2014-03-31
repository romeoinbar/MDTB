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
  <body class="nav-trans animate-nav title-page tabs-title" data-url="{{ url() }}">
@stop

@section('content')
  @include('Titles.Partials.Jumbotron')

  <section class="container push-footer-wrapper">

    <div class="yt-modal-box"></div> 
    
    <div class="row ads-row">
      @if($ad = $options->getTitleJumboAd())
        {{ $ad }}
      @endif
    </div>
    
    <div class="row responses"> @include('Partials.Response') </div>

    <div class="tab-content">
      <div class="tab-pane fade in active" id="description">
        @include('Titles.Themes.Tabs.Description')
      </div>

      <div class="tab-pane fade" id="cast">
        @include('Titles.Themes.Tabs.Cast')
      </div>

      <div class="tab-pane fade" id="reviews">
        @include('Titles.Themes.Tabs.Reviews')
      </div>

      <div class="tab-pane fade" id="similar">
        @include('Titles.Themes.Tabs.Similar')
      </div>
    </div>

    @if (isset($disqus))

      <section class="disqus row">
        <div class="bordered-heading"><span style="border-color:{{$options->getColor('warning')}};color:{{$options->getColor('warning')}}" class="text-border-top"><i class="fa fa-comments"></i> {{ trans('main.comments') }}</div>
        <div id="disqus_thread"></div>
      </section>

      @include('Titles.Partials.Disqus')

    @endif
  <div class="push"></div>
  </section>{{--container--}}

<div class="modal fade animated fadeInBig" id="img-modal">
  <div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div></div></div>
</div>


@section('scripts')

<script>
    $(document).ready(function() {
        @if(Sentry::check() and $data->getType() == 'movie')
        // Open add link modal
        $('.btn-add-link').click(function() {
            $('#link-url, #captcha').val('');

            // Get captcha
            $.ajax({
                type: 'Get',
                url: '{{url("/getCaptcha")}}'
            }).done(function(response) {
                $('#captcha-img').attr('src', response.image);
                $('#captcha-id').val(response.captcha_id);
                $('#add-link-modal').modal('show');
            });
        });

        // Reload captcha
        $('#reload-captcha').click(function() {
            $.ajax({
                type: 'Get',
                url: '{{url("/getCaptcha")}}',
                beforeSend: function() {
                    $('#captcha-img').removeAttr('src');
                }
            }).done(function(response) {
                $('#captcha-img').attr('src', response.image);
                $('#captcha-id').val(response.captcha_id);
            });
        });

        $('#add-link').click(function() {
            var title_id = {{$data->getId()}},
                language_id = $('#link-language').val(),
                url = $('#link-url').val(),
                captcha = $('#captcha').val(),
                captcha_id = $('#captcha-id').val(),
                that = this;

            $.ajax({
                type: 'Post',
                url: '{{url("/links/add")}}',
                dataType: 'Json',
                data: {
                    title_id: title_id,
                    language_id: language_id,
                    url: url,
                    captcha: captcha,
                    captcha_id: captcha_id
                },
                beforeSend: function() {
                    $('.alert').addClass('hidden');
                    $(that).button('loading');
                }
            }).done(function(response) {
                if(response.status == 'success') {
                    $('.alert-success').removeClass('hidden');
                    window.location.reload();
                } else if(response.status == 'error') {
                    var html = '';
                    for(key in response.error_msg) {
                        html += '<li>' + response.error_msg[key] + '</li>';
                    }

                    $('.alert-danger').html(html).removeClass('hidden');
                }
            }).always(function() {
                $(that).button('reset');
            });
        });

        $('#report').click(function() {
            var id = $('#link-id').val();

            $.ajax({
                type: 'Post',
                url: '{{url("links/report")}}',
                dataType: 'Json',
                data: {
                    id: id
                }
            }).done(function(response) {
                if(response.status == 'error') {
                    alert(response.error_msg);
                } else {
                    $('#reported-number').text(response.reported);
                    
                    if(response.reported == 20) {
                        window.location.reload();
                    }
                }
            });
        });
        @endif

        $('.movie-link').click(function() {
            var id = $(this).data('id'),
                username = $(this).data('username'),
                userpage = $(this).data('userpage');
            $.ajax({
                type: 'Get',
                url: '{{url()}}' + '/links/detail/' + id,
            }).done(function(response) {
                if(response.status == 'error') {
                    alert(response.error_msg);
                } else if(response.status == 'success') {
                    $('#movie-iframe').html(response.result.embed_code);
                    $('#username').attr('href', userpage).text(username);
                    $('#reported-number').text(response.result.reported);
                    $('#link-id').val(response.result.id);
                    $('#views').text(response.result.views);

                    $('#play-link-modal').modal('show');
                }
            });
        });
    });

(function ($){

  $('#imdb-rate').raty({
    readOnly: true, 
    score: '{{ $data->getImdbRating() }}', 
    path: '../assets/images',
    halfShow : true,
    number: 10,
    width: 260,
  });

  $('#mc-user-rate').raty({
    readOnly: true, 
    score: '{{ $data->getMcUserRate() }}', 
    path: '../assets/images',
    halfShow : true,
    number: 10,
    width: 260,
  });

  $('#tmdb-rate').raty({
    readOnly: true, 
    score: '{{ $data->getTmdbRating() }}', 
    path: '../assets/images',
    halfShow : true,
    number: 10,
    width: 260,
  });

   $('#mc-critic-rate').raty({
    readOnly: true, 
    score: '{{ $data->getMcCriticRate("convert") }}', 
    path: '../assets/images',
    halfShow : true,
    number: 10,
    width: 260,
  });

})(jQuery);

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