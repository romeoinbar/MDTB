<?php

return array(

	'title'  => trans('main.movies'),
	'single' => trans('main.movie'),
	'model'  => 'Title',

	'link' => function($model)
	{
    	return Helpers::url($model->title, $model->id, 'movies');
	},

	'columns' => array(
	   'id',   
	   'poster' => array(
	   		'title' => trans('main.poster'),
	   		 'output' => '<img src="(:value)" height="100" />',
	   		),

	   'title' => array(
			'title' => trans('main.title'),
		),
	   'genre' => array(
			'title' => trans('main.genre'),
		),

	   Helpers::getProvider() . '_rating',

	   'year' => array(
			'title' => trans('main.year'),
		),
	   'created_at' => array(
			'title' => trans('dash.created at'),
		),
	),

	'edit_fields' => array(
		'title' => array(
			'title' => trans('main.title'),
		),
		'type' => array(
		    'type' => 'enum',
		    'title' => trans('main.type'),
		    'options' => array('movie', 'series'),
		),
		'actor' => array(
		    'type' => 'relationship',
		    'title' => trans('main.actors'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
		'director' => array(
		    'type' => 'relationship',
		    'title' => trans('dash.directors'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
		'writer' => array(
		    'type' => 'relationship',
		    'title' => trans('dash.writers'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
		'featured' => array(
	    	'type' => 'bool',
	    	'title' => trans('main.featured'),
		),
		'now_playing' => array(
	    	'type' => 'bool',
	    	'title' => trans('dash.now playing'),
		),

		'release_date' => array(
			'title' => trans('main.release date'),
		),

		'custom_field' => array(
    		'type' => 'textarea',
    		'title' => trans('dash.custom content'),
		),

		'plot' => array(
			'title' => trans('main.plot'),
			'type' => 'markdown',
    		'limit' => 1000,
    		'height' => 130,
		),

		'tagline' => array(
			'title' => trans('main.tagline'),
		),

		'genre' => array(
			'title' => trans('main.genre'),
		),

		'affiliate_link' => array(
			'title' => trans('main.affiliate link'),
		),

		'poster' => array(
		    'title' => trans('main.poster'),
		    'type' => 'image',
		    'location' => public_path() . '/imdb/posters/',
		    'naming' => 'random',
		    'length' => 20,
		    'size_limit' => 5,
		    'sizes' => array(
        		array(428, 634, 'crop', public_path() . '/imdb/posters/', 100)
    		)
		),

		'trailer' => array(
			'title' => trans('main.trailer'),
		),

		'awards' => array(
			'title' => trans('main.awards'),
		),

		'runtime' => array(
			'title' => trans('main.runtime'),
		),

		'budget' => array(
			'title' => trans('main.budget'),
		),

		'revenue' => array(
			'title' => trans('main.revenue'),
		),
		'year' => array(
			'title' => trans('main.year'),
		),
		'imdb_id' => array(
			'title' => 'IMDb ID',
		),
		'tmdb_id' => array(
			'title' => 'TMDB ID',
		),
		'allow_update' => array(
			'title' => trans('dash.allow update'),
			'value' => 0,
		),
	),

	'filters' => array(
	    'title' => array(
	        'title' => trans('main.title'),
	    ),
	    'language' => array(
	        'title' => trans('main.lang'),
	    ),
	    'country' => array(
	        'title' => trans('main.country'),
	    ),
	    'release_date' => array(
	        'title' => trans('main.release date'),
	        'type' => 'date',
	    ),
	    'actor' => array(
		    'type' => 'relationship',
		    'title' => trans('main.actor'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
		'director' => array(
		    'type' => 'relationship',
		    'title' => trans('dash.director'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
		'writer' => array(
		    'type' => 'relationship',
		    'title' => trans('dash.writer'),
		    'name_field' => 'name',
		    'autocomplete' => true,
		),
	    'mc_user_score' => array(
	    	'title' => trans('dash.mc user score'),
	    	'type' => 'number'
	    ),
	    'mc_critic_score' => array(
	    	'title' => trans('dash.mc critic score'),
	    	'type' => 'number'
	    ),
	    'created_at' => array(
	    	'title' => trans('dash.created at'),
	    	'type' => 'date'
	    ),

	),

	'sort' => array(
	    'field' => Helpers::getOrdering(),
	    'direction' => 'desc',
	),

	'query_filter'=> function($query)
	{

	    $query->whereType('movie');
	},

	'form_width' => 1000,

	'rules' => array(
    	'title' => 'required',
    	'year' => 'required|min:4,max:4|numeric',
    	'type'  => 'required|in:movie,series',
    	'allow_update' => 'required|in:1,0',
	),

	'actions' => array(
    'update_from_external' => array(
        'title' => 'Update From External',
        'messages' => array(
            'active' => trans('dash.updating'),
            'success' => trans('dash.updated'),
            'error' => trans('main.error'),
        ),
        'action' => function($model)
        {
            $model->updateFromExternal();

            return true;
        }
    )),
);