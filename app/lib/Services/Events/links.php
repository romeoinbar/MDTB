<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Links',

	'single' => 'Link',

	'model' => 'Link',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name' => array(
	   		'title' => 'Name',
	   	),
		'url' => array(
			'title' => 'Url',
		),
		'title_id' => array(
			'title' => 'Title ID',
		),
		'button' => array(
			'title' => 'Button',
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name' => array(
			'title' => 'Name',
		),
		'title' => array(
			'title' => 'Title',
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
		'button' => array(
			'title' => 'Button',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
	   		'title' => 'Name',
	   	),
		'url' => array(
			'title' => 'Url',
		),
		'title' => array(
			'title' => 'Title',
			'type' => 'relationship',
			'name_field' => 'title',
			'autocomplete' => true,
		),
		'button' => array(
			'type' => 'enum',
		    'title' => 'Button',
		    'options' => array('buy|rent', 'tickets'),
		),
	),

	'form_width' => 500,

	'rules' => array(
    	'name' => 'required|max:255',
    	'url' => 'required|max:255',
    	'button' => 'required|max:255',
    	'title_id' => 'required',
	),

);