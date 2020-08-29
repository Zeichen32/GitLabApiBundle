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
use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpClient\MockHttpClient;
use Zeichen32\GitLabApiBundle\DependencyInjection\Zeichen32GitLabApiExtension;

class Zeichen32GitLabApiExtensionTest extends TestCase {

    /**
     * @var ContainerBuilder
     */
    private $container;
    /**
     * @var Zeichen32GitLabApiExtension
     */
    private $extension;


    public function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->container->setDefinition('http_client', new Definition(MockHttpClient::class));
        $this->extension = new Zeichen32GitLabApiExtension();
    }

    public function tearDown(): void
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
        $this->assertTrue($this->container->has('gitlab_api'));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.firstclient'));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.secondclient'));

        $this->assertInstanceOf(Client::class, $this->container->get('zeichen32_gitlabapi.client.default'));
        $this->assertInstanceOf(Client::class, $this->container->get('zeichen32_gitlabapi.client.firstclient'));
        $this->assertInstanceOf(Client::class, $this->container->get('zeichen32_gitlabapi.client.secondclient'));

        $this->assertNotSame(
            $this->container->get('zeichen32_gitlabapi.client.firstclient'),
            $this->container->get('zeichen32_gitlabapi.client.secondclient')
        );
    }

    public function testWrongAuthMethod() {
        $this->expectException(InvalidConfigurationException::class);

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

    public function testClientAlias() {
        $config = array(
            'zeichen32_git_lab_api' => array('clients' => array(
                'firstclient' => array(
                    'token' => '12345',
                    'url' => 'http://example.org/api/v3/',
                    'alias' => 'test.client',
                ),
            )),
        );

        $this->extension->load($config, $this->container);
        $this->assertTrue($this->container->has(Client::class));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.default'));
        $this->assertTrue($this->container->has('zeichen32_gitlabapi.client.firstclient'));
        $this->assertTrue($this->container->has('gitlab_api'));
        $this->assertTrue($this->container->has('test.client'));

        $this->assertSame(
            $this->container->get('zeichen32_gitlabapi.client.firstclient'),
            $this->container->get('zeichen32_gitlabapi.client.default')
        );

        $this->assertSame(
            $this->container->get(Client::class),
            $this->container->get('zeichen32_gitlabapi.client.default')
        );

        $this->assertSame(
            $this->container->get('zeichen32_gitlabapi.client.firstclient'),
            $this->container->get('gitlab_api')
        );

        $this->assertSame(
            $this->container->get('zeichen32_gitlabapi.client.firstclient'),
            $this->container->get('test.client')
        );
    }

    public function testHttpClients() {

        $config = array(
            'zeichen32_git_lab_api' => array('clients' => array(
                'firstclient' => array(
                    'token' => '12345',
                    'url' => 'http://example.org/api/v3/',
                ),
                'secondclient' => array(
                    'token' => '12345',
                    'url' => 'http://example.org/api/v3/',
                    'http_client' => 'http.client',
                ),
            )),
        );

        $httpClient = $this->createMock(HttpClient::class);
        $this->container->setDefinition('http.client', new Definition(HttpClient::class));
        $this->container->set('http.client', $httpClient);

        $this->extension->load($config, $this->container);

        $firstClient = $this->container->get('zeichen32_gitlabapi.client.firstclient');
        $secondClient = $this->container->get('zeichen32_gitlabapi.client.secondclient');

        $this->assertInstanceOf(
            HttpClient::class,
            $firstClient->getHttpClient()
        );

        $this->assertInstanceOf(
            HttpClient::class,
            $secondClient->getHttpClient()
        );
    }
}
