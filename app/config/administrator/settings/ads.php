<?php

return array(

	/**
	 * Settings page title
	 *
	 * @type string
	 */
	'title' => trans('dash.ads'),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'ad_footer_all' => array(
			'title' => trans('dash.ad footer'),
			'type' => 'text',
		),
		'ad_home_news' => array(
			'title' => trans('dash.ad home news'),
			'type' => 'text',
		),
		'ad_home_jumbo' => array(
			'title' => trans('dash.ad home jumbo'),
			'type' => 'text',
		),
		'ad_title_jumbo' => array(
			'title' => trans('dash.ad title jumbo'),
			'type' => 'text',
		),
		'ad_title_critic' => array(
			'title' => trans('dash.ad title critic'),
			'type' => 'text',
		),
		'ad_title_user' => array(
			'title' => trans('dash.ad title user'),
			'type' => 'text',
		)
	),

	'rules' => array(
		'add_footer_all' => 'max:1000',
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