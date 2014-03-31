<div class="jumbotron" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
	<div class="transparent">

		<div class="row">
	    	<div class="col-sm-3"></div>
	      	<div class="col-sm-6">	        
				 {{ Form::open(array('url' => Str::slug(trans('main.search')), 'method' => 'GET')) }}

	            	<div class="input-group">

	            		{{ Form::text('q', null, array('id' => 'auto-complete', 'class' => 'form-control search-bar', 'placeholder' => trans('main.search placeholder'), 'data-url' => url('typeahead'))) }}
						              		
                  		<span class="input-group-btn search-btn-ie-fix" title="GO!">
                    		<button class="btn btn-default search-button home-search-btn" type="submit"><i class="fa fa-search"></i></button>
                  		</span>
		          	</div>	     

		        {{ Form::close() }}		      
			</div>
	     	<div class="col-sm-3"></div>
	    </div>

		{{--slider begins--}}
		@if ( ! $featured->isEmpty())

			<div class="row">
				<div class="col-xs-1 previous-col hidden-xs">
					<a href="#left" data-liquidslider-ref="slider-home"><span class="fa fa-chevron-left previous"></span></a>
				</div>
			   
				<div class="col-sm-10 col-xs-12">
					<div class="liquid-slider" id="slider-home">

					{{--first slide--}}
					<div>

			           @foreach($featured->slice(0, 4) as $k => $v)

			             <figure class="col-sm-3 col-xs-6 home-trailer-poster" >
			               <img src="{{$v->poster}}" class="img-responsive trailer-trigger" alt="{{{ $v->title . 'Poster' }}}" data-trailer="{{{ $v->trailer }}}">
			               <div data-trailer="{{{ $v->trailer }}}" class="trailer-trigger overlay hidden-xs"><i class="fa fa-play"></i></div>
			               <figcaption><a href="{{ Helpers::url($v->title, $v->id, $v->type) }}">{{{ $v->title }}}</a></figcaption>                     
			             </figure> 

			           @endforeach             
			 	    </div>

			 	    {{--second slide--}}
			 	    <div id="slide-2" class="hidden-xs" style="display:none">

			        	@foreach($featured->slice(4, 8) as $k => $v)
			
							<figure class="col-xs-3 home-trailer-poster">
								<img src="{{$v->poster}}" class="img-responsive trailer-trigger" data-trailer="{{{ $v->trailer }}}" alt="{{{ $v->title . 'Poster' }}}">
								<div class="overlay"><i class="fa fa-play"></i></div>
								<figcaption><a href="{{ Helpers::url($v->title, $v->id, $v->type) }}">{{{ $v->title }}}</a></figcaption>                     
			             	</figure> 

						@endforeach
			 	    </div>

			 		</div>{{--slider--}}
				</div>{{--col-xs-10--}}

				<div class="col-xs-1 next-col hidden-xs">
		        	<a href="#right" data-liquidslider-ref="slider-home"><span class="fa fa-chevron-right next"></span></a>
		    	</div>

			</div>{{--slider row--}}

		@endif
		
	</div>{{--transparent--}}
</div>{{--jumbotron--}}

