<?php

	namespace Koala\Http;

	use \Koala\Interfaces;

	class Request implements Interfaces\Events\Wrappable, Interfaces\Http\Request
	{

		public function __construct()
		{

		}

		public function getRequest()
		{
			return '/user/1';
		}
	}