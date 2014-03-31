<div class="jumbotron" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
	<div class="transparent">
		<div class="row profile-row">
			<div class="col-sm-12">
				
				<div class="col-xs-1 previous-col hidden-xs no-padding">
					<a href="#left" data-liquidslider-ref="slider-home"><i class="fa fa-chevron-left previous"></i></a>
				</div>
			   
				<div class="col-sm-10 col-xs-12 no-padding">
					<div class="liquid-slider " id="slider-home">

					{{--first slide--}}
					<div>

			           @foreach($data->slice(0, 4) as $k => $v)

			             <figure class="col-sm-3 col-xs-6">
			               <a href="{{ Helpers::url($v['title'], $v['id'], $v['type']) }}"><img src="{{{ asset($v->poster) }}}" class="img-responsive" alt="{{{ $v->title . 'Poster' }}}"></a>

			               <figcaption><a href="{{ Helpers::url($v->title, $v->id, $v->type) }}">{{{ $v->title }}}</a></figcaption>             
			             </figure> 

			           @endforeach             
			 	    </div>

			 	    {{--second slide--}}
			 	    <div id="slide-2" class="hidden-xs" style="display:none">

			        	@foreach($data->slice(4, 8) as $k => $v)
			
							<figure class="col-xs-3">
								<img src="{{{ asset($v->poster) }}}" class="img-responsive" alt="{{{ $v->title . 'Poster' }}}">
							</figure> 

						@endforeach
			 	    </div>

			 		</div>{{--slider--}}
				</div>{{--col-xs-10--}}

				<div class="col-xs-1 next-col hidden-xs no-padding">
		        	<a href="#right" data-liquidslider-ref="slider-home"><i class="fa fa-chevron-right next"></i></a>
		    	</div>		    	
			</div>
		</div>
	</div>
</div>