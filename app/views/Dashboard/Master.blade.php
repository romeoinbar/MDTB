<div class="container">
	<div class="row stats-container">
 		<div class="box col-sm-2">
 			<span id="number">{{ $userCount }}</span><br><span id="text">{{ trans('dash.users in db') }}</span>
 		</div>
 		<div class="box col-sm-2">
 			<span id="number">{{ $movieCount }}</span><br><span id="text">{{ trans('dash.movies in db') }}</span>
 		</div>
 		<div class="box col-sm-2">
 			<span id="number">{{ $seriesCount }}</span><br><span id="text">{{ trans('dash.series in db') }}</span>
 		</div>
 		<div class="box col-sm-2">
 			<span id="number">{{ $actorCount }}</span><br><span id="text">{{ trans('dash.actors in db') }}</span>
 		</div>
 		<div class="box col-sm-2">
 			<span id="number">{{ $newsLastUpdated }}</span><br><span id="text">{{ trans('dash.news updated') }}</span>
 		</div>
 	</div><br>

 	<div class="row"> @include('Partials.Response') </div>
	
 	<div class="col-sm-4">
 		<div class="scraper-container">

 		<h4><i class="fa fa-wrench"></i> {{ trans('dash.scrape imdb') }}</h4>
 		{{ Form::open(array('url' => 'dashboard/imdb-advanced', 'class' => 'form-horizontal')) }}

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('from', trans('dash.from')) }}
	      {{ Form::text('from', 1980, array('class' => 'form-control')) }}
	      {{ $errors->first('from', '<span class="help-block alert alert-danger">:message</span>') }}          
	    </div>           

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('to', trans('dash.to')) }}
	      {{ Form::text('to', 2015, array('class' => 'form-control')) }}
	      {{ $errors->first('to', '<span class="help-block alert alert-danger">:message</span>') }}
	    </div>

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('minVotes', trans('dash.min votes')) }}
	      {{ Form::text('minVotes', 2000, array('class' => 'form-control')) }}
	      {{ $errors->first('minVotes', '<span class="help-block alert alert-danger">:message</span>') }}          
	    </div>

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('minRating', trans('dash.min rating')) }}
	      {{ Form::text('minRating', 4, array('class' => 'form-control')) }}
	      {{ $errors->first('minRating', '<span class="help-block alert alert-danger">:message</span>') }}         
	    </div>

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('howMuch', trans('dash.how much')) }}
	      {{ Form::text('howMuch', 1000, array('class' => 'form-control')) }}  
	      {{ $errors->first('howMuch', '<span class="help-block alert alert-danger">:message</span>') }}            
	    </div>

	    <div class="form-group on-image col-sm-12">
	      {{ Form::label('offset', trans('dash.offset')) }}
	      {{ Form::text('offset', Input::old('offset'), array('class' => 'form-control', 'placeholder' => '1000...')) }}   
	      {{ $errors->first('offset', '<span class="help-block alert alert-danger">:message</span>') }}            
	    </div>

	    <button type="submit">{{ trans('dash.scrape') }}</button>


	    {{ Form::close() }}
 	</div>
 	</div>

 	<div class="scraper-container col-sm-4">
 		<h4><i class="fa fa-wrench"></i> {{ trans('dash.scrape tmdb') }}</h4>
 		{{ Form::open(array('url' => 'dashboard/tmdb-discover', 'class' => 'form-horizontal')) }}

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('sort_by', trans('dash.sort by')) }}
		      {{ Form::select('sort_by', array('popularity.desc' => trans('dash.popularity'), 'vote_average.desc' => trans('dash.votes'), 'release_date.desc' => trans('dash.year')), 'popularity.desc', array('class' => 'form-control')) }}
		      {{ $errors->first('sort_by', '<span class="help-block alert alert-danger">:message</span>') }}          
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('include_adult', trans('dash.include adult')) }}
		      {{ Form::select('include_adult', array('true' => trans('dash.yes'), 'false' => trans('dash.no')), 'false', array('class' => 'form-control')) }}
		      {{ $errors->first('include_adult', '<span class="help-block alert alert-danger">:message</span>') }}          
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('type', trans('main.type')) }}
		      {{ Form::select('type', array('movie' => trans('main.movie'), 'tv' => trans('main.series')), 'movie', array('class' => 'form-control')) }}
		      {{ $errors->first('type', '<span class="help-block alert alert-danger">:message</span>') }}          
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('language', trans('dash.language')) }}
		      {{ Form::text('language', '', array('class' => 'form-control')) }}
		      <span class="help-block"> * {{ trans('dash.tmdb lang expl') }}.</span>
		      {{ $errors->first('language', '<span class="help-block alert alert-danger">:message</span>') }}
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('release_date*gte', trans('dash.from')) }}
		      {{ Form::text('release_date*gte', '1980-01-01', array('class' => 'form-control')) }}
		      {{ $errors->first('release_date*gte', '<span class="help-block alert alert-danger">:message</span>') }}
		    </div>
		     
		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('release_date*ite', trans('dash.to')) }}
		      {{ Form::text('release_date*ite', '2015-01-01', array('class' => 'form-control')) }}
		      {{ $errors->first('release_date*ite', '<span class="help-block alert alert-danger">:message</span>') }}
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('howMuch', trans('dash.how much')) }}
		      {{ Form::text('howMuch', 100, array('class' => 'form-control')) }}
		      {{ $errors->first('howMuch', '<span class="help-block alert alert-danger">:message</span>') }}
		    </div>

		    <div class="form-group on-image col-sm-12">
		      {{ Form::label('page', trans('dash.offset')) }}
		      {{ Form::text('page', 1, array('class' => 'form-control')) }}
		      {{ $errors->first('page', '<span class="help-block alert alert-danger">:message</span>') }}
		    </div>

		    <button type="submit">{{ trans('dash.scrape') }}</button>

		    {{ Form::close() }}
 	</div>

 	<div class="col-sm-4">
 		<div class="action-block">
	 		<div class="scraper-container">
				<h4>{{ trans('dash.fully scrape') }}</h4>
				{{ Form::label('amount', trans('dash.how much')) }}
		        {{ Form::open(array('route' => 'titles.scrapeFully')) }}
		        {{ Form::text('amount', 100, array('class' => 'form-control')) }}<br>
		        <button type="submit">{{ trans('dash.scrape') }}</button>
		        {{ Form::close() }}
		 	</div>
		 	<div class="scraper-container">
				<h4>{{ trans('dash.update all') }}</h4>
				{{ Form::open(array('url' => 'dashboard/featured-trailers')) }}
		          <button type="submit"><i class="fa fa-refresh"></i> {{ trans('dash.update fet trailer') }}</button>     
		        {{ Form::close() }}
		        {{ Form::open(array('url' => 'dashboard/now-playing')) }}
		          <button type="submit"><i class="fa fa-refresh"></i> {{ trans('dash.update in theaters') }}</button>     
		        {{ Form::close() }}
		        {{ Form::open(array('url' => 'dashboard/truncate')) }}
	         		<button type="submit"><i class="fa fa-trash-o"></i> {{ trans('dash.truncate all data') }}</button>      
	        	{{ Form::close() }}
	        	{{ Form::open(array('route' => 'news.ext')) }}
	          		<button type="submit"><i class="fa fa-refresh"></i> {{ trans('dash.update news') }}</button>
	        	{{ Form::close() }}
		 	</div>
		 	<div class="scraper-container">
		 		<h4>{{ trans('dash.notification') }}</h4>
		 		<p>
		 			{{ trans('dash.new links movie') }}: {{ $newMovieLinkCount }}
		 		</p>
		 		<p>
		 			{{ trans('dash.new links serie') }}: {{ $newSerieLinkCount }}
		 		</p>
		 	</div>
 		</div>
 	</div>
</div>

