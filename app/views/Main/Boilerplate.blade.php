<!DOCTYPE html>

@section('htmltag')
  <html>
@show

  <head>

    @section('title')

      <title>{{ trans('main.meta title') }}</title>

    @show

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @section('assets')

      <link rel="shortcut icon" href="{{{ asset('assets/images/favicon.ico') }}}">
      <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Ceviche+One' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Cantora+One' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Quando' rel='stylesheet' type='text/css'>

      {{ HTML::style('assets/css/styles.css') }}
      {{ HTML::style('assets/css/' . $options->getColorScheme() . '.css') }}
      {{ HTML::style('assets/css/new.css') }}
     
    @show

  </head>

  
  @section('bodytag')

    <body>

  @show

  @section('nav')

    @include('Partials.Navbar')

  @show

  @yield('content')

  @section('ads')

  @if($ad = $options->getFooterAd())

    <div class="row ads-row">{{ $ad }}</div>

  @endif

 

  @show

  <footer style="border-color:{{$options->getColor('warning')}}">
    <div class="col-sm-4"> {{ trans('main.copyright') }} &#169; <span class="brand">{{ trans('main.brand') }}</span>{{ Carbon\Carbon::now()->year }}</div>

    <section class="col-sm-6 hidden-xs">
      <a href="{{ route('privacy') }}">{{ trans('main.privacy') }}</a> |
      <a href="{{ route('tos') }}">{{ trans('main.tos') }}</a> |
      <a href="{{ route('contact') }}">{{ trans('main.contact') }}</a>
    </section>
   <div class="col-sm-2 home-social hidden-xs hidden-sm">
     
     <div id="twitter" data-url="{{ url() }}" data-text='{{ trans("main.meta description") }}' data-title="<i class='fa fa-twitter'></i>"></div>
     <div id="facebook" data-url="{{ url() }}" data-text='{{ trans("main.meta description") }}' data-title="<i class='fa fa-facebook'></i>"></div>
     <div id="pinterest" data-url="{{ url() }}" data-text='{{ trans("main.meta description") }}' data-title="<i class='fa fa-pinterest'></i>"></div>
     <div id="linkedin" data-url="{{ url() }}" data-text='{{ trans("main.meta description") }}' data-title="<i class='fa fa-linkedin'></i>"></div>

   </div>
 </footer>
 {{ HTML::script('assets/js/scripts.js') }}
  @yield('scripts')

  </body>
</html>