<?php

	namespace Koala\Http;

	use \Koala\Interfaces\Hookable;

	class Request implements Hookable
	{

		public function getRequest()
		{
			return '/user/1';
		}
	}