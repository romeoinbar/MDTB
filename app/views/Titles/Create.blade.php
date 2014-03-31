@extends('Main.Boilerplate')

@section('title')
	<title> {{  trans('main.create new title') . ' - ' . trans('main.brand')}} </title>
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')
    <div class="container push-footer-wrapper">

      <div class="col-sm-12">

      	<h3 class="heading">{{ trans('main.add a new title') }} <i class="fa fa-pencil"></i></h3 class="heading">

        <p class="padding-top-bot"> {{ trans('main.add new title expl') }} </p>

        <div class="row"> @include('Partials.Response') </div>

        {{ Form::open(array('route' => array(Str::slug(trans('main.movies')) . '.store'))) }}

          @include('Titles.Partials.CreateEditForm')

          {{ Form::submit(trans('dash.create'), array('class' => 'btn btn-success')) }}
          
        {{ Form::close() }}

    </div>
    <div class="push"></div>
</div>
  @stop