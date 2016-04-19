<?php

namespace RememberMe\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
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
     * @var \RememberMe\Controller\Component\RememberMeComponent
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
        $registry = new ComponentRegistry();
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
        $this->markTestIncomplete('Not implemented yet.');
    }
}
