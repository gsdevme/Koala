<?php

	use \Koala\Registry;
	use \Koala\App;

	require_once __DIR__ . '/../../Koala/bootstrap.php';	

	$app = new App(Registry::getInstance());

	$app->setConfiguration(array(
		'mode' => 'debug'
	));

	$app->hook('after://Koala\Http\Request->getRequest', function($request){
		echo '<pre>' . print_r('You have just been hooked ' . $request, true) . '</pre>' . PHP_EOL;
	});

	$app->run();