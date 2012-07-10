<?php

	require_once DIR . '/../Koala/App.php';

	$app = new Koala\App(array(
		'mode' => 'debug'
	));

	$app->run();