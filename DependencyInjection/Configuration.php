<?php

namespace Zeichen32\GitLabApiBundle\DependencyInjection;

use Gitlab\Client;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zeichen32_git_lab_api');

        $rootNode->children()
                ->arrayNode("clients")
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('token')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->scalarNode('url')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->scalarNode('auth_method')
                                ->defaultValue(Client::AUTH_HTTP_TOKEN)
                                ->validate()
                                ->ifNotInArray(array(Client::AUTH_URL_TOKEN, Client::AUTH_HTTP_TOKEN))
                                    ->thenInvalid('Invalid Auhtmethod "%s"')
                                ->end()
                            ->end()
                            ->arrayNode('options')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->integerNode('timeout')
                                    ->cannotBeEmpty()
                                    ->defaultValue(60)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
