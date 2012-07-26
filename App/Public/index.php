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

	$classMap = new \Koala\ClassMap($registry);
	$classMap->addPrefix('Zend_', 'Libraries/', true);

	// lets test we can use Zends json... not that we want it .. Yuk!
	$x = Zend_Json::encode(array('foo' => 1));

	if($x == '{"foo":1}'){
		echo '<pre>' . print_r('Zends JSON loaded correct', true) . '</pre>' . PHP_EOL;
	}

	// Pass $_SERVER, the ability to pass the $_SERVERS help you mock stuff, if NULL it will grab $_SERVER
	$environment = new \Koala\Environment($_SERVER);

	/**
	 * Hook example
	 */
	$app->hook('after://Koala\Http\Request->getRequest', function($request){
		echo '<pre>' . print_r('You have just been hooked ' . $request, true) . '</pre>' . PHP_EOL;
	});

	// Pass the environment to the request
	$request = new \Koala\Http\Request($environment);

	$app->run($request);

