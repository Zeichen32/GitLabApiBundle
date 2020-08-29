<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Developer: Jens Averkamp
 * Date: 06.03.2015
 * Time: 14:15
 */

namespace Zeichen32\GitLabApiBundle\DependencyInjection;

use Gitlab\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Zeichen32GitLabApiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // Create default Buzz HttpClient
       // $httpClient = new Definition('Buzz\Client\Curl');
       // $httpClient->setPublic(false);
       // $container->setDefinition('zeichen32_gitlabapi.http.curl', $httpClient);

        $this->addClients($config['clients'], $container);
    }

    /**
     * @param array $clients
     * @param ContainerBuilder $container
     */
    private function addClients(array $clients, ContainerBuilder $container) {
        foreach($clients as $name => $client) {
            $this->createClient(
                $name,
                $client['url'],
                $client['token'],
                $client['auth_method'],
                $client['sudo'],
                $client['alias'],
                $client['http_client'],
                $container
            );
        }

        reset($clients);
        $this->setDefaultClient(key($clients), $container);
    }

    /**
     * @param $name
     * @param ContainerBuilder $container
     */
    private function setDefaultClient($name, ContainerBuilder $container) {
        $container->setAlias('zeichen32_gitlabapi.client.default', sprintf('zeichen32_gitlabapi.client.%s', $name));
        $container->setAlias(Client::class, 'zeichen32_gitlabapi.client.default');
    }

    /**
     * @param $name
     * @param $url
     * @param $token
     * @param $authMethod
     * @param $sudo
     * @param $alias
     * @param ContainerBuilder $container
     */
    private function createClient($name, $url, $token, $authMethod, $sudo, $alias, $httpClient, ContainerBuilder $container) {
        // Create new client if needed
        if (null !== $httpClient) {
            $container->setAlias(sprintf('zeichen32_gitlabapi.http.client.%s', $name), $httpClient);

            $definition = new Definition('%zeichen32_gitlabapi.client.class%');
            $definition->addArgument(new Reference($httpClient));
            $definition->setFactory(array(Client::class, 'createWithHttpClient'));
            $definition->addMethodCall('setUrl', array($url));
        } else {
            // Create new client if needed
            $psr18Client = new Definition('Symfony\Component\HttpClient\Psr18Client', [new Reference('http_client')]);

            $definition = new Definition('%zeichen32_gitlabapi.client.class%');
            $definition->addArgument($psr18Client);
            $definition->setFactory(array(Client::class, 'createWithHttpClient'));
            $definition->addMethodCall('setUrl', array($url));
        }

        // Call authenticate method
        $definition->addMethodCall('authenticate', array(
            $token,
            $authMethod,
            $sudo
        ));

        // Add Service to Container
        $container->setDefinition(
            sprintf('zeichen32_gitlabapi.client.%s', $name),
            $definition
        );

        // If alias option is set, create a new alias
        if(null !== $alias) {
            $container->setAlias($alias, sprintf('zeichen32_gitlabapi.client.%s', $name));
        }
    }
}
