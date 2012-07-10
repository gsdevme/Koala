<?php

	require_once DIR . '/../Koala/bootstrap.php';

	$app = new Koala\App(array(
		'mode' => 'debug'
	));

	$app->run();