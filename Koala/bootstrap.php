<?php

	/**
	 * Ensures it cant be called twice and there isnt some 
	 * random global var running around
	 */
	$bootstrap = function(){
		$root = realpath(__DIR__) . '/../';

		require_once $root . 'Koala/Interfaces/Singleton.php';
		require_once $root . 'Koala/Interfaces/Hookable.php';

		require_once $root . 'Koala/Hooker.php';
		require_once $root . 'Koala/Registry.php';
		require_once $root . 'Koala/App.php';

		$registry = \Koala\Registry::getInstance();

		$registry->set('benchmark', microtime(true));
		$registry->set('memory', memory_get_usage());
		$registry->set('root', $root);

		unset($registry, $root);
	};

	$bootstrap();

	unset($bootstrap);