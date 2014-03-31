@extends('Main.Boilerplate')

@section('title')
	<title>{{ trans('main.overview of') }} '{{{ $data->getTitle() }}}' {{ trans_choice('main.season', 1) }} {{{ $num }}} - {{ trans('main.brand') }}</title>
@stop

@section('bodytag')
  <body class="nav-trans animate-nav title-page" id="episodes-page">
@stop

@section('content')

	@if ($options->getTitleView() == 'NoTabs')
    @include('Titles.Themes.NoTabs.Jumbotron')
  @else
    @include('Titles.Partials.Jumbotron')
  @endif
  
<div class="container push-footer-wrapper">

<div class="yt-modal-box"></div>

  @if (Helpers::hasAccess('titles.create') && $options->getTitleView() == 'NoTabs')

    <a class="btn btn-success pull-right" href='{{ url("series/" . $data->getId() . "/seasons/$num/episodes/create") }}'>{{ trans('main.create new epi') }}</a>

  @endif

	<br>
  <div class="row" id="responses"> @include('Partials.Response') </div>

    <div class="tab-content">
       <div class="tab-pane fade in active" id="episodes">
        @include('Titles.Themes.Tabs.EpisodeList')
      </div>

      <div class="tab-pane fade" id="description">
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
</div>{{--container--}}


@section('scripts')
<script>
    $(document).ready(function() {
        @if(Sentry::check())
        // Open add link modal
        $('.btn-add-episode-link').click(function() {
            var season_number = $(this).data('season_number'),
                episode_number = $(this).data('episode_number'),
                title_id = $(this).data('title_id'),
                episode_id = $(this).data('episode_id');

            $('#s_num').val(season_number);
            $('#e_num').val(episode_number);
            $('#title_id').val(title_id);
            $('#episode_id').val(episode_id);

            $('#link-url, #captcha').val('');

            // Get captcha
            $.ajax({
                type: 'Get',
                url: '{{url("/getCaptcha")}}'
            }).done(function(response) {
                $('#captcha-img').attr('src', response.image);
                $('#captcha-id').val(response.captcha_id);
                $('#add-episode-link-modal').modal('show');
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

        // Submit link
        $('#add-episode-link').click(function() {
            var title_id = $('#title_id').val(),
                episode_id = $('#episode_id').val(),
                language_id = $('#link-language').val(),
                url = $('#link-url').val(),
                captcha_id = $('#captcha-id').val(),
                captcha  = $('#captcha').val();
                that = this;

            $.ajax({
                type: 'Post',
                url: '{{url("/links/add")}}',
                dataType: 'Json',
                data: {
                    title_id: title_id,
                    episode_id: episode_id,
                    language_id: language_id,
                    url: url,
                    captcha_id: captcha_id,
                    captcha: captcha
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

        $('.episode-link').click(function() {
            var id = $(this).data('id'),
                username = $(this).data('username'),
                userpage = $(this).data('userpage'),
                episode_number = $(this).data('episode-number'),
                link_number = $(this).data('link-number');

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

                    $('#username').attr('href', userpage).text(username);
                    $('#episode-number').text(episode_number);
                    $('#link-number').text(link_number);
                    $('#play-episode-link-modal').modal('show');
                }
            });
        });
    });

    (function( $ ){
        $(".edit-episode").submit(function(e) {
            e.preventDefault();

            var url = $(this).attr('action');

            $.ajax({
              url: url,
              type: "POST",
              datatype: "json",
              data: $(this).serialize(),
              beforeSend: function()
              {
                $('#ajax-loading').show();
              }
            }).done(function(data) {
              if (data == 'success')
              {
                $('.edit-season-modal').modal('hide')

                $('#responses').html('<div class="alert alert-success alert-dismissable">{{ trans("main.ajax edit episode success") }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
              }
              else
              {
                $('#modal-response').html('<div class="alert alert-danger alert-dismissable">' + data + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>') 
              }

              $('#ajax-loading').hide();      
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                $('#ajax-loading').hide();
                alert('Something went wrong on our end, sorry.');
            });

            return false;

        });
    })( jQuery );

</script>

@stop

@stop