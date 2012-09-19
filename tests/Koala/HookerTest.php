<?php

	namespace tests\Koala;

	require_once realpath(__DIR__) . '/../../src/Koala/Hooker.php';

	use \Koala\Hooker;

	class HookerTest extends \PHPUnit_Framework_TestCase
	{

		private $_registry;

		public function setUp()
		{
			// Since we use the type hint for the interface we need to tell the class its name
			$this->_registry = $this->getMock('Koala\Interfaces\Registry', array('get'), array(), '', false);
		}

		public function testConstruct()
		{
			/**
			 * Lets make the get() method and make it return an object for our Hook
			 *
			 * We setup this method to return FALSE
			 */
			$this->_registry->expects($this->any())
				->method('get')
				->will($this->returnValue((object)array(
					'hook' . sprintf('%u', crc32('Hookable->test')) => (object)array(
						'point' => 'after',
						'methodNS' => 'Hookable->test',
						'callback' => (function(){
							return false;
						})
					)
				)));

			$hookable = $this->getMock('Koala\Interfaces\Hookable', array('test'), array(), 'Hookable');

			/**
			 * We setup this method to return TRUE, however it this works the
			 * actual outcome should be FALSE (see hook get())
			 */
			$hookable->expects($this->any())
				->method('test')
				->will($this->returnValue(true));

			$hookedClass = new Hooker($hookable, $this->_registry);

			$this->assertFalse($hookedClass->test());

		}
	}