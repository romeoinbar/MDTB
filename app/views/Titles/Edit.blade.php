@extends('Main.Boilerplate')

@section('title')
	<title> {{  trans('main.edit')}} - {{{ $title->title }}} </title>
@stop

@section('bodytag')
	<body id="edit">
@stop

@section('content')

  <div class="container">

    <div class="col-sm-12">

      <h3 class="heading">{{ trans('main.edit title heading', array('title' => $title->title)) }} <i class="fa fa-pencil"></i></h3 class="heading">

      <p class="padding-top-bot"> {{ trans('main.edit title expl') }} </p>

      <div class="row"> @include('Partials.Response') </div>

      {{ Form::model($title, array('route' => array(Str::slug(trans("main.$type")) . '.update', $title->id), 'method' => 'PUT')) }}
          
        @include('Titles.Partials.CreateEditForm')

          <a type="button" href="{{ url(Str::slug(trans("main.$type")) . '/' . Request::segment(2)) }}" class="btn btn-warning">
            <i class="fa fa-arrow-left"></i> {{ trans('main.back') }}
          </a>

          <button type="submit" class="btn btn-success">{{ trans('dash.update') }}</button>
         
      {{ Form::close() }}

    </div>
  </div>


  @stop

@section('ads')
@stop