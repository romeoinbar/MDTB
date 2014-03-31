@extends('Main.Boilerplate')

@section('bodytag')
	<body class="padding nav">
@stop


@section('content')

  <div class="container push-footer-wrapper">

  <div class="row pagination-top">{{ $actors->links() }}

  	@if(Helpers::hasAccess('people.create'))	
  		<a href="{{ route(Str::slug(trans('main.people')) . '.create') }}" class="pull-right btn btn-success">{{ trans('main.create new') }}</a>
  	@endif
  	
  </div>

	
	<div class="row"> @include('Partials.Response') </div>
    
    <div id="grid" class="browse-grid">	

		@foreach($actors as $k => $r)

		    <figure class="col-sm-3 col-lg-2 col-xs-6" data-age="{{{ $r['birth_date'] }}}" data-name="{{{ $r['name'] }}}">
		    	<div class="img-container">
		    		<a href="{{ Helpers::url($r['name'], $r['id'], 'people') }}">
		    			<img class ="img-responsive" src="{{ str_replace('w185', 'w342', asset($r['image'])) }}" alt="{{{ $r['name'] }}}">
					</a>

			  	  <figcaption name="{{{ $r['name'] }}}" >
			  	  	<a href="{{ Helpers::url($r['name'], $r['id'], 'people') }}"> {{  Helpers::shrtString($r['name']) }} </a>

			  	  	<section class="row action-buttons">

			  	  		@if (Helpers::hasAccess('people.delete'))
						
							{{ Form::open(array('route' => array(Str::slug(trans('main.people')) . '.destroy', $r['id']), 'method' => 'delete')) }}

							  <button type="submit" title="{{ trans('main.delete') }}" class="btn btn-danger-drk btn-xs"><i class="fa fa-trash-o"></i> </button>

							{{ Form::close() }}

			  	  		@endif

						@if (Helpers::hasAccess('people.edit'))

							<a href="{{ route(Str::slug(trans('main.people')) . '.edit', $r['id']) }}" title="{{ trans('main.edit') }}" class="btn btn-warning btn-xs actor-edit-sm"><i class="fa fa-edit"></i> </a>

						@endif
		    			
			  	  	</section>

			  	  </figcaption>

		    	</div>	      
		    </figure>


	  @endforeach
     
	</div> 
<div class="push"></div>				
</div>

@stop
