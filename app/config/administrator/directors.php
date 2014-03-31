<?php

/**
 * Directors model config
 */

return array(

	'title' => trans('dash.directors'),

	'single' => trans('dash.director'),

	'model' => 'Director',

	/**
	 * The display columns
	 */
	'columns' => array(
		'name' => array(
			'title' => trans('main.name'),
		),
		'num_films' => array(
			'title' => '# ' . trans('main.movies'),
			'relation' => 'title',
			'select' => 'COUNT((:table).id)',
		),
		'title' => array(
			'title' => trans('dash.movies&series'),
			'type' => 'relationship',
			'name_field' => 'title',
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name',
		'title' => array(
			'title' => trans('dash.movies&series'),
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key',
		),
		'name' => array(
			'title' => trans('main.name'),
			'type' => 'text',
		),
		'title' => array(
			'title' => trans('dash.movies&series'),
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
	),

);