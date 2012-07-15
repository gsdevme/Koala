<?php

	require_once __DIR__ . '/../../Koala/bootstrap.php';

	$registry = $bootstrap('\Koala\Registry');
	unset($bootstrap);

	// Pass in the Registry or some class which has the registry interface
	$app = new \Koala\App($registry);

	// optional configuration options
	$app->setConfiguration(array(
		'mode' => 'debug'
	));

	// Pass $_SERVER, the ability to pass the $_SERVERS help you mock stuff, if NULL it will grab $_SERVER
	$environment = new \Koala\Environment($_SERVER);

	// Pass the environment to the request
	$request = new \Koala\Http\Request($environment);

	$app->run($request);

	/**
	 * Using the classMap is only for third party stuff, if you dont
	 * use it dont create an instance
	 */
	//$classMap = new ClassMap(Registry::getInstance());

	// $classMap->add('Zend_Json', 'Libraries/'); Maps Zend_Json direct to Libraries/, so that translates to Libraries/Zend/Json.php (class: Zend_Json)

	// Because Zend runs off and requires() loads of files you need TRUE, however it zend didnt then it wouldnt
	//$classMap->addPrefix('Zend_', 'Libraries/', true);

	//$x = new Zend_Json();
	//var_dump($x);

	/*$app->hook('after://Koala\Http\Request->getRequest', function($request){
		echo '<pre>' . print_r('You have just been hooked ' . $request, true) . '</pre>' . PHP_EOL;
	});

	var_dump($app);*/

