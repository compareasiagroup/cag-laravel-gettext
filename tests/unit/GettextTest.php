<?php

namespace CompareAsiaGroup\LaravelGettext\Test;

use \Mockery as m;
use \CompareAsiaGroup\LaravelGettext\Gettext;
use \CompareAsiaGroup\LaravelGettext\Config\ConfigManager;

class GettextTest extends BaseTestCase
{
	/**
	 * Gettext wrapper
	 * @var CompareAsiaGroup\LaravelGettext\Gettext
	 */
	protected $gettext;

    public function setUp()
	{
		parent::setUp();

        // Config
        include __DIR__ . '/../config/config.php';
        $config = ConfigManager::create($testConfig);

		// Session handler
		$session = m::mock('CompareAsiaGroup\LaravelGettext\Session\SessionHandler');
		$session->shouldReceive('get')->andReturn('en_US');
		$session->shouldReceive('set')->with('en_US');

		// Framework adapter
		$adapter = m::mock('CompareAsiaGroup\LaravelGettext\Adapters\LaravelAdapter');
		$adapter->shouldReceive('setLocale')->with('en_US');
		$adapter->shouldReceive('getApplicationPath')->andReturn(dirname(__FILE__));

        // FileSystem module
        $fileSystem = m::mock('CompareAsiaGroup\LaravelGettext\FileSystem');
        $fileSystem->shouldReceive('filesystemStructure')->andReturn(true);
        $fileSystem->shouldReceive('getDomainPath')->andReturn('path');

		$this->gettext = new Gettext($config->get(), $session, $adapter, $fileSystem);

	}

    /**
     * Test setting locale.
     */
	public function testSetLocale()
	{
		$response = $this->gettext->setLocale('en_US');

        $this->assertEquals('en_US', $response);
	}

    /**
     * Test getting locale.
     * It should receive locale from mocked config.
     */
	public function testGetLocale()
	{
		$response = $this->gettext->getLocale();

		$this->assertEquals('en_US', $response);
	}

	public function testIsLocaleSupported()
	{
		$this->assertTrue($this->gettext->isLocaleSupported('en_US'));
	}

    /**
     * Test dumping locale to string
     */
	public function testToString()
	{
		$response = $this->gettext->__toString();

		$this->assertEquals('en_US', $response);
	}

	public function testGetEncoding()
	{
		$response = $this->gettext->getEncoding();
		$this->assertNotEmpty($response);
		$this->assertEquals('UTF-8', $response);
	}

	public function testSetEncoding()
	{
		$response = $this->gettext->setEncoding('UTF-8');
		$this->assertNotEmpty($response);
		$this->assertInstanceOf('CompareAsiaGroup\LaravelGettext\Gettext', $response);
	}

	public function tearDown()
	{
		m::close();
	}

}
