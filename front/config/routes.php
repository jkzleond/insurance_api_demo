<?php
$router = $di->get('router');

$router->addPost('/login', array(
	'controller' => 'user',
	'action' => 'login'
));

$router->addGet('/user_state', array(
	'controller' => 'user',
	'action' => 'getUserState'
));
