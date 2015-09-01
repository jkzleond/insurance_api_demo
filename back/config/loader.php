<?php
/*
 * 类加载器
 */

$core_loader->registerPrefix(array(
	'EX' => $config->app->extensionsDir
));

$core_loader->registerSuffix(array(
	'Controller' => $config->app->controllersDir,
	'Model' => $config->app->modelsDir
));

$core_loader->registerDirs(array(
	$config->app->libsDir.'/utils'
));
