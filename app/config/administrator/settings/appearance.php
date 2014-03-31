<?php

return array(

	/**
	 * Settings page title
	 *
	 * @type string
	 */
	'title' => trans('dash.appearance'),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'color_scheme' => array(
			'title' => trans('dash.color scheme'),
			'type' => 'enum',
			'options' => array('red', 'green', 'blue', 'asbestos', 'purple', 'navy', 'beach', 'rust'),
		),
		'logo' => array(
			'title' => trans('dash.logo'),
			'type' => 'image',
		    'location' => public_path() . '/assets/images/',
		    'naming' => 'random',
		    'length' => 20,
		    'size_limit' => 5,
		), 
		'success_color' => array(
			'title' => trans('dash.success color'),
			'type' => 'color',
		),
		'warning_color' => array(
			'title' => trans('dash.warning color'),
			'type' => 'color',
		),
		'danger_color' => array(
			'title' => trans('dash.danger color'),
			'type' => 'color',
		),
		'home_view' => array(
		    'type' => 'enum',
		    'title' => trans('dash.home view'),
		    'options' => array('columns', 'rows'),
		),
		'title_view' => array(
		    'type' => 'enum',
		    'title' => trans('dash.title view'),
		    'options' => array('tabs', 'noTabs'),
		),
		'news_ex_len' => array(
			'title' => trans('dash.news exe len'),
			'type' => 'text',
		),
	),

	'rules' => array(
		'news_ex_len' => 'required|numeric'
	),

	/**
	 * This is run prior to saving the JSON form data
	 *
	 * @type function
	 * @param array		$data
	 *
	 * @return string (on error) / void (otherwise)
	 */
	'before_save' => function(&$data)
	{
		$dash = \App::make('Lib\Repository\Dashboard\DashboardRepositoryInterface');
		$dash->updateOptions($data);
	},
);