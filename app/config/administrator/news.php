<?php

/**
 * Directors model config
 */

return array(

	'title' => trans('main.news'),

	'single' => trans('dash.news item'),

	'model' => 'News',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'image' => array(
	   		'title' => trans('main.image'),
	   		'output' => '<img src="(:value)" height="100" />',
	   	),
	   	'title' => array(
			'title' => trans('main.title'),
		),
	   	'source' => array(
			'title' => trans('main.source'),
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'title' => array(
			'title' => trans('main.title'),
		),
		'created_at' => array(
			'title' => trans('dash.created at'),
			'type' => 'date',
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
		'title' => array(
			'title' => trans('main.title'),
			'type' => 'text',
		),
		'image' => array(
			'title' => trans('main.image'),
			'type' => 'text',
		),
		'body' => array(
			'title' => trans('main.body'),
			'type' => 'wysiwyg',
		),
	),

	'form_width' => 800,

);