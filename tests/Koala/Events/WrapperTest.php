<?php

	namespace tests\Koala;

	require_once realpath(__DIR__) . '/../../../src/Koala/Events/Wrapper.php';

	use \Koala\Events\Wrapper;

	/**
	 * @backupGlobals disabled
	 */
	class WrapperTest extends \PHPUnit_Framework_TestCase
	{

		private $_registry;

		public function run(\PHPUnit_Framework_TestResult $result = null)
		{
			$this->setPreserveGlobalState(false);
			return parent::run($result);
		}

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
					'event' . sprintf('%u', crc32('Wrappable->test')) => (object)array(
						'point' => 'after',
						'methodNS' => 'Wrappable->test',
						'callback' => (function(){
							return false;
						})
					)
				)));

			$hookable = $this->getMock('Koala\Interfaces\Events\Wrappable', array('test'), array(), 'Wrappable');

			/**
			 * We setup this method to return TRUE, however it this works the
			 * actual outcome should be FALSE (see hook get())
			 */
			$hookable->expects($this->any())
				->method('test')
				->will($this->returnValue(true));

			$hookedClass = new Wrapper($hookable, $this->_registry);

			$this->assertFalse($hookedClass->test());

		}
	}