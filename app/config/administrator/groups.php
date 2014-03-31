<?php

/**
 * Actors model config
 */

return array(

	'title' => trans('main.groups'),

	'single' => trans('dash.group'),

	'model' => 'Group',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name' => array(
	   		'title' => trans('main.name'),
	   	),
		'permissions' => array(
			'title' => trans('dash.permissions'),
		),
		'created_at' => array(
			'title' => trans('dash.created at'),
		),
		'updated_at' => array(
			'title' => trans('dash.last updated'),
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name' => array(
			'title' => trans('main.name'),
		),
		'permissions' => array(
			'title' => trans('dash.permissions'),
		),
		'created_at' => array(
			'title' => trans('dash.created at'),
			'type'  => 'date',
		),
		'updated_at' => array(
			'title' => trans('dash.last updated'),
			'type'  => 'date',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => trans('main.name'),
		),
		'permissions' => array(
			'title' => trans('dash.permissions'),
			'value' => '{"titles.create":1}'
		),
	),

	'form_width' => 500,

	'rules' => array(
    	'name' => 'required',
	),

	'sort' => array(
	    'field' => 'created_at',
	    'direction' => 'desc',
	),

);