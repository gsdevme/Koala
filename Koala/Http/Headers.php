<?php

	namespace Koala\Http;

	use \Koala\Interfaces\Registry;
	use \Koala\Interfaces\Hookable;
	use \Serializable;

	class Headers implements Hookable, Serializable
	{

		public function __construct(Registry $registry)
		{

		}

		public function serialize()
		{

		}

		public function unserialize($serialized)
		{

		}
	}