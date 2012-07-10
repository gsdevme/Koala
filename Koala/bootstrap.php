<?php

	/**
	 * Ensures it cant be called twice and there isnt some 
	 * random global var running around
	 */
	$bootstrap = function(){
		$root = realpath(__DIR__) . '/../';

		require_once $root . 'Koala/Interfaces/Singleton.php';
		
		require_once $root . 'Koala/Registry.php';
		require_once $root . 'Koala/App.php';

		$registry = \Koala\Registry::getInstance();

		$registry->set('benchmark', microtime(true));
		$registry->set('memoryUsage', memory_get_usage());

		unset($registry, $root);
	};

	$bootstrap();

	echo '<pre>' . print_r(\Koala\Registry::getInstance(), true) . '</pre>';