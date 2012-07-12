<?php

	namespace Koala\Debug;

	class Log
	{

		private static $_instance;
		private $_log;

		private function __construct()
		{

		}

		public static function getInstance()
		{
			if(!self::$_instance instanceof self){
				self::$_instance = new self;
			}

			return self::$_instance;
		}

		public function wtf()
		{
			$args = func_get_args();

			if(count($args) > 1){

			}

		}

	}