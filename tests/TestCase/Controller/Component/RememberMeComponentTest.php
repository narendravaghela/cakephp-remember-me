<?php

/**
 * Remember Me plugin for CakePHP 3
 * Copyright (c) Narendra Vaghela (http://www.narendravaghela.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.md
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Narendra Vaghela (http://www.narendravaghela.com)
 * @link          https://github.com/narendravaghela/cakephp-remember-me
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace RememberMe\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use RememberMe\Controller\Component\RememberMeComponent;

/**
 * RememberMeComponent Test Case
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
