<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Developer: Jens Averkamp
 * Date: 06.03.2015
 * Time: 13:56
 */

namespace Zeichen32\GitLabApiBundle\Tests\DependencyInjection;

use Gitlab\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zeichen32\GitLabApiBundle\DependencyInjection\Zeichen32GitLabApiExtension;

class Zeichen32GitLabApiExtensionTest extends \PHPUnit_Framework_TestCase{

    /**
     * @var ContainerBuilder
     */
    private $container;
    /**
     * @var Zeichen32GitLabApiExtension
     */
    private $extension;


    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new Zeichen32GitLabApiExtension();
    }

    public function tearDown()
    {
        unset($this->container, $this->extension);
    }

    public function testCreateClients()
    {

        $config = array(
            'zeichen32_git_lab_api' => array('clients' => array(
                'firstclient' => array('token' => '12345', 'url' => 'http://example.org/api/v3/'),
                'secondclient' => array('token' => '12345', 'url' => 'http://example.com/api/v3/')
            )),
        );

        $this->extension->load($config, $this->container);
        $this->assertTrue($this->container->hasAlias('zeichen32_gitlabapi.client.default'));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.firstclient'));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.secondclient'));

        $this->assertInstanceOf('Gitlab\Client', $this->container->get('zeichen32_gitlabapi.client.default'));
        $this->assertInstanceOf('Gitlab\Client', $this->container->get('zeichen32_gitlabapi.client.firstclient'));
        $this->assertInstanceOf('Gitlab\Client', $this->container->get('zeichen32_gitlabapi.client.secondclient'));
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testWrongAuthMethod() {
        $config = array(
            'zeichen32_git_lab_api' => array('clients' => array(
                'firstclient' => array(
                    'token' => '12345',
                    'url' => 'http://example.org/api/v3/',
                    'auth_method' => 'xyz'
                ),
            )),
        );

        $this->extension->load($config, $this->container);
    }

    public function testOptions() {
        $config = array(
            'zeichen32_git_lab_api' => array('clients' => array(
                'firstclient' => array(
                    'token' => '12345',
                    'url' => 'http://example.org/api/v3/',
                    'auth_method' => Client::AUTH_URL_TOKEN,
                    'sudo' => '1',
                    'options' => array(
                        'timeout' => 120,
                        'user_agent' => 'TestAgent',
                    )
                ),
            )),
        );

        $this->extension->load($config, $this->container);
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.default'));

        /** @var Client $client */
        $client = $this->container->get('zeichen32_gitlabapi.client.default');
        $this->assertEquals(120, $client->getOption('timeout'));
        $this->assertEquals('TestAgent', $client->getOption('user_agent'));

    }
}
