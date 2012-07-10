<?php

	use \Koala\Hooker;
	use \Koala\Registry;
	use \Koala\App;

	require_once __DIR__ . '/../../Koala/bootstrap.php';	

	$app = new Hooker(new App(Registry::getInstance()));

	$app->setConfiguration(array(
		'mode' => 'debug'
	));

	$app->run();