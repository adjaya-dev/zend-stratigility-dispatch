<?php

namespace ZendTest\Stratigility\Dispatch\Router;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Stratigility\Dispatch\Router\Aura;

class AuraTest extends TestCase
{
    public function testMatchedParams()
    {
        $config = [
            'routes' => [
                'home' => [
                    'url'    => '/test{/id}',
                    'action' => function () {
                        return true;
                    },
                    'tokens' => [
                       'id' => '(\d+)?'
                    ],
                    'methods' => [ 'POST']
                ]
            ]
        ];
        $router = new Aura();
        $router->setConfig($config);

        $server = [
            'REQUEST_METHOD' => 'POST'
        ];

        $this->assertTrue($router->match('/test/12', $server));
        $params = $router->getMatchedParams();
        $this->assertTrue(is_array($params));
        $this->assertTrue(isset($params['id']));
        $this->assertEquals(12, $params['id']);

        $this->assertTrue($router->match('/test', $server));
        $params = $router->getMatchedParams();
        $this->assertTrue(is_array($params));
        $this->assertFalse(isset($params['id']));
    }
}
