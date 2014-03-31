<?php

/**
 * Actors model config
 */

return array(

	'title' => trans('main.actors'),

	'single' => trans('main.actor'),

	'model' => 'Actor',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'image' => array(
	   		'title' => trans('main.image'),
	   		'output' => '<img src="(:value)" height="100" />',
	   	),
		'name' => array(
			'title' => trans('main.name'),
		),
		'num_films' => array(
			'title' => '# ' . trans('dash.titles'),
			'relationship' => 'title',
			'select' => 'COUNT((:table).id)',
		),
		'birth_date' => array(
			'title' => trans('main.birth date'),
			'sort_field' => 'birth_date',
		),
		'views' => array(
			'title' => trans('dash.views'),
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name' => array(
			'title' => trans('main.name'),
			'type' => 'text'
		),
		'title' => array(
			'title' => trans('dash.movies&series'),
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
		'birth_date' => array(
			'title' => trans('main.birth date'),
			'type' => 'date'
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => trans('main.name'),
			'type' => 'text',
		),
		'bio' => array(
			'title' => trans('main.bio'),
			'type' => 'text',
		),
		'awards' => array(
			'title' => trans('main.awards'),
			'type' => 'text',
		),
		'birth_place' => array(
			'title' => trans('main.birth place'),
			'type' => 'text',
		),
		'birth_date' => array(
			'title' => trans('main.birth date'),
			'type' => 'date',
		),
		'title' => array(
			'title' => trans('dash.movies&series'),
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
		'allow_update' => array(
			'title' => 'allow_update',
			'value' => 0,
		),
	),

	'form_width' => 500,

	'rules' => array(
    	'name' => 'required',
	),

	'sort' => array(
	    'field' => 'num_films',
	    'direction' => 'desc',
	),

);