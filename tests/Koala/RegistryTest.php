<?php

	namespace tests\Koala;

	require_once realpath(__DIR__) . '/../../Koala/Interfaces/Registry.php';
	require_once realpath(__DIR__) . '/../../Koala/Registry.php';

	use \Koala\Registry;

	class RegistryTest extends \PHPUnit_Framework_TestCase
	{

		private $_registry;

		public function setUp()
		{
			$this->_registry = Registry::getInstance();
		}

		/**
		 * @dataProvider setProvider
		 */
		public function testSet($key, $value)
		{
			$this->_registry->set($key, $value);
			$this->assertTrue(isset($this->_registry->$key));

			$setValue = $this->_registry->get($key);

			$this->assertTrue(($value === $setValue));
		}

		/**
		 * @expectedException LogicException
		 */
		public function testClone()
		{
			$x = clone $this->_registry;
		}

		public function testNullGet()
		{
			$this->assertNull($this->_registry->get('efinsefienfienf'));
		}

		public function testInterface()
		{
			$this->assertTrue(($this->_registry instanceof \Koala\Interfaces\Registry));
		}

		public function setProvider()
		{
			return array(
				array('integer', 7),
				array('string', 'Hello World!'),
				array('array', array(1,2,3)),
				array('binary', (binary)'Foobar'),
				array('callable', (function(){ return 'Hello World'; })),
			);
		}
	}