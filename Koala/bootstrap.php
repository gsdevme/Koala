<?php

	/**
	 * Ensures it cant be called twice and there isnt some
	 * random global var running around
	 *
	 * We cant typehint the registry as the interface wont be
	 * loaded yet, nor is the autoloader
	 */
	$bootstrap = function($registry='\Koala\Registry'){
		$root = realpath(__DIR__) . '/../';

		// The autoloader for namespaced classes. i.e. not rubbish like Zend_Application_Model_Lemon_Mapper_Final
		spl_autoload_register(function($class) use ($root){
			$file = $root . str_replace('\\', '/', $class) . '.php';

			if(file_exists($file)){
				return require $file;
			}
		}, true);

		// Some keys files, everything is required for any bit of Koala to work
		require_once $root . 'Koala/Interfaces/Singleton.php';
		require_once $root . 'Koala/Interfaces/Registry.php';
		require_once $root . 'Koala/Interfaces/Hookable.php';
		require_once $root . 'Koala/Interfaces/Http/Request.php';

		// Real programming erors
		set_error_handler(function($errno, $errstr, $errfile, $errline ) {
				throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
			});

		// This is if its a CLI, just to stop defined Errors
		if (!isset($_SERVER['HTTP_HOST'])) {
			$_SERVER['REQUEST_URI'] = null;
			$_SERVER['HTTP_HOST'] = null;
		}

		// This is if its a CLI, just to stop defined Errors
		if(!isset($_SERVER['REQUEST_URI'])){
			$_SERVER['REQUEST_URI'] = null;
		}

		// Fire!! Registry is a-go
		$registry = $registry::getInstance();

		// Some stats for debugging/benchmark
		$registry->set('benchmark', microtime(true));
		$registry->set('memory', memory_get_usage());

		// You are Here for the Application
		$registry->set('root', $root);

		// Please sir.. can i have some memory
		unset($root);

		return $registry;
	};