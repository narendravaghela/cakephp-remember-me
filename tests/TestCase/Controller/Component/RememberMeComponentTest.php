<?php

namespace RememberMe\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use RememberMe\Controller\Component\RememberMeComponent;

/**
 * RememberMe\Controller\Component\RememberMeComponent Test Case
 */
class RememberMeComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var RememberMeComponent
     */
    public $RememberMe;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
		$request = new Request();
        $response = new Response();
        $this->controller = $this->getMock(
            'Cake\Controller\Controller',
            null,
            [$request, $response]
        );
        $registry = new ComponentRegistry($this->controller);
        $this->RememberMe = new RememberMeComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RememberMe);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->assertNotEmpty($this->RememberMe->config('cypherKey'));
    }

    /**
     * Test rememberData
     *
     * @return void
     */
    public function testRememberData()
    {
		$this->assertFalse($this->RememberMe->rememberData());
		$this->assertTrue($this->RememberMe->rememberData("data@example.com"));
    }

    /**
     * Test getRememberedData
     *
     * @return void
     */
    public function testGetRememberedData()
    {
		$this->RememberMe->removeRememberedData();
		$this->assertFalse($this->RememberMe->getRememberedData());

		$this->RememberMe->rememberData("data@example.com");
		$this->assertNotEmpty($this->RememberMe->getRememberedData());
		$this->assertEquals("data@example.com", $this->RememberMe->getRememberedData());

		$this->RememberMe->removeRememberedData();
		$this->RememberMe->rememberData(['foo' => 'bar']);
		$this->assertNotEmpty($this->RememberMe->getRememberedData());
		$this->assertEquals(['foo' => 'bar'], $this->RememberMe->getRememberedData());

		$this->RememberMe->removeRememberedData();
		$obj = (object) ['foo' => 'bar'];
		$this->RememberMe->rememberData($obj);
		$this->assertNotEmpty($this->RememberMe->getRememberedData());
		$this->assertEquals($obj, $this->RememberMe->getRememberedData());
    }

	/**
     * Test removeRememberedData
     *
     * @return void
     */
    public function testRemoveRememberedData()
    {
		$this->RememberMe->rememberData("data@example.com");
		$this->RememberMe->removeRememberedData();
		$this->assertEquals(false, $this->RememberMe->getRememberedData());

		$this->RememberMe->rememberData(['foo' => 'bar']);
		$this->RememberMe->removeRememberedData();
		$this->assertEquals(false, $this->RememberMe->getRememberedData());

		$obj = (object) ['foo' => 'bar'];
		$this->RememberMe->rememberData($obj);
		$this->RememberMe->removeRememberedData();
		$this->assertEquals(false, $this->RememberMe->getRememberedData());
    }
}
