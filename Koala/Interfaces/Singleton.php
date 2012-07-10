<?php

	namespace Koala\Interfaces;

	/**
	 * Interface for Singletons
	 */
	interface Singleton
	{

		public static function getInstance();
		public function __construct();
	}