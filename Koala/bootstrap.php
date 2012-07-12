<?php

	/**
	 * Ensures it cant be called twice and there isnt some 
	 * random global var running around
	 */
	$bootstrap = function(){
		$root = realpath(__DIR__) . '/../';

		// Some keys files, everything is required for any bit of Koala to work
		require_once $root . 'Koala/Interfaces/Singleton.php';
		require_once $root . 'Koala/Interfaces/Registry.php';
		require_once $root . 'Koala/Interfaces/Hookable.php';

		require_once $root . 'Koala/Hooker.php';
		require_once $root . 'Koala/Registry.php';
		require_once $root . 'Koala/Http/Request.php';
		require_once $root . 'Koala/Http/Router.php';
		require_once $root . 'Koala/App.php';

		// Real programming erors
		set_error_handler(function($errno, $errstr, $errfile, $errline ) {
				throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
			});

		// This is if its a CLI, just to stop defined Errors
		if (!isset($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = null;
			$_SERVER['HTTP_HOST'] = null;
		}			

		// Fire!! Registry is a-go
		$registry = \Koala\Registry::getInstance();

		// Some stats for debugging/benchmark
		$registry->set('benchmark', microtime(true));
		$registry->set('memory', memory_get_usage());

		// You are Here for the Application
		$registry->set('root', $root);

		// The autoloader for namespaced classes. i.e. not rubbish like Zend_Application_Model_Lemon_Mapper_Final

		spl_autoload_register(function($class) use ($root){
			$file = $root . str_replace('\\', '/', $class) . '.php';

			if(file_exists($file)){
				return require $file;
			}
		}, true);

		// Please sir.. can i have some memory
		unset($registry, $root);
	};

	$bootstrap();

	unset($bootstrap);