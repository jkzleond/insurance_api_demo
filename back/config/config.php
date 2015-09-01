<?php
$config = new SF_BaseConfigure( array(
		'app' => array(
			'controllersDir' => dirname(__FILE__).'/../controllers',
			'modelsDir' => dirname(__FILE__).'/../models',
			'viewsDir' => dirname(__FILE__).'/../views',
			'extensionsDir' => dirname(__FILE__).'/../../ext',
			'libsDir' => dirname(__FILE__).'/../../libs'
		),
		'database' => array(
			'dsn' => 'dblib:host=116.55.248.76:31433;dbname=IAMisDB;charset=UTF-8',
			'user' => 'sa_iamis',
			'password' => 'pl0871iamis'
		)
	)
);