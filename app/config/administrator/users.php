<?php

/**
 * Actors model config
 */

return array(

	'title' => trans('main.users'),

	'single' => trans('main.user'),

	'model' => 'User',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'avatar' => array(
	   		'title' => trans('users.avatar'),
	   		'output' => '<img src="(:value)"/>',
	   	),
		'username' => array(
			'title' => trans('users.username'),
		),
		'email' => array(
			'title' => trans('main.email'),
		),
		'gender' => array(
			'title' => trans('users.gender'),
		),
		'created_at' => array(
			'title' => trans('dash.registered'),
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'username' => array(
			'title' => trans('users.username'),
		),
		'email' => array(
			'title' => trans('main.email'),
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'username' => array(
			'title' => trans('users.username'),
		),
		'email' => array(
			'title' => trans('main.email'),
		),
		'password' => array(
			'title' => trans('users.password'),
			'type' => 'password',
		),
		'group' => array(
			'title' => trans('dash.group'),
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'avatar' => array(
			'title' => trans('users.avatar'),
		),
		'first_name' => array(
			'title' => trans('users.first name'),
		),
		'last_name' => array(
			'title' => trans('users.last name'),
		),
		'activated' => array(
			'title' => trans('dash.activated'),
			'type'  => 'bool',
		),
		'permissions' => array(
			'title' => trans('dash.permissions'),
		),
	),

	'form_width' => 500,

	'rules' => array(
    	'username' => 'required',
    	'password' => 'required|min:5',
    	'email'    => 'required|email|min:5,max:25',
	),

	'sort' => array(
	    'field' => 'created_at',
	    'direction' => 'desc',
	),

);