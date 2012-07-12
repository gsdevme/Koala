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

	// $classMap->add('Zend_Json', 'Libraries/'); Maps Zend_Json direct to Libraries/, so that translates to Libraries/Zend/Json.php (class: Zend_Json)

	// Because Zend runs off and requires() loads of files you need TRUE, however it zend didnt then it wouldnt
	$classMap->addPrefix('Zend_', 'Libraries/', true);

	$x = new Zend_Json();
	var_dump($x);	

	$app->hook('after://Koala\Http\Request->getRequest', function($request){
		echo '<pre>' . print_r('You have just been hooked ' . $request, true) . '</pre>' . PHP_EOL;
	});

	$app->run();