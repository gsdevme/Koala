<?php

	namespace Koala\Interfaces;

	interface Registry
	{

		public static function getInstance();
		public function __construct();

		public function get($key);
		public function set($key, $value);		
	}