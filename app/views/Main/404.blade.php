@extends('Main.Boilerplate')

@section('htmltag')
  <html id="not-found" class="nav-no-border" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('title')
  <title>{{ '404 - ' . trans('main.brand') }}</title>
@stop

@section('content')
  <div class="container push-footer-wrapper">
    <div class="col-sm-2"></div>

    <div class="col-sm-8 centered-box">
    
      <h1>404</h1>
      <p>{{ trans('main.404 page message') }}</p>
    
    </div>

  <div class="col-sm-2"></div>

  <div class="push"></div>

  </div>
@stop

  @section('ads')
  @stop