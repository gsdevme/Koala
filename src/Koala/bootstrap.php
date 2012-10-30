<?php

	namespace Koala;

	class Bootstrap
	{

		private function __construct()
		{

		}

		private function __clone()
		{

		}

		/**
		 * @param  string/object $registry
		 */
		public static function init($registry='\Koala\Registry')
		{
			$root = realpath(__DIR__) . '/../';

			// The autoloader for namespaced classes. i.e. not rubbish like Zend_Application_Model_Lemon_Mapper_Final
			spl_autoload_register(function($class) use ($root){
				$file = $root . str_replace('\\', '/', $class) . '.php';

				if(file_exists($file)){
					return require $file;
				}
			}, true, true);

			// Some key files, everything is required for any bit of Koala to work
			// @todo perhaps make some kind of built Interface file save having to grab loads of files
			require $root . 'Koala/Interfaces/Singleton.php';
			require $root . 'Koala/Interfaces/Registry.php';
			require $root . 'Koala/Interfaces/Events/Wrappable.php';
			require $root . 'Koala/Interfaces/Http/Request.php';

			// Real programming erors
			set_error_handler(function($errno, $errstr, $errfile, $errline ) {
				throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
			});

			// This allows the $registry to be pass as an object
			if(!is_object($registry)){
				// Fire!! Registry is a-go
				$registry = $registry::getInstance();
			}

			// Some stats for debugging/benchmark
			$registry->set('benchmark', microtime(true));
			$registry->set('memory', memory_get_usage());

			// You are Here for the Application
			$registry->set('root', $root);

			// Please sir.. can i have some memory
			unset($root);

			return $registry;
		}
	}