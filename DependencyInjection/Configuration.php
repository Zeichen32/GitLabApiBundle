<?php

namespace Zeichen32\GitLabApiBundle\DependencyInjection;

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
                        ->children()
                            ->scalarNode('token')->cannotBeEmpty()->isRequired()->end()
                            ->scalarNode('url')->cannotBeEmpty()->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode("issue_tracker")
                ->isRequired()
                ->children()
                    ->scalarNode('project')->isRequired()->defaultValue(null)->end()
                    ->scalarNode('client')->cannotBeEmpty()->defaultValue('default')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
