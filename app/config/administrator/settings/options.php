<?php

return array(

	/**
	 * Settings page title
	 *
	 * @type string
	 */
	'title' => trans('dash.options'),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'data_provider' => array(
		    'type' => 'enum',
		    'title' => trans('dash.primary data provider'),
		    'options' => array('tmdb', 'imdb', 'db'),
		),
		'search_provider' => array(
		    'type' => 'enum',
		    'title' => 'Primary Search Provider',
		    'options' => array('tmdb', 'imdb', 'db'),
		),
		'tmdb_api_key' => array(
			'title' => trans('dash.tmdb api key'),
			'type' => 'text',
			'limit' => 255,
		),
		'disqus_short_name' => array(
			'title' => trans('dash.short name'),
			'type' => 'text',
			'limit' => 255,
		),
		'contact_us_email' => array(
			'title' => trans('dash.contact us email'),
			'type' => 'text',
			'limit' => 255,
		),
		'fb_url' => array(
			'title' => trans('dash.facebook url'),
			'type' => 'text',
			'limit' => 255,
		),
		'amazon_id' => array(
			'title' => trans('dash.amazon aff id'),
			'type' => 'text',
			'limit' => 255,
		),
		'tmdb_language' => array(
			'title' => trans('dash.tmdb language'),
			'type' => 'text',
			'limit' => 255,
		),
		'uri_separator' => array(
			'title' => trans('dash.uri separator'),
			'type' => 'text',
			'limit' => 1,
		),
		'uri_case' => array(
			'title' => trans('dash.resource uri first letter'),
			'type' => 'enum',
			'options' => array('lowercase', 'uppercase'),
		),
		'save_tmdb' => array(
			'title' => trans('dash.save images locally'),
			'type' => 'bool',
		),
		'scrape_news_fully' => array(
			'title' => trans('dash.scrape news fully'),
			'type' => 'bool',
		),	
		'require_act' => array(
			'title' => trans('dash.req user acti'),
			'type' => 'bool',
		),
		'use_cache' => array(
			'title' => trans('dash.enable caching?'),
			'type' => 'bool',
		),
		'auto_upd_data' => array(
			'title' => trans('dash.auto update data'),
			'type' => 'bool',
		),
		
	),

	'rules' => array(
		'tmdb_api_key' => 'max:255',
		'contact_us_email' => 'email|max:100',
		'uri_separator' => 'max:1',
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