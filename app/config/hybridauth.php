<?php
return array(	
	"base_url"   => url() . '/social/auth',
	"providers"  => array (
		"Google"     => array (
			"enabled"    => true,
			"keys"       => array ( "id" => "698985655412-ooajf7b1vs1trpcqddtn85borb9c7t2q.apps.googleusercontent.com", "secret" => "j4-88i0nQDwdSk9YlUkULXz7" ),
			"scope"      => "https://www.googleapis.com/auth/userinfo.profile ".
                            "https://www.googleapis.com/auth/userinfo.email"   ,
			),
		"Facebook"   => array (
			"enabled"    => true,
			"keys"       => array ( "id" => "264280627064055", "secret" => "4ee0151a9a3a794e332e3a82e1f8b827" ),
			'scope'      =>  'email',
			),
		"Twitter"    => array (
			"enabled"    => true,
			"keys"       => array ( "key" => "pUDHscHj6EFBSrwozmndw", "secret" => "BIUEquAoBxocuifupdpjbVFAbnU9eb5sGnWAaQK7w1o" )
			)
	),
);