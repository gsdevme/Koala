<?php

	use \Koala\Registry;
	use \Koala\App;
	use \Koala\ClassMap;

	require_once __DIR__ . '/../../Koala/bootstrap.php';	

	$app = new App(Registry::getInstance());

	$app->setConfiguration(array(
		'mode' => 'debug'
	));

	/**
	 * Using the classMap is only for third party stuff, if you dont 
	 * use it dont create an instance
	 */
	$classMap = new ClassMap(Registry::getInstance());
	$classMap->add('WideImage', 'Libraries/WideIage/');

	$app->hook('after://Koala\Http\Request->getRequest', function($request){
		echo '<pre>' . print_r('You have just been hooked ' . $request, true) . '</pre>' . PHP_EOL;
	});

	$app->run();